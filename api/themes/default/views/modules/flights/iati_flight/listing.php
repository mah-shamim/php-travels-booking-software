<link href="<?php echo $theme_url; ?>assets/css/iati.css" rel="stylesheet" type="text/css">
<?php

function yearArray($year) {

 

    $range = array();

    $start = strtotime($year.'-01-01'); 

    $end = strtotime($year.'-12-31');

   

    do {

     $range[] = date('Y-m-d', $start);

     $start = strtotime("+ 1 day", $start);

    } while ( $start <= $end );

   

   return $range;

}



?>

<style>

  .summary  { border-right: solid 2px rgb(0, 93, 247); color: #ffffff; background: #4285f4; padding: 14px; float: left; font-size: 14px; }

  .sideline { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; display: table-cell; border-left: solid 1px #e7e7e7; }

  .localarea { margin-top: 15px; margin-bottom: 15px; padding-left: 15px; }

  .captext  { display: block; font-size: 14px; font-weight: 400; color: #23527c; line-height: 1.2em; text-transform: capitalize; }

  .ellipsis { max-width: 250px; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; }

  .noResults { right: 30px; top: 26px; color: #008cff; font-size: 16px; }

  .table { margin-bottom: 5px; }

  .fa-arrow-right { font-size: 10px; }

  a.disabled { pointer-events: none; cursor: default; }

  .table-striped>tbody>tr:nth-of-type(odd) { background-color: #EEEEEE; }

  .disabled_dates{background-color: #dddddd;}

</style>

<?php if($ismobile): ?>

<div class="modal <?php if($isRTL == "RTL"){ ?> right <?php } else { ?> left <?php } ?> fade" id="sidebar_filter" tabindex="1" role="dialog" aria-labelledby="sidebar_filter">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close go-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="close icon-angle-<?php if($isRTL == "RTL"){ ?>right<?php } else { ?>left<?php } ?>"></i></span></button>

        <h4 class="modal-title go-text-right" id="sidebar_filter"><i class="icon_set_1_icon-65 go-right"></i> <?php echo trans('0191');?></h4>

      </div>

      <?php require $themeurl.'views/includes/filter.php';?>

    </div>

  </div>

</div>

<?php endif; ?>

<div class="header-mob hidden-xs">

  <div class="container">

      <div class="col-xs-2 text-leftt">

        <a data-toggle="tooltip" data-placement="right" title="<?php echo trans('0533');?>" class="icon-angle-left pull-left mob-back" onclick="goBack()"></a>

      </div>

      <div class="col-xs-1 text-center pull-right hidden-xs ttu hidden-lg">

        <div class="row">

          <a class="btn btn-success btn-xs btn-block" data-toggle="collapse" data-target="#modify" aria-expanded="false" aria-controls="modify">

          <i class="icon-filter mob-filter"></i>

          <span><?php echo trans('0106');?></span>

          </a>

        </div>

      </div>

  </div>

</div>

    <div class="search_head">

  <div class="container">

      <?php include $themeurl.'views/modules/iati_flight/search_form.php';?>

    </div>

  </div>

  <div class="clearfix"></div>



<div class="listingbg">

<div class="container">

    <div class="col-md-12">

        <div class="panel panel-default">

            <div class="panel-heading">Dates and Availability</div>

            <div class="panel-body flights">

                <div class="row">

                    <div class="col-md-2">

                        <div class="row">

                            <label class="panel-body tl"><img src="<?php echo $theme_url; ?>assets/img/icons/dep.png"> Departing</label>

                        </div>

                    </div>

                    <div class="col-md-10">

                        <div class="flight-listing">

                        <ul class="nav nav-pills nav-justified" role="tablist">

                                <li><a class="arrow-flight <?php if($_SESSION['fromDate'] == date('Y-m-d'))echo "disabled"?>" onclick="update_date('<?php echo date("Y-m-d", strtotime("-1 day", strtotime($_SESSION['fromDate']))) ?>')" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-left"></i><br><br></a></li>

                                <?php

                                $increment = 1;

                                $decrement = 3;

                                for($i =1;$i<=7;$i++){

                                    if($i == 4)

                                    {

                                        echo  '<li class="active">';

                                    }else{

                                        echo  '<li class="">';

                                    }

                                    if($i<4)

                                    {

                                        $op = "- ".$decrement;

                                        $decrement--;

                                    }else if($i == 4){

                                       $op = "+ 0";

                                    }else{

                                        $op = "+ ".$increment;

                                        $increment++;

                                    }

                                    ?>

                                    <?php $curDate = date("D-M-d", strtotime($op." day", strtotime($_SESSION['fromDate'])));

                                    $passDate = date("Y-m-d", strtotime($op." day", strtotime($_SESSION['fromDate'])));

                                    if($passDate < date("Y-m-d"))

                                    {

                                        $disabled = "disabled";

                                        $tag = "span";

                                    }else{

                                        $disabled = "enable";



                                    }

                                    $arraDate = explode('-', $curDate);

                                    ?>

                                     <a class="<?=$disabled?>" href="javascript:void();" onclick="update_date('<?php echo $passDate; ?>')">

                                         <?php echo $arraDate[0] ?>

                                         <br>

                                         <strong><?php echo $arraDate[1] ?></strong><br>

                                         <?php echo $arraDate[2]; ?>

                                     </a>

                                            </li>

                                    <?php

                                }

                                ?>

                                <li><a class="arrow-flight" onclick="update_date('<?php echo date("Y-m-d", strtotime("+1 day", strtotime($_SESSION['fromDate']))) ?>')" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-right"></i><br><br></a></li>

                            </ul>

                        </div>

                    </div>

                </div>

                <?php if($isReturnFlight){ ?>

                    <!-- Calendar PArt 2 -->

                    <div class="row">

                    <div class="col-md-2">

                        <div class="row">

                            <label class="panel-body tl"><img src="<?php echo $theme_url; ?>assets/img/icons/arr.png"> Return</label>

                        </div>

                    </div>

                    <div class="col-md-10">

                    <div class="flight-listing">

                        <ul class="nav nav-pills nav-justified" role="tablist">

                                <li><a class="arrow-flight <?php if($_SESSION['returnDate'] == date('Y-m-d'))echo "disabled"?>" onclick="update_date_arv('<?php echo date("Y-m-d", strtotime("-1 day", strtotime($_SESSION['returnDate']))) ?>')" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-left"></i><br><br></a></li>

                                <?php

                                $increment = 1;

                                $decrement = 3;

                                for($i =1;$i<=7;$i++){

                                    if($i == 4)

                                    {

                                        echo  '<li class="active">';

                                    }else{

                                        echo  '<li class="">';

                                    }

                                    if($i<4)

                                    {

                                        $op = "- ".$decrement;

                                        $decrement--;

                                    }else if($i == 4){

                                       $op = "+ 0";

                                    }else{

                                        $op = "+ ".$increment;

                                        $increment++;

                                    }

                                    ?>

                                    <?php $curDate = date("D-M-d", strtotime($op." day", strtotime($_SESSION['returnDate'])));

                                    $passDate = date("Y-m-d", strtotime($op." day", strtotime($_SESSION['returnDate'])));

                                    if($passDate < date("Y-m-d"))

                                    {

                                        $disabled = "disabled";

                                        $tag = "span";

                                    }else{

                                        $disabled = "enable";



                                    }

                                    $arraDate = explode('-', $curDate);

                                    ?>

                                     <a class="<?=$disabled?>" href="javascript:void();" onclick="update_date_arv('<?php echo $passDate; ?>')">

                                         <?php echo $arraDate[0] ?>

                                         <br>

                                         <strong><?php echo $arraDate[1] ?></strong><br>

                                         <?php echo $arraDate[2]; ?>

                                     </a>

                                            </li>

                                    <?php

                                }

                                ?>

                                <li><a class="arrow-flight" onclick="update_date_arv('<?php echo date("Y-m-d", strtotime("+1 day", strtotime($_SESSION['returnDate']))) ?>')" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-right"></i><br><br></a></li>

                            </ul>

                        </div>

                    </div>

                </div>

                    <!-- Calendar PArt 2 End -->

                <?php } ?>



                <hr style="margin-top: 10px; margin-bottom: 10px;" >

                <!-- Extra Code - Not Needed. -->

                <!-- <?php if($payload[5] == "round") { ?>

                <div class="row">

                    <div class="col-md-2">

                        <div class="row">

                            <label class="panel-body tl"><img src="<?php echo $theme_url; ?>assets/img/icons/arr.png"> Returning</label>

                        </div>

                    </div>

                    <div class="col-md-10">

                        <div class="flight-listing">

                            <ul class="nav nav-pills nav-justified" role="tablist">

                                <li><a class="arrow-flight" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-left"></i><br><br></a></li>

                                <li class=""><a href="">MAR<br><strong>19</strong><br>Monday</a></li>

                                <li class=""><a href="">MAR<br><strong>20</strong><br>Monday</a></li>

                                <li class=""><a href="">MAR<br><strong>21</strong><br>Monday</a></li>

                                <li class="active"><a href="">MAR<br><strong>22</strong><br>Monday</a></li>

                                <li class=""><a href="">MAR<br><strong>23</strong><br>Monday</a></li>

                                <li class=""><a href="">MAR<br><strong>24</strong><br>Monday</a></li>

                                <li class=""><a href="">MAR<br><strong>25</strong><br>Monday</a></li>

                                <li><a class="arrow-flight" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-right"></i><br><br></a></li>

                            </ul>

                        </div>

                    </div>

                </div>

                <?php } ?> -->

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="panel panel-default">

            <div class="panel-heading">Filter Your Search</div>

            <div class="">

                <div class="checkbox">

                    <label>

                    <input type="checkbox" value="nodirect" data-filtertype="transit" class="stopFilter" id="nonstop1" <?php if($payload[11]==1) echo "checked"?>  name="stopFilter"> Transit

                    </label>

                </div>

                <div class="checkbox">

                    <label>

                    <input type="checkbox" value="direct" data-filtertype="transit" class="stopFilter" id="nonstop"  name="stopFilter" <?php if($payload[10]==1) echo "checked"?> > Non-Stop

                    </label>

                </div>

                <hr>

                <!-- <div class="checkbox">

                    <label>

                    <div class="icheckbox_square-grey">

                        <input type="checkbox" value="" data-filtertype="refundable" name="" id="Refundable" class="checkbox" <?php if($payload[12] == 1) echo "checked"?> >

                    </div>

                    <label for="Refundable" class="css-label go-left" > Refundable</label>

                </label>

                </div> -->



                <!-- <div class="checkbox">

                  <label>

                    <div class="icheckbox_square-grey">

                        <input type="checkbox" value="" data-filtertype="refundable" name="" id="Refundable" class="checkbox" <?php if($payload[12] == 1) echo "checked"?> >

                    </div>

                    <label for="Refundable" class="css-label go-left" > None Refundable</label>

                    </label>

                </div> -->

                <div style="background: #eee; width: 100%; padding: 12px;"><b class="heading primary">Filter by Carrier</b></div>

                <?php  

                    $carriers = array();

                    if($isReturnFlight){

                        foreach($iatiData as $flights) {

                            foreach($flights as $flight){

                                foreach($flight->legs as $leg){

                                    if(!(in_array(

                                        array(

                                            'code' => $leg->carrierCode,

                                            'name' => $leg->carrierName

                                        ), $carriers

                                    ))){

                                       array_push($carriers, array(

                                        'code' => $leg->carrierCode,

                                        'name' => $leg->carrierName

                                    )); 

                                    }

                                }

                            }

                        }

                    }else{

                        foreach($iatiData as $flight) {

                            foreach($flight->legs as $leg){

                                if(!(in_array(

                                    array(

                                        'code' => $leg->carrierCode,

                                        'name' => $leg->carrierName

                                    ), $carriers

                                ))){

                                    array_push($carriers, array(

                                    'code' => $leg->carrierCode,

                                    'name' => $leg->carrierName

                                )); 

                                }

                            }

                        }

                    }

                    foreach($carriers as $carrier){

                ?>

                <div style="padding: 0px 10px;" class="go-right">

                <div id="test" class="icheckbox_square-grey">

                        <input type="checkbox" data-filtertype="carrier" id="flight_<?php echo $carrier['code']; ?>" value="<?php echo $carrier['code']; ?>" name="" class="checkbox airlines_filter">

                    </div>

                    

                    <label style="display: inline-block; white-space: nowrap !important; overflow: hidden !important; max-width: 100%; width: 170px; font-size: 12px; margin-bottom: 0px; margin-top: 8px; font-weight: 700;" for="flight_<?php echo $carrier['code']; ?>" class="css-label go-left">&nbsp;&nbsp; <img style="height: 20px; width:50px; margin-top: 8px;float: left;" src="<?php echo base_url(); ?>uploads/images/flights/airlines/<?php echo $carrier['code']; ?>.png" /> &nbsp;&nbsp; <span style="margin-top: 15px; position: absolute; white-space: nowrap !important; overflow: hidden !important; width: 122px;e"><?php echo $carrier['name']; ?></span></label> 

                </div>

                <div class="clearfix"></div>

                <?php  } ?>

                <!-- End Filter by Carrier -->

            </div>

        </div>

    </div>

    <style>

        .flights-list {

            list-style: none;+

        }

        .flights-list li {

            display: inline;

        }

    </style>

    <?php if($isReturnFlight){ ?>

        <!-- Return flight -->

        <div class="col-md-9">

            <div class="panel panel-default">

                <div class="panel-heading">Flights and Dates</div>

                <table id="load_data" class="bgtable table flight-listing flights">

                <?php 

                if(!empty($iatiData)){

                $i = 0; foreach($iatiData as $flights) {

                    

                    foreach($flights as $flight){

                        // echo "<pre>";print_r($flight);exit();

                ?>

                    <tr data-carrier="<?php echo $flight->legs[0]->carrierCode; ?>" data-flightid="<?php echo $flight->id; ?>">

                <?php

                    }

                ?>

                        <td class="wow fadeIn p-10-0 animated" style="<!--width:100%;display:block-->">

                            <ul class="ss-list">

                            <?php 

                            $switch = true;

                            $total_price = 0;

                            foreach($flights as $flight):

                                    $fares = $flight->fares;

                                ?>

                                <form action="<?php echo base_url('flightsi/makeTicket'); ?>" method="POST">

                                <input type="hidden" name="bookingData" value="<?=$flight?>">  

                                <li data-carrier="<?=$flight->legs[0]->carrierCode?>" data-transit="<?=count($flight->legs) - 1?>">

                                    <div class="col-md-9">

                                    <div class="row pt10">

                                            <div class="col-md-1 text-center">

                                                <img style="height: 20px;margin-top: 8px;margin-left: -8px;" height=50 width=50 src="<?php echo $airline_logos.$flight->legs[0]->carrierCode.".png"; ?>" class="center-block" alt="">

                                            </div>



                                            <div class="col-md-1 text-center">

                                                

                                                <?php foreach($flight->legs as $leg): ?>

                                                    <small>

                                                    <?php echo $leg->flightNo; ?>

                                                </small>

                                                <?php endforeach; ?> 

                                                    <br>

                                            </div>

                                            

                                            <ul class="col-md-4 col-sm-5 col-xs-10">

                                                <?php foreach($flight->legs as $leg): ?>

                                                <li>

                                                <img src="<?php echo $theme_url; ?>assets/img/qr.png" class="inline visible-xs" alt="Departure">                                   

                                                <span data-toggle="tooltip" data-placement="top" title="<?php echo $leg->departureCityName; ?>"><?php echo $leg->departureAirport; ?></span> <i class="fa fa-arrow-right"></i> <span data-toggle="tooltip" data-placement="top" title="<?php echo $leg->arrivalCityName; ?>"> <?php echo $leg->arrivalAirport; ?></span> &nbsp; <small><b><?php echo $leg->legDurationMinute; ?> Min</b></small>

                                                <div class="clearfix"></div>

                                                </li>

                                                <?php endforeach; ?> 

                                            </ul>   



                                            <div class="col-sm-4 col-xs-10 col-sm-offset-0 col-xs-offset-2">

                                                <?php 

                                                    $count = 0;

                                                    foreach($flight->legs as $leg):

                                                        $count = $count + 1;

                                                ?>

                                                    <p class=""><strong><?php echo "Departure Time: ".substr($leg->departureTime,11, 5); ?></strong></p>

                                                <?php

                                                    endforeach;

                                                    if($count > 1){

                                                ?>

                                            </div>

                                            <div class="col-sm-2 col-xs-10 col-xs-offset-2 col-sm-offset-0">

                                                <div class="row">

                                                    <p><span class="fa fa-exchange"></span> <?php echo $count-1; ?> Stop</p> 

                                                    <div class="clearfix"></div>

                                                </div>

                                            </div>

                                            <?php

                                            }else{

                                            ?>

                                            </div>

                                            <div class="col-sm-2 col-xs-10 col-xs-offset-2 col-sm-offset-0">

                                                <div class="row">

                                                    <p><span class="fa fa-exchange"></span> <?php echo "Direct"; ?></p> 

                                                    <div class="clearfix"></div>

                                                </div>

                                            </div>

                                            <?php  

                                            }

                                            ?>                                        

                                        </div>

                                        <div class="collapse" id="collapseExample<?php echo $i;?>">

                                            <div class="panel-body" style="background:white">

                                                <div style="font-size:12px">

                                                        <?php foreach($flight->legs as $leg): ?>

                                                            <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/dep.png"> <?php echo $leg->departureCityName; ?> &nbsp;</p></div>

                                                            <div class="col-md-2 text-center"><p><i class="fa fa-arrow-right"></i></p></div>

                                                            <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/arr.png"> &nbsp; <?php echo $leg->arrivalCityName; ?></p></div>

                                                        <?php endforeach; ?>

                                                    <hr style="margin-bottom:10px"><br>

                                                        <p class="main-title go-right">Description and baggage</p>

                                                    <div class="clearfix"></div>

                                                        <i class="tiltle-line  go-right"></i>

                                                    <div class="clearfix"></div>

                                                        <?php foreach($fares as $fare): ?>

                                                            <p><table class="table table-striped">

                                                                <thead>

                                                                <tr>

                                                                    <th>Amount</th>

                                                                    <th>Type</th>

                                                                    <th>Tlternative Type</th>

                                                                    <th>Flight Number</th>

                                                                    <th>Departure Airport</th>

                                                                    <th>Arrival Airport</th>

                                                                    <th>Carrier</th>

                                                                    <th>Class Code</th>

                                                                </tr>

                                                                </thead>

                                                                <?php foreach($fare->baggageAllowances as $bag):?>

                                                                <tbody>

                                                                <tr>

                                                                    <td><?=$bag->amount?></td>

                                                                    <td><?=$bag->type?></td>

                                                                    <td><?=$bag->alternativeType?></td>

                                                                    <td><?=$bag->flightNumber?></td>

                                                                    <td><?=$bag->departureAirport?></td>

                                                                    <td><?=$bag->arrivalAirport?></td>

                                                                    <td><?=$bag->carrier?></td>

                                                                    <td><?=$bag->classCode?></td>

                                                                </tr>

                                                                </tbody>

                                                                <?php endforeach; ?>

                                                            </table></p>

                                                        <?php endforeach; ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-3 col-sm-3 return-class">

                                        <p class="listing-price text-center">

                                        <?php

                                        if($switch){

                                            $switch = false;

                                        ?>

                                            <form action="<?php echo base_url('flightsi/makeTicket'); ?>" method="POST">

                                                <input type="hidden" name="searchId" value="<?=$searchId?>">

                                                <input type="hidden" name="bookingData" value='<?=json_encode($flight)?>'>
                                                <input type="hidden" name="outbound" value='<?=json_encode($flight)?>'>
                                                <input type="hidden" name="flight[]" value='<?=json_encode($flight)?>'>

                                                <button type="submit" id="bookbtn" class="btn btn-danger btn-sm btn-block bookbtn">Book Now &nbsp; <span class="fa fa-caret-right"></span></button>

                                            </form>

                                        <?php

                                        }

                                        ?>

                                        <?php foreach($flight->fares as $fare): ?>

                                         <small><?php echo current($fares)->type." ".$fare->totalSingleAdultFare." ".current($fares)->currency; ?></small>

                                            <a href="javascript:void(0);" id="priceDetails" data-apis='' class="text-center" data-toggle="collapse" data-target="#collapseExample<?php echo $i; $i++; ?>" aria-expanded="false" aria-controls="collapseExample" >More Details</a>

                                        <?php endforeach; ?>

                                        </p>   

                                    </div>

                                </li>

                                </form>

                            <?php endforeach; ?>

                            </ul>

                        </td>

                    </tr>

                <?php } }else{ ?>

                    <div class="alert alert-danger">

                        <p>No Response From Iati API.</p>

                    </div>

                <?php } ?>

                </table>

        </div>

        <!-- Return Flight End -->

    <?php }else{ ?>

        <!--  Single Flights -->

        <div class="col-md-9">

            <div class="panel panel-default">

                <div class="panel-heading">Flights and Dates</div>

                <table id="load_data" class="bgtable table flight-listing flights">

                <?php 

                $i = 0;

                if(!empty($iatiData)){

                

                foreach($iatiData as $flight){

                    // echo "<pre>";print_r($flight);exit();

                    $fares = $flight->fares;

                ?>

                <tr data-carrier="<?php echo $leg->carrierCode; ?>" data-flightid="<?php echo $flight->id; ?>">

                    <td class="wow fadeIn p-10-0 animated" style="<!--width:100%;display:block-->">

                        <ul class="ss-list">

                            <li data-carrier="<?=$flight->legs[0]->carrierCode?>" data-transit="<?=count($flight->legs) - 1?>">

                                <div class="col-md-9">

                                <div class="row pt10">

                                        <div class="col-md-1 text-center">

                                            <img style="height: 20px;margin-top: 8px;margin-left: -8px;" height=50 width=50 src="<?php echo $airline_logos.$flight->legs[0]->carrierCode.".png"; ?>" class="center-block" alt="">

                                        </div>



                                        <div class="col-md-1 text-center">

                                            

                                            <?php foreach($flight->legs as $leg): ?>

                                                <small>

                                                <?php echo $leg->flightNo; ?>

                                            </small>

                                            <?php endforeach; ?> 

                                                <br>

                                        </div>

                                        

                                        <ul class="col-md-4 col-sm-5 col-xs-10 sm-margin">

                                            <?php foreach($flight->legs as $leg): ?>

                                            <li>

                                            <img src="<?php echo $theme_url; ?>assets/img/qr.png" class="inline visible-xs" alt="Departure">                                   

                                            <span data-toggle="tooltip" data-placement="top" title="<?php echo $leg->departureCityName; ?>"><?php echo $leg->departureAirport; ?></span> <i class="fa fa-arrow-right"></i> <span data-toggle="tooltip" data-placement="top" title="<?php echo $leg->arrivalCityName; ?>"> <?php echo $leg->arrivalAirport; ?></span> &nbsp; <small><b><?php echo $leg->legDurationMinute; ?> Min</b></small>

                                            <div class="clearfix"></div>

                                            </li>

                                            <?php endforeach; ?> 

                                        </ul>   



                                        <div class="col-sm-4 col-xs-10 col-sm-offset-0 col-xs-offset-2 sm-center">

                                            <?php 

                                                $count = 0;

                                                foreach($flight->legs as $leg):

                                                    $count = $count + 1;

                                            ?>

                                                <p class=""><strong><?php echo "Departure Time: ".substr($leg->departureTime,11, 5); ?></strong></p>

                                            <?php

                                                endforeach;

                                                if($count > 1){

                                            ?>

                                        </div>

                                        <div class="col-sm-2 col-xs-10 col-xs-offset-2 col-sm-offset-0">

                                            <div class="row">

                                                <p class="sm-pos"><span class="fa fa-exchange"></span> <?php echo $count-1; ?> Stop</p> 

                                                <div class="clearfix"></div>

                                            </div>

                                        </div>

                                        <?php

                                        }else{

                                        ?>

                                        </div>

                                        <div class="col-sm-2 col-xs-10 col-xs-offset-2 col-sm-offset-0">

                                            <div class="row">

                                                <p><span class="fa fa-exchange"></span> <?php echo "Direct"; ?></p> 

                                                <div class="clearfix"></div>

                                            </div>

                                        </div>

                                        <?php  

                                        }

                                        ?>                                        

                                    </div>

                                    <div class="collapse" id="collapseExample<?php echo $i;?>">

                                        <div class="panel-body" style="background:white">

                                            <div style="font-size:12px">

                                                    <?php foreach($flight->legs as $leg): ?>

                                                        <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/dep.png"> <?php echo $leg->departureCityName; ?> &nbsp;</p></div>

                                                        <div class="col-md-2 text-center"><p><i class="fa fa-arrow-right"></i></p></div>

                                                        <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/arr.png"> &nbsp; <?php echo $leg->arrivalCityName; ?></p></div>

                                                    <?php endforeach; ?>

                                                <hr style="margin-bottom:10px"><br>

                                                    <p class="main-title go-right">Description and baggage</p>

                                                <div class="clearfix"></div>

                                                    <i class="tiltle-line  go-right"></i>

                                                <div class="clearfix"></div>

                                                    <?php foreach($fares as $fare): ?>

                                                        <p><table class="table table-striped">

                                                            <thead>

                                                            <tr>

                                                                <th>Amount</th>

                                                                <th>Type</th>

                                                                <th>Tlternative Type</th>

                                                                <th>Flight Number</th>

                                                                <th>Departure Airport</th>

                                                                <th>Arrival Airport</th>

                                                                <th>Carrier</th>

                                                                <th>Class Code</th>

                                                            </tr>

                                                            </thead>

                                                            <?php foreach($fare->baggageAllowances as $bag):?>

                                                            <tbody>

                                                            <tr>

                                                                <td><?=$bag->amount?></td>

                                                                <td><?=$bag->type?></td>

                                                                <td><?=$bag->alternativeType?></td>

                                                                <td><?=$bag->flightNumber?></td>

                                                                <td><?=$bag->departureAirport?></td>

                                                                <td><?=$bag->arrivalAirport?></td>

                                                                <td><?=$bag->carrier?></td>

                                                                <td><?=$bag->classCode?></td>

                                                            </tr>

                                                            </tbody>

                                                            <?php endforeach; ?>

                                                        </table></p>

                                                    <?php endforeach; ?>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-3 col-sm-3 return-class">

                                    <p class="listing-price text-center">

                                    <?php foreach($fares as $fare): ?>

                                        <small><?php echo $fare->type." ".$fare->totalSingleAdultFare." ".$fare->currency; ?></small>

                                    <?php endforeach; ?>

                                    <span class="strong">

                                    <form action="<?php echo base_url('flightsi/makeTicket'); ?>" method="POST">

                                        <input type="hidden" name="searchId" value="<?=$searchId?>">

                                        <input type="hidden" name="bookingData" value='<?=json_encode($flight)?>'>
                                        <input type="hidden" name="inbound" value='<?=json_encode($flight)?>'>
                                        <input type="hidden" name="flight[]" value='<?=json_encode($flight)?>'>

                                        <button type="submit" id="bookbtn" class="btn btn-danger btn-sm btn-block bookbtn">Book Now &nbsp; <span class="fa fa-caret-right"></span></button>

                                    </form>

                                        </p>

                                        <a href="javascript:void(0);" class="text-center sm-center-a" data-toggle="collapse" data-target="#collapseExample<?php echo $i; $i++; ?>" aria-expanded="false" aria-controls="collapseExample" >More Details</a>

                                </div>

                            </li>  

                        </ul>

                    </td>

                </tr>

                <?php  }

                }else{

                ?>

                    <div class="alert alert-danger">

                        <p>No Response From Iati API.</p>

                    </div>

                <?php

                }

                 ?>

                </table>

        </div>

        <!-- Single Flight End -->

    <?php } ?>



  <div class="offset-3 offset-RTL">

    <ul class="nav nav-pills nav-justified pagination-margin" role="tablist">

        <?php  echo $links; ?>

    </ul>

</div>

</div>

</div>

</div>

<script>



function update_date(param){

    current_url = window.location.href;

    var obj = {}; 

        current_url.replace(/([^?=&]+)=([^&]*)/g, function(m, key, value) {

            obj[decodeURIComponent(key)] = decodeURIComponent(value);

        });

    obj['departure'] = param;

    window.location.href = '<?php echo base_url("/iati_flight/search?"); ?>' + serialize(obj);

}



function update_date_arv(param){

    current_url = window.location.href;

    var obj = {}; 

        current_url.replace(/([^?=&]+)=([^&]*)/g, function(m, key, value) {

            obj[decodeURIComponent(key)] = decodeURIComponent(value);

        });

    obj['arrival'] = param;

    window.location.href = '<?php echo base_url("/iati_flight/search?"); ?>' + serialize(obj);

}



// convert array to QueryString

serialize = function(obj, prefix) {

    var str = [],

        p;

    for (p in obj) {

        if (obj.hasOwnProperty(p)) {

        var k = prefix ? prefix + "[" + p + "]" : p,

            v = obj[p];

        str.push((v !== null && typeof v === "object") ?

            serialize(v, k) :

            encodeURIComponent(k) + "=" + encodeURIComponent(v));

        }

    }

    return str.join("&");

}



$(document).ready(function() {

    $('input[type=checkbox]').on('ifChecked', function (event) {
        var showAll = true;
        $('tr').not('.first').hide();
        $('input[type=checkbox]').each(function () {
            if ($(this)[0].checked) {
                showAll = false;
                var value = $(this).val();
                console.log(value);
                console.log($(this).data('filtertype'));
                if ($(this).data('filtertype') === 'carrier') {
                    $('tr ul.ss-list li[data-carrier="' + value + '"]').closest('tr').show();
                } else if ($(this).data('filtertype') === 'transit') {
                    if (value === 'direct') {
                        $('tr ul.ss-list li[data-transit=0]').closest('tr').show();
                    } else {
                        $('tr ul.ss-list li').closest('tr').show();
                    }
                }
            }
        });
        if(showAll) { 
            $('tr').show(); 
        }
    });

    $('input[type=checkbox]').on('ifUnchecked', function (event) {
        var showAll = true;
        $('tr').not('.first').hide();
        $('input[type=checkbox]').each(function () {
            if ($(this)[0].checked) {
                showAll = false;
                var value = $(this).val();
                if ($(this).data('filtertype') === 'carrier') {
                    $('tr ul.ss-list li[data-carrier="' + value + '"]').closest('tr').show();
                } else if ($(this).data('filtertype') === 'transit') {
                    if (value === 'direct') {
                        $('tr ul.ss-list li[data-transit=0]').closest('tr').show();
                    } else {
                        $('tr ul.ss-list li').closest('tr').show();
                    }
                }
            }
        });
        if(showAll) { 
            $('tr').show(); 
        }
    });

    // $('input[type=checkbox]').on('ifChecked', function (event) {
        
    //     var filter = [];

    //     $('input.airlines_filter:checkbox:not(:checked)').each(function () {

    //         filter.push('tr[data-carrier='+$(this).val()+']');

    //     });

    //     $(filter.join(',')).hide();

    // }); 

    // $('input[type=checkbox]').on('ifUnchecked', function (event) {

    //     var filter = [];

    //     $('input.airlines_filter:checkbox:not(:checked)').each(function () {

    //         filter.push('tr[data-carrier='+$(this).val()+']');

    //     });

    //     $(filter.join(',')).show();

    // }); 

});



</script>