<?php
use Curl\Curl;
$req = new Curl();
$req->get(api_url.'api/login/dashboard?appKey='.api_key.'&user_id='.$_SESSION['user_id']);
$res = json_decode($req->response);
$dashboard_details = $res->response;
?>

<div class="dashboard-bread">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="breadcrumb-content">
                    <div class="section-heading">
                        <h2 class="sec__title font-size-30 text-white"><?=T::hi?>, <span style="text-transform:capitalize"><?=$_SESSION['user_name']?></span> <?=T::welcomeback?></h2>
                    </div>
                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6">
                <div class="breadcrumb-list text-right">
                    <p style="font-weight:bold;color:#fff" id="ct"></p>
                </div><!-- end breadcrumb-list -->
            </div><!-- end col-lg-6 -->
        </div><!-- end row -->
        <div class="row mt-4">
            <div class="col-lg-3 responsive-column-m">
                <div class="icon-box icon-layout-2 dashboard-icon-box">
                    <div class="d-flex">
                        <div class="info-icon icon-element flex-shrink-0">
                           <i class="la la-wallet"></i>
                        </div><!-- end info-icon-->
                        <div class="info-content">
                            <p class="info__desc"><?=T::walletbalance?></p>
                            <h4 class="info__title"><?=$dashboard_details->currency.' '.$dashboard_details->balance?></h4>
                        </div><!-- end info-content -->
                    </div>
                </div>
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-m">
                <div class="icon-box icon-layout-2 dashboard-icon-box">
                    <div class="d-flex">
                        <div class="info-icon icon-element bg-2 flex-shrink-0">
                           <i class="la la-shopping-cart"></i>
                        </div><!-- end info-icon-->
                        <div class="info-content">
                            <p class="info__desc"><?=T::totalbookings?></p>
                            <h4 class="info__title"><?=$dashboard_details->totel_booking?></h4>
                        </div><!-- end info-content -->
                    </div>
                </div>
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-m">
                <div class="icon-box icon-layout-2 dashboard-icon-box">
                    <div class="d-flex">
                        <div class="info-icon icon-element bg-3 flex-shrink-0">
                           <i class="la la-clock"></i>
                        </div><!-- end info-icon-->
                        <div class="info-content">
                            <p class="info__desc"><?=T::pendinginvoices?></p>
                            <h4 class="info__title"><?=$dashboard_details->pending_nvoices?></h4>
                        </div><!-- end info-content -->
                    </div>
                </div>
            </div><!-- end col-lg-3 -->
            <div class="col-lg-3 responsive-column-m">
                <div class="icon-box icon-layout-2 dashboard-icon-box">
                    <div class="d-flex">
                        <div class="info-icon icon-element bg-4 flex-shrink-0">
                           <i class="la la-star"></i>
                        </div><!-- end info-icon-->
                        <div class="info-content">
                            <p class="info__desc"><?=T::reviews?></p>
                            <h4 class="info__title">0</h4>
                        </div><!-- end info-content -->
                    </div>
                </div>
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div>
</div><!-- end dashboard-bread -->