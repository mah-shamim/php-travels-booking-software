<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bread-bg-7">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="search-result-content">
                        <div class="section-heading">
                         <h2 class="sec__titles text-white"><?=trans('0660');?></h2>
                        </div>
                        <div class="search-fields-container margin-top-30px">
                         <div class="contact-form-action">
                             <?php echo searchForm($appModule,$searchFormhotels); ?>
                    </div><!-- end search-result-content -->
                    </div><!-- end search-result-content -->
                    </div><!-- end search-result-content -->
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
    <div class="bread-svg-box">
        <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><polygon points="100 0 50 10 0 0 0 10 100 10"></polygon></svg>
    </div><!-- end bread-svg -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->
<?php include $themeurl. 'views/modules/hotels/standard/featured.php';?>