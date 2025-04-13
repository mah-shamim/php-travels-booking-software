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
                    <div class="col-lg-12">
                        <div class="form-box">
                            <div class="form-title-wrap">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="title"><?=T::mybookings?></h3>
                                    </div>
                                    <?php if (empty($booking_data->booking_empty)) {?>
                                        <span><?=T::totalbookings?> <strong class="color-text">( <?=count($booking_data)?> )</strong></span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-content">
                                <div class="table-form table-responsive able-striped" style="text-transform:capitalize">
                                    <?php if (empty($booking_data->booking_empty)) {?>
                                    <table class="table  text-center">
                                        <thead>
                                    <tr>
                                        <th scope="col"><?=T::type?></th>
                                        <!--<th scope="col"><?=T::title?></th>-->
                                        <th scope="col"><?=T::dates?></th>
                                        <th scope="col"><?=T::price?></th>
                                        <th scope="col"><?=T::status?></th>
                                        <th scope="col text-center"><?=T::action?></th>
                                    </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($booking_data as $key) {  ?>
                                            <tr>
                                            <th scope="row">

                                            <?php
                                            if (strtolower($key->module) == "flights") { echo '<i class="la la-plane mr-1 font-size-18"></i>' ; }
                                            if (strtolower($key->module)  == "hotels") { echo '<i class="la la-hotel mr-1 font-size-18"></i>' ; }
                                            if (strtolower($key->module)  == "tours") { echo '<i class="la la-briefcase mr-1 font-size-18"></i>' ; }
                                            if (strtolower($key->module)  == "cars") { echo '<i class="la la-car mr-1 font-size-18"></i>' ; }
                                            if (strtolower($key->module)  == "visa") { echo '<i class="la la-passport mr-1 font-size-18"></i>' ; }
                                            ?>

                                            <?=$key->module?></th>

                                            
                                            <td><?=$key->booking_date?></td>
                                            <?php // echo "<pre>"; print_r($key); exit;  ?>
                                            <td><?=$key->booking_curr_code.' '.$key->total_price?></td>
                                            <td> <?=$key->booking_status?> </td>
                                            <td>
                                                <div class="table-content">
                                                   <a target="_blank" href="<?=root.$key->module.'/booking/invoice/'.$key->booking_ref_no.'/'.$key->booking_id?>" target"_blank" class="theme-btn theme-btn-small"><i class="la la-eye"></i> <?=T::viewvouchar?></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                  <?php  }else{echo T::noresultsfound;}?>
                                </div>
                            </div>
                        </div><!-- end form-box -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
                <!--<div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link page-link-nav" href="#" aria-label="Previous">
                                        <span aria-hidden="true"><i class="la la-angle-left"></i></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link page-link-nav" href="#">1</a></li>
                                <li class="page-item active">
                                    <a class="page-link page-link-nav" href="#">2 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link page-link-nav" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link page-link-nav" href="#" aria-label="Next">
                                        <span aria-hidden="true"><i class="la la-angle-right"></i></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>-->
                <div class="border-top mt-5"></div>
            </div>
        </div>
    </div>
</section>
<style>
.cta-area{display:none}
tr:hover{background-color: rgba(128,137,150,0.1);}
</style>