<?php
require_once(BASEPATH.'/libraries/Calendar.php');
class Hotels_calendar_lib extends CI_Calendar
{
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
	  $this->my_parse_template("back");

		// Begin building the calendar output
	 //  $out = $this->temp['table_open'];
		$out = "\n";
         if($month < 2){
        // Write the cells containing the days of the week
		$out .= "\n";
		$out .= $this->temp['week_row_start'];
		$out .= "<td></td>";


		$day_names = $this->get_day_names();
        $sunsats = array("0","6","7","13","14","20","21","27","28","34","35");
		for ($i = 0; $i < 37; $i ++)
		{
			$weekdays = str_replace('{week_day}', $day_names[($start_day + $i) %7], $this->temp['week_day_cell']);
            if(in_array($i,$sunsats)){
             $weekdays2 = str_replace('{sat_sun}', "satsun", $weekdays);
            }else{
            $weekdays2 = str_replace('{sat_sun}', "", $weekdays);
            }

			$out .= $weekdays2;
		}

		$out .= "\n";
		$out .= $this->temp['week_row_end'];
		$out .= "\n";

         }



		// Build the main body of the calendar
		while ($day <= $total_days)
		{
			$out .= "\n";
            if($month == $cur_month){
             $out .= $this->temp['cal_row_start_current_month'];
            }else{
             $out .= $this->temp['cal_row_start'];
            }

			$out .= "<td class='$curr_month'>".$this->get_month_name($month)."&nbsp;".$year."</td> ";

			for ($i = 0; $i < 37; $i++)
			{
              $str = $this->check_rate($basic,"$day-$month-$year",$id);
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
						'week_day_cell'				=> '<td class="{sat_sun}">{week_day}</td>',
						'week_row_end'				=> '</tr>',
						'cal_row_start'				=> '<tr>',
						'cal_row_start_current_month' => '<tr class="currentmonth">',
						'cal_cell_start'			=> '<td style="color: green;text-align: center;line-height: 14px;font-size: 12px;padding:2px">',
						'cal_cell_start_today'		=> '<td>',
						'cal_cell_start_booked'		=> '<td style="background-color: red;color: #fff;">',
						'cal_cell_start_available'		=> '<td style="background-color: green;color: #fff;">',
						'cal_cell_content'			=> '<a href="{content}">{day}</a>',
						'cal_cell_content_today'	=> '<a href="{content}"><strong>{day}</strong></a>',
						'cal_cell_no_content'		=> '{day}<hr>{rate}',
						'cal_cell_no_content_today'	=> '<strong>{day}<hr>{rate}</strong>',
						'cal_cell_content_booked'	=> '<span  style="color: red;"><strong>{day}<br><input id="{id}" data-room ="{rid}" class="resdates booked" type="text" value="{rate}" /></strong></span>',
						'cal_cell_content_avail'	=> '<span  style="color: green;text-align: center;line-height: 0px;font-size: 12px;">{day}<br><input id="{id}" data-room ="{rid}" class="resdates" type="text" value="{rate}" /></span>',
						'cal_cell_blank'			=> '&nbsp;',
						'cal_cell_end'				=> '</td>',
						'cal_cell_end_today'		=> '</td>',
						'cal_row_end'				=> '</tr>',
						'table_close'				=> '</table>'
					);
	}

