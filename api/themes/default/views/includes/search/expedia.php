<!-- EAN search form -->
   <form  class="container" action="<?php echo $baseUrl;?>search" method="GET" role="search">
    <div class="col-md-3 col-lg-4 col-sm-12 go-right">
      <div class="form-group">
        <div class="clearfix"></div>
        <label class="control-label go-right"><i class="icon-location-6"></i><?php echo trans('012');?></label>
        <input id="HotelsPlacesEan" name="city"  type="text" class="form-control RTL search-location" placeholder="<?php echo trans('026');?>" value="<?php if(!empty($_GET['city'])){ echo $_GET['city']; }else{ echo $selectedCity; } ?>" required >
      </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-6 go-right">
      <div class="form-group">
        <div class="clearfix"></div>
        <label class="control-label go-right size13"><i class="icon-calendar-7"></i> <?php echo trans('07');?></label>
        <input type="text" placeholder=" <?php echo trans('07');?>" name="checkIn" class="dpean1 form-control" value="<?php echo $checkin; ?>" required >
      </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-6 go-right">
      <div class="form-group">
        <div class="clearfix"></div>
        <label class="control-label go-right size13"><i class="icon-calendar-7"></i> <?php echo trans('09');?></label>
        <input type="text" class="form-control dpean2" placeholder=" <?php echo trans('09');?>" name="checkOut" value="<?php echo $checkout; ?>" required >
      </div>
    </div>
    <div class="col-md-2 col-lg-1 col-sm-6 col-xs-6 go-right">
      <div class="form-group">
        <div class="clearfix"></div>
        <label class="control-label go-right size13"><i class="icon-user-7"></i> <?php echo trans('010');?></label>
        <select class="RTL form-control" placeholder=" <?php echo trans('');?>"  name="adults">
          <?php for($i = 1; $i <= 9; $i++){ if(empty($adults)){ $adults = 2; } ?>
          <option value="<?php echo $i; ?>" <?php if($i == $adults){ echo "selected"; } ?> ><?php echo $i; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="hidden-md col-lg-1 col-sm-6 col-xs-6 go-right">
      <div class="form-group">
        <div class="clearfix"></div>
        <label class="control-label go-right size13"><i class="icon-user-7"></i> <?php echo trans('011');?></label>
        <select  class="form-control childcount" placeholder=" <?php echo trans('011');?> " name="child" id="child">
          <option value="">0</option>
          <?php for($j = 1; $j <= 3; $j++ ){ ?>
          <option value="<?php echo $j; ?>" <?php if($j == $child){ echo "selected"; } ?> > <?php echo $j; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="visible-sm visible-xs">
      <div class="clearfix"></div>
    </div>
    <div class="col-md-3 col-lg-2 col-xs-12 col-sm-12 go-right">
      <div class="form-group">
        <div class="clearfix"></div>
        <input name="search" type="hidden" value="1">
        <input type="hidden" name="childages" id="childages" value="<?php echo $childAges; ?>">
        <button style="font-size: 14px;" type="submit" class="btn btn-block btn-action"><?php echo trans('012');?></button>
      </div>
    </div>
    <div class="clearfix"></div>
  </form>
<?php include 'integrations/ean/ages.php'; ?>
    <script>
    $(function() {
       google.maps.event.addDomListener(window,"load",function(){new google.maps.places.Autocomplete(document.getElementById("HotelsPlacesEan"))});
    });
  </script>

<script type="text/javascript">
  var loading = false;//to prevent duplicate
  function loadNewContent() {

      // get the current cache location and key..
      var moreResultsAvailable = $("#moreResultsAvailable").val();
      var cacheKey = $("#cacheKey").val();
      var cacheLocation = $("#cacheLocation").val();
      var cachePaging = $("#cachePaging").val();
      var checkin = $(".dpean1").val();
      var checkout = $(".dpean2").val();
      var agesappend = $("#agesappendurl").val();
      var adultsCount = $("#adultsCount").val();


      $('#loader_new').html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
      var url_to_new_content = '<?php echo base_url(); ?>ean/loadMore';

      $.ajax({
          type: 'POST',
          data: {'moreResultsAvailable': moreResultsAvailable, 'cacheKey': cacheKey, 'cacheLocation': cacheLocation, 'checkin': checkin, 'checkout': checkout,'agesappendurl': agesappend,'adultsCount': adultsCount },
          url: url_to_new_content,
          success: function (data) {

              // document.getElementById('loadNewdata').value = 1;

              if (data != "" && data != "404") {

                  $('#loader_new').html('');
                  loading = false;


                 // $("#latest_record_para").html(data);

                         var newData = data.split("###");

                    $("#latest_record_para").html(newData[0]);

                    $("#New_data_load").append(newData[1]);


              }
              else
              {
                  $('#loader_new').html('');
                  $("#message_noResult").html('');

              }
              //console.log(data);

          }
      });
  }

  //scroll to PAGE's bottom
  var winTop = $(window).scrollTop();
  var docHeight = $(document).height();
  var winHeight = $(window).height();




  $(window).scroll(function () {

      var moreResultsAvailable = $("#moreResultsAvailable").val();
      var foot = $("#footer").offset().top - 500;
      // console.log($(window).scrollTop()+" == "+foot);

      if (moreResultsAvailable != '' && moreResultsAvailable == 1) {

          if ($(window).scrollTop() > foot) {

              if (!loading) {
                  loading = true;
                  loadNewContent();



              }
          }
      }
  });

</script>

<!-- End EAN Search Form -->

<?php }else if($appModule == "offers"){ ?>

<form class="container" action="<?php echo base_url();?>offers/search" method="GET">
      <div class="col-md-3 col-lg-4 col-sm-12 go-right">
         <div class="form-group">
            <div class="clearfix"></div>
            <label class="control-label go-right size13"><i class="icon-location-6"></i> <?php echo trans('0350');?></label>
            <div class="clearfix"></div>
              <input id="" name="searching" type="text" class="RTL form-control form searching" placeholder=" <?php echo trans('0350');?>" value="<?php if(!empty($_GET['searching'])){ echo $_GET['searching']; } ?>">

         </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-6 go-right">
         <div class="form-group">
            <div class="clearfix"></div>
          <label class="control-label go-right size13"><i class="icon-calendar-7"></i> <?php echo trans('0273');?></label>
              <input type="text" placeholder=" <?php echo trans('0273');?> " name="dfrom" class="RTL form-control  dpd1" value="<?php echo $dfrom; ?>" >
            </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-6 go-right">
         <div class="form-group">
            <div class="clearfix"></div>
           <label class="control-label go-right size13"><i class="icon-calendar-7"></i> <?php echo trans('0274');?></label>
              <input type="text" placeholder=" <?php echo trans('0274');?> " name="dto" class="RTL form-control dpd2" value="<?php echo $dto; ?>" >
            </div>
      </div>

      <div class="visible-sm visible-xs"><div class="clearfix"></div></div>
      <div class="col-md-5 col-lg-4 col-xs-12 col-sm-12 go-right">

         <div class="form-group">
            <div class="clearfix"></div>
            <label class="control-label">&nbsp;</label>
            <button type="submit" class="btn btn-block btn-primary"><?php echo trans('012');?></button>
         </div>
      </div>
      <div class="clearfix"></div>
   </form>