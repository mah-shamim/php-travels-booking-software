<?php

ini_set('memory_limit', '-1');

use Ausi\SlugGenerator\SlugGenerator;

class HotelbedsCli extends MX_Controller
{
	const TB_HOTELS = 'hotels';
    const HOTELBED_CONTENT_PATH = APPPATH.'modules/Hotelbeds/libraries/ReferenceData';

	public function __construct()
	{
        $this->dbhb = getDatabaseConnection('hotelbeds');
	}

    public function ping()
    {
        echo "Pong";
    }

    public function loadAndSyncBoards()
    {
        $path = APPPATH.'modules\Hotelbeds\libraries\ReferenceData\Boards/boards-1-1000.json';
        $myfile = fopen($path, "r") or die("Unable to open file!");
        $response = json_decode(fread($myfile,filesize($path)));
        fclose($myfile);

        $bulk_data = array();
        foreach ($response->boards as $board) {
            array_push($bulk_data, array(
                "code" => $board->code,
                "languageCode" => $board->description->languageCode,
                "content" => $board->description->content,
                "multiLingualCode" => $board->multiLingualCode,
            ));
        }
        $response = $this->dbhb->insert_batch("boards", $bulk_data);
        echo "Batch Query Response: ".$response.PHP_EOL;
    }

    public function gen_hotels_slug()
    {
        echo "Starting..." . PHP_EOL;
        $generator = new SlugGenerator;
        $dataset = $this->dbhb->select("code, name, slug, city, city_slug")->get("hotels")->result();

        $total_batch = [];
        $start_time = time();
        foreach($dataset as $hotel)
        {
            $hotel->slug = $generator->generate($hotel->name);
            $hotel->city_slug = $generator->generate($hotel->city);
            $total_batch[] = $this->dbhb->where('code', $hotel->code)->update('hotels', $hotel);
            echo "updated hotel: " . $hotel->code . PHP_EOL;
        }
        $end_time = time();

        echo "Batch Query Response: " . count($total_batch) . PHP_EOL;
        echo "Start Time: " . date("Y-m-d H:i:s" . $start_time) . PHP_EOL;
        echo "End Time: " . date("Y-m-d H:i:s" . $end_time) . PHP_EOL;
    }

    private function save($service, $file, $data)
    {
        $directory = self::HOTELBED_CONTENT_PATH . '/'.$service;
        if ( ! file_exists($directory) ) {
            mkdir($directory, 0777, true);
        }
        $file = fopen($directory.'/'.$file.'.json', 'w') or die("Unable to open file!");
        fwrite($file, $data);
        fclose($file);
    }

