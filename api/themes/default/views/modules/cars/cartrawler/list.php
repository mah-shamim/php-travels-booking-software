<br><br>
<?php if(empty($_GET)){ ?>
<div class="bgdiv" style="margin-top:-40px;">
  <div class="overlay-block"></div>
</div>
<div class="container">
<div class="col-md-5" id="frmModal" tabindex="1" role="dialog" aria-labelledby="frmModalLabel" aria-hidden="true">
<div class="bgcar">
  <?php include $themeurl.'views/modules/cartrawler/main_search.php'; ?>
  <div class="clearfix"></div>
</div>
</div>
<div class="col-md-5">
    <br>
    <img src="<?php echo $theme_url; ?>assets/img/rentals.jpg" class="img-responsive" alt="" />
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<style>
.search-button { padding: 0px; background: transparent; height: 0px; border: 0px solid transparent; }
.search-button { width: 100%; }
.xxl { width: 100%; }
.chkin { width: 50%; }

   .bgcar {
    background: orange;
    color: white;
    margin-top: -186px;
    padding: 18px;
    border: 2px solid #ff7e00;
   }

   .overlay-block {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-color: inherit;
    }

   .bgdiv {
    position: relative;
    box-sizing: border-box;
    padding-top: 160px !important;
    padding-bottom: 102px !important;
    background: rgba(51,51,50,0.9) url('<?php echo $theme_url; ?>assets/img/carbg.jpg') !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    }

  .autosuggest {
  margin-left: -1px;
  position: absolute;
  z-index: 10003;
  cursor: pointer;
  color: rgba(99, 99, 99, 0.83);
  width: 92.5%;
  margin-top: -1px;
  padding-right: 0px !important;
  padding-left: 0px !important;
  border-radius: 0px 0px 4px 4px;
  }
  .autosuggest ul {
  list-style: none;
  padding: 0;
  margin-bottom: 0;
  }
  .autosuggest ul li {
  padding: 5px 10px;
  border-bottom: 1px solid;
  }
  .autosuggest ul li:hover {
  color: #fff;
  background: #3875d7;
  }
  .autosuggest ul li:last-child {
  border-bottom: none;
  }
  .highlight {
  background: white;
  color: #595959;
  }
</style>
<div class="container">
  <div id="abe_ABE">
    <noscript>YOUR BROWSER DOES NOT SUPPORT JAVASCRIPT</noscript>
  </div>
  <script type="text/javascript">
    var CT = {
      ABE: {
        Settings: {
          clientID: '<?php echo $cartrawlerid;?>',
          customStyles: [
          {
          style_name: "theme.css",
          style_path: "./"
          }]
        }
      }
    };
  </script>
  <script>
    (function() {
    //  CT.ABE.Settings.version = '4.0';
      var cts = document.createElement('script'); cts.type = 'text/javascript'; cts.async = true;
      cts.src = '<?php echo $url; ?>?' + new Date().getTime();
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(cts, s);
    })();
  </script>
  <br><br><br>
</div>
<style>
 body{background:#f0f3f7!important}
.ct-box .ct-box-title{border-bottom:2px solid #dcdcdc;padding:13px 2.25% 8px;background-color:rgba(228,228,228,0.45)}
#ct_tmpl_layout_step_1{display:none}
#ct_box_DriversDetails{margin-top:6px}
#ct_step2 aside#ct_s2_side_panel #ct_filters_desktop .ct_filter_header{background-color:rgba(228,228,228,0.56)}
.ct-box .ct-box-title .ct-toggle{position:absolute;right:18px;top:15px;cursor:pointer;font-size:20px;color:rgba(85,85,85,0.62)}
.ct-btn.ct-icon-left span:before{left:-1.33333px;font-size:13px}
.ct-box{margin-bottom:1.25%!important}
i.ct-icon-cancel-big:before{font-size:15px}
#ct_step2 aside#ct_s2_side_panel div#ct_booking_summary_form i#ct_toggle_booking_summary_form,#ct_step3 aside#ct_s3_side_panel div#ct_booking_summary_form i#ct_toggle_booking_summary_form,#ct_step4 aside#ct_s4_side_panel div#ct_booking_summary_form i#ct_toggle_booking_summary_form{line-height:21px}
#ct_booking_summary{padding:10px}
h2 span,h3 span,h4 span,h5 span,h6 span{color:#808080;font-size:15px}
.ct-font-xlarge{font-size:14px;font-weight:600}
.ct-ui-base h3{margin-top:5px}
.ct-hybrid-grid .ct-grid .ct-grid-unit-4-14{margin-top:6px}
.ct-grid .ct-box-content{margin-top:5px}
#ct_step2 section#ct_s2_body_panel div.ct-car .ct-list-shrinker li span{width:90%}
#ct_step2 section#ct_s2_body_panel #ct_cars #ct-legend-wrapper .ct_avail_sort_container{margin-top:5px}
.ct-hybrid-grid .ct-grid .ct-grid-unit-14-14{padding:10px}
#ct_step2 aside#ct_s2_side_panel #ct_filters_desktop ul ul.ct_filters_checkbox_container li:hover,#ct_step2 aside#ct_s2_side_panel #ct_filters_desktop ul ul.ct_filters_checkbox_container li:active{background-color:rgba(212,211,209,0)}
.ct-form-field .ct-input{display:block;width:100%;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:2px}
.ct-form-field .ct-input:hover{border-radius:2!important;box-shadow:none;border-color:#d2d6de}
.ui-datepicker .ui-datepicker-close{float:right;margin:0 7px 9px;background:#3d51b4!important;border:0;cursor:pointer;-webkit-border-radius:0;-moz-border-radius:0;-ms-border-radius:0;-o-border-radius:0;border-radius:0}
.ui-datepicker .ui-datepicker-header{background-color:#3d51b4!important}
.ct-palette-s-color{color:#3d51b4!important}
.ct-box{background:white;width:100%;opacity:1;float:left;position:relative;margin-bottom:10.25%;border:!important -webkit-border-radius:0;-ms-border-radius:0;-o-border-radius:0;border-radius:0;-webkit-box-shadow:none!important;-moz-box-shadow:none!important;box-shadow:none!important}
.ct-box{background:white;width:100%;opacity:1;float:left;position:relative;margin-bottom:10.25%;border:!important -webkit-border-radius:0;-ms-border-radius:4px;-o-border-radius:4px;border-radius:4px;-webkit-box-shadow:3px 3px rgba(228,228,228,0)!important;-moz-box-shadow:none!important;box-shadow:3px 3px rgba(228,228,228,0)!important}
.ct-btn-s{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:normal;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1px solid transparent;border-radius:2px;box-shadow:none!important;background-color:#3d51b4;border-color:#24557f}
.ct-btn-s:hover{background-color:#35469c;border-color:#193a58}
.ct-box{width:100%;opacity:1;float:left;position:relative;margin-bottom:10.25%;border:!important -webkit-border-radius:0;*/-moz-border-radius:0;-ms-border-radius:0;-o-border-radius:0;border-radius:0;-webkit-box-shadow:3px 3px #e4e4e4!important;-moz-box-shadow:none!important;box-shadow:3px 3px #e4e4e4!important}
.modal-backdrop{background-color:transparent!important}
.modal-open .navbar-fixed-top,.modal-open .navbar-fixed-bottom{margin-right:0}
#ct_s2_body_panel{padding-top:0px !important}
#ct_s3_body_panel{padding-top:0px !important}

</style>
<div class="clearfix"></div>
<!--<script type="text/javascript">
    $(function(){
    <?php if(empty($_GET)){ ?>
    $('#frmModal').modal('show');
    <?php } ?>
    })
</script>-->
