 <!-- PHPtravels Reports Starting -->



<script type="text/javascript">

  $(function(){

  $("#canvasbar").hide();

  $('#filterrep').click(function(){ var from = $(".dprfrom").val(); var to = $(".dprto").val(); var type = $(".type").val();

  if($.trim(from) != "" && $.trim(to) != ""){

  $.post("<?php echo base_url().$this->uri->segment(1);?>/reports/from_to_report", {from: from, to: to, type: type }, function(theResponse){

  $('#Filter').modal('show');$("#filter_result").html(type);$("#reportdetails").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");$("#reportdetails").html(theResponse);})

  }else{

  $.alert.open('info', 'Please select Dates.');

  }

  ;});

  $(".chartview").on("change",function(){

  var type = $(this).val();

  if(type == "line"){

  $("#canvasbar").fadeOut("slow");

  $("#canvasline").fadeIn("slow");

  }else if(type = "bar"){

  $("#canvasline").fadeOut("slow");

  $("#canvasbar").fadeIn("slow");

  }

  });

  });

</script>

<!-- ------------------------ PHPtravels Charts ---------------------------------------------- -->

<script src="<?php echo base_url(); ?>assets/include/charts/Chart.min.js"></script>

<!-- ------------------------ PHPtravels Charts ---------------------------------------------- -->

<div class="<?php echo body;?>">

<div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><?php if(!empty($selmodule)){ echo ucfirst($selmodule); }else{ echo "Overall"; };?> Reports</span>
      <div class="pull-right">
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>


    <div class="panel-body">







    <div class="well">

      <div class="row">

        <div class="col-sm-4">

          <div class="text-center">

            <h1><strong><?php echo $app_settings[0]->currency_sign.$thisday;?></strong></h1>

            <h5>Today</h5>

          </div>

        </div>

        <div class="col-sm-4">

          <div class="text-center">

            <h1><strong><?php echo $app_settings[0]->currency_sign.$thismonth;?></strong></h1>

            <h5>This Month</h5>

          </div>

        </div>

        <div class="col-sm-4">

          <div class="text-center">

            <h1><strong><?php echo $app_settings[0]->currency_sign.$thisyear;?></strong></h1>

            <h5>This Year</h5>

          </div>

        </div>

      </div>

    </div>
     <div class="panel panel-default">

      <div class="panel-header">

        <div class="navbar-header">

          <a class="navbar-brand">Filter Earnings By Module</a>

        </div>

        <center>

          <div class="navbar-collapse collapse" id="navbar-main">

            <div class="navbar-form navbar-right" role="search">
                <form action="" method="POST">
              <div class="form-group">

                <select class="form-control type" name="module">
               <option value="">All</option>
                <?php
                      foreach($modules as $mod):
                        $istrue = $chklib->is_mod_available_enabled($mod);
                         $isintegration = $chklib->is_integration($mod);
                         $ispermitted = pt_permissions($mod,$userloggedin);

                       if($ispermitted && $istrue && !$isintegration && !in_array($mod,$chklib->notinclude)){
                      ?>
                    <option value="<?php echo $mod;?>" <?php if(@$selmodule == $mod){ echo "selected"; } ?> ><?php echo ucfirst($mod);?></option>
                    <?php } endforeach; ?>

                </select>

              </div>

               <input type="hidden" name="filtermod" value="1" />

              <button class="btn btn-primary">Filter</button>
              </form>
            </div>

          </div>

        </center>

      </div>


    </div>
    <!---------Fliter by dates---------------------->
    <div class="panel panel-default">

      <div class="panel-header">

        <div class="navbar-header">

          <a class="navbar-brand">Filter Earnings By Date</a>

        </div>

        <center>

          <div class="navbar-collapse collapse" id="navbar-main">

            <div class="navbar-form navbar-right" role="search">

              <div class="form-group">

                <input type="text" class="form-control dprfrom" placeholder="From">

              </div>

              <div class="form-group">

                <input type="text" class="form-control dprto" placeholder="To">

              </div>



              <button id="filterrep" class="btn btn-primary">Filter</button>

            </div>

          </div>

        </center>

      </div>

      <div class="modal fade" id="Filter" tabindex="" role="dialog" aria-labelledby="Filter" aria-hidden="true">

        <div class="modal-dialog modal-sm">

          <div class="modal-content">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

              <h4 class="modal-title"><i class="fa fa-calendar-o"></i> <span id="filter_result" style="text-transform: capitalize;"></span> Reports Filter</h4>

            </div>

            <div class="modal-body">

              <div class="row">

                <div class="text-center" id="reportdetails">

                </div>

              </div>

            </div>

            <div class="modal-footer">

              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>

          </div>

        </div>

      </div>

    </div>

    <div class="panel-body">

      <div class="form-group">

        <label class="col-md-2 control-label">View Chart</label>

        <div class="col-md-3">

          <select name="title" data-placeholder="Select" class="selectpicker form-control chartview" tabindex="1">

            <option value="line" >Line Chart</option>

            <option value="bar" >Bar Chart</option>

          </select>

        </div>

      </div>

      <canvas id="canvasbar" height="200" width="1000"></canvas>

      <canvas id="canvasline" height="200" width="1000"></canvas>

    </div>

  </div>

</div>
 </div>

<script>

  var ChartData = {

  	labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],

  	datasets : [

  	   	{

  			fillColor : "rgba(151,187,205,0.5)",

  			strokeColor : "rgba(151,187,205,1)",

  			data : [<?php foreach($monthly as $mon){ echo $mon.",";} ?>]

  		}

  	]



  }



    var myBar = new Chart(document.getElementById("canvasbar").getContext("2d")).Bar(ChartData);

  var myLine = new Chart(document.getElementById("canvasline").getContext("2d")).Line(ChartData);



</script>

<!-- PHPtravels reports ending -->