    public function downloadHotelsAndSync()
    {
        $from = 1;
        $to = 1000;

        $this->load->library('Hotelbeds/ServiceController');
        $service = new ServiceController();
        $log = fopen(APPPATH . 'modules/Hotelbeds/libraries/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $step = 1000;
        $running = TRUE;
        while ($running)
        {
            $query = 'hotels?' . http_build_query([
                'fields' => 'all',
                'language' => 'ENG',
                'from' => $from,
                'to' => $to,
                'useSecondaryLanguage' => false
            ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $service->content($query);
            fwrite($log, 'Status: '.$resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data) ) {
                    fwrite($log, 'Data Saved'. PHP_EOL);
                    $file = sprintf('hotels-%s-%s', $from, $to);
                    $this->save('Hotels', $file, json_encode($resp->data));
                    echo $file.PHP_EOL;
                    $total_batch = $this->syncHotels($resp->data->hotels);
                    fwrite($log, 'batched data inserted: ' . $total_batch . PHP_EOL);
                    echo 'batched data inserted: ' . $total_batch . PHP_EOL;
                } else {
                    fwrite($log, 'Data return empty'. PHP_EOL);
                    $running = FALSE;
                    break;
                }
            } else {
                echo "Fail".PHP_EOL;
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
                break;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

	public function syncHotels()
    {
        $from = 1;
        $to = 1000;

        $aCountris = array();
        $countries = $this->dbhb->get('countries')->result();
        foreach ($countries as $country) {
            $aCountris[$country->code] = $country->description;
        }
        $batchLimit = 100;
        $step = 1000;
        $running = TRUE;
        $netTotal = 0;
        $data = [];
        while ($running) 
        {
            $totalHotesl = 0;
            $file = sprintf(self::HOTELBED_CONTENT_PATH.'/Hotels/hotels-%s-%s.json', $from, $to);
            if ( ! file_exists($file) ) {
                $running = FALSE;
                break;
            } else {
                $dataset = file_get_contents($file);
                if($from >= 68601 && $from <= 107901) {
                    preg_match('/({.*}){"from"/', $dataset, $matches);
                    if(isset($matches[1]) && ! empty($matches[1])) {
                        $dataset = $matches[1];
                    }
                }
                $dataset = json_decode($dataset);
                if(isset($dataset) && ! empty($dataset->hotels)) {
                    $totalHotesl = count($dataset->hotels);
                }
            };

            if( ! empty($dataset) )
            {
                $netTotal += $totalHotesl;
                echo $file.' Total Hotels: '.$totalHotesl.' netTotal: '.$netTotal.PHP_EOL;

                if(isset($dataset->hotels) && ! empty($dataset->hotels)) {
                    foreach($dataset->hotels as $hotel) {
                        array_push($data, array(
                            'code' => $hotel->code,
                            'name' => $hotel->name->content,
                            'description' => $hotel->description->content,
                            'countryCode' => $hotel->countryCode,
                            'countryName' => $aCountris[$hotel->countryCode],
                            'city' => $hotel->city->content,
                            'destinationCode' => $hotel->destinationCode,
                            'latitude' => $hotel->coordinates->latitude,
                            'longitude' => $hotel->coordinates->longitude,
                            'images' => (isset($hotel->images))?json_encode($hotel->images):NULL,
                            'ratingStars' => $hotel->categoryCode[0], // 3Stars
                            'address' => $hotel->address->content
                        ));
                        if(count($data) >= $batchLimit) {
                            $total_batch = $this->insert_data($data);
                            echo "Batch Query Response: " . $total_batch . PHP_EOL;
                            $data = [];
                            if($total_batch == 0) {
                                die("something went wrong with database batch insertion.");
                            }
                        }
                    }
                } else {
                    echo 'if(isset($hotels) && ! empty($hotels)) Failed'.PHP_EOL;
                    break;
                }
            }
            else
            {
                echo 'if( ! empty($dataset) ) Failed'.PHP_EOL;
                break;
            }

            $from = $to + 1;
            $to = $to + $step;
        }

        if(count($data) > 0) {
            $total_batch = $this->insert_data($data);
            echo "Batch Query Response: " . $total_batch . PHP_EOL;
        }
	}

	public function insert_data($data)
    {
        $total_batch = [];
        foreach ($data as $_data) {
            $this->dbhb->where('code', $_data['code']);
            $dataAdapter = $this->dbhb->get($this::TB_HOTELS);
            if ($dataAdapter->num_rows() <= 0) {
                $resp = $this->dbhb->insert($this::TB_HOTELS, $_data);
                array_push($total_batch, $resp);
            }
        }
        return count($total_batch);
    }

    public function downloadHotelsAndSyncCronJob()
    {
        $from = 1;
        $to = 1000;

        $this->load->library('Hotelbeds/ServiceController');
        $service = new ServiceController();
        $log = fopen(APPPATH . 'modules/Hotelbeds/libraries/ReferenceData/cronjobslog.txt', "a") or die("Unable to open file!");
        $step = 1000;
        $running = TRUE;
        while ($running)
        {
            $query = 'hotels?' . http_build_query([
                'fields' => 'all',
                'language' => 'ENG',
                'from' => $from,
                'to' => $to,
                'lastUpdateTime' => date('Y-m-d')
            ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $service->content($query);
            fwrite($log, 'Status: '.$resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data) && $resp->data->total > 0) {
                    fwrite($log, 'Data Saved'. PHP_EOL);
                    $file = sprintf('hotels-%s-%s', $from, $to);
                    $this->save('Cronjob/Hotels', $file, json_encode($resp->data));
                    $total_batch = $this->insert_data($resp->data);
                    echo $file . PHP_EOL;
                    fwrite($log, 'Batch Insert :'. $total_batch . PHP_EOL);
                } else {
                    fwrite($log, 'Data return empty'. PHP_EOL);
                    $running = FALSE;
                    break;
                }
            } else {
                echo "Fail".PHP_EOL;
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
                break;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }
}