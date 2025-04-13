<div style="background-color: #d8d8d8;" bgcolor="#d8d8d8">
    <div id="content">
        <div id="printablediv">
            <table id="invoiceTable" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                   style="max-width:600px;margin-top: 35px; margin-bottom: 35px;">
                <tr>
                    <td align="center" valign="top"
                        style="font-size: 0; padding: 12px; color: black; font-family: tahoma; text-transform: uppercase; letter-spacing: 4px;"
                        bgcolor="#FF9900">
                        <div style="font-size:16px;color:white;">
                            <?php echo trans("0409"); ?> <b class="wow flash animted"><?php echo trans("0445"); ?></b>
                            <p style="color:white;letter-spacing: 2px; font-size: 10px; margin-top: 0px;"
                               class="text-center"><?php echo trans("0474"); ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#E0F0FF">
                        <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"
                                   style="max-width:300px;">
                                <tr>
                                    <td align="left" valign="top"
                                        style="font-family: Tahoma; font-size: 36px;line-height: 28px;color:#002141">
                                        <div style="font-size: 11px !important;height: 14px;">
                                            <strong><?php echo trans("076"); ?><?php echo trans("08"); ?> </strong>: <?php echo $invoice->created_at; ?>
                                        </div>
                                        <div style="font-size: 12px !important;height: 14px;margin-bottom:14px">
                                            <strong><?php echo trans("079"); ?> </strong>: <?php echo $invoice->checkin; ?>
                                        </div>
                                        <div style="font-size: 34px;text-transform:uppercase;font-weight: bold;"><?php echo trans("076"); ?></div>
                                        <div style="font-size: 12px !important;height: 14px;">
                                            <strong><?php echo trans("076"); ?><?php echo trans("0434"); ?></strong>
                                            : <?php echo $invoice->id; ?></div>
                                        <div style="font-size: 12px !important;height: 14px;">
                                            <strong><?php echo trans("0398"); ?></strong> <?php echo $invoice->booking_code; ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"
                                   style="max-width:300px;">
                                <tr>
                                    <td align="right" valign="top"
                                        style="font-family: Tahoma; font-size: 18px; font-weight: 400; line-height: 48px;">
                                        <div style="text-transform: uppercase;font-size: 16px !important;height: 20px;font-weight:bold"><?php echo trans("0545"); ?></div>
                                        <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?php echo $invoice->guest->first_name . ' ' . $invoice->guest->last_name; ?></div>
                                        <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?php echo $invoice->guest->email; ?></div>
                                        <div style="text-transform: uppercase; letter-spacing: 0px;font-size: 12px !important;height: 4px;margin-bottom:14px"><?php echo $invoice->guest->number; ?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr style="height: 4px; width: 100%; float: left;background: #f76570; background: -moz-linear-gradient(left, #f76570 0%, #f76570 8%, #f3a46b 8%, #f3a46b 16%, #f3a46b 16%, #ffd205 16%, #ffd205 24%, #ffd205 24%, #1bbc9b 24%, #1bbc9b 25%, #1bbc9b 32%, #14b9d5 32%, #14b9d5 40%, #c377e4 40%, #c377e4 48%, #f76570 48%, #f76570 56%, #f3a46b 56%, #f3a46b 64%, #ffd205 64%, #ffd205 72%, #1bbc9b 72%, #1bbc9b 80%, #14b9d5 80%, #14b9d5 80%, #14b9d5 89%, #c377e4 89%, #c377e4 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,#f76570), color-stop(8%,#f76570), color-stop(8%,#f3a46b), color-stop(16%,#f3a46b), color-stop(16%,#f3a46b), color-stop(16%,#ffd205), color-stop(24%,#ffd205), color-stop(24%,#ffd205), color-stop(24%,#1bbc9b), color-stop(25%,#1bbc9b), color-stop(32%,#1bbc9b), color-stop(32%,#14b9d5), color-stop(40%,#14b9d5), color-stop(40%,#c377e4), color-stop(48%,#c377e4), color-stop(48%,#f76570), color-stop(56%,#f76570), color-stop(56%,#f3a46b), color-stop(64%,#f3a46b), color-stop(64%,#ffd205), color-stop(72%,#ffd205), color-stop(72%,#1bbc9b), color-stop(80%,#1bbc9b), color-stop(80%,#14b9d5), color-stop(80%,#14b9d5), color-stop(89%,#14b9d5), color-stop(89%,#c377e4), color-stop(100%,#c377e4)); background: -o-linear-gradient(left, #f76570 0%,#f76570 8%,#f3a46b 8%,#f3a46b 16%,#f3a46b 16%,#ffd205 16%,#ffd205 24%,#ffd205 24%,#1bbc9b 24%,#1bbc9b 25%,#1bbc9b 32%,#14b9d5 32%,#14b9d5 40%,#c377e4 40%,#c377e4 48%,#f76570 48%,#f76570 56%,#f3a46b 56%,#f3a46b 64%,#ffd205 64%,#ffd205 72%,#1bbc9b 72%,#1bbc9b 80%,#14b9d5 80%,#14b9d5 80%,#14b9d5 89%,#c377e4 89%,#c377e4 100%); background: -ms-linear-gradient(left, #f76570 0%,#f76570 8%,#f3a46b 8%,#f3a46b 16%,#f3a46b 16%,#ffd205 16%,#ffd205 24%,#ffd205 24%,#1bbc9b 24%,#1bbc9b 25%,#1bbc9b 32%,#14b9d5 32%,#14b9d5 40%,#c377e4 40%,#c377e4 48%,#f76570 48%,#f76570 56%,#f3a46b 56%,#f3a46b 64%,#ffd205 64%,#ffd205 72%,#1bbc9b 72%,#1bbc9b 80%,#14b9d5 80%,#14b9d5 80%,#14b9d5 89%,#c377e4 89%,#c377e4 100%); background: linear-gradient(to right, #f76570 0%,#f76570 8%,#f3a46b 8%,#f3a46b 16%,#f3a46b 16%,#ffd205 16%,#ffd205 24%,#ffd205 24%,#1bbc9b 24%,#1bbc9b 25%,#1bbc9b 32%,#14b9d5 32%,#14b9d5 40%,#c377e4 40%,#c377e4 48%,#f76570 48%,#f76570 56%,#f3a46b 56%,#f3a46b 64%,#ffd205 64%,#ffd205 72%,#1bbc9b 72%,#1bbc9b 80%,#14b9d5 80%,#14b9d5 80%,#14b9d5 89%,#c377e4 89%,#c377e4 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f76570', endColorstr='#c377e4',GradientType=1 );"></tr>
                <tr>
                    <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;"
                        bgcolor="#ffffff">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                               style="max-width:600px;">
                            <tr>
                                <td align="left"
                                    style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 5px;">
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="padding-top: 20px;">
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td width="75%" align="left" bgcolor="#eeeeee"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 800; line-height: 24px; padding: 5px;">
                                                <?php echo $invoice->hotel_name; ?>
                                            </td>
                                            <td width="25%" align="left" bgcolor="#eeeeee"
                                                style="font-family: Tahoma; font-size: 12px; line-height: 24px; padding: 5px;"><?php echo $invoice->hotel_location; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="75%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <img style="width:55px" src="<?php echo $invoice->hotel_image; ?>"
                                                     class="img-responsive">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="75%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <?php echo trans("0435"); ?> : <?php echo $invoice->room_name; ?>
                                            </td>
                                            <td width="25%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="75%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <strong><?php echo trans("07"); ?>  </strong>
                                            </td>
                                            <td width="25%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <?php echo $invoice->checkin; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="75%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <strong><?php echo trans("09"); ?>  </strong>
                                            </td>
                                            <td width="25%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <?php echo $invoice->checkout; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="75%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <strong><?php echo trans("060"); ?>  </strong>
                                            </td>
                                            <td width="25%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <?php echo $invoice->total_nights; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="75%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <strong>Total Amount </strong>
                                            </td>
                                            <td width="25%" align="left"
                                                style="font-family: Tahoma; font-size: 16px; font-weight: 400; line-height: 14px; padding: 5px;">
                                                <?php echo $invoice->currency_code; ?><?php echo $invoice->total_amount; ?>
                                            </td>
                                        </tr>


                                        <?php if (!empty($invoice->additionaNotes)) { ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><?php echo trans('0178'); ?></div>
                                                <div class="panel-body"><p><?php echo $invoice->additionaNotes; ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </table>
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                <td align="center" style="padding: 10px 37px;; background-color: #ffffff;"
                                    bgcolor="#ffffff">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                                           style="max-width:600px;">
                                        <tr>
                                            <td style="width:50px">
                                                <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER . "favicon.png"; ?>"
                                                     style="display: block; border: 0px;height:50px;width:50px;margin-right: 10px;"/>
                                            </td>
                                            <td align="left" style="color:#002141;width:550px">
                                                <p style="font-size: 14px;font-family: tahoma; font-weight: 800; line-height: 0px; color: #002141;    margin-top: 5px;"><?php echo $app_settings[0]->site_title; ?></p>
                                                <p style="margin: 0px;"><i
                                                            class="icon_set_1_icon-41"></i> <?php echo strip_tags($contactaddress); ?>
                                                </p>
                                                <p style="margin: 0px;"><i
                                                            class="icon_set_1_icon-84"></i> <?php echo strip_tags($contactemail); ?>
                                                </p>
                                                <p style="margin: 0px;"><i
                                                            class="icon_set_1_icon-90"></i> <?php echo strip_tags($phone); ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="text-center">
        <div id="editor"></div>
        <input type="button" class="btn btn-success" value="Print" onclick="printinvoice()">
        <button onclick="downloadInvoice()" class="btn btn-default"><?php echo trans('0596');?></button>
        <button id="btn" class="btn btn-primary"><?php echo trans('0593');?></button>
    </div>
    <a href="#" id="image"></a> <!-- popup download box for downloading -->
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>themes/default/assets/js/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/default/assets/js/html2canvas.min.js"></script>
<script language="javascript" type="text/javascript">
    var receivers = JSON.parse('<?php echo json_encode($notifiable_emails); ?>');
    var saveAndSendInvoice = function (notification_flag) {
        var image_name = "<?=time()?>";
        var invoice_name = image_name + ".png";
        if (image_name != undefined) {
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
                    var save_invoice_endpoint = base_url + "thhotels/ajaxController/save_invoice";
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
                        $.post(save_invoice_endpoint, payload, function (response) {
                            // $('.loader-wrapper').hide();
                            console.log(response);
                        });
                    }
                }
            });
        }
    }

    // Send Notification
    var notification_flag = "<?=$notification_flag?>";
    saveAndSendInvoice(notification_flag);
    // change uri
    window.history.pushState('Invoice', 'Invoice', '<?php echo $invoice_url; ?>');

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

    function downloadInvoice() {
        var container = document.getElementById("invoiceTable");
        html2canvas(container, {
            onrendered: function (snapshot) {
                var tempcanvas = document.createElement('canvas');
                tempcanvas.width = container.clientWidth;
                tempcanvas.height = container.clientHeight;
                var context = tempcanvas.getContext('2d');
                context.drawImage(snapshot, 0, 0);
                var base64ImageString = tempcanvas.toDataURL('image/jpeg');
                // Download image
                var image = base64ImageString.replace("image/png", "application/octet-stream;headers=Content-Disposition: attachment; filename=invoice.png");
                var anchor = document.getElementById('image');
                anchor.href = image;
                anchor.download = 'invoice_'+Date.now()+'.png';
                anchor.click();
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