<div class="col-md-5 go-right">
<h3 class="go-text-right strong" style="margin-top:0px"></h3>

<div class="panel panel-default">
  <div class="panel-heading"><?php echo trans('0439');?></div>
  <div class="panel-body">

<div class="box_style_1 expose">
  <h3 class="inner"></h3>
  <?php if(!empty($offer->email)){ ?>
  <form action="" method="POST">
    <fieldset>
      <?php if(!empty($success)){ ?>
      <div class="alert alert-success successMsg"><?php echo trans('0479');?></div>
      <?php } ?>
      <div class="col-md-6 go-right">
        <label class="go-right"><?php echo trans('0350');?></label>
        <input class="form-control" placeholder="<?php echo trans('0350');?>" type="text" name="name" value="" required>
      </div>
      <div class="col-md-6 go-left">
        <label class="go-right"><?php echo trans('092');?></label>
        <input class="form-control" placeholder="<?php echo trans('092');?>" type="text" name="phone" value="" required><br>
      </div>
       <div class="clearfix"></div> 
      <div class="col-md-12">
        <label class="go-right"><?php echo trans('0262');?></label>
        <textarea class="form-control" placeholder="<?php echo trans('0262');?>" name="message" rows="4" cols="25" required></textarea><br>

     </div>
     <div class="clearfix"></div>
      <div class="col-md-12">
        <input type="hidden" name="toemail" value="<?php echo $offer->email;?>">
        <input type="hidden" name="sendmsg" value="1">
        <input class="btn btn-success btn-success btn-block btn-lg" type="submit" name="" value="<?php echo trans('0439');?>">
      </div>
      <br>
      <!-- END CONTACT FORM -->
    </fieldset>
  </form>
  <?php } ?>
</div>
</div>
</div>
</div>
<?php if(!$offer->offerForever){ ?>
<div class="box_style_4">
  <i class="fa fa-clock-o go-right"></i>
  <h4><?php echo trans('0269');?></h4>
  <p href="#" class="phone"><span class="wow fadeInLeft animated" id="countdown"></span></p>
  <!--<small>Monday to Friday 9.00am - 7.30pm</small>-->
</div>
<?php } ?>
<div class="clearfix"></div>

<!-- /.modal-content -->
<script type="text/javascript">
  // set the date we're counting down to
  var target_date = new Date('<?php echo $offer->fullExpiryDate; ?>').getTime();

  // variables for time units
  var days, hours, minutes, seconds;

  // get tag element
  var countdown = document.getElementById('countdown');

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

  $(function(){
      setTimeout(function(){
  $(".successMsg").fadeOut("slow");
  }, 7000);

  });

</script>