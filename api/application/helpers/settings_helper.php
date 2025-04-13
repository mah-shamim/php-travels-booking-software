<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('pt_get_hotel_settings_data'))
{
    function pt_get_hotel_settings_data($type)
    {
       $CI = get_instance();

    $CI->load->model('Hotels/Hotels_model');

    $res = $CI->Hotels_model->get_hotel_settings_data($type);


    return $res;

    }
}


if ( ! function_exists('pt_get_hotel_settings_value'))
{
    function pt_get_hotel_settings_value($type,$id)
    {
       $CI = get_instance();

    $CI->load->model('Hotels/Hotels_model');

    $res = $CI->Hotels_model->get_hotel_settings_value($type,$id);


    return $res;

    }
}





if ( ! function_exists('pt_get_hsettings_data'))
{
    function pt_get_hsettings_data($type)
    {
       $CI = get_instance();

    $CI->load->model('Hotels/Hotels_model');

    $res = $CI->Hotels_model->get_hsettings_data($type);


    return $res;

    }
}




if ( ! function_exists('pt_search_select_box'))
{
    function pt_search_select_box($for,$pos)
    {
      $html = '';
       $CI = get_instance();

    $CI->load->model('admin/settings_model');
    $CI->load->model('Admin/Countries_model');

    $res = $CI->Settings_model->get_front_settings($for);
    $all_countries = $CI->Countries_model->get_all_countries();


    $country = $res[0]->front_search_country;
    $state = $res[0]->front_search_state;
    $city = $res[0]->front_search_city;
    $txtsearch = $res[0]->front_txtsearch;

      $sel_states = $CI->Countries_model->get_country_state($country);
       $sel_cities = $CI->Countries_model->get_state_city($state);

if($pos == "home" && $txtsearch == "1"){



 ?>
  <!-- <div class="form-group">
 <label for="">Hotel or City Name</label>   -->
<input name="searching" type="text" class="form-control searching empty" placeholder="&#xf041; <?php echo trans('026');?>">
<!--</div>  -->
 <?php
  }elseif($pos == "side"  && $txtsearch == "1"){
  ?>
  <!-- <div class="form-group">
  <label for="">Hotel or City Name</label>-->
<input name="searching" type="text" class="form-control searching" id="" placeholder="<?php echo trans('026');?>">
<!--</div> -->


  <?php


  }else{ ?>

  <?php
    if(empty($country)){


  if($pos == "side"){
?>

<h4>Where</h4>
<?php

}else{
?>

<?php

}
?>
       <div>
    <select data-placeholder="Select" data-live-search="true" name="country" class="chosen-select" onchange="populateStates(this.options[this.selectedIndex].value,'hotels')" >
            <option value=""> Select Country </option>
    <?php foreach($all_countries as $c){
     ?>
     <option value="<?php echo $c->iso2;?>"><?php echo $c->short_name;?></option>
     <?php

     }

     ?>

    </select>

<select data-placeholder="Select" name="state" class="chosen-select" id="hotels_state" onchange="populateCities(this.options[this.selectedIndex].value,'hotels')">
  <option value=""> Select State </option>

 </select>


 			 <select data-placeholder="Select" class="chosen-select" name="city" id="hotels_city" >
                <option value=""> Select City </option>

              </select>

     </div>
     <?php
     if($pos == "side"){
?>

<hr>
<?php

}else{
?>

<?php

}


    }elseif(!empty($country) && $state < 1){

  if($pos == "side"){
?>

<h4>Where</h4>
<?php

}else{
?>
 <div class="form-group col-sm-6 col-lg-3">
<?php

}
?>

     <div>

<select data-placeholder="Select" name="state" class="chosen-select" id="hotels_state" onchange="populateCities(this.options[this.selectedIndex].value,'hotels')">
  <option value=""> Select State </option>
   <?php foreach($sel_states as $s){
                               ?>
                               <option value="<?php echo $s->state_id;?>" ><?php echo $s->state_name;?></option>
                               <?php

                               }

                               ?>

</select>


 			 <select data-placeholder="Select" class="chosen-select" name="city" id="hotels_city" >
                <option value=""> Select City </option>

              </select>

     </div>
         <?php
     if($pos == "side"){
?>

<hr>
<?php

}else{
?>
 </div>
<?php

}


    }elseif($state > 0 && $city < 1){

  if($pos == "side"){
?>

<h4>Where</h4>
<?php

}else{
?>
 <div class="form-group col-sm-6 col-lg-3">
<?php

}
?>
        <div>


 			 <select data-placeholder="Select" class="chosen-select" name="city" id="hotels_city" >
                <option value=""> Select City </option>
                         <?php foreach($sel_cities as $cit){
                               ?>
                               <option value="<?php echo $cit->city_id;?>"><?php echo $cit->city_name;?></option>
                               <?php

                               }

                               ?>
              </select>

     </div>
        <?php
     if($pos == "side"){
?>

<hr>
<?php

}else{
?>
</div>
<?php

}



    }

    }

    }
}


