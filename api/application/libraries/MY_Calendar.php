<?php

class MY_Calendar extends CI_Calendar {
        public $bookeddates = array();
    	function customcalendar($year = '', $month = '', $id,$basic, $data = array())
	{

		// Set and validate the supplied month/year
		if ($year == '')
			$year  = date("Y", $this->local_time);

		if ($month == '')
			$month = date("m", $this->local_time);

		if (strlen($year) == 1)
			$year = '200'.$year;

		if (strlen($year) == 2)
			$year = '20'.$year;

		if (strlen($month) == 1)
			$month = '0'.$month;

		$adjusted_date = $this->adjust_date($month, $year);

		$month	= $adjusted_date['month'];
		$year	= $adjusted_date['year'];

		// Determine the total days in the month
		$total_days = $this->get_total_days($month, $year);

		// Set the starting day of the week
		$start_days	= array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
		$start_day = ( ! isset($start_days[$this->start_day])) ? 0 : $start_days[$this->start_day];

		// Set the starting day number
		$local_date = mktime(12, 0, 0, $month, 1, $year);
		$date = getdate($local_date);
		$day  = $start_day + 1 - $date["wday"];

		while ($day > 1)
		{
			$day -= 7;
		}

		// Set the current month/year/day
		// We use this to determine the "today" date
		$cur_year	= date("Y", $this->local_time);
		$cur_month	= date("m", $this->local_time);
		$cur_day	= date("j", $this->local_time);

		$is_current_month = ($cur_year == $year AND $cur_month == $month) ? TRUE : FALSE;

		// Generate the template data array
	  $this->my_parse_template();

		// Begin building the calendar output
	 //  $out = $this->temp['table_open'];
		$out = "\n";
         if($month < 2){
        // Write the cells containing the days of the week
		$out .= "\n";
		$out .= $this->temp['week_row_start'];
		$out .= "<td></td>";


		$day_names = $this->get_day_names();

		for ($i = 0; $i < 37; $i ++)
		{
			$out .= str_replace('{week_day}', $day_names[($start_day + $i) %7], $this->temp['week_day_cell']);
		}

		$out .= "\n";
		$out .= $this->temp['week_row_end'];
		$out .= "\n";

         }


      /*
		$out .= "\n";
		$out .= $this->temp['heading_row_start'];
		$out .= "\n";

		// "previous" month link
		if ($this->show_next_prev == TRUE)
		{
			// Add a trailing slash to the  URL if needed
			$this->next_prev_url = preg_replace("/(.+?)\/*$/", "\\1/",  $this->next_prev_url);

			$adjusted_date = $this->adjust_date($month - 1, $year);
			$out .= str_replace('{previous_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->temp['heading_previous_cell']);
			$out .= "\n";
		}

		// Heading containing the month/year
		$colspan = ($this->show_next_prev == TRUE) ? 5 : 7;

		$this->temp['heading_title_cell'] = str_replace('{colspan}', $colspan, $this->temp['heading_title_cell']);
		$this->temp['heading_title_cell'] = str_replace('{heading}', $this->get_month_name($month)."&nbsp;".$year, $this->temp['heading_title_cell']);

		$out .= $this->temp['heading_title_cell'];
		$out .= "\n";

		// "next" month link
		if ($this->show_next_prev == TRUE)
		{
			$adjusted_date = $this->adjust_date($month + 1, $year);
			$out .= str_replace('{next_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->temp['heading_next_cell']);
		}

		$out .= "\n";
		$out .= $this->temp['heading_row_end'];
		$out .= "\n";*/


		// Build the main body of the calendar
		while ($day <= $total_days)
		{
			$out .= "\n";
			$out .= $this->temp['cal_row_start'];
			$out .= "<td>".$this->get_month_name($month)."&nbsp;".$year."</td> ";

			for ($i = 0; $i < 37; $i++)
			{
              $str = $this->convert_unix($basic,"$day-$month-$year");
            $out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_start_today'] : $this->temp['cal_cell_start'];

				if ($day > 0 AND $day <= $total_days)
				{
				  	if (isset($data[$day]))
					{
						// Cells with content
						$temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_content_today'] : $this->temp['cal_cell_content'];
						$out .= str_replace('{day}', $day, str_replace('{content}', $data[$day], $temp));

					}
					else
					{
						// Cells with no content
                         if($str['announce'] == "booked"){
                          $temp = $this->temp['cal_cell_content_booked'];
                         }else{
                          $temp = $this->temp['cal_cell_content_avail'];
                         }
                      //  $temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_no_content_today'] : $this->temp['cal_cell_no_content'];
						$temp2 = str_replace('{day}', $day, str_replace('{rate}', $str['rate'], $temp));
						$temp3 = str_replace('{id}', $str['id'], $temp2);
						$out .= str_replace('{rid}', $id, $temp3);

					}


                    $out .= "</span>";

				}
				else
				{
					// Blank cells
					$out .= $this->temp['cal_cell_blank'];
				}

				$out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_end_today'] : $this->temp['cal_cell_end'];

            $day++;
			}

			$out .= "\n";
			$out .= $this->temp['cal_row_end'];
			$out .= "\n";
		}

		$out .= "\n";
	   // $out .= $this->temp['table_close'];

		return $out;
	}