    	function my_front_default_template()
	{
		return  array (
						'table_open'				=> '<table class="availability-table table-bordered bg-white table-condensed pull-left">',
						'heading_row_start'			=> '<tr>',
						'heading_previous_cell'		=> '<th><a href="{previous_url}">&lt;&lt;</a></th>',
						'heading_title_cell'		=> '<th colspan="{colspan}" style="font-weight:700" class="text-center">{heading}</th>',
						'heading_next_cell'			=> '<th><a href="{next_url}">&gt;&gt;</a></th>',
						'heading_row_end'			=> '</tr>',
						'week_row_start'			=> '<tr style="background-color: #f4f4f4; border-bottom: 1px solid #dbdbdb;">',
						'week_day_cell'				=> '<th class="dow">{week_day}</th>',
						'week_row_end'				=> '</tr>',
						'cal_row_start'				=> '<tr>',
						'cal_cell_start'			=> '<td>',
						'cal_cell_start_today'		=> '<td class="today">',
                        'cal_cell_start_booked'		=> '<td class="notavailable">',
						'cal_cell_start_available'	=> '<td class="available">',
						'cal_cell_start_past'	    => '<td>',
					   	'cal_cell_content'			=> '<a href="{content}">{day}</a>',
						'cal_cell_content_today'	=> '<a href="{content}"><strong>{day}</strong></a>',
						'cal_cell_no_content'		=> '{day}',
						'cal_cell_no_content_today'	=> '<strong class="today">{day}</strong>',
						'cal_cell_blank'			=> '&nbsp;',
						'cal_cell_end'				=> '</td>',
						'cal_cell_end_today'		=> '</td>',
						'cal_row_end'				=> '</tr>',
						'table_close'				=> '</table>'
					);

	}


    function my_parse_template($mode)
	{
	  if($mode == "front"){
         $this->temp = $this->my_front_default_template();
	  }else{
       $this->temp = $this->my_default_template();
	  }


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

function check_rate($basic = null,$date,$roomid){

}


/**** functions for front ****/
	function frontgenerate($year = '', $month = '',$id,$data = array())
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
		$this->my_parse_template("front");

		// Begin building the calendar output
		$out = $this->temp['table_open'];
		$out .= "\n";

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
		$out .= "\n";

		// Write the cells containing the days of the week
		$out .= "\n";
		$out .= $this->temp['week_row_start'];
		$out .= "\n";

		$day_names = $this->get_day_names();

		for ($i = 0; $i < 7; $i ++)
		{
			$out .= str_replace('{week_day}', $day_names[($start_day + $i) %7], $this->temp['week_day_cell']);
		}

		$out .= "\n";
		$out .= $this->temp['week_row_end'];
		$out .= "\n";

		// Build the main body of the calendar
		while ($day <= $total_days)
		{
			$out .= "\n";
			$out .= $this->temp['cal_row_start'];
			$out .= "\n";

			for ($i = 0; $i < 7; $i++)
			{
                $rchk = $this->room_check($id,"$year-$month-$day");

                if(!$rchk){
                    $out .= ($day > 0 AND $day <= $total_days) ? $this->temp['cal_cell_start_booked'] : $this->temp['cal_cell_start'];

                }else{
                 $out .= ($day > 0 AND $day <= $total_days) ? $this->temp['cal_cell_start_available'] : $this->temp['cal_cell_start'];

                }



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
						$temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_no_content_today'] : $this->temp['cal_cell_no_content'];
					    $out .= str_replace('{day}', $day, $temp);

					}
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
		$out .= $this->temp['table_close'];

		return $out;
	}


    function room_check($roomid,$chkd){
 $res = array();
 $CI = &get_instance();
 $CI->load->helper('check');
 $CI->db->select('room_quantity');
 $CI->db->where('room_id',$roomid);
 $run = $CI->db->get('pt_rooms')->result();
 $totalquantity = $run[0]->room_quantity;
 $currentyear = date("Y");

 $dateparts = explode("-",$chkd);
 $year = $dateparts[0];
 $month = $dateparts[1];

 if($dateparts[2] < 10){
 $dateparts[2] = str_replace("0","",$dateparts[2]);
 }

 $day = "d".$dateparts[2];
 if($year == $currentyear){
 	$y = '0';
 }else{
 	$y = '1';
 }


$CI->db->where('y',$y);
$CI->db->where('m',$month);
$CI->db->where('room_id',$roomid);

$ravial = $CI->db->get('pt_rooms_availabilities')->result();
$ckhavail = $ravial[0]->$day;

if($ckhavail > 0){
$chk1 = TRUE;

}else{

$chk1 = FALSE;

}

$calcheck = calendar_room_check($roomid,$totalquantity,$chkd);

if($calcheck && $chk1){
	return TRUE;
}else{
	return FALSE;
}



}

}