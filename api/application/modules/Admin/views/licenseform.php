<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png';?> ">
    <title><?php echo $pagetitle?></title>
    <!--PHPTravels Bootstrap core -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <!--PHPTravels Bootstrap core -->
    <!--PHPTravels JQuery -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js"></script>
    <!--PHPTravels JQuery -->
  </head>
  <body>
    <div class="container">
      <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default" style="margin-top:200px">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $pagetitle?></h3>
            </div>
            <div class="adminimg"><?php echo $this->session->flashdata('invalid'); ?></div>
            <div class="panel-body">
              <form class="form-signin" method="POST" action="<?php echo base_url();?>admin/license" role="form" >
                <fieldset>
                  <div class="form-group">
                    <input class="form-control" placeholder="License Key" name="licensekey" type="text" required>
                  </div>
                  <input type="hidden" name="check" value="1" />
                  <input class="btn btn-success btn-block" type="submit" value="Submit">
                </fieldset>
              </form>
              <p class="text-center">How to obtain <a href="https://phptravels.com/documentation/license/" target="_blank"><strong>License</strong></a></p>
            </div>
          </div>
          <p class="text-center"> Powered by  <a target="_blank" style="color: #1C1C1C" href="http://phptravels.com"><b>PHPTRAVELS</b></a> <a href="http://phptravels.com/change-log/#<?php echo PT_VERSION; ?>"></a><?php echo PT_VERSION; ?></p>
        </div>
      </div>
    </div>
  </body>
</html>
<style>
  body {
  background-color: #168eda !important;
  background: radial-gradient(circle,#94d2f8,#168eda) !important;
  background: radial-gradient(circle,#94d2f8,#3a92c8) !important;
  overflow-y: scroll;
  }
  .shadow {
  -webkit-box-shadow: 0 2px 10px rgba(0,0,0,0.24),0 0 0 3px #fff inset;
  -moz-box-shadow: 0 2px 10px rgba(0,0,0,0.24),0 0 0 3px #fff inset;
  box-shadow: 0 2px 10px rgba(0,0,0,0.24),0 0 0 3px #fff inset;
  border-radius: 5px;
  background-color: #fff;
  border: 1px solid #c4c5c9;
  max-width: 350px;
  margin: 0 auto;
  margin-bottom: 15px;
  }
  #rotatingImg { display: none; }
</style>
<!-- Bootstrap Core -->
<script src="<?php echo $base_url; ?>assets/js/bootstrap.min.js"></script>