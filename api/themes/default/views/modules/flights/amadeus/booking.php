<div id="body-section">
    <br><br>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <style>
    body { 
        background:#d9d9d9;
        font-weight: normal;
    }
    .input-group {
        width: 100%;
    }
    .input-group-addon {
        min-width:150px;
        font-family: 'Noto Sans', sans-serif !important;
    }
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
        color: white !important;
        cursor: default;
        background: #76ce85;
    }
    .nav-tabs>li>a {
        background: rgba(0, 0, 0, 0.09);
        border-radius: 0px;
        color: #000 !important;
        padding: 10px;
        font-size: 14px;
    }
    .switch-ios.switch-light {
        margin-top: 5px !important;
    }
    .panel-default{
        box-shadow: 0 0px 0px rgba(0,0,0,0.19), 0 2px 2px rgba(0,0,0,0.23);
    }
    .btn-circle {
        border-radius: 50%;font-size: 54px;padding: 10px 20px;
    }
    #overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: 0.5s;
        background: #fff;
        z-index: 2;
        cursor: progress;
    }

    #text{
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 50px;
        color: black;
        text-align: center;
        transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
    }
    .form-control{
        overflow: hidden;
    }
</style>
<style>
.btn-circle {border-radius: 50%;font-size: 54px;padding: 10px 20px;}
</style>
<div class="container">
    <div id="data_invoice"></div>
    <form action="<?php echo site_url("amadeus/invoice"); ?>" method="post" id="booking_form" >
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default bg-white-shadow pt-25 ph-30 pb-40">
                    <h3 class="heading-title"><span><?php echo trans('0170'); ?></span></h3>
                    <div class="clear"></div>
                    <div class="panel-body">
                        <div class="row row-reverse">
                            <div class="col-md-6">
                              <label><?php echo trans('090'); ?></label>
                              <input class="form-control" type="text" required="required" name="firstname" value="">
                            </div>
                                <div class="col-md-6">
                                    <label><?php echo trans('091'); ?></label>
                                    <input class="form-control" type="text" required="required"  name="lastname" value="">
                            </div>

                            </div>
                                    <div class="row">     
                                   <div class="col-md-6">
                                    <label><?php echo trans('094'); ?></label>
                                    <input class="form-control" type="text" required="required"  name="email" id="email" value="">
                                   </div>
                                     
                                <div class="col-md-6">
                                    <label><?php echo trans('0175')." ".trans('094'); ?></label>
                                    <input class="form-control" type="email" required="required" id="cemail" name="confirmemail" value="">
                            </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                
                                    <label><?php echo trans('092'); ?></label>
                                    <input class="form-control" type="text" required="required" name="phone" value="">
                        
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <label><?php echo trans('098'); ?></label>
                                    <input class="form-control" type="text" required="required" name="address" value="">
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <label><?php echo trans('0105'); ?></label>
                                    <?php // print_r($countries); ?>
                                    <select class="select2 form-control" style="width:100%" name="country" required="required">
                                        <option value=""><?php echo trans('0484'); ?></option>
                                        <?php 
                                        foreach ($countries as $country) {
                                           echo "<option value=".$country['nicename'].">".$country['nicename']."</option>";
                                       }
                                       ?>
                                   </select>
                               </div>
                               </div>
                               <br>
                               <div class="row row-reverse">
                                <div class="col-md-12">
                                    <label><?php echo trans('0178'); ?></label>
                                </div>
                                <div class="col-md-10 col-10">
                                    <textarea class="form-control" placeholder="<?php echo trans('0415'); ?>" rows="4" style="resize: none;" name="additionalnotes"></textarea>
                                </div>
                            </div>
                         </div>
                         <label class="font-weight-bold mt-20 mb-10">
                        <?php echo trans('0416'); ?>
                    </label>
                
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="guest"><?php echo trans('0306'); ?></button>

            </div>
    
        </div>
        <div class="col-md-4">
            <div class="bg-white-shadow pt-25 ph-30 pb-40">
            <div class="panel panel-primary">
                <h5 class="font400"><?php echo trans('0411'); ?></h5>
                <div class="clear"></div>
                <div class="panel-body">
                    <?php
                    $count = count($booking_data['carrier_code']);
                    for ($i=0; $i < $count ; $i++) { ?>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img class="img-thumbnail" style="max-width: 100px;" src="<?php echo base_url(); ?>uploads/images/flights/airlines/<?php echo $booking_data['carrier_code'][$i]; ?>.png" class="img-responsive" alt="">
                                <input type="hidden" name="booking_data[carrier_code][]" value="<?php echo $booking_data['carrier_code'][$i]; ?>">
                            </div>
                            <div class="col-md-6">
                                <h6 style="line-height: 15px;" class="pull-right"><strong> <?php echo $booking_data['iataCode_departure'][$i]; ?> <i class="fa fa-arrow-right RTL"></i> <?php echo $booking_data['iataCode_arrival'][$i]; ?> </strong></h6>
                                <input type="hidden" name="booking_data[iataCode_departure][]" value="<?php echo $booking_data['iataCode_departure'][$i];  ?>">
                                <input type="hidden" name="booking_data[iataCode_arrival][]" value="<?php echo $booking_data['iataCode_arrival'][$i];  ?>">
                                <input type="hidden" name="booking_data[departure_at][]" value="<?php echo $booking_data['departure_at'][$i];  ?>">
                                <input type="hidden" name="booking_data[arrival_at][]" value="<?php echo $booking_data['arrival_at'][$i];  ?>">
                            </div>
                        </div>
                        <br>
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td>Departure date From <?php echo $booking_data['iataCode_departure'][$i]; ?></td>
                                    <td><span class="pull-right"><?php echo date("D d-M-Y", strtotime($booking_data['departure_at'][$i])); ?></span></td>
                                </tr>
                                <tr>
                                    <td>Arrival date at <?php echo $booking_data['iataCode_arrival'][$i]; ?></td>
                                    <td class="pull-right"><?php echo date("D d-M-Y", strtotime($booking_data['arrival_at'][$i])); ?></td>
                                </tr>
                                <tr>
                                    <td>Departure time from <?php echo $booking_data['iataCode_departure'][$i]; ?></td>
                                    <td class="pull-right"><?php echo date("h:i:s a", strtotime($booking_data['departure_at'][$i])); ?></td>
                                </tr>
                                <tr>
                                    <td>Arrival time at <?php echo $booking_data['iataCode_arrival'][$i]; ?></td>
                                    <td class="pull-right"><?php echo date("h:i:s a", strtotime($booking_data['arrival_at'][$i])); ?></td>
                                </tr>
                                <tr>
                                    <td>Traveling <?php echo trans('0585'); ?> <?php echo $booking_data['iataCode_arrival'][$i]; ?></td>
                                    <td class="pull-right">
                                        <?php 
                                        $time1 = strtotime($booking_data['departure_at'][$i]);
                                        $time2 = strtotime($booking_data['arrival_at'][$i]);
                                        $difference = round(abs($time2 - $time1) / 3600,2);
                                        echo $difference; 
                                        ?> Hours
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                    <?php }
                    ?>

                    <input type="hidden" name="madult[passenger]" value="<?php echo $booking_data['madult']; ?>">
                    <input type="hidden" name="mchildren[passenger]" value="<?php echo $booking_data['mchildren']; ?>">
                    <input type="hidden" name="minfant[passenger]" value="<?php echo $booking_data['minfant']; ?>">
                    <input type="hidden" name="seniors[passenger]" value="<?php echo $booking_data['seniors']; ?>">
                </div>
            </div>
            <div class="">
                <h5 class="font400"><?php echo trans('070'); ?></h5>
                <div class="panel-body">
                    <?php   if ($booking_data['madult'] > 0) { ?>
                        <table style="width: 100%; padding-bottom: 10px ">
                            <tr>
                                <td>Adults</td>
                                <td style="text-align: right;"><?php echo $booking_data['madult'];  ?></td>
                            </tr>
                            <tr>
                                <td><?php echo trans("070"); ?> / <?php echo trans('010'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerAdult']['total']; ?><input type="hidden" name="madult[total]" value="<?php echo $booking_data['pricePerAdult']['total']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0333'); ?> / <?php echo trans('010'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerAdult']['totalTaxes']; ?>
                                <input type="hidden" name="madult[totalTaxes]" value="<?php echo $booking_data['pricePerAdult']['totalTaxes']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0150')." ".trans('0375'); ?> <?php echo trans('010'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol']; echo ($booking_data['madult']*$booking_data['pricePerAdult']['total']) + ($booking_data['madult']*$booking_data['pricePerAdult']['totalTaxes']);  ?></td>
                            </tr>
                        </table>
                        <hr>
                    <?php } ?>
                    <?php   if ($booking_data['mchildren'] > 0) { ?>

                        <table style="width: 100%;">
                            <tr>
                                <td>Childs</td>
                                <td style="text-align: right;"><?php echo $booking_data['mchildren']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo trans("070"); ?> / <?php echo trans('011'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerChild']['total']; ?><input type="hidden" name="mchildren[total]" value="<?php echo $booking_data['pricePerChild']['total']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0333'); ?> / <?php echo trans('011'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerChild']['totalTaxes']; ?><input type="hidden" name="mchildren[totalTaxes]" value="<?php echo $booking_data['pricePerChild']['totalTaxes']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0150')." ".trans('0375'); ?> <?php echo trans('011'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol']; echo ($booking_data['mchildren']*$booking_data['pricePerChild']['total']) + ($booking_data['mchildren']*$booking_data['pricePerChild']['totalTaxes']);  ?></td>
                            </tr>
                        </table>
                        <hr>
                    <?php } ?>
                    <?php   if ($booking_data['minfant'] > 0) { ?>
                        <table style="width: 100%;">
                            <tr>
                                <td><?php echo trans('0282'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['minfant'];  ?></td>
                            </tr>
                            <tr>
                                <td><?php echo trans("070"); ?> / <?php echo trans('0282'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerInfant']['total']; ?><input type="hidden" name="minfant[total]" value="<?php echo $booking_data['pricePerInfant']['total']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0333'); ?> / <?php echo trans('0282'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerInfant']['totalTaxes']; ?><input type="hidden" name="minfant[totalTaxes]" value="<?php echo $booking_data['pricePerInfant']['totalTaxes']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0150')." ".trans('0375'); ?> <?php echo trans('0282'); ?></td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol']; echo ($booking_data['minfant']*$booking_data['pricePerInfant']['total']) + ($booking_data['minfant']*$booking_data['pricePerInfant']['totalTaxes']);  ?></td>
                            </tr>
                        </table>
                        <hr>
                    <?php } ?>
                    <?php   if ($booking_data['seniors'] > 0) { ?>
                        <table style="width: 100%;">
                            <tr>
                                <td>Seniors</td>
                                <td style="text-align: right;"><?php echo $booking_data['seniors'];  ?></td>
                            </tr>
                            <tr>
                                <td><?php echo trans("070"); ?> Per Senior</td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerSenior']['total']; ?><input type="hidden" name="seniors[total]" value="<?php echo $booking_data['pricePerSenior']['total']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0333'); ?> Per Senior</td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol'].$booking_data['pricePerSenior']['totalTaxes']; ?><input type="hidden" name="seniors[totalTaxes]" value="<?php echo $booking_data['pricePerSenior']['totalTaxes']; ?>"></td>
                            </tr>
                            <tr>
                                <td><?php echo trans('0150')." ".trans('0375'); ?> Seniors</td>
                                <td style="text-align: right;"><?php echo $booking_data['currency']." " .$booking_data['currencysymbol']; echo ($booking_data['minfant']*$booking_data['pricePerSenior']['total']) + ($booking_data['seniors']*$booking_data['pricePerSenior']['totalTaxes']);  ?></td>
                            </tr>
                        </table>
                        <hr>
                    <?php } ?>
                </div>
            </div>
            <input type="hidden" name="currencysymbol" value="<?php echo $booking_data['currencysymbol']; ?>">
            <div class="total_table">
                <div class="booking-deposit">
                </div>
                <table class="table table_summary">
                    <tbody>
                        <tr class="beforeExtraspanel">
                            <td>
                                <?php echo trans('0333'); ?>                                      
                            </td>
                            <td class="text-right">
                                <input type="hidden" name="currency" value="<?php echo $booking_data['currency']; ?>">

                                <?php echo $booking_data['currency']." ".$booking_data['currencysymbol']. number_format($booking_data['totalTaxes'],2); ?> 
                                <input type="hidden" name="totalTaxes" value="<?php echo $booking_data['totalTaxes'];  ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="booking-deposit-font">
                                <strong>Ticket <?php echo trans('0124');  ?></strong>
                            </td>
                            <td class="text-right">
                                <?php echo $booking_data['currency']." " .$booking_data['currencysymbol']. number_format($booking_data['total_with_commission'],2); ?>
                                <input type="hidden" name="total_with_commission" value="<?php echo $booking_data['total_with_commission']; ?>">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="margin-bottom:0px" class="table table_summary">
                    <tbody>
                        <tr style="border-top: 1px dotted white;">
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tr10">
                            <td class="booking-deposit-font">
                                <strong><?php echo trans('0124'); ?></strong>
                            </td>
                            <td class="text-right">
                                <strong>
                                    <?php echo $booking_data['currency']." " .$booking_data['currencysymbol']; echo " ". number_format($booking_data['total_with_commission']+$booking_data['totalTaxes'],2); ?>
                                    <input type="hidden" name="total_amount_with_tax" value="<?php echo $booking_data['total_with_commission']+$booking_data['totalTaxes']; ?>">
                                    <input type="hidden" name="totalPrice" value="<?php echo $booking_data['total']; ?>">
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
     
       </div>
   </div>
   <div class="row">
        <div class="col-md-12 mt-30">
            <div class="panel panel-white panel-body">
            <div><strong><i class="fa fa-support"></i> <?php echo trans('0382'); ?></strong></div>
            <div><i class="fa fa-envelope-o"></i> <?php echo $contactemail; ?></div>
            <div><i class="fa fa-phone"></i> <?php echo $phone; ?></div>
               </div>
           </div>
           
       </div>
</form>    
</div>
<script type="text/javascript">
    $("#booking_form").submit(function(e){
        e.preventDefault();
        var email = document.getElementById('email').value;
        var cemail = document.getElementById('cemail').value;
        if (email == cemail) {
            var form = $("#booking_form");
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('airlines/invoice/'); ?>',
                dataType: 'json',
                data:form.serialize(),
                beforeSend: function () {
                    document.getElementById('overlay').style.display= "block";
                },
                success: function(data)
                {  
                    if (data['status'] == "1") {
                        //$("#booking_form").html("");
                        $("#data_invoice").html("<div class='alert alert-success' style='background:green;color:white;'>Your booking has been received. We'll contact you shortly.</div>");
                    } else {
                        $("#data_invoice").html("<div class='alert alert-danger' style='background:red;color:white;'>Unable to process with the booking. Please try again.</div>");
                    }
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    document.getElementById('overlay').style.display= "none";
                }
            });
        } else {
            $("#data_invoice").html("<div class='alert alert-danger' style='background:red;color:white;'>Email do not match</div>");
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });
    $( document ).ready(function() {
        $(".go-left").hide();
    });
</script>
<div id="overlay">
    <div id="text"><img src="<?php echo base_url(''); ?>uploads/images/flights/airlines/flight.gif" alt="Searching flight"><br>Please Wait ... </div>
</div>
<style type="text/css">
#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transition: 0.5s;
    background: #fff;
    z-index: 2;
    cursor: progress;
}

#text{
    position: absolute;
    top: 50%;
    left: 50%;
    font-size: 50px;
    color: black;
    text-align: center;
    transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
}
</style>
</div>