    function convert_unix($basic,$dates){

            $response = array();
            $mydates = array("23-11-2014","12-10-2014","2-11-2014","3-11-2014","4-11-2014",
            "5-11-2014","23-05-2014","24-05-2014","18-02-2014","2-01-2014","3-01-2014",
            "3-08-2014","4-08-2014","5-08-2014","6-08-2014","1-11-2014");
            if(in_array($dates,$this->bookeddates)){
              $response['announce'] = "booked";
              $response['rate'] = $basic;
              $response['id'] = strtotime($dates);
            }else{
              $response["announce"] = "available";
               $response['rate'] = $basic;
               $response['id'] = strtotime($dates);
            }
       return $response;

    }


    	function my_default_template()
	{

        return  array (
						'table_open'				=> '<table border="2" cellpadding="3" cellspacing="5">',
						'heading_row_start'			=> '<tr>',
						'heading_previous_cell'		=> '<th><a href="{previous_url}">&lt;&lt;</a></th>',
						'heading_title_cell'		=> '<th colspan="{colspan}">{heading}</th>',
						'heading_next_cell'			=> '<th><a href="{next_url}">&gt;&gt;</a></th>',
						'heading_row_end'			=> '</tr>',
						'week_row_start'			=> '<tr>',
						'week_day_cell'				=> '<td>{week_day}</td>',
						'week_row_end'				=> '</tr>',
						'cal_row_start'				=> '<tr>',
						'cal_cell_start'			=> '<td>',
						'cal_cell_start_today'		=> '<td>',
						'cal_cell_start_booked'		=> '<td style="background-color: red;color: #fff;">',
						'cal_cell_start_available'		=> '<td style="background-color: green;color: #fff;">',
						'cal_cell_content'			=> '<a href="{content}">{day}</a>',
						'cal_cell_content_today'	=> '<a href="{content}"><strong>{day}</strong></a>',
						'cal_cell_no_content'		=> '{day}<hr>{rate}',
						'cal_cell_no_content_today'	=> '<strong>{day}<hr>{rate}</strong>',
						'cal_cell_content_booked'	=> '<span  style="color: red;"><strong>{day}<br><input id="{id}" data-room ="{rid}" class="resdates" type="text" value="{rate}" /></strong></span>',
						'cal_cell_content_avail'	=> '<span  style="color: green;"><strong>{day}<br><input id="{id}" data-room ="{rid}" class="resdates" type="text" value="{rate}" /></strong></span>',
						'cal_cell_blank'			=> '&nbsp;',
						'cal_cell_end'				=> '</td>',
						'cal_cell_end_today'		=> '</td>',
						'cal_row_end'				=> '</tr>',
						'table_close'				=> '</table>'
					);
	}


    function my_parse_template()
	{
		$this->temp = $this->my_default_template();

		if ($this->template == '')
		{
			return;
		}

		$today = array('cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today');

		foreach (array('table_open', 'table_close', 'heading_row_start', 'heading_previous_cell', 'heading_title_cell', 'heading_next_cell', 'heading_row_end', 'week_row_start', 'week_day_cell', 'week_row_end', 'cal_row_start', 'cal_cell_start', 'cal_cell_content', 'cal_cell_no_content',  'cal_cell_blank', 'cal_cell_end', 'cal_row_end', 'cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today') as $val)
		{
			if (preg_match("/\{".$val."\}(.*?)\{\/".$val."\}/si", $this->template, $match))
			{
				$this->temp[$val] = $match['1'];
			}
			else
			{
				if (in_array($val, $today, TRUE))
				{
					$this->temp[$val] = $this->temp[str_replace('_today', '', $val)];
				}
			}
		}
	}

function booked_dates($bdates){
  $this->bookeddates = $bdates;

}



}