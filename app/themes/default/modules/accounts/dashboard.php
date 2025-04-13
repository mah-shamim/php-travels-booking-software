<body onload=display_ct();>
<!-- ================================
       START DASHBOARD NAV
================================= -->
<?php require "sidebar.php"?>

<!-- ================================
    START DASHBOARD AREA
================================= -->
<section class="dashboard-area">
    <div class="dashboard-content-wrap">
        <?php require "headbar.php"?>
        <div class="dashboard-main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 responsive-column--m">
                        <div class="form-box">
                            <div class="form-title-wrap">
                                <h3 class="title"><?=T::your_location?></h3>
                            </div>
                            <div class="form-content">
                                <?php $log[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']))?>
                                <iframe src="https://maps.google.com/maps?q=<?=$log[0]['geoplugin_latitude']?>,<?=$log[0]['geoplugin_longitude']?>&z=15&output=embed" width="100%" height="270" frameborder="0" style="border:0"></iframe>
                               <p><strong><?=T::your_ip_address?></strong> <?=$_SERVER['REMOTE_ADDR']?></p>
                            </div>
                        </div><!-- end form-box -->
                    </div><!-- end col-lg-6 -->
                    <div class="col-lg-6 responsive-column--m">
                        <div class="form-box dashboard-card">
                            <div class="form-title-wrap">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="title"><?=T::recentsearches?></h3>
                                    <button type="button" class="icon-element mark-as-read-btn ml-auto mr-0">
                                        <i class="la la-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-content p-0">
                                <div class="list-group drop-reveal-list">
                                    <?php
                                    if (isset($_SESSION['SEARCHES'])) {
                                    krsort($_SESSION['SEARCHES']);
                                    foreach ($_SESSION['SEARCHES'] as $index => $SEARCHES) { // if ( $index < 50 )
                                    {
                                    $urlm = 0;
                                    $urlc = 1;
                                    $urlb = 2;
                                    }
                                    ?>
                                    <a href="<?=$SEARCHES->$urlb?>" class="list-group-item list-group-item-action border-top-0" target="_blank">
                                        <div class="msg-body d-flex align-items-center">
                                            <div class="icon-element flex-shrink-0 mr-3 ml-0"><i class=""><?=$index+1?></i></div>
                                            <div class="msg-content w-100">
                                                <h3 class="title pb-1 px-2" style="text-transform:uppercase"><?=$SEARCHES->$urlm?> - <?=$SEARCHES->$urlc?></h3>
                                                <p class="msg-text px-2"><?=$SEARCHES->$urlb?></p>
                                            </div>
                                            <span class="icon-element mark-as-read-btn flex-shrink-0 ml-auto mr-0">
                                                <i class="la la-check-square"></i>
                                            </span>
                                        </div><!-- end msg-body -->
                                    </a>
                                    <?php } } else {} ?>
                                </div>
                            </div>
                        </div><!-- end form-box -->
                    </div><!-- end col-lg-6 -->
                     
                </div><!-- end row -->
                <div class="border-top mt-4"></div>
            </div><!-- end container-fluid -->
        </div><!-- end dashboard-main-content -->
    </div><!-- end dashboard-content-wrap -->
</section><!-- end dashboard-area -->
<!-- ================================
    END DASHBOARD AREA
================================= -->
</body>