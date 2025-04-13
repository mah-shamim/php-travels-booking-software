<br><br>
<style>p    { margin:0px;font-size: 14px;} h5 { margin:0px;font-size: 15px;} table { width: 680px; } html { font-family:tahoma; } body { background-color: #d8d8d8 } </style>

<style>

    .unpaid.success-box .icon{
        background: red;
        border-color:red;
    }
    .unpaid.success-box .content{
        border-color:red;
    }
    .reserved.success-box .icon{
        background: #ee8e06 ;
        border-color:#ee8e06;
    }
    .reserved.success-box .content{
        border-color:#ee8e06;
    }
    .cancelled.success-box .icon{
        background: red;
        border-color:red;
    }
    .cancelled.success-box .content{
        border-color:red;
    }
    .expired.success-box .icon{
        background: #ee8e06 ;
        border-color:#ee8e06;
    }
    .expired.success-box .content{
        border-color:#ee8e06;
    }

</style>

<?php if( isset($dataAdapter) && ! empty($dataAdapter) ): ?>
    <center id="container">
        <?php if( isset($dataAdapter->access_token) && ! empty($dataAdapter->access_token) ): ?>
            <div id="booking">
                <?php echo trans('0594');?>: <strong><?php echo $dataAdapter->access_token; ?></strong>
            </div>
            <br>
        <?php endif; ?>

        <?php if($invoice_details->status != "paid"){ ?>
        <div class="col-md-7 creditcardform" style="">
            <form role="form" id="myForm" action="<?=base_url('trflight/payments')?>" method="POST">

                <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label class="required ">Card Holder</label>
                                        <div class="clear"></div>
                                        <input type="hidden" value="DB" name="paymentType">
                                        <input type="hidden" value="<?=$invoice_details->id?>" name="entityId">
                                        <input type="hidden" value="<?=$dataAdapter->price?>" name="amount">
                                        <input type="hidden" value="<?=$dataAdapter->Currency_code?>" name="currency">
                                        <input type="text" required class="form-control" value="<?=$config->api_environment == "sandbox" ? "Jhon Doe":""?>" name="card[holder]" id="card-holder-firstname" placeholder="Card Holder">
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        <label class="required ">Card Number</label>
                                        <div class="clear"></div>
                                        <input type="text" value="<?=$config->api_environment == "sandbox" ? "4200000000000000":""?>" required class="form-control" name="card[number]" id="card-number" placeholder="Card Number" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="form-group ">
                                        <label style="font-size:13px" class="required  ">Expiration Date</label>
                                        <div class="clear"></div>
                                        <select required class="form-control" name="card[expiryMonth]" id="expiry-month">
                                            <option value="01">Jan (01)</option>
                                            <option value="02">Feb (02)</option>
                                            <option value="03">Mar (03)</option>
                                            <option value="04">Apr (04)</option>
                                            <option selected value="05">May (05)</option>
                                            <option value="06">June (06)</option>
                                            <option value="07">July (07)</option>
                                            <option value="08">Aug (08)</option>
                                            <option value="09">Sep (09)</option>
                                            <option value="10">Oct (10)</option>
                                            <option value="11">Nov (11)</option>
                                            <option value="12">Dec (12)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required ">&nbsp;</label>
                                        <div class="clear"></div>
                                        <select required class="form-control" name="card[expiryYear]" id="expiry-year">
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option selected value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required ">&nbsp;</label>
                                        <div class="clear"></div>
                                        <input required type="text" value="<?=$config->api_environment == "sandbox" ? "123":""?>" class="form-control" name="card[cvv]" id="cvv" placeholder="Card CVV">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="required  d-block pt-5">&nbsp;</label>
                                    <div class="clear"></div>
                                    <img src="http://localhost:8080/phptravels/assets/img/cc.png" class="img-responsive">
                                </div>
                            </div>
                        </fieldset></div>
                <br>
                <div class="form-group">
                    <div class="alert alert-danger submitresult" style="display: none;"></div>
                    <button type="submit" class="btn btn-success btn-lg paynowbtn go-right">Pay Now</button>
                    <div class="clear"></div>
                </div>
            </form>
            <form id="newForm" action="" method="post">
                <div id="main_form_div">
                </div>
            </form>

        </div>
        <?php } ?>
        <div style="max-width:680px" id="invoiceTable">

            <div class="success-box <?php if($invoice_details->status == "cancel"){ echo "cancelled"; }elseif ($invoice_details->status == "unpaid"){ echo "unpaid";  }else{echo "paid";}  ?>">
                <div class="icon">
                    <span><i class="<?php if($invoice_details->status == "paid"){ echo "ion-checkmark"; }else{ echo "ion-close";}  ?>"></i></span>
                </div>
                <div class="content">
                    <h4>Your booking status is <?=ucfirst($invoice_details->status)?></h4>
                    <div class="clear"></div>
                </div>
            </div>
            <table>
                <tr>
                    <?php if(isset($dataAdapter->responseMessage) && ! empty($dataAdapter->responseMessage)): ?>
                        <div class="alert-message"></div>
                    <?php endif; ?>
                    <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#E0F0FF">
                        <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                <tr>
                                    <td align="left" valign="top" style="font-family: Tahoma; font-size: 36px;line-height: 28px;color:#002141">
                                        <div style="font-size: 34px;text-transform:uppercase;font-weight: bold;"><?php echo trans("076"); ?></div>
                                        <div style="font-size: 12px !important;height: 14px;"><strong><?php echo trans('0398');?>:</strong> <?=$dataAdapter->booking_id?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                <?php if(isset($dataAdapter->bookingTraveler) && ! empty($dataAdapter->bookingTraveler)): ?>
                                    <?php foreach($dataAdapter->bookingTraveler as $index => $bookingTraveler): ?>
                                        <tr>
                                            <td align="right" valign="top" style="font-family: Tahoma; font-size: 18px; font-weight: 400; line-height: 12px;">
                                                <?php if ($index == 0): ?>
                                                    <div style="text-transform: uppercase;font-size: 16px !important;height: 20px;font-weight:bold"><?php echo trans("0545"); ?></div>
                                                <?php else: ?>
                                                    <hr/>
                                                <?php endif; ?>
                                                <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?=$bookingTraveler->name.' '.$bookingTraveler->surname?></div>
                                                <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?=$bookingTraveler->email?></div>
                                                <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?=$bookingTraveler->phone?></div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- <div  style="padding: 25px; background-color: #E0F0FF; color: #002141;">
            <div class="modal-title panel-body">
                <img src="<?php echo $theme_url; ?>assets/img/check.png" style="display: block; margin-right: auto; margin-left: auto;border: 0;ertical-align: middle;" alt="check" />
                <h4 class="text-center"><?php echo trans('0591');?></h4>
            </div>
        </div>-->

            <div style="background:#ffffff;padding: 18px;">
                <?php if(isset($dataAdapter->segments) && ! empty($dataAdapter->segments)): ?>
                    <h5 style="margin: 10px 0; text-align: left; background: #eee; padding: 13px; color: #0068d7; text-transform: uppercase;"> <strong><?php echo trans('0472');?></strong></h5>
                    <?php foreach(json_decode($dataAdapter->segments) as $segment){?>
                        <table>
                            <tr>
                                <td><h5><strong><?php echo trans('08');?></strong></h5></td>
                                <td><h5 class="strong"><?php echo $segment->operating_airline_iata; ?></h5></td>
                                <td><h5 class="strong"><?php echo trans('0564');?>: <?php echo $segment->flight_no ?></h5></td>
                            </tr>
                            <tr>
                                <td><p><?=$segment->ArrivalDate ?></p></td>
                                <td><p><?php echo $segment->OriginCode; ?></p></td>
                                <td><p><?php echo $segment->arrival_airport; ?></p></td>
                            </tr>
                            <tr>
                                <td><p><?=$segment->DepartureDate?></p></td>
                                <td><p><?php echo $segment->DestinationCode; ?></p></td>
                                <td><p><?php echo $segment->departure_airport; ?></p></td>

                            </tr>
                        </table>
                    <?php } ?>
                <?php endif; ?>
            </div>

            <div style="background: #ffffff; padding: 15px; text-align: left; border-top: 3px solid #a3a3a3;">
                <table style="width:100%;background: #F5F5F5; padding: 10px;">
                    <thead style="text-transform:uppercase;background: #e1dddd;">
                    <tr>
                        <td width="33.3%" align="left" style="font-family: Tahoma; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px;">
                            <?php echo trans('0562');?>
                        </td>
                        <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px;">
                            <?php echo trans('0563');?>
                        </td>
                        <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px;">
                            <?php echo trans('078');?>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td width="33.3%" align="left" style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px;">
                            <strong><?=$dataAdapter->Currency_code." ".$dataAdapter->price ?></strong>
                        </td>
                        <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px;">
                            <strong><?=$dataAdapter->taxes?></strong>
                        </td>
                        <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px;">
                            <strong><?=$dataAdapter->total_price?></strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p id="token" data-pnr="<?php echo $dataAdapter->access_token; ?>"><?php $show_download_button = TRUE; ?></p>
            </div>

            <table style="max-width: 600px; margin-top: 30px;">
                <tr>
                    <td align="center" style="background-color: #ffffff;" bgcolor="#ffffff">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                            <tr>
                                <td style="width:50px">
                                    <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER."favicon.png";?>" style="display: block; border: 0px;height:50px;width:50px;margin-right: 10px;"/>
                                </td>
                                <td align="left" style="color:#002141">
                                    <p style="font-size: 18px;font-family: tahoma; font-weight: 800; line-height: 10px; color: #002141;    margin-top: 5px;"><?php echo $app_settings[0]->site_title; ?></p>
                                    <p style="margin-top: 8px; font-size: 13px; line-height: 0px;"><i class="icon_set_1_icon-84"></i> <?php echo $contactemail; ?></p>
                                    <p style="margin-top: 3px; font-size: 13px; line-height: 0px;"><i class="icon_set_1_icon-90"></i> <?php echo $phone; ?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>
<?php endif; ?>
<?php if($show_download_button): ?>

    <br><br>
    <div class="text-center">
        <div id="editor"></div>
        <input type="button" class="btn btn-success" value="Print" onclick="printinvoice()">
        <button onclick="saveAndSendInvoice(0)" class="btn btn-default"><?php echo trans('0596');?></button>
        <button id="btn" class="btn btn-primary"><?php echo trans('0593');?></button>
    </div>

    <a href="#" id="image"></a> <!-- popup download box for downloading -->
<?php endif; ?>

<!-- JS script convet targeted DOM into PNG image and saved on server, Also send invocie as notification in email -->
<script src="<?php echo base_url('assets/js/jquery-ui.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/default/assets/js/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/default/assets/js/html2canvas.min.js"></script>
<script>


    function printinvoice() {
        var container = document.getElementById("invoiceTable");
        html2canvas(container, {
            onrendered: function (snapshot) {
                var tempcanvas = document.createElement('canvas');
                tempcanvas.width = container.clientWidth;
                tempcanvas.height = container.clientHeight;
                var context = tempcanvas.getContext('2d');
                context.drawImage(snapshot, 0, 0);
                var base64ImageString = tempcanvas.toDataURL('image/jpeg');
                // Print image
                var oldPage = document.body.innerHTML; //Get the HTML of whole page
                document.body.innerHTML ="<html><head><title></title></head><body><img style='margin:10px 60px' src='" + base64ImageString + "'/></body>";
                setTimeout(function() {
                    window.print(); //Print Page
                    document.body.innerHTML = oldPage; //Restore orignal HTML
                }, 1000)
            }
        });
    }

    $("#myForm").submit(function (e) {

        e.preventDefault();

        var actionurl = e.currentTarget.action;

        //do your own request an handle the results
        $.ajax({
            url: actionurl,
            type: 'post',
            data: $("#myForm").serialize(),
            success: function(data) {
                var data = JSON.parse(data);
                console.log(data);
                if(data.status){
                    data = data.body;
                    $("#newForm").attr('action',data.redirect.url);
                    data.redirect.parameters.forEach(function (item) {
                        $("#main_form_div").append(
                            '<input type="hidden" name="'+item.name+'" value="'+item.value+'">'
                        );
                    });
                    $("#newForm").submit();

                }
            }
        });

    });

    $('#btn').click(function () {
        var container = document.getElementById("invoiceTable");
        html2canvas(container, {
            onrendered: function (snapshot) {
                var tempcanvas = document.createElement('canvas');
                tempcanvas.width = container.clientWidth;
                tempcanvas.height = container.clientHeight;
                var context = tempcanvas.getContext('2d');
                context.drawImage(snapshot, 0, 0);
                var base64ImageString = tempcanvas.toDataURL('image/jpeg');
                console.log(base64ImageString);
                // Save as a pdf
                var doc = new jsPDF();
                doc.addImage(base64ImageString, 'JPEG', 30, 20, 150, 200);
                doc.save('invoice_'+Date.now()+'.pdf');
            }
        });
    });
</script>
