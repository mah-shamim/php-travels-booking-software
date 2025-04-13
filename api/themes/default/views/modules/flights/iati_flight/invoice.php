<br><br>

<style>p { margin:0px;font-size: 14px;} h5 { margin:0px;font-size: 15px;} table { width: 680px; } html { font-family:tahoma; } body { background-color: #d8d8d8 } </style>



<center id="container">



    <div id="booking" data-is-placed="1">

        <?php echo trans('0594');?>: <strong><?php echo $invoice->pnr; ?></strong>

    </div>

    <br>



    <div style="max-width:680px" id="invoiceTable">

        <div style="height: 60px; padding: 15px; background-color: #323232; color: #ffffff; letter-spacing: 1px;">

            <img style="height:32px;float:left;"src="<?php echo $theme_url; ?>assets/img/paper.png" alt="print" />

            <p style="float:left;margin:0px;font-size:12px;text-align:left;padding-left:15px">

                <?php echo trans('0592');?>

            </p>

            <br><br>

            <div style="display:block"></div>

        </div>



        <table>

            <tr>


            <!-- start: passengers -->


            <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#E0F0FF">

                <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">

                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">

                        <tr>

                            <td align="left" valign="top" style="font-family: Tahoma; font-size: 36px;line-height: 28px;color:#002141">

                                <div style="font-size: 34px;text-transform:uppercase;font-weight: bold;"><?php echo trans("076"); ?></div>

                                <div style="font-size: 12px !important;height: 14px;"><strong><?php echo trans('0398');?>:</strong> <?=$invoice->order_id?></div>

                            </td>

                        </tr>

                    </table>

                </div>

                <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">

                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                        <?php foreach($invoice->passengers as $passenger): ?>
                        <tr>
                            <td align="right" valign="top" style="font-family: Tahoma; font-size: 18px; font-weight: 400; line-height: 12px;">
                               <div style="text-transform: uppercase;font-size: 16px !important;height: 20px;font-weight:bold"><?php echo trans("0545"); ?></div>
                               <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?=$passenger->name.' '.$passenger->surname?></div>
                               <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?=$invoice->contact_info->email?></div>
                               <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?=$invoice->contact_info->phoneNumber?></div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>

                </div>

            <!-- end: passengers -->

            </td>

           </tr>

               <tr style="height: 4px; width: 100%; float: left;background: #f76570; background: -moz-linear-gradient(left, #f76570 0%, #f76570 8%, #f3a46b 8%, #f3a46b 16%, #f3a46b 16%, #ffd205 16%, #ffd205 24%, #ffd205 24%, #1bbc9b 24%, #1bbc9b 25%, #1bbc9b 32%, #14b9d5 32%, #14b9d5 40%, #c377e4 40%, #c377e4 48%, #f76570 48%, #f76570 56%, #f3a46b 56%, #f3a46b 64%, #ffd205 64%, #ffd205 72%, #1bbc9b 72%, #1bbc9b 80%, #14b9d5 80%, #14b9d5 80%, #14b9d5 89%, #c377e4 89%, #c377e4 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,#f76570), color-stop(8%,#f76570), color-stop(8%,#f3a46b), color-stop(16%,#f3a46b), color-stop(16%,#f3a46b), color-stop(16%,#ffd205), color-stop(24%,#ffd205), color-stop(24%,#ffd205), color-stop(24%,#1bbc9b), color-stop(25%,#1bbc9b), color-stop(32%,#1bbc9b), color-stop(32%,#14b9d5), color-stop(40%,#14b9d5), color-stop(40%,#c377e4), color-stop(48%,#c377e4), color-stop(48%,#f76570), color-stop(56%,#f76570), color-stop(56%,#f3a46b), color-stop(64%,#f3a46b), color-stop(64%,#ffd205), color-stop(72%,#ffd205), color-stop(72%,#1bbc9b), color-stop(80%,#1bbc9b), color-stop(80%,#14b9d5), color-stop(80%,#14b9d5), color-stop(89%,#14b9d5), color-stop(89%,#c377e4), color-stop(100%,#c377e4)); /* background: -webkit-linear-gradient(left, #f76570 0%,#f76570 8%,#f3a46b 8%,#f3a46b 16%,#f3a46b 16%,#ffd205 16%,#ffd205 24%,#ffd205 24%,#1bbc9b 24%,#1bbc9b 25%,#1bbc9b 32%,#14b9d5 32%,#14b9d5 40%,#c377e4 40%,#c377e4 48%,#f76570 48%,#f76570 56%,#f3a46b 56%,#f3a46b 64%,#ffd205 64%,#ffd205 72%,#1bbc9b 72%,#1bbc9b 80%,#14b9d5 80%,#14b9d5 80%,#14b9d5 89%,#c377e4 89%,#c377e4 100%); */ background: -o-linear-gradient(left, #f76570 0%,#f76570 8%,#f3a46b 8%,#f3a46b 16%,#f3a46b 16%,#ffd205 16%,#ffd205 24%,#ffd205 24%,#1bbc9b 24%,#1bbc9b 25%,#1bbc9b 32%,#14b9d5 32%,#14b9d5 40%,#c377e4 40%,#c377e4 48%,#f76570 48%,#f76570 56%,#f3a46b 56%,#f3a46b 64%,#ffd205 64%,#ffd205 72%,#1bbc9b 72%,#1bbc9b 80%,#14b9d5 80%,#14b9d5 80%,#14b9d5 89%,#c377e4 89%,#c377e4 100%); background: -ms-linear-gradient(left, #f76570 0%,#f76570 8%,#f3a46b 8%,#f3a46b 16%,#f3a46b 16%,#ffd205 16%,#ffd205 24%,#ffd205 24%,#1bbc9b 24%,#1bbc9b 25%,#1bbc9b 32%,#14b9d5 32%,#14b9d5 40%,#c377e4 40%,#c377e4 48%,#f76570 48%,#f76570 56%,#f3a46b 56%,#f3a46b 64%,#ffd205 64%,#ffd205 72%,#1bbc9b 72%,#1bbc9b 80%,#14b9d5 80%,#14b9d5 80%,#14b9d5 89%,#c377e4 89%,#c377e4 100%); background: linear-gradient(to right, #f76570 0%,#f76570 8%,#f3a46b 8%,#f3a46b 16%,#f3a46b 16%,#ffd205 16%,#ffd205 24%,#ffd205 24%,#1bbc9b 24%,#1bbc9b 25%,#1bbc9b 32%,#14b9d5 32%,#14b9d5 40%,#c377e4 40%,#c377e4 48%,#f76570 48%,#f76570 56%,#f3a46b 56%,#f3a46b 64%,#ffd205 64%,#ffd205 72%,#1bbc9b 72%,#1bbc9b 80%,#14b9d5 80%,#14b9d5 80%,#14b9d5 89%,#c377e4 89%,#c377e4 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f76570', endColorstr='#c377e4',GradientType=1 );"></tr>

        </table>


        <div style="background:#ffffff;padding: 18px;">

            <h5 style="margin: 10px 0; text-align: left; background: #eee; padding: 13px; color: #0068d7; text-transform: uppercase;"> <strong><?php echo trans('0472');?></strong></h5>

            <!-- start: Outbound segment -->
            <?php if (! empty($invoice->iati_flight['outbound'])): ?>
            <?php foreach ($invoice->iati_flight['outbound']->legs as $outbound): ?>
            <table>
                <tr>
                    <td><h5><strong><?php echo trans('08');?></strong></h5></td>
                    <td><h5 class="strong"><?php echo $outbound->carrierName; ?></h5></td>
                    <td>
                        <h5 class="strong"><?php echo trans('0564');?>: <?php echo $outbound->flightNo ?></h5>
                    </td>
                </tr>
                <tr>
                    <td><p><?= $outbound->arrivalTime ?></p></td>
                    <td><p><?php echo $outbound->departureCityName; ?></p></td>
                    <td><p><?php echo $outbound->carrierName; ?></p></td>
                </tr>
                <tr>
                    <td><p><?= $outbound->departureTime ?></p></td>
                    <td><p><?php echo $outbound->arrivalCityName; ?></p></td>
                    <td></td>
                </tr>
            </table>
            <?php endforeach; ?>
            <?php endif; ?>
            <!-- end: Outbound segment -->


            
            
            <!-- start: Inbound segment -->
            <?php if (! empty($invoice->iati_flight['inbound'])): ?>
            <h5 style="margin: 10px 0; text-align: left; background: #eee; padding: 13px; color: #0068d7; text-transform: uppercase;"> <strong><?php echo trans('0473');?></strong></h5>
            <?php foreach ($invoice->iati_flight['inbound']->legs as $inbound): ?>
            <table>
                <tr>
                    <td><h5><strong><?php echo trans('08');?></strong></h5></td>
                    <td><h5 class="strong"><?php echo $inbound->carrierName; ?></h5></td>
                    <td>
                        <h5 class="strong"><?php echo trans('0564');?>: <?php echo $inbound->flightNo ?></h5>
                    </td>
                </tr>
                <tr>
                    <td><p><?= $inbound->arrivalTime ?></p></td>
                    <td><p><?php echo $inbound->departureCityName; ?></p></td>
                    <td><p><?php echo $inbound->carrierName; ?></p></td>
                </tr>
                <tr>
                    <td><p><?= $inbound->departureTime ?></p></td>
                    <td><p><?php echo $inbound->arrivalCityName; ?></p></td>
                    <td></td>
                </tr>
            </table>
            <?php endforeach; ?>
            <?php endif; ?>
            <!-- end: Inbound segment -->

            <div>

            </div>

        </div>

        <div style="background: #ffffff; padding: 15px; text-align: left; border-top: 3px solid #a3a3a3;">

         <!-- start: price aggregator -->

        <table style="width:100%;background: #F5F5F5; padding: 10px;">

                    <thead style="text-transform:uppercase;background: #e1dddd;">

                        <tr>

                            <td width="33.3%" align="left" style="font-family: Tahoma; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px;">

                                <?php echo trans('0562');?>                                            </td>

                            <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px;">

                               <?php echo trans('0563');?>                                          </td>

                            <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px;">

                               <?php echo trans('078');?>                                       </td>

                        </tr>

                    </thead>

                    <tbody>

                          <tr>

                            <td width="33.3%" align="left" style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px;">

                               <strong><?= $invoice->currency.' '.$invoice->base_fare ?></strong>                                       
                            </td>

                            <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px;">

                               <strong><?= $invoice->currency.' '.($invoice->tax + $invoice->service_fee) ?></strong>                                           
                            </td>

                            <td width="33.3%" align="center" style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px;">

                               <strong><?= $invoice->currency.' '.$invoice->total_price ?></strong>                                        
                            </td>

                        </tr>

                    </tbody>

                </table>
            
            <div>

                <p id="token" data-pnr="pnr"><?php $show_download_button = TRUE; ?></p>

            </div>

            <!-- end: price aggregator -->

            <table style="max-width: 600px; margin-top: 30px;">

            <tr>

                        <td align="center" style="background-color: #ffffff;" bgcolor="#ffffff">

                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">

                                <tr>

                                    <td style="width:50px">

                                    <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER."favicon.png";?>" style="display: block; border: 0px;height:50;width:50px;margin-right: 10px;"/>

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

    </div>

</center>


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

    var receivers = '';

    var saveAndSendInvoice = function(notification_flag) {

        var image_name = $('#token').data('pnr');

        var invoice_name = '<?=$invoice->pnr?>' + ".png";

        if (image_name != undefined)

        {

            console.log('Processing...');

            // Create invoice snap shot and send

            var container = document.getElementById("invoiceTable");

            html2canvas(container, {

                onrendered: function (snapshot) {

                    var tempcanvas = document.createElement('canvas');

                        tempcanvas.width = container.clientWidth;

                        tempcanvas.height = container.clientHeight;

                    var context = tempcanvas.getContext('2d');

                        context.drawImage(snapshot, 0, 0);

                    var base64ImageString = tempcanvas.toDataURL('image/png');

                    var save_invoice_endpoint = base_url + "flightsi/save_invoice";

                    var payload = { 

                        invoice_name: invoice_name, 

                        base64ImageString: tempcanvas.toDataURL(),

                        receivers: receivers

                    };

                    

                    var image = base64ImageString.replace("image/png", "application/octet-stream;headers=Content-Disposition: attachment; filename=something.png");

                    var anchor = document.getElementById('image');

                        anchor.href = image;

                        anchor.download = invoice_name;

                    // Send as notification Or Download

                    if (notification_flag == 1) {

                        // $('.loader-wrapper').show();

                        $.post(save_invoice_endpoint, payload, function(response) {

                            // $('.loader-wrapper').hide();

                            console.log(response);

                        });

                    } else {

                        anchor.click();

                    }

                }

            });

        }

    }



    var is_order_placed = $('#booking').data('is-placed');

    if (is_order_placed != undefined) {

        is_order_placed = undefined;

        // Send Notification

        saveAndSendInvoice(1);



        // change uri

        window.history.pushState('Invoice', 'Invoice', '<?php echo $invoice_url; ?>');

    }



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

