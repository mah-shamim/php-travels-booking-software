<style>
.switch {
position: relative;
display: inline-block;
width: 60px;
height: 34px;
}
.switch input {
opacity: 0;
width: 0;
height: 0;
}
.slider {
position: absolute;
cursor: pointer;
top: 0;
left: 0;
right: 0;
bottom: 0;
background-color: #ccc;
-webkit-transition: .4s;
transition: .4s;
}
.slider:before {
position: absolute;
content: "";
height: 26px;
width: 26px;
left: 4px;
bottom: 4px;
background-color: white;
-webkit-transition: .4s;
transition: .4s;
}
input:checked + .slider {
background-color: #3E50B4;
}
input:focus + .slider {
box-shadow: 0 0 1px #3E50B4;
}
input:checked + .slider:before {
-webkit-transform: translateX(26px);
-ms-transform: translateX(26px);
transform: translateX(26px);
}
/* Rounded sliders */
.slider.round {
border-radius: 34px;
}
.slider.round:before {
border-radius: 50%;
}
</style>
<div class="dashboard-bread dashboard--bread">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="breadcrumb-content">
          <div class="section-heading">
            <h2 class="sec__titles font-size-30 cw"><?php echo trans('023');?></h2>
          </div>
          </div><!-- end breadcrumb-content -->
          </div><!-- end col-lg-6 -->
          <div class="col-lg-6 d-none">
            <div class="breadcrumb-list">
              <ul class="list-items d-flex justify-content-end">
                <li><a href="index.html" class="text-white">Home</a></li>
                <li>Dashboard</li>
                <li>My Booking</li>
              </ul>
              </div><!-- end breadcrumb-list -->
              </div><!-- end col-lg-6 -->
              </div><!-- end row -->
            </div>
          </div>
          <!-- end dashboard-bread -->
          <!-- CONTENT -->
          <div class="dashboard-main-content">
            <div class="clearfix"></div>
            <div class="container-fluid">
              <!-- CONTENT -->
              <div class="row">
                <!-- LEFT MENU -->
                <div class="col-lg-12">
                  <div class="form-box">
                    <div class="clearfix"></div>
                    
                    <div class="form-title-wrap">
                      <div class="d-flex align-items-center justify-content-between">
                        <div>
                          <h3 class="title"><?php echo trans('023');?> Results</h3>
                          <p class="font-size-14 d-none">Showing 1 to 7 of 17 entries</p>
                        </div>
                        <span class="d-none">Total Bookings <strong class="color-text">(17)</strong></span>
                      </div>
                    </div>
                    <div class="form-content">
                      <div class="go-right">
                        <h4 class="float-none"><?php echo trans('024');?></h4>
                        <strong style="display: inline-block;transform: translate(-6px,6px);">NO</strong>
                        <label class="switch float-none">
                          <input type="checkbox" class="newsletter" value="<?php echo $profile[0]->accounts_email;?>" <?php if($is_subscribed){echo "checked";}?>>
                          <span class="slider round"></span>
                        </label>
                        <strong style="display: inline-block;transform: translate(6px,6px);">YES</strong>
                      </div>
                      <div class="clear"></div>
                    </div>
                    
                  </div>
                  <!-- END OF TAB 1 -->
                  <!-- End of Tab panes from left menu -->
                </div>
                <!-- END OF RIGHT CPNTENT -->
                <div class="clearfix"></div>
              </div>
              
              <!-- END CONTENT -->
            </div>
          </div>