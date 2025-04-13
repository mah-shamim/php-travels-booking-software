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
                                    <div class="d-block">
                                        <h3 class="title"><?=T::funds_added?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="form-content text-center p-5">
                            <div class="d-flex justify-content-center">
                            <svg viewBox="0 0 100 100" class="animate">
                            <filter id="dropshadow" height="100%">
                            <feGaussianBlur in="SourceAlpha" stdDeviation="3" result="blur"/>
                            <feFlood flood-color="rgba(76, 175, 80, 1)" flood-opacity="0.5" result="color"/>
                            <feComposite in="color" in2="blur" operator="in" result="blur"/>
                            <feMerge>
                            <feMergeNode/>
                            <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                            </filter>
                            <circle cx="50" cy="50" r="46.5" fill="none" stroke="rgba(76, 175, 80, 0.5)" stroke-width="5"/>
                            <path d="M67,93 A46.5,46.5 0,1,0 7,32 L43,67 L88,19" fill="none" stroke="rgba(76, 175, 80, 1)" stroke-width="5" stroke-linecap="round" stroke-dasharray="80 1000" stroke-dashoffset="-220"  style="filter:url(#dropshadow)"/>
                            </svg>
                            </div>

                            <p class="my-2"><strong><?=T::payment_successfull?></strong></p>
                            <p><?=T::your_funds_has_been_added?></p>

                            </div>
                        </div><!-- end form-box -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
                <div class="border-top mt-5"></div>
            </div>
        </div>
    </div>
</section>
<style>
.cta-area,.gateway_pay-later,.gateway_wallet-balance{display:none}

svg {
    width : 100px;
    height: 100px;
    position: unset;
    top: 150px;
    left: 50%;
}

svg.animate path {
    animation: dash 0.75s linear both;
    animation-delay: 0.5s;
}

@keyframes dash {
    0% { stroke-dashoffset: 210; }
    75% { stroke-dashoffset: -220; }
    100% { stroke-dashoffset: -205; }
}

</style>