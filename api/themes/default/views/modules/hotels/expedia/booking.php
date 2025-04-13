<?php if($result == "success"){ ?>
<style>
  .btn-circle {
  border-radius: 50%;
  font-size: 54px;
  padding: 10px 20px;
  }
</style>
<div class="modal-dialog modal-lg" style="z-index: 10;">
  <div class="modal-content">
    <div class="modal-body">
      <br><br>
      <div class="center-block">
        <center>
          <button class="btn btn-circle block-center btn-lg btn-success"><i class="fa fa-check"></i></button>
          <h3 class="text-center"><?php echo trans('0409');?> <b class="text-success wow flash animted animated"><?php echo trans('0135');?></b></h3>
          <p class="text-center"><?php echo $msg;?></p>
          <p><?php echo trans('0540'); ?>: <?php echo $itineraryID; ?></p>
          <p><?php echo trans('0539'); ?>: <?php echo $confirmationNumber; ?></p>

              <?php if(!empty($nightlyRateTotal)){ ?>
              <p><strong>Total Nightly Rate: <?php echo $currency." ".$nightlyRateTotal; ?></strong></p>
              <?php } ?>

              <?php if(!empty($SalesTax)){ ?>
              <p><strong>Sales Tax: <?php echo $currency." ".$SalesTax; ?></strong></p>
              <?php } ?>

              <?php if(!empty($HotelOccupancyTax)){ ?>
              <p>><strong>Hotel Occupancy Tax: <?php echo $currency." ".$HotelOccupancyTax; ?></strong></p>
              <?php } ?>

              <?php if(!empty($TaxAndServiceFee)){ ?>
              <p><strong>Tax and Service Fee: <?php echo $currency." ".$TaxAndServiceFee; ?></strong></p>
              <?php } ?>

          <p><b>  <?php echo trans('0124');?> :</b> <?php echo $currency.$grandTotal;?> (<?php echo trans('0538'); ?>) </p>
          <p><?php echo trans('0537'); ?> </p>
          <?php if(!empty($checkInInstructions)){ ?>
          <p><strong><?php echo trans('0458'); ?></strong> : <?php echo $checkInInstructions; ?></p>
          <?php } ?>
          <?php if(!empty($nonRefundable)){ ?>
          <p><strong><?php echo trans('0309'); ?></strong> : <?php echo $cancellationPolicy; ?></p>
          <?php } ?>
        </center>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<?php  }else{ ?>
<form role="form" action="" method="POST">
  <div class="container">
    <?php if($result == "fail"){ ?>
    <div class="alert alert-danger wow bounce" role="alert">
      <p><?php echo $msg;?></p>
    </div>
    <?php } ?>
    <div class="container mt25 offset-0">
      <div class="loadinvoice">
        <div class="acc_section">
          <div class="col-md-8 pagecontainer2 offset-0 go-right" style="margin-bottom:50px;">
            <?php if(!empty($error)){ ?>
            <h1 class="text-center strong"><?php echo trans('0432');?></h1>
            <h3 class="text-center"><?php echo trans('0431');?></h3>
            <br>
            <?php }else{ ?>
            <div class="step">
              <div class="panel-body">
                <div class="col-md-6  go-right">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('0171');?></label>
                    <input class="form-control form" id="card-holder-firstname" type="text" placeholder="<?php echo trans('0171');?>" name="firstName"  value="<?php echo @@$profile[0]->ai_first_name?>">
                  </div>
                </div>
                <div class="col-md-6  go-left">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('0172');?></label>
                    <input class="form-control form" id="card-holder-lastname" type="text" placeholder="<?php echo trans('0172');?>" name="lastName"  value="<?php echo @$profile[0]->ai_last_name?>">
                  </div>
                </div>
                <div class="col-md-6 go-right">
                  <div class="form-group ">
                    <label  class="required  go-right"><?php echo trans('094');?></label>
                    <input class="form-control form" id="card-holder-email" type="text" placeholder="<?php echo trans('094');?>" name="email"  value="<?php echo @$profile[0]->accounts_email; ?>">
                  </div>
                </div>
                <div class="col-md-6 go-right">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('0173');?></label>
                    <input class="form-control form" id="card-holder-phone" type="text" placeholder="<?php echo trans('0414');?>" name="phone"  value="<?php echo @$profile[0]->ai_mobile; ?>">
                  </div>
                </div>
                <div class="col-md-6  go-right">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('0105');?></label>
                    <select data-placeholder="Select" id="country" name="country" class="form-control">
                      <option value=""> <?php echo trans('0158');?> <?php echo trans('0105');?> </option>
                      <?php foreach($allcountries as $c){ ?>
                      <option value="<?php echo $c->iso2;?>" <?php makeSelected($c->iso2, @$profile[0]->ai_country); ?> ><?php echo $c->short_name;?></option>
                      <?php }  ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6  go-left">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('0101');?></label>
                    <input id="card-holder-state" class="form-control form" type="text" placeholder="<?php echo trans('0101');?>" name="province"  value="<?php if(!empty($profile[0]->ai_state)){ echo @$profile[0]->ai_state; } ?>">
                  </div>
                </div>
                <div class="col-md-6 go-right">
                  <div class="form-group ">
                    <label  class="required  go-right"><?php echo trans('0100');?></label>
                    <input id="card-holder-city" class="form-control form" type="text" placeholder="<?php echo trans('0100');?>" name="city"  value="<?php echo @$profile[0]->ai_mobile; ?>">
                  </div>
                </div>
                <div class="col-md-6 go-left">
                  <div class="form-group">
                    <label  class="required go-right"><?php echo trans('0103');?></label>
                    <input id="card-holder-postalcode" class="form-control form" type="text" placeholder="<?php echo trans('0104');?>" name="postalcode"  value="<?php if(!empty($profile[0]->ai_postal_code)){ echo @$profile[0]->ai_postal_code; } ?>">
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12  go-right">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('098');?></label>
                    <textarea class="form-control form" placeholder="<?php echo trans('098');?>" rows="4"  name="address"><?php echo @$profile[0]->ai_address_1; ?></textarea>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
            <!--End step -->
            <script type="text/javascript">
              $(function(){
              $('.popz').popover({ trigger: "hover" });
              });
            </script>
            <!-- Complete This booking button only starting -->
            <div class="panel panel-default btn_section" style="display:none;">
              <div class="panel-body">
                <center>
              </div>
            </div>
            <!-- End Complete This booking button only -->
            <input type="hidden" name="pay" value="1" />
            <input type="hidden" name="adults" value="<?php echo $_GET['adults'];?>" />
            <input type="hidden" name="sessionid" value="<?php echo $_GET['sessionid']; ?>" />
            <input type="hidden" name="hotel" value="<?php echo $_GET['hotel']; ?>" />
            <input type="hidden" name="hotelname" value="<?php echo $HotelSummary['name'];?>" />
            <input type="hidden" name="hotelstars" value="<?php echo $hotelStars;?>" />
            <input type="hidden" name="location" value="<?php echo $HotelSummary['city'];?>" />
            <input type="hidden" name="thumbnail" value="<?php echo $HotelImages['HotelImage'][0]['url']; ?>" />
            <input type="hidden" name="roomname" value="<?php echo $roomname; ?>" />
            <input type="hidden" name="roomtotal" value="<?php echo $roomtotal; ?>" />
            <input type="hidden" name="checkin" value="<?php echo $_GET['checkin']; ?>" />
            <input type="hidden" name="checkout" value="<?php echo $_GET['checkout']; ?>" />
            <input type="hidden" name="roomtype" value="<?php echo $_GET['roomtype']; ?>" />
            <input type="hidden" name="ratecode" value="<?php echo $_GET['ratecode']; ?>" />
            <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
            <input type="hidden" name="affiliateConfirmationId" value="<?php echo $eanlib->cid.$affiliateConfirmationId; ?>" />
            <input type="hidden" name="total" value="<?php echo $total; ?>" />
            <input type="hidden" name="tax" value="<?php echo $tax; ?>" />
            <input type="hidden" name="nights" value="<?php echo $nights; ?>" />
            <div class="clearfix"></div>
            <div class="panel">
              <div class="col-md-6  go-right">
                <div class="form-group ">
                  <label  class="required go-right"><?php echo trans('0330');?></label>
                  <select class="form-control" name="cardtype" id="cardtype">
                    <option value="">Select Card</option>
                    <?php foreach($payment as $pay){ ?>
                    <option value="<?php echo $pay['code'];?>"> <?php echo $pay['name'];?> </option>
                    <?php  } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6  go-left">
                <div class="form-group ">
                  <label  class="required go-right"><?php echo trans('0316');?></label>
                  <input type="text" class="form-control" name="cardno" id="card-number" pattern=".{12,}" required title="12 characters minimum" placeholder="Credit Card Number" onkeypress="return isNumeric(event)" value="<?php echo set_value('cardno');?>" >
                </div>
              </div>
              <div class="col-md-3 go-right">
                <div class="form-group ">
                  <label  class="required  go-right"><?php echo trans('0329');?></label>
                  <select class="form-control" name="expMonth" id="expiry-month">
                    <option value="01"><?php echo trans('0317');?> (01)</option>
                    <option value="02"><?php echo trans('0318');?> (02)</option>
                    <option value="03"><?php echo trans('0319');?> (03)</option>
                    <option value="04"><?php echo trans('0320');?> (04)</option>
                    <option value="05"><?php echo trans('0321');?> (05)</option>
                    <option value="06"><?php echo trans('0322');?> (06)</option>
                    <option value="07"><?php echo trans('0323');?> (07)</option>
                    <option value="08"><?php echo trans('0324');?> (08)</option>
                    <option value="09"><?php echo trans('0325');?> (09)</option>
                    <option value="10"><?php echo trans('0326');?> (10)</option>
                    <option value="11"><?php echo trans('0327');?> (11)</option>
                    <option value="12"><?php echo trans('0328');?> (12)</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3 go-left">
                <div class="form-group">
                  <label  class="required go-right">&nbsp;</label>
                  <select class="form-control" name="expYear" id="expiry-year">
                    <?php for($y = date("Y");$y <= date("Y") + 10;$y++){?>
                    <option value="<?php echo $y?>"><?php echo $y; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3 go-left">
                <div class="form-group">
                  <label  class="required go-right"><?php echo trans('0331');?></label>
                  <input type="text" class="form-control" name="cvv" id="cvv" placeholder="<?php echo trans('0331');?>" value="<?php echo set_value('cvv');?>">
                </div>
              </div>
              <div class="col-md-3 go-left">
                <label  class="required go-right">&nbsp;</label>
                <img src="<?php echo base_url(); ?>assets/img/cc.png" class="img-responsive" />
              </div>
              <!--<div class="clearfix"></div>
                <div class="col-md-6 go-right">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('0173');?></label>
                    <input class="form-control form" type="text" placeholder="<?php echo trans('0414');?>" name="phone"  value="<?php echo set_value('phone');?>">
                  </div>
                </div>
                <div class="col-md-6 go-right">
                  <div class="form-group ">
                    <label  class="required go-right"><?php echo trans('098');?></label>
                    <input class="form-control form" type="text" placeholder="<?php echo trans('098');?>" name="address"  value="<?php echo set_value('address');?>">
                  </div>
                </div>-->
              <div class="clearfix"></div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <p style="padding:10px;"><input type="checkbox" name="" id="policy" value="1">
                    <?php echo trans('0416');?>  <br>
                    <a href="https://us.travelnow.com/customer_care/terms_conditions.html" target="_blank"><?php echo trans('057'); ?></a>
                  </p>
                  <div class="form-group">
                    <div class="alert alert-danger submitresult"></div>
                    <span id="waiting"></span>
                    <div class="col-md-12"><button type="submit" class="btn btn-success btn-lg btn-block paynowbtn" onclick="return expcheck();" name="<?php if(empty($usersession)){ echo "guest";}else{ echo "logged"; } ?>"  onclick="return completebook('<?php echo base_url();?>','<?php echo trans('0159')?>');"><?php echo trans('0306');?></button></div>
                 <div class="clearfix"></div><hr>
                    <div class="panel-body">
                     <p style="font-size:12px" class="go-right RTL"> <?php echo $checkInInstructions; ?></p>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Booking Final Starting -->
        <div class="col-md-8 final_section"  style="display:none;">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="step-pane" id="step4">
               <div class="matrialprogress show"><div class="indeterminate"></div></div>
                <h2 class="text-center"><?php echo trans('0179');?></h2>
                <p class="text-center"><?php echo trans('0180');?></p>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <!-- Booking Final Ending -->
        <!-- End col-md-8 -->
        <div class="col-md-4 go-left" style="margin-bottom: 40px;">
          <div class="pagecontainer2 paymentbox grey">
            <div class="panel-body">
              <img class="img-responsive" src="<?php echo $HotelImages['HotelImage'][0]['url']; ?>" />
              <div class="opensans size18 dark bold RTL go-right"><?php echo $HotelSummary['name'];?></div>
              <div class="clearfix"></div>
              <div class="opensans size13 grey RTL go-right"><i class="fa fa-map-marker RTL"></i> <?php echo $HotelSummary['city'];?> </div>
              <div class="clearfix"></div>
              <span class="go-right RTL"> <?php echo pt_create_stars($hotelStars); ?> </span>
            </div>
            <div class="hpadding30">
              <div>
                <div class="row">
                  <table class="table table_summary">
                    <tbody>
                      <tr>
                        <td>
                          <strong> <?php echo trans('016');?></strong> : <?php echo $roomsCount;?>
                        </td>
                        <td class="text-right">
                          <strong> <?php echo trans('010');?></strong> : <?php echo $_GET['adults'];?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong> <?php echo trans('07');?></strong> : <?php echo $checkin;?>
                        </td>
                        <td class="text-right">
                          <strong> <?php echo trans('09');?></strong> : <?php echo $checkout;?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo trans('060');?>
                        </td>
                        <td class="text-right">
                          <?php echo $nights;?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong> <?php echo $roomname; ?> </strong>
                        </td>
                        <td class="text-right">
                          <?php echo @$roomscount;?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php echo trans('0412');?>
                        </td>
                        <td class="text-right">
                          <?php echo $currency." ".$roomtotal; ?>
                        </td>
                      </tr>
                      <?php if(!empty($ExtraPersonFee)){ ?>
                      <tr>
                        <td>
                          <strong>Extra Person Fee</strong>
                        </td>
                        <td class="text-right">
                          <?php echo $currency." ".$ExtraPersonFee; ?>
                        </td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td>
                          <?php echo trans('0541');?>
                        </td>
                        <td class="text-right">
                          <?php echo $currency." ".$tax; ?>
                        </td>
                      </tr>
                      <?php if(!empty($SalesTax)){ ?>
                      <tr>
                        <td>
                          <small>Sales Tax</small>
                        </td>
                        <td class="text-right">
                          <?php echo $currency." ".$SalesTax; ?>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($HotelOccupancyTax)){ ?>
                      <tr>
                        <td>
                          <small>Hotel Occupancy Tax</small>
                        </td>
                        <td class="text-right">
                          <?php echo $currency." ".$HotelOccupancyTax; ?>
                        </td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td>
                        </td>
                        <td >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="padding30" style="padding-top:0px">
                    <span class="left size20 dark"><strong><?php echo trans('0124');?></strong> :</span>
                    <span class="right lred2 bold size18">  <?php echo $currency." ".$total; ?>
                    <br><span style="font-size: 9px !important; color: #000 !important;"> (Including Taxes and Fees) </span> </span>
                    <div class="clearfix"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="panel-footer row text-danger go-right RTL">
                    <?php echo trans('0212');?>
                  </div>
                  <div class="panel-footer row" style="background: #E6EDF7;font-size:12px">
                    <div class="clearfix"></div>
                    <br>
                    <h4>Cancellation Policy</h4>
                    <p class="go-right RTL"><?php echo $cancelpolicy;?></p>
                  </div>
                  <br>
                </div>
              </div>
              <?php } ?>
            </div>
            <?php if(!empty($phone)){ ?>
            <div class="panel-body">
              <h4 class="opensans text-center"><i class="icon_set_1_icon-57"></i><?php echo trans('061');?></h4>
              <p class="opensans size30 lblue xslim text-center">+<?php echo $phone; ?></p>
              <!--<small>Monday to Friday 9.00am - 7.30pm</small>-->
            </div>
            <?php } ?>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<?php } ?>
<script type="text/javascript">
  $(function(){

        $(".submitresult").hide();

        })

       function expcheck(){

          $(".submitresult").html("").fadeOut("fast");

       var cardno = $("#card-number").val();
       var cardtype = $("#cardtype").val();

       var email = $("#card-holder-email").val();

       var country = $("#country").val();

       var cvv = $("#cvv").val();

       var city = $("#card-holder-city").val();

       var state = $("#card-holder-state").val();

       var postalcode = $("#card-holder-postalcode").val();

       var firstname = $("#card-holder-firstname").val();

       var lastname = $("#card-holder-lastname").val();
       var policy = $("#policy").val();
      var minMonth = new Date().getMonth() + 1;

      var minYear = new Date().getFullYear();

      var month = parseInt($("#expiry-month").val(), 10);

      var year = parseInt($("#expiry-year").val(), 10);

       if(country == "US"){

        if($.trim(postalcode) == ""){

       $(".submitresult").html("Enter Postal Code").fadeIn("slow");

       return false;

       }else if($.trim(state) == ""){

      $(".submitresult").html("Enter State").fadeIn("slow");

       return false;

       }

       }

       if($.trim(firstname) == ""){

       $(".submitresult").html("Enter First Name").fadeIn("slow");

       return false;

       }else if($.trim(lastname) == ""){

      $(".submitresult").html("Enter Last Name").fadeIn("slow");

       return false;

       }else if($.trim(cardno) == ""){

      $(".submitresult").html("Enter Card number").fadeIn("slow");

       return false;

       }else if($.trim(cardtype) == ""){

      $(".submitresult").html("Select Card Type").fadeIn("slow");

       return false;

       }else if(month <= minMonth && year <= minYear){

        $(".submitresult").html("Invalid Expiration Date").fadeIn("slow");

       return false;



       }else if($.trim(cvv) == ""){

        $(".submitresult").html("Enter Security Code").fadeIn("slow");

       return false;



       }else if($.trim(country) == ""){

        $(".submitresult").html("Select Country").fadeIn("slow");

       return false;



       }else if($.trim(city) == ""){

        $(".submitresult").html("Enter City").fadeIn("slow");

       return false;



       }else if($.trim(email) == ""){

        $(".submitresult").html("Enter Email").fadeIn("slow");

       return false;



       }else if(!$('#policy').is(':checked')){

        $(".submitresult").html("Please Accept Cancellation Policy").fadeIn("slow");

       return false;



       }else{

         $(".paynowbtn").hide();

        $(".submitresult").removeClass("alert-danger");

        $(".submitresult").html("<div class='matrialprogress'><div class='indeterminate'></div></div>").fadeIn("slow");

       }





       }

       function isNumeric(evt)

        {

          var e = evt || window.event; // for trans-browser compatibility

          var charCode = e.which || e.keyCode;

          if (charCode > 31 && (charCode < 47 || charCode > 57))

          return false;

          if (e.shiftKey) return false;

          return true;

       }
</script>
<style>
  #rotatingImg {
  display: none;
  }
  .booking-bg {
  padding: 10px 0 5px 0;
  width: 100%;
  background-image: url('<?php echo $theme_url; ?>assets/images/step-bg.png');
  background-color: #222;
  text-align: center;
  }
  .bookingFlow__message {
  color: white;
  font-size: 18px;
  margin-top: 5px;
  margin-bottom: 15px;
  letter-spacing: 1px;
  }
  /*Form Wizard*/
  .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #5087E7; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
  .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {   content: ' ';  width: 20px; height: 20px; background: #FFFFFF; border-radius: 50px; position: absolute; top: 5px; left: 5px; }
  .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #5087E7;}
  /*END Form Wizard*/
</style>
<div class="clearfix"></div>
