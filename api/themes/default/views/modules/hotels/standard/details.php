
<div class="main-wrapper scrollspy-action">
<div class="page-wrapper page-detail bg-light">
  <div class="detail-header">
    <div class="container">
      <div class="d-flex flex-column flex-lg-row sb">
        <div class="o2">
          <h2 id="detail-content-sticky-nav-00" class="name"></h2>

          <div class="clear"></div>
          <p class="location">
            <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
            <i class="material-icons text-info small">place</i>
            <?php } ?>

            <?php if(!empty($module->mapAddress)){ ?> <small class="hidden-xs">, </small>
            <?php } ?>
            <a href="#detail-content-sticky-nav-03" class="anchor">
            <?php echo trans('0143');?>
            </a>
          </p>
        </div>


      </div>
    </div>
  </div>





       
