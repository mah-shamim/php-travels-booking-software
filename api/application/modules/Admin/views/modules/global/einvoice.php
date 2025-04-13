<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo trans('076');?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="phptravels">
    <link rel="shortcut icon" href="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png';?>">

    <!--PHPTravels Bootstrap core -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url();  ?>assets/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <!--PHPTravels Bootstrap core -->
    <style>
    ::selection                     { background: #a8d1ff;                                   }
    ::-moz-selection                { background: #a8d1ff;                                   }
    ::-webkit-scrollbar             { width: 10px;                                           }
    ::-webkit-scrollbar-track       { background-color: #eaeaea; border-left: 1px solid #ccc;}
    ::-webkit-scrollbar-thumb       { background-color: #888888;                             }
    ::-webkit-scrollbar-thumb:hover { background-color: #636363;                             }

    .modal-content { box-shadow: 0px 0px 0px 0px !important; }
    .head {
      margin: 0;
      padding: 8px 12px;
      line-height: 16px;
      border-bottom: 0;
      border-left: 0;
      color: #333;
      font-size: 14px;
      font-weight: bold;
      background-color: #fafafa;
      background-image: -webkit-linear-gradient(bottom, rgba(1,2,2,.03), rgba(255,255,255,.03));
      background-image: -moz-linear-gradient(bottom, rgba(1,2,2,.03), rgba(255,255,255,.03));
      background-image: -o-linear-gradient(bottom, rgba(1,2,2,.03), rgba(255,255,255,.03));
      background-image: -ms-linear-gradient(bottom, rgba(1,2,2,.03), rgba(255,255,255,.03));
      background-image: linear-gradient(to top, rgba(1,2,2,.03), rgba(255,255,255,.03));
      }
      body {
      background-color: #eaeaea !important;
      }

    </style>

    <script type="text/javascript">
      $(function(){
        $(".submitresult").hide();
      $(".checkout").on('click',function(){
      $(this).html("Please Wait...");
      })
      $(".couponsubmit").on('click',function(){
      var code = $("#couponcode").val();
      var bookingid = $("#bookingid").val();
      $.post("<?php echo base_url();?>invoice/validate_coupon", { code: code, bookingid: bookingid }, function(resp){
      if($.trim(resp) > 0){
      $("#resultdiv").html("Please Wait.....");
      location.reload();
      }else{
      $("#resultdiv").html("<span class='btn btn-xs btn-danger'>Invalid code</span>")
      }
      });});});
       function expcheck(){
          $(".submitresult").html("").fadeOut("fast");
       var cardno = $("#card-number").val();
       var firstname = $("#card-holder-firstname").val();
       var lastname = $("#card-holder-lastname").val();
      var minMonth = new Date().getMonth() + 1;
      var minYear = new Date().getFullYear();
      var month = parseInt($("#expiry-month").val(), 10);
      var year = parseInt($("#expiry-year").val(), 10);

       if($.trim(firstname) == ""){
       $(".submitresult").html("Enter First Name").fadeIn("slow");
       return false;
       }else if($.trim(lastname) == ""){
      $(".submitresult").html("Enter Last Name").fadeIn("slow");
       return false;
       }else if($.trim(cardno) == ""){
      $(".submitresult").html("Enter Card number").fadeIn("slow");
       return false;
       }else if(month <= minMonth && year <= minYear){
        $(".submitresult").html("Invalid Expiration Date").fadeIn("slow");
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
  </head>


    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

       <div class="col-md-4">
            <div class="pull-left">
              <img class="img-responsive" src="<?php echo PT_GLOBAL_IMAGES_FOLDER.'logo.png';?>" alt="logo" />
           </div>
          </div>


        <div class="clearfix"></div>
      </div>
      <div class="modal-body">


        <div class="col-md-6">
            <div class="panel panel-default" style="height:150px">
              <div class="panel-heading head">
                <h3 class="panel-title"><?php echo trans('0545');?></h3>
              </div>
              <div class="panel-body">
                <p><strong><?php echo $invoice[0]->ai_first_name." ".$invoice[0]->ai_last_name; ?></strong></p>
                <p><?php echo $invoice[0]->ai_address_1." ".$invoice[0]->ai_address_2; ?></p>
                <p><?php echo $invoice[0]->ai_mobile; ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="panel panel-default" style="height:150px">
              <div class="panel-heading head">
                <h3 class="panel-title"><?php echo trans('0546');?></h3>
              </div>
              <div class="panel-body">
                <p><strong><?php echo $app_settings[0]->site_title;?></strong></p>
                <p><?php echo $contactaddress;?></p>
                <p><?php echo $contactphone;?></p>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
           <hr>
          <div class="col-md-3">
             <p><strong><?php echo trans('0540');?> #<?php echo $invoice[0]->book_itineraryid;?></strong></p>
            <span><?php echo trans('0547');?>: <?php echo pt_show_date_php($invoice[0]->book_date);?></span>
          </div>

          <div class="col-md-4">
             <p><strong><?php echo trans('047');?></strong>: <?php echo $invoice[0]->book_confirmation;?></p>
                <strong><?php echo trans('07');?> : </strong> <?php echo date("M j, Y", strtotime($invoice[0]->book_checkin));?>
               <br> <strong><?php echo trans('09');?> : </strong> <?php echo date("M j, Y", strtotime($invoice[0]->book_checkout));?>
          </div>

          <div class="col-md-5">
             <p><strong><?php echo $invoice[0]->book_hotel;?></strong></p>
                <strong><?php echo trans('098');?> : </strong> <?php echo $response->hotelAddress.", ".$response->hotelCity;?>
              </div>




          <div class="clearfix"></div>
          <div class="panel-body">

            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong><?php echo trans('0121');?></strong> <?php if(!empty($invoice[0]->booking_coupon)){ echo "<span class='btn btn-success btn-xs pull-right'>".$invoice[0]->booking_coupon_rate."% Coupon Discount Applied</span>"; } ?></h3>
                  </div>
                  <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table table-condensed">
                        <thead>
                          <tr>
                            <td><strong>Room Type</strong></td>
                            <td class="text-center"><strong><?php echo trans('0227');?></strong></td> 
                            <td class="text-center"><strong><?php echo trans('070');?> <?php echo trans('0245'); ?></strong></td>
                            <td class="text-center"><strong><?php echo trans('0122');?></strong></td>
                          
                          <td class="text-center"><strong><?php echo trans('010');?></strong></td> 
                          <td class="text-center"><strong><?php echo trans('011');?></strong></td> 
                            <td class="text-right"><strong><?php echo trans('0124');?></strong></td>
                          </tr>
                        </thead>
                        <tbody>

                          <tr>
                            <td><?php echo $invoice[0]->book_roomname;?></td>
                              <td class="text-center"><?php echo $response->numberOfRoomsBooked;?></td>   
                            <td class="text-center"><?php echo $invoice[0]->book_roomtotal;?></td>
                            <td class="text-center"><?php echo $invoice[0]->book_nights;?></td>
                        
                          <td class="text-center"><?php echo $response->RoomGroup->Room->numberOfAdults;?></td>   
                          <td class="text-center"><?php echo $response->RoomGroup->Room->numberOfChildren;?></td>   
                            <td class="text-right"><?php echo $invoice[0]->book_roomtotal;?></td>
                          </tr>

                          <tr>
                            <td class="thick-line"></td>
                            <td class="thick-line"></td>
                           <td class="thick-line"></td> 
                           <td class="thick-line"></td> 
                           <td class="thick-line"></td> 
                            <td class="thick-line text-center"><strong>Subtotal</strong></td>
                            <td class="thick-line text-right"><strong><?php echo $invoice[0]->book_roomtotal;?></strong></td>
                          </tr>
                          <?php if(!empty($invoice[0]->book_tax)){ ?>
                          <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                          <td class="no-line"></td> 
                          <td class="no-line"></td> 
                          <td class="no-line"></td> 
                            <td class="no-line text-center"><?php echo trans('0541');?></td>
                            <td class="no-line text-right"><?php echo $invoice[0]->book_tax;?></td>
                          </tr>
                          <?php } ?>
                          <tr>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                            <td class="no-line"></td>
                         <td class="no-line"></td>  
                            <td class="no-line text-center">
                              <h3><strong><?php echo trans('078');?></strong></h3>
                            </td>
                            <td class="no-line text-right">
                              <h3><strong><?php echo $invoice[0]->book_total;?></strong></h3><br>
                              <small>(<?php echo trans('0538'); ?>)</small>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
<!-- 
                <div class="panel panel-default">
                  <div class="well-sm text-center">
                    <i><span class="fa fa-info-circle"></span> <?php echo trans('0127');?> </i>
                  </div>
                </div> -->
                  <p> <strong> <?php echo trans('0149'); ?> </strong> : <?php echo $response->cancellationPolicy; ?></p>
                  <p><strong><?php echo trans('0548');?></strong></p>
                  <p><?php echo trans('0129');?> : <a href="<?php echo base_url();?>"><?php echo base_url();?></a><br>
                  <?php echo trans('094');?>    :   <?php echo $contactemail;?><br>
                  <?php echo trans('0130');?>   :   <?php echo $contactphone;?></p>
                </div>

            </div>
          </div>


      </div>
      <div class="panel-footer">
        <strong><?php echo trans('0131');?>,</strong>
        <p><?php echo $app_settings[0]->site_title;?> | <?php echo trans('0132');?></p>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->




<!-- PHPtravels Credit Modal Starting-->
<div class="modal fade" id="creditcard" tabindex="-1" role="dialog" aria-labelledby="creditcard" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Payment</h4>
      </div>
      <div class="modal-body">
        <form  class="form-horizontal" role="form" action="<?php echo base_url();?>checkout" method="POST">
          <fieldset>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="card-holder-name">First Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="firstName" id="card-holder-firstname" placeholder="Card Holder's First Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="card-holder-name">Last Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="lastName" id="card-holder-lastname" placeholder="Card Holder's Last Name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="card-number">Card Number</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="cardno" id="card-number" pattern=".{12,}" required title="12 characters minimum" placeholder="Debit/Credit Card Number" onkeypress="return isNumeric(event)" >
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="expiry-month">Expiration Date</label>
              <div class="col-sm-8">
                <div class="row">
                  <div class="col-xs-6">
                    <select class="form-control col-sm-2" name="expMonth" id="expiry-month">
                      <option value="01">Jan (01)</option>
                      <option value="02">Feb (02)</option>
                      <option value="03">Mar (03)</option>
                      <option value="04">Apr (04)</option>
                      <option value="05">May (05)</option>
                      <option value="06">June (06)</option>
                      <option value="07">July (07)</option>
                      <option value="08">Aug (08)</option>
                      <option value="09">Sep (09)</option>
                      <option value="10">Oct (10)</option>
                      <option value="11">Nov (11)</option>
                      <option value="12">Dec (12)</option>
                    </select>
                  </div>
                  <div class="col-xs-6">
                    <select class="form-control" name="expYear" id="expiry-year">
                      <?php for($y = date("Y");$y <= date("Y") + 10;$y++){?>
                      <option value="<?php echo $y?>"><?php echo $y; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="cvv">Card CVV</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security Code">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-9">
                <div class="alert alert-danger submitresult"></div>
                <input type="hidden" name="paymethod" value="<?php echo $invoice[0]->booking_payment_type;?>" />
                <input type="hidden" name="bookingid" id="bookingid" value="<?php echo $invoice[0]->booking_id;?>" />
                <button type="submit" class="btn btn-success btn-lg paynowbtn" onclick="return expcheck();">Pay Now</button>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- PHPtravels Credit Modal Ending-->

<div class="panel-body">
 <center>
  <form action="<?php echo base_url();?>" method="post"><button type="submit" class="btn btn-primary"><?php echo trans('0133');?></button></form>
 </center>
</div>



