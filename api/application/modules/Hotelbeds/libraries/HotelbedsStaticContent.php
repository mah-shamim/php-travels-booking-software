<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'ServiceController.php';

class HotelbedsStaticContent extends ServiceController {

    const HOTELBED_CONTENT_PATH = APPPATH.'Hotelbeds/libraries/RefrenceData';

    public function hotels()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 133301;
        $to = 133400;
        $step = 100;
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
            $resp = $this->content($query);
            fwrite($log, 'Status: '.$resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data) ) {
                    fwrite($log, 'Data Saved'. PHP_EOL);
                    $file = sprintf('Hotels/hotels-%s-%s', $from, $to);
                    $this->save($file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data return empty'. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Accommodations()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        while ($running)
        {
            $query = 'types/accommodations?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->accommodations) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('accommodations-%s-%s', $from, $to);
                    $this->save('Accommodations/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Destinations()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        while ($running)
        {
            $query = 'locations/destinations?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->destinations) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('%s-%s', $from, $to);
                    $this->save('Destinations/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Countries()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        while ($running)
        {
            $query = 'locations/countries?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->countries) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('%s-%s', $from, $to);
                    $this->save('Countries/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Boards()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        while ($running)
        {
            $query = 'types/boards?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->boards) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('%s-%s', $from, $to);
                    $this->save('Boards/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Chains()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        while ($running)
        {
            $query = 'types/chains?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->chains) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('%s-%s', $from, $to);
                    $this->save('Chains/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Currencies()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        while ($running)
        {
            $query = 'types/currencies?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->currencies) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('%s-%s', $from, $to);
                    $this->save('Currencies/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Facilities()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 100;
        $step = 100;
        $running = TRUE;
        while ($running)
        {
            $query = 'types/facilities?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->facilities) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('%s-%s', $from, $to);
                    $this->save('Facilities/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    public function Facilitytypologies()
    {
        $log = fopen(__DIR__ . '/ReferenceData/logs.txt', "a") or die("Unable to open file!");
        $from = 1;
        $to = 1000;
        $step = 1000;
        $running = TRUE;
        while ($running)
        {
            $query = 'types/facilitytypologies?' . http_build_query([
                    'fields' => 'all',
                    'language' => 'ENG',
                    'from' => $from,
                    'to' => $to,
                    'useSecondaryLanguage' => false
                ]);
            fwrite($log, $query . PHP_EOL);
            $resp = $this->content($query);
            fwrite($log, $resp->status . PHP_EOL);
            if($resp->status == 'success') {
                if( ! empty($resp->data->facilityTypologies) ) {
                    fwrite($log, 'Data Saved: '. PHP_EOL);
                    $file = sprintf('%s-%s', $from, $to);
                    $this->save('FacilityTypologies/'.$file, json_encode($resp->data));
                } else {
                    fwrite($log, 'Data Empty: '. PHP_EOL);
                    $running = FALSE;
                }
            } else {
                fwrite($log, 'Fail: ' . json_encode($resp) . PHP_EOL);
                $running = FALSE;
            }

            $from = $to + 1;
            $to = $to + $step;
        }
        fclose($log);
    }

    private function save($file, $data)
    {
        $directory = self::HOTELBED_CONTENT_PATH . '/'.$file.'.json';
        $f = fopen($directory, 'a+');
        fwrite($f, $data);
        fclose($f);
    }
}