<?php $response = json_decode($invoice->response_object); ?>
<?php $bookingHolder = json_decode($invoice->booking_holder); ?>
<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-action">
  <div class="page-wrapper page-confirmation bg-light">
    <div class="container">
      <div class="success-box">
        <div class="icon">
          <span><i class="ri ri-check-square"></i></span>
        </div>
        <div class="content">
          <?php if ($invoice->status == "unpaid") { if (time() < $invoice->expiryUnixtime) { ?>
          <div class="success-box unpaid">
            <div class="icon">
              <span><i class="ion-close"></i></span>
            </div>
            <div class="content">
              <h4><?php echo trans("082"); ?></h4>
              <div class="clear"></div>
            </div>
          </div>
          <?php } else { ?>
          <div class="success-box expired">
            <div class="icon">
              <span><i class="ion-alert-circled"></i></span>
            </div>
            <div class="content">
              <h4><?php echo trans("0409"); ?></h4>
              <div class="clear"></div>
            </div>
          </div>
          <?php }
            } elseif ($response->booking->status == "CONFIRMED") { ?>
          <?php echo trans("0409"); ?> <b class="wow flash animted"><?php echo trans("0445"); ?></b>
          <?php if ($invoice->paymethod == "payonarrival") { ?>
          <h4><?php echo trans("0474"); ?></h4>
          <?php }
            } elseif ($invoice->status == "cancelled") { ?>
          <h4><?php echo trans("0347"); ?></h4>
          <?php } else { ?>
          <?php echo trans("0409"); ?> <b class="wow flash animted"><?php echo trans("081"); ?></b>
          <p style="color:white;letter-spacing: 2px; font-size: 10px; margin-top: 0px;" class="text-center"><?php echo trans("0410"); ?><?php echo $invoice->accountEmail; ?></p>
          <?php } ?>
        </div>
      </div>
      <div class="row gap-30 equal-height">
        <div class="col-12 col-lg-4 order-lg-last">
          <aside class="sidebar-wrapper pt-30 pb-30 bg-white-shadow">
            <a href="#" class="product-small-item">
              <div class="image">
                <img src="<?php echo $invoice->hotel_image;?>" alt="image">
              </div>
              <div class="content">
                <div class="content-body">
                  <div class="rating-item rating-sm rating-inline mb-7 go-text-right">
                    <i class="rating-icon fa fa-star rating-rated"></i><i class="rating-icon fa fa-star rating-rated"></i><i class="rating-icon fa fa-star rating-rated"></i><i class="rating-icon fa fa-star rating-rated"></i><i class="rating-symbol-background rating-icon far fa-star"></i>                      
                  </div>
                  <h6> <?php echo $invoice->hotel_name;?> 
                    <small>
                    <?php for($i = 0; $i < 5; $i++): ?>
                    <?php if($i < $invoice->hotel_stars): ?>
                    <i class="star fa fa-star"></i>
                    <?php else: ?>
                    <i class="star star fa fa-star-o"></i>
                    <?php endif; ?>
                    <?php endfor; ?>
                    </small>
                  </h6>
                  <div class="clear"></div>
                  <span class="meta text-muted"><i class="ion-location text-info"></i><?php echo ($invoice->hotel_location!="NULL")?$invoice->hotel_location:"";?></span>
                  <div class="clear"></div>
                </div>
              </div>
            </a>
            <h3 class="heading-title"><span>Summary</span></h3>
            <hr class="mb-30 mt-30" />
            <ul class="confirmation-list">
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("0435");?>:</span>
                <span><?php echo $invoice->room_name;?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold">Board Name:</span>
                <span><?php echo $invoice->room_rate->boardName;?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("07");?>:  </span>
                <span> <?php echo date('Y-m-d', strtotime($invoice->checkin)); ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("09");?>:</span>
                <span>  <?php echo date('Y-m-d', strtotime($invoice->checkout)); ?></span>
              </li>
            </ul>
            <div class="mb-40"></div>
            <h3 class="heading-title"><span>Cancellation Policies</span></h3>
            <ul class="confirmation-list">
              <li class="clearfix">
                <?php foreach ($invoice->room_rate->cancellationPolicies as $policy): ?>
                <span class="font-weight-bold">Amount:</span>
                <span><?= $policy->amount ?></span>
                <?php endforeach; ?>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold">From:</span>
                <?php foreach ($invoice->room_rate->cancellationPolicies as $policy): ?>
                <span><?= $policy->from ?></span>
                <?php endforeach; ?>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("060");?>:</span>
                <span><?php echo $invoice->total_nights; ?></span>
              </li>
              <li class="clearfix total">
                <span class="font-weight-bold">Total Amount</span>
                <span class="text-main text-secondary">  <?php echo $invoice->currency_code;?><?php echo $invoice->total_amount;?></span>
              </li>
            </ul>
          </aside>
        </div>
        <div class="col-12 col-lg-8">
          <div class="content-wrapper pt-30 pb-30 bg-white-shadow w-100">
            <h3 class="heading-title"><span>Traveller Information</span></h3>
            <ul class="confirmation-list">
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("076"); ?> <?php echo trans("08"); ?>:</span>
                <span><?php echo $invoice->created_at; ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("079"); ?>:</span>
                <span><?php echo $invoice->checkin; ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("076"); ?> <?php echo trans("0434"); ?>:</span>
                <span><?php echo $invoice->id; ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?php echo trans("0398"); ?>:</span>
                <span><?php echo $response->booking->reference; ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?=lang('090')?>:</span>
                <span><?php echo $bookingHolder->first_name.$bookingHolder->last_name; ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?=lang('098')?>:</span>
                <span><?php echo $bookingHolder->address; ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold"><?=lang('0173')?>:</span>
                <span><?php echo $bookingHolder->mobile_code.$bookingHolder->phone_number; ?></span>
              </li>
              <?php foreach ($invoice->room->paxes as $pax): ?>
              <li class="clearfix">
                <span class="font-weight-bold">Type:</span>
                <span><?= $pax->type ?></span>
              </li>
              <li class="clearfix">
                <span class="font-weight-bold">Name:</span>
                <span><?= $pax->name.' '.$pax->surname ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
            <div class="mb-40"></div>
            <?php if(!empty($invoice->additionaNotes)){ ?>
            <h3 class="heading-title"><span><?php echo trans('0178');?></span></h3>
            <div class="clear"></div>
            <p><?php echo $invoice->additionaNotes;?></p>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="row shrink-auto-md gap-30 mt-40">
        <div class="col-6 col-shrink">
          <div class="featured-contact-01">
            <img style="width:100px; height:100px;" src="<?php echo PT_GLOBAL_IMAGES_FOLDER."favicon.png";?>" />
          </div>
        </div>
        <div class="col-6 col-shrink">
          <div class="featured-contact-01">
            <h3><?php echo $app_settings[0]->site_title; ?></h3>
            <p><?php echo strip_tags($contactaddress); ?></p>
            <p><?php echo strip_tags($contactemail); ?></p>
            <p><?php echo strip_tags($phone); ?></p>
          </div>
        </div>
      </div>
      <?php if( isset($_SESSION['order_placed']) && ! empty($_SESSION['order_placed']) ): ?>
      <div id="booking" data-is-placed="1"></div>
      <?php endif; ?>
      <div class="text-center">
        <div id="editor"></div>
        <input type="button" class="btn btn-success" value="Print" onclick="printDiv()"/>
        <button id="downloadInvoice" class="btn btn-default"><?php echo trans('0596');?></button>
        <a href="#" id="image"></a>
        <a href="javascript:void()" id="btn" class="btn btn-primary"><?php echo trans('0593');?></a>
      </div>
    </div>
  </div>
</div>
<!-- end Main Wrapper -->
<script language="javascript" type="text/javascript">
  var saveAndSendInvoice = function(notification_flag) {
      var receivers = "<?=$_SESSION['notifiable_emails']?>";
      var image_name = "invoice_<?=time()?>";
      var invoice_name = image_name + ".png";
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
                  var save_invoice_endpoint = base_url + "hotelb/save_invoice";
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
                  // $('.loader-wrapper').show();
                  $.post(save_invoice_endpoint, payload, function(response) {
                      // $('.loader-wrapper').hide();
                      console.log(response);
                  });
              }
          });
      }
  }
  var is_order_placed = $('#booking').data('is-placed');
  if (is_order_placed != undefined) {
      is_order_placed = undefined;
      // Send Notification
      saveAndSendInvoice();
      // change uri
      // window.history.pushState('Invoice', 'Invoice', "<?php echo $_SESSION['invoice_url']; ?>");
  }
  
  // Create invoice snap shot and download as a pdf
  $(document).ready(function() {
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
                  // Save as a pdf
                  var doc = new jsPDF();
                  doc.addImage(base64ImageString, 'JPEG', 5, 20, 200, 250);
                  doc.save('invoice_<?php echo $invoice->id; ?>.pdf');
              }
          });
      });
  
      $('#downloadInvoice').click(function () {
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
      });
  });
  
  function printDiv() {
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
  // set the date we're counting down to
  var target_date = new Date('<?php echo $invoice->expiryFullDate; ?>').getTime();
  var target_date = '<?php echo $invoice->expiryUnixtime * 1000; ?>';
  var invoiceStatus = "<?php echo $invoice->status; ?>";
  
  // variables for time units
  var days, hours, minutes, seconds;
  
  // get tag element
  var countdown = document.getElementById('countdown');
  var ccc = new Date().getTime();
  if(invoiceStatus == "unpaid"){
      // update the tag with id "countdown" every 1 second
      setInterval(function () {
  
    // find the amount of "seconds" between now and target
     var current_date = new Date().getTime();
     var seconds_left = (target_date - current_date) / 1000;
  
    // do some time calculations
     days = parseInt(seconds_left / 86400);
     seconds_left = seconds_left % 86400;
     hours = parseInt(seconds_left / 3600);
     seconds_left = seconds_left % 3600;
     minutes = parseInt(seconds_left / 60);
     seconds = parseInt(seconds_left % 60);
  
    // format countdown string + set tag value
     countdown.innerHTML = '<span class="days">' + days +  ' <b><?php echo trans("0440");?></b></span> <span class="hours">' + hours + ' <b><?php echo trans("0441");?></b></span> <span class="minutes">'
     + minutes + ' <b><?php echo trans("0442");?></b></span> <span class="seconds">' + seconds + ' <b><?php echo trans("0443");?></b></span>';
     }, 1000);
  }
  
  $(function(){
  $(".submitresult").hide();
  loadPaymethodData();
  $(".arrivalpay").on("click",function(){
  var id = $(this).prop("id");
  var module = $(this).data("module");
  var check = confirm("<?php echo trans('0483')?>");
  if(check){
  $.post("<?php echo base_url();?>invoice/updatePayOnArrival", {id: id,module: module}, function(resp){
  location.reload();
  }); }
  });
  
  $('#response').on('click','input[type="image"],input[type="submit"]',function(){
  setTimeout(function(){
  
  $("#response").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
  }, 500)
  });
  
  $("#gateway").on("change",function(){
  var gateway = $(this).val();
  $("#response").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
  $.post("<?php echo base_url();?>invoice/getGatewaylink/<?php echo $invoice->id?>/<?php echo $invoice->code;?>", {gateway: gateway}, function(resp){
  
  var response = $.parseJSON(resp);
  console.log(response);
  if(response.gateway === 'paystack') {
    if(response.htmldata.status === 'success') {
      window.location.href = response.htmldata.message;
    }
  } else {
      if(response.iscreditcard == "1"){
        $(".creditcardform").fadeIn("slow");
        $("#creditcardgateway").val(response.gateway);
        $("#response").html("");
        }else{
        $(".creditcardform").hide();
        $("#response").html(response.htmldata);
        }
  }
  });
  })
  });
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
  
  function loadPaymethodData(){
  var gateway = $("#gateway").val();
  var invoiceStatus = "<?php echo $invoice->status; ?>";
  
  if(invoiceStatus == "unpaid"){
  if(gateway != ""){
  $.post("<?php echo base_url();?>invoice/getGatewaylink/<?php echo $invoice->id?>/<?php echo $invoice->code;?>", {gateway: gateway}, function(resp){
  var response = $.parseJSON(resp);
  console.log(response);
  if(response.iscreditcard == "1"){
  $(".creditcardform").fadeIn("slow");
  $("#creditcardgateway").val(response.gateway);
  $("#response").html("");
  }else{
  $(".creditcardform").hide();
  $("#response").html(response.htmldata);
  }
  });
  }
  }
  }
</script>
<script src="<?php echo base_url(); ?>themes/default/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>themes/default/assets/js/scripts.js"></script>