<?php 

$url = explode('/', $_GET['url']);
$count = count($url);
if ($count < 4) { header('Location: '.root);  }

$module = $url[0];
$submit = $url[1];
$from_country = $url[2];
$to_country = $url[3];
$date = $url[4];

?>

<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="mb-5" style="background: #000;">
    <div class="breadcrumb-wrap pb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title_list text-center my-2 text-white mt-5" style="text-transform:uppercase">
                                <strong><?=$from_country?></strong> 
                                
                                <svg fill="#fff" width="46" height="46" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"> <rect id="Icons" x="-192" y="-192" width="1280" height="800" style="fill:none;"></rect> <g id="Icons1" serif:id="Icons"> <g id="Strike"> </g> <g id="H1"> </g> <g id="H2"> </g> <g id="H3"> </g> <g id="list-ul"> </g> <g id="hamburger-1"> </g> <g id="hamburger-2"> </g> <g id="list-ol"> </g> <g id="list-task"> </g> <g id="trash"> </g> <g id="vertical-menu"> </g> <g id="horizontal-menu"> </g> <g id="sidebar-2"> </g> <g id="Pen"> </g> <g id="Pen1" serif:id="Pen"> </g> <g id="clock"> </g> <g id="external-link"> </g> <g id="hr"> </g> <g id="info"> </g> <g id="warning"> </g> <g id="plus-circle"> </g> <g id="minus-circle"> </g> <g id="vue"> </g> <g id="cog"> </g> <g id="logo"> </g> <path id="arrow-right" d="M48.337,29.881l-7.414,-7.414l2.832,-2.832l12.247,12.247l-0.001,0.001l0.001,0.001l-12.247,12.246l-2.832,-2.832l7.412,-7.412l-40.335,0l0,-4.005l40.337,0Z"></path> <g id="radio-check"> </g> <g id="eye-slash"> </g> <g id="eye"> </g> <g id="toggle-off"> </g> <g id="shredder"> </g> <g id="spinner--loading--dots-" serif:id="spinner [loading, dots]"> </g> <g id="react"> </g> <g id="check-selected"> </g> <g id="turn-off"> </g> <g id="code-block"> </g> <g id="user"> </g> <g id="coffee-bean"> </g> <g id="coffee-beans"> <g id="coffee-bean1" serif:id="coffee-bean"> </g> </g> <g id="coffee-bean-filled"> </g> <g id="coffee-beans-filled"> <g id="coffee-bean2" serif:id="coffee-bean"> </g> </g> <g id="clipboard"> </g> <g id="clipboard-paste"> </g> <g id="clipboard-copy"> </g> <g id="Layer1"> </g> </g> </svg>
                                
                                <strong><?=$to_country?></strong>
                                <h5 data-wow-duration="0.3s" data-wow-delay="0.6s" class="text-white wow fadeIn sub-title animated animated text-center mt-3"><?=$date?></h5>
                            </h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <div class="breadcrumb-list">
                        <!--<ul class="list-items d-flex justify-content-end">
                            <li><a href="index.html">Home</a></li>
                            <li>Hotel Booking</li>
                        </ul>-->
                    </div><!-- end breadcrumb-list -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
    START BOOKING AREA
================================= -->

<div class="container mb-5">
<div class="card">
<div class="card-header">
<?=T::submissionform?>
  </div>
     
    <!-- form-title-wrap -->
    <div class="form-content p-4">
        <div class="contact-form-action">
            <div class="panel panel-primary">
                <div class="panel-body">
                <form method="post" action="<?=root;?>submit/visa">
                        <input type="hidden" value="<?=$from_country?>" name="from_country">
                        <input type="hidden" value="<?=$to_country?>" name="to_country">
                        <div class="row">
                        <div class="col-lg-6 responsive-column">
                            <div class="mb-3">
                                <div class="form-floating">
                                    <span class="la la-user form-icon"></span>
                                    <input class="form-control" type="text" name="first_name" placeholder="<?=T::first_name?>">
                                    <label class="label-text"><?=T::first_name?></label>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="mb-3">
                                <div class="form-floating">
                                     <input class="form-control" type="text" name="last_name" placeholder="<?=T::last_name?>">
                                     <label class="label-text"><?=T::last_name?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="mb-3">
                                <div class="form-floating">
                                     <input class="form-control" type="text" name="email" placeholder="<?=T::email?>">
                                     <label class="label-text"><?=T::email?></label>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="mb-3">
                                <div class="form-floating">
                                     <input class="form-control" type="text" name="phone" placeholder="<?=T::phone?>">
                                     <label class="label-text"><?=T::phone?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="mb-3">
                                <div class="form-floating">
                                     <input class="form-control dp" type="text" name="date" placeholder="<?=T::date?>" value="<?=$date?>" required="" autocomplete="off">
                                     <label class="label-text"><?=T::date?></label>
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-6 responsive-column">
                            <div class="mb-3">
                                <div class="form-floating">
                                    <textarea style="padding-left:15px" class="form-control" placeholder="<?=T::notes?>" rows="2" name="notes"></textarea>
                                    <label class="label-text"><?=T::notes?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 responsive-column mt-2">
                         <div class="btn-search text-center">
                       <button style="height: 60px;" type="submit" id="submit" class="more_details w-100 btn btn-outline-primary btn-lg" data-style="zoom-in"><i class="mdi mdi-search"></i> <?=T::submit?></button>
                    </div>
                     </div>
                     </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    .select2-dropdown { top: -63px !important; }
</style>