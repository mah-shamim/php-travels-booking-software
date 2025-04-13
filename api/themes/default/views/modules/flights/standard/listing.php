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
    .form-inner  label{position:static}
    .form-icon-left .icon-font{top: -2px;}
</style>
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
        <?php echo searchForm($appModule); ?>
    </div>
</div>
<div class="clearfix"></div>

<div class="listingbg">
    <div class="container">
        <div class="col-md-12">
            <?php if($payload[1] != "0") {?>
                <!--<div class="panel panel-default">
                    <div class="panel-heading"><?php echo trans('0583');?> <?php echo trans('0251');?></div>
                    <div class="panel-body flights">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="row">
                                    <label class="panel-body tl"><img src="<?php echo $theme_url; ?>assets/img/icons/dep.png"> <?php echo trans('0472');?></label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="flight-listing">
                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        <li><a class="arrow-flight <?php if($payload[3] == date('Y-m-d'))echo "disabled"?>" onclick="update_date('<?php echo date("Y-m-d", strtotime("-1 day", strtotime($payload[3]))) ?>',3)" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-left"></i><br><br></a></li>
                                        <div class="clearfix"></div>
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
                                            <?php $curDate = date("D-M-d", strtotime($op." day", strtotime($payload[3])));
                                            $passDate = date("Y-m-d", strtotime($op." day", strtotime($payload[3])));
                                            if($passDate < date("Y-m-d"))
                                            {
                                                $disabled = "disabled";
                                                $tag = "span";
                                            }else{
                                                $disabled = "enable";

                                            }
                                            $arraDate = explode('-', $curDate);
                                            ?>
                                            <a class="<?=$disabled?>" href="javascript:void();" onclick="update_date('<?php echo $passDate; ?>',3)">
                                                <?php echo $arraDate[0] ?>
                                                <br>
                                                <strong><?php echo $arraDate[1] ?></strong><br>
                                                <?php echo $arraDate[2]; ?>
                                            </a>


                                            <?php
                                        }
                                        ?>
                                        <li><a class="arrow-flight" onclick="update_date('<?php echo date("Y-m-d", strtotime("+1 day", strtotime($payload[3]))) ?>',3)" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-right"></i><br><br></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php  if($payload[5] != "oneway")
                        { ?>
                            <hr style="margin-top: 10px; margin-bottom: 10px;" >
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="row">
                                        <label class="panel-body tl"><img src="<?php echo $theme_url; ?>assets/img/icons/arr.png"> <?php echo trans('0473');?></label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="flight-listing">
                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                            <li><a class="arrow-flight <?php if($payload[4] == date('Y-m-d'))echo "disabled"?>" onclick="update_date('<?php echo date("Y-m-d", strtotime("-1 day", strtotime($payload[4]))) ?>',4)" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-left"></i><br><br></a></li>
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
                                                <?php $curDate = date("D-M-d", strtotime($op." day", strtotime($payload[4])));
                                                $passDate = date("Y-m-d", strtotime($op." day", strtotime($payload[4])));
                                                if($passDate < date("Y-m-d"))
                                                {
                                                    $disabled = "disabled";
                                                    $tag = "span";
                                                }else{
                                                    $disabled = "enable";

                                                }
                                                $arraDate = explode('-', $curDate);
                                                ?>
                                                <a class="<?=$disabled?>" href="javascript:void();" onclick="update_date('<?php echo $passDate; ?>',4)">
                                                    <?php echo $arraDate[0] ?>
                                                    <br>
                                                    <strong><?php echo $arraDate[1] ?></strong><br>
                                                    <?php echo $arraDate[2]; ?>
                                                </a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                            <li><a class="arrow-flight" onclick="update_date('<?php echo date("Y-m-d", strtotime("+1 day", strtotime($payload[4])))?>',4)" href="javascript:void();"><br><i class="glyphicon-chevron-right fa fa-angle-right"></i><br><br></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>-->
            <?php }?>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo trans('0191');?></div>
                <div class="panel-body">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="no" class="stopFilter" id="nonstop"  name="stopFilter" <?php if($payload[10]==1) echo "checked"?> > Non-Stop
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="yes" class="stopFilter" id="nonstop1" <?php if($payload[11]==1) echo "checked"?>  name="stopFilter"> Transit
                        </label>
                    </div>
                    <hr>
                    <div style="padding: 0px 20px;" class="go-right">
                        <div class="icheckbox_square-grey">
                            <input type="checkbox" value="" name="" id="Refundable" class="checkbox" <?php if($payload[12] == 1) echo "checked"?> >
                        </div>
                        <label for="Refundable" class="css-label go-left" >&nbsp;&nbsp;<?php echo trans('0344');?></label>
                    </div>
                    <hr>
                    <div><b class="heading primary"><?php echo trans('0136');?></b></div>
                    <br>
                    <?php  foreach($airlines as $re) {  ?>
                        <div style="padding: 0px 10px;" class="row go-right">
                            <div style="margin-top: -15px;" class="icheckbox_square-grey go-right">
                                <input type="checkbox" id="checkair<?php echo $re->name; ?>" value="<?php echo $re->name; ?>" name="" class="checkbox airlines_filter" <?php if($re->check) echo "checked"?> />
                                <div class="clearfix"></div>
                            </div>
                            <label style="max-width: 188px;" for=""class="css-label go-left ellipsis">&nbsp;&nbsp; <img style="max-width:35px" src="<?php echo PT_FLIGHTS_AIRLINES.$re->thumbnail; ?>" /> &nbsp;&nbsp; <?php echo $re->name; ?></label>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo trans('0252');?> <?php echo trans('0564');?></div>
                <?php if(empty($result)){ ?>
                    <div class="alert alert-danger"><?php echo trans('066');?></div>
                <?php }?>
                <table id="load_data" class="bgtable table table-striped flight-listing flights">
                    <?php
                    $setting_id = 0;
                    foreach($result as $i => $re) {  $check = true;?>

                        <?php if($setting_id != $re->setting_id){ ?>
                            <tr>
                            <td class="wow fadeIn p-10-0 animated" style="<!--width:100%;display:block-->">
                            <div class="col-md-9 col-sm-8">
                        <?php } ?>
                        <div class="row pt10">
                            <div class="col-md-2 col-xs-4 text-center">
                                <img src="<?php echo PT_FLIGHTS_AIRLINES.$re->thumbnail; ?>" class="img-responsive center-block" style="margin-top: 6px;" alt="">
                                <small><?php echo json_decode($re->flight_no)[0]; ?></small>
                            </div>
                            <div class="col-md-4 col-sm-3 col-xs-4">
                                <!--<img src="<?php echo $theme_url; ?>assets/img/qr.png" class="inline visible-xs" alt="Departure">-->
                                <p class=""><strong>
                                        <span data-toggle="tooltip" data-placement="top" title="<?php echo $re->from_location; ?>"><?php echo $re->from_code; ?></span> <i class="fa fa-arrow-right"></i>
                                        <?php foreach (json_decode($re->transact) as $trans) { ?>
                                            <span data-toggle="tooltip" data-placement="top" title="<?php echo json_decode($trans)->label; ?>"><?php echo json_decode($trans)->code; ?> <i class="fa fa-arrow-right"></i></span>
                                        <?php } ?>
                                        <span data-toggle="tooltip" data-placement="top" title="<?php echo $re->to_location; ?>"><?php echo $re->to_code; ?></span></strong></p>
                                <p>
                                    <?php if ($payload[5] == 'round' && $setting_id == $re->setting_id): ?>
                                        <small>
                                            <?php echo $re->time_arrival; ?>
                                            (<?=$payload[4]?>)
                                        </small>
                                    <?php else: ?>
                                        <small>
                                            <?php echo $re->time_departure; ?>
                                            (<?=$payload[3]?>)
                                        </small>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-4">
                                <p class="">
                                    <?php if ($payload[5] == 'round' && $setting_id == $re->setting_id): ?>
                                        <small>
                                            <strong><?=$payload[4]?></strong>
                                            <?php echo $re->time_arrival; ?>
                                        </small>
                                    <?php else: ?>
                                        <small>
                                            <strong><?=$payload[3]?></strong>
                                            <?php echo $re->time_departure; ?>
                                        </small>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-sm-3 col-xs-8 hidden-xs">
                                <p class=""><span class="fa fa-clock-o"></span> <strong><?php echo $re->total_hours; ?></strong></p>
                                <p><span class="fa fa-exchange"></span>  <?php echo count(json_decode($re->transact))?><?php echo trans('0423');?></p>
                            </div>
                        </div>
                        <?php if($setting_id != $re->setting_id): ?>
                            <?php  $setting_id = $re->setting_id; ?>
                        <?php endif; ?>

                        <?php if( $result[$i]->setting_id ==$result[$i+1]->setting_id){ ?>
                            <hr>
                        <?php } ?>
                        <div class="collapse" id="collapseExample<?php echo $i;?>">
                            <div class="panel-body" style="background:white">
                                <div class="row" style="font-size:12px">
                                    <?php $trans_locations = json_decode($re->transact);
                                    $transcat = array();
                                    array_push($transcat,$re->from_location);
                                    for($j=0;$j<count($trans_locations);$j++)
                                    {
                                        if($j%2!=0)
                                            array_push($transcat,json_decode($trans_locations[$j])->label);
                                    }
                                    array_push($transcat,$re->to_location);
                                    for($tindex = 0; $tindex<count($transcat)-1;$tindex++){
                                        ?>
                                        <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/dep.png"> &nbsp; <?php if($tindex == 0)echo $transcat[$tindex];else echo $transcat[$tindex];  ?></p></div>
                                        <div class="col-md-2 text-center"><p><i class="fa fa-arrow-right"></i></p></div>
                                        <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/arr.png"> &nbsp; <?php echo $transcat[$tindex+1]?></p></div><?php }?>

                                    <?php if((isset($result[$i-1]) && $result[$i]->setting_id == $result[$i-1]->setting_id)){ ?>
                                        <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/dep.png"> &nbsp; <?php echo $result[$i-1]->from_location; ?></p></div>
                                        <div class="col-md-2 text-center"><p><i class="fa fa-arrow-right"></i></p></div>
                                        <div class="col-md-5"><p><img style="height:16px" src="<?php echo $theme_url; ?>assets/img/icons/arr.png"> &nbsp; <?php echo $result[$i-1]->to_location?></p></div>
                                    <?php }?>

                                </div>
                                <hr style="margin-bottom:10px;margin-top: 15px;">
                                <p class="main-title go-right"><?php echo trans('046');?> | <?php echo trans('0582');?></p>
                                <div class="clearfix"></div>
                                <i class="tiltle-line  go-right"></i>
                                <div class="clearfix"></div>
                                <p><?php echo $re->desc_flight; ?></p>
                            </div>
                        </div>

                        <?php if((isset($result[$i+1]) && $setting_id != $result[$i+1]->setting_id) || ! isset($result[$i+1])){   ?>
                            </div>

                            <div class="col-md-3 col-sm-3 return-class">
                                <p class="listing-price text-center"><small><?php echo  $flight_lib->currencycode ?></small> <span class="strong"><?php

                                        if((isset($result[$i-1]) && $result[$i]->setting_id == $result[$i-1]->setting_id)){
                                            $price = $flight_lib->convertAmount(
                                                ($re->adults_price * $payload[7]) +
                                                ($re->infants_price * $payload[9]) +
                                                ($re->child_price * $payload[8]) +
                                                ($result[$i-1]->adults_price * $payload[7]) +
                                                ($result[$i-1]->infants_price * $payload[9]) +
                                                ($result[$i-1]->child_price * $payload[8]));
                                        }else{
                                            $price = $flight_lib->convertAmount(
                                                ($re->adults_price * $payload[7]) +
                                                ($re->infants_price * $payload[9]) +
                                                ($re->child_price * $payload[8]));
                                        }


                                        echo  $price.$flight_lib->currencysign; ?></span>

                                    <?php
                                    $bookpayload = [];

                                    if($payload[5] == "0")
                                    {
                                        array_push($bookpayload,"oneway");

                                    }else{
                                        array_push($bookpayload,$payload[5]);

                                    }
                                    array_push($bookpayload,$re->setting_id);
                                    array_push($bookpayload,$payload[7]);
                                    array_push($bookpayload,$payload[8]);
                                    array_push($bookpayload,$payload[9]);

                                    ?>
                                    <input id="bookpass_<?=$re->setting_id?>" type="hidden" value="<?php echo implode("/",$bookpayload); ?>">
                                    <button type="button" data-setting_id="<?=$re->setting_id?>" id="bookbtn" class="btn btn-primary btn-sm btn-block bookbtn br25"><?php echo trans('0142');?> &nbsp; <span class="fa fa-caret-right"></span></button>
                                </p>
                                <a href="javascript:void(0)" class="text-center" data-toggle="collapse" data-target="#collapseExample<?php echo $i?>" aria-expanded="false" aria-controls="collapseExample" ><?php echo trans('052');?></a>
                            </div>
                            </td>
                            </tr>
                        <?php }?>
                    <?php } ?>
                </table>
            </div>
            <div class="offset-3 offset-RTL">
                <ul class="nav nav-pills nav-justified pagination-margin" role="tablist">
                    <?php foreach ($links as $link) {
                        echo  $link;
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var abc = <?php echo json_encode($payload); ?>;
        var ab = Object.keys(abc).map(function (key) { return abc[key]; });
        $('#Refundable').on('ifChecked ifUnchecked', function(event){
            $(event.target).change();
            if($('#Refundable').is(":checked"))
            {
                ab[12] = 1;

            }else{
                ab[12] = 0;
            }
            window.location.href = "<?php echo  base_url();?>"+ab.toString().replace(/,/gi,'/');
        });
        var checkboxes = $('[id^=checkair]');
        checkboxes.on('ifChecked ifUnchecked', function (event) {
            $(event.target).change();
            var arr = [];
            for(var i = 13 ;i <= ab.length ; i++)
            {
                ab.splice(i,1);
            }
            $('input.airlines_filter:checkbox:checked').each(function () {
                arr.push($(this).val().replace(/ /gi,'-'));
            });
            ab = ab.concat(arr);
            window.location.href = "<?php echo  base_url();?>"+ab.toString().replace(/,/gi,'/');
        });
        $('[id^=nonstop]').on('ifChecked ifUnchecked', function(event){
            $(event.target).change();
            var arr = [];
            $('[id^=nonstop]:checkbox:checked').each(function () {
                arr.push($(this).val())
            });

            if(arr.indexOf("yes") != -1)
            {
                ab[11] = 1;
            }else{
                ab[11] = 0;
            }
            if(arr.indexOf("no") !== -1)
            {
                ab[10] = 1;
                console.log("0")
            }else{
                ab[10] = 0;
                console.log("1")
            }
            window.location.href = "<?php echo  base_url();?>"+ab.toString().replace(/,/gi,'/');
        });
        $( ".bookbtn" ).click(function() {
            var ab = $('#bookpass_'+$(this).data('setting_id')).val();
            console.log(ab);
            window.location.href = "<?php echo  base_url();?>"+"flights/book/"+ab;
        });
    });
</script>
<script>
    function update_date(param,index){
        var payload = <?php echo json_encode($payload); ?>;
        payload[index] = param;
        var jspayload = Object.keys(payload).map(function (key) { return payload[key]; });
        window.location.href = "<?php echo  base_url();?>"+jspayload.toString().replace(/,/gi,'/');
    }
</script>