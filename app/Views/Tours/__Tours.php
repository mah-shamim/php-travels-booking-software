<!-- 
<script src="<?= root ?>assets/js/mixitup.min.js"></script>
<script src="<?= root ?>assets/js/mixitup-pagination.min.js"></script>
<script src="<?= root ?>assets/js/mixitup-multifilter.min.js"></script> 
-->
<script src="<?=root?>assets/js/plugins/ion.rangeSlider.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<div class="py-4 mb-0">
   <div class="container">
      <div class="">
         <?php require_once "./App/Views/Tours/Search.php"; ?>
      </div>
   </div>
</div>
<?php
if (isset($meta['data']->response)) { $TOURS_DATA = $meta['data']->response; }
if (empty($TOURS_DATA)) { 
?>
<!-- NO RESULTS PAGE -->
<?php include "App/Views/No_results.php" ?>
<?php } else { ?>
<div class="position-relative container-fluid bg-light pt-4 p-0">
<div class="container">
   <div class="row g-3">
      <!-- left side  -->
      <div class="col-lg-3 d-none">
         <div class="sticky-top" style="top:100px">
            <!-- left header  -->
            <!-- <div class="position-relative rounded-3 mb-2" style="background-image: url('<?= root ?>assets/img/map.png'); background-size: cover; background-position: 0 -14px; height: 100px;">
               <button data-bs-toggle="modal" data-bs-target="#MAP" type="button" class="position-absolute btn btn-primary rounded-1 fw-bold translate-middle" style="top: 50%; left: 50%;"><?=T::show_on_map?></button>
               </div> -->
            <div class="card border-0 rounded-3">
               <!-- select price  -->
               <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center card-title">
                     <span class="fw-bold"><?=T::price?> ( <?=$_SESSION['phptravels_client_currency']?> )</span>
                  </div>
                  <div class="sidebar-price-range">
                     <div class="main-search-input-item">
                        <div class="range-sliderrr" data-filter-group>
                           <input type="text" class="js-range-slider" data-ref="range-slider-a" value="" />
                        </div>
                     </div>
                  </div>
                  <!-- <div class="d-flex mt-3">
                     <input class="form-control form-control-sm text-center" type="text" name="rangePriceIni" id="rgpri">
                     <span class="mx-3">
                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f294d" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                     </span>
                     <input class="form-control form-control-sm text-center" type="text" name="rangePricefnl" id="rgprfni">
                     </div> -->
               </div>
               <hr class="mt-0 mb-0 text-muted">
               <div class="sidebar-widget" data-filter-group>
                  <div class="card-body px-2">
                     <p class="card-title fw-bold px-2"><?=T::search_by_name?></p>
                     <input type="text" class="form-control filter--tours-name" placeholder="<?=T::tour?> <?=T::name?>" value="" data-search-attribute="id" />
                  </div>
               </div>
               <hr class="mt-0 mb-0 text-muted">
               <!-- star rating  -->
               <div class="card-body px-2 controls">
                  <p class="card-title fw-bold px-2"><?=T::star_rating?></p>
                  <ul class="list-group list remove_duplication tours--filter-stars" data-filter-group>
                     <!-- 1 star -->
                     <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                        <div class="custom-checkbox d-flex gap-3 align-items-center">
                           <input class="filter form-check-input m-0" type="checkbox" id="stars_1" data-toggle=".stars_1" value=".stars_1">
                           <label class="custom-control-label" for="stars_1">
                           <strong>1</strong> &nbsp;
                           <?= star() ?>
                           <?= star_o() ?>
                           <?= star_o() ?>
                           <?= star_o() ?>
                           <?= star_o() ?>
                           </label>
                        </div>
                     </li>
                     <!-- 2 stars -->
                     <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                        <div class="custom-checkbox d-flex gap-3 align-items-center">
                           <input class="filter form-check-input m-0" type="checkbox" id="stars_2" data-toggle=".stars_2"  value=".stars_2">
                           <label class="custom-control-label" for="stars_2">
                           <strong>2</strong> &nbsp;
                           <?= star() ?>
                           <?= star() ?>
                           <?= star_o() ?>
                           <?= star_o() ?>
                           <?= star_o() ?>
                           </label>
                        </div>
                     </li>
                     <!-- 3 stars -->
                     <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                        <div class="custom-checkbox d-flex gap-3 align-items-center">
                           <input class="filter form-check-input m-0" type="checkbox" id="stars_3" data-toggle=".stars_3" value=".stars_3">
                           <label class="custom-control-label" for="stars_3">
                           <strong>3</strong> &nbsp;
                           <?= star() ?>
                           <?= star() ?>
                           <?= star() ?>
                           <?= star_o() ?>
                           <?= star_o() ?>
                           </label>
                        </div>
                     </li>
                     <!-- 4 stars -->
                     <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                        <div class="custom-checkbox d-flex gap-3 align-items-center">
                           <input class="filter form-check-input m-0" type="checkbox" id="stars_4" data-toggle=".stars_4" value=".stars_4">
                           <label class="custom-control-label" for="stars_4">
                           <strong>4</strong> &nbsp;
                           <?= star() ?>
                           <?= star() ?>
                           <?= star() ?>
                           <?= star() ?>
                           <?= star_o() ?>
                           </label>
                        </div>
                     </li>
                     <!-- 5 stars -->
                     <li class="list-group-item list-group-item-action border-0 px-2 py-1">
                        <div class="custom-checkbox d-flex gap-3 align-items-center">
                           <input class="filter form-check-input m-0" type="checkbox" id="stars_5" data-toggle=".stars_5" value=".stars_5">
                           <label class="custom-control-label" for="stars_5"><strong>5</strong> &nbsp;
                           <?= star() ?>
                           <?= star() ?>
                           <?= star() ?>
                           <?= star() ?>
                           <?= star() ?>
                           </label>
                        </div>
                     </li>
                  </ul>
               </div>
               <hr class="mt-0 mb-0 text-muted">
               
            </div>
            <!-- left side end  -->
         </div>
      </div>
      <!-- right side  -->
      <div class="col-md-12">
         <div class="new-m-main-tit__content flex1 mb-4" style="background: url('<?=root?>assets/img/hotels_search.png') center left -800px / cover, rgb(50, 100, 255);">
            <div class="stacked-color"></div>
            <div class="flex tit-travel-restriction-wrapper">
               <h2 class="new-main-tit mx-2">
                  <span class="j_listABTit text-capitalize">

                  <?=($meta['data']->total)?>

                  <?=T::tours?> <?=T::found?>                        
                  </span>
               </h2>
               <span class="title__fetched-time" style="color: rgb(255, 255, 255);">
                  <strong class="text-uppercase mx-3">
                  <?=$_SESSION['tours_location']?>
                  </strong>
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M5 12h13M12 5l7 7-7 7"/>
                  </svg>
                  <?=$_SESSION['tours_date']?>
               </span>
            </div>
         </div>
         <!-- user hotel filter  -->
         <nav class="#sticky-top uhf d-none" style="top:80px" id="data" data-filter-group>
            <ul class="flex-nowrap gap-2 flex-sm-wrap gap-sm-0 nav nav-pills nav-justified bg-white rounded overflow-hidden mb-3">
               <li class="nav-item">
                  <button data-value="price,asc" role="button" class="nav-link border-end active rounded-0 px-0" data-bs-toggle="tab">
                  <span class="d-block w-100"><?=T::lowest_to_higher?> </span>
                  </button>
               </li>
               <li class="nav-item">
                  <button data-value="price,desc" role="button" class="nav-link border-end rounded-0 px-0" data-bs-toggle="tab">
                  <span class="d-block w-100"><?=T::highest_to_lower?> </span>
                  </button>
               </li>
               <li class="nav-item">
                  <button data-value="popular,desc" role="button" class="nav-link border-end rounded-0 px-0" data-bs-toggle="tab">
                  <span class="d-block w-100"><?=T::most_popular?></span>
                  </button>
               </li>
               <li class="nav-item">
                  <button data-value="star,desc" role="button" class="nav-link rounded-0 px-0" data-bs-toggle="tab">
                  <span class="d-block w-100"><?=T::star_rating?></span>
                  </button>
               </li>
            </ul>
         </nav>
         <div class="">
            <div class="row g-3">
               <?php foreach ($TOURS_DATA as $index => $item) {
                  $hash=base64_encode(json_encode($item->supplier));
                  $link = root.'tour/'.$item->tour_id.'/'.
                  $meta['date'].'/'.$meta['adults'].'/'.$meta['childs'].'/'.$hash;
                  
                  if($item->supplier =="tours"){
                      (isset($item->img))?$img = root."uploads/".$item->img:$img = root."assets/img/hotel.jpg";
                  } else {
                      $img = $item->img;
                  }
                  
                  ?>
               <div class="col-md-4 mb-2">
                  <div class="bg-white h-100 rounded-3">
                     <div class="card rounded-3 border-0">
                        <!-- THUMBNAIL -->
                        <div class="col-12 overflow-hidden border-0" style="max-height: 230px;min-height: 230px; border-radius: 6px 6px 0px 0px !important;">
                           <img class="w-100 h-100" src="<?=$img?>" style="object-fit: cover;min-height: 230px;" alt="">
                        </div>
                     </div>
                     <div class="p-3 py-3 overflow-hidden position-relative">
                        <p class="m-1" style="line-height:20px;min-height:40px"><strong><?= substr($item->name, 0, 50); if (strlen($item->name) > 50){echo "...";} ?></strong></p>
                         <span class="d-inline-block rounded-pill position-absolute" style="top:5px; right:5px; height: 10px;width: 10px;background: <?=$item->color?>"></span>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                           <div class="d-flex gap-1 align-items-center text-muted h6 py-2">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f294d" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs">
                                    <path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                 </svg>
                              </span>
                              <span class="text--overflow text-capitalize"><?= $item->location ?></span>
                           </div>
                           
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                           <div class="d-flex align-items-center">
                              <?php for ($i = 1; $i <= $item->rating; $i++) { ?>
                              <?= star() ?>
                              <?php } ?>
                           </div>

                           <div class="d-inline-flex fw-bold rounded">
                              <small>
                              <?=T::rating?> <?= $item->rating ?>/5
                              </small>
                           </div>

                           <span class="fw-bold fs-5"><small style="font-size:14px"><?= $_SESSION['phptravels_client_currency'] ?></small>  <?= $item->actual_price ?></span>
                        </div>
                        <?php if(!empty($item->redirect)){?>
                        <a href="<?=$item->redirect?>" target="_blank" class="d-flex align-items-center btn btn-primary rounded-1 justify-content-center gap-2" type="button">
                           <?=T::details?>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1" stroke-linecap="square" stroke-linejoin="arcs">
                              <path d="M9 18l6-6-6-6"/>
                           </svg>
                        </a>
                        <?php }else{ ?>
                        <a href="<?=$link?>" class="d-flex align-items-center btn btn-primary rounded-1 justify-content-center gap-2" type="button">
                           <?=T::details?>
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1" stroke-linecap="square" stroke-linejoin="arcs">
                              <path d="M9 18l6-6-6-6"/>
                           </svg>
                        </a>
                        <?php }?>
                     </div>
                  </div>
               </div>
               <?php }?>
            </div>
         </div>
        
         <div class="my-4"></div>
         <?php
         
            // PAGINATION
            include "./App/Lib/paginator.php";
            $totalItems = ($meta['data']->total);
            $itemsPerPage = 50;
            $currentPage = $PageNumber=$meta['page_number'];
            $urlPattern = './(:num)';
            $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
            echo $paginator; 

        ?>
      </div>
   </div>
</div>
<!-- back to the top  -->
<!-- <div class="position-fixed bg-primary rounded-1 top-50 translate-middle-y" style="right: 30px;">
   <a class="btn btn-primary" href="">
   <svg xmlns="http://www.w3.org/2000/svg" width="40" height="50" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><path d="M18 15l-6-6-6 6"/></svg>
   </a>
   </div> -->
<style>
   @media only screen and (max-width: 425px) {
   .uhf > .nav { border-radius: 0 !important; padding-block: 10px !important; overflow-x: scroll !important; }
   .uhf > .nav::-webkit-scrollbar {height: 2px !important; }
   .uhf > .nav > .nav-item { border-radius: 20px !important; }
   .uhf > .nav > .nav-item > .nav-link { border: none !important; border-radius: 20px !important; width: 100% !important; padding: 0 !important; }
   /* assigning to parent  */
   .uhf > .nav > .nav-item:not(:has(.active)) { background-color: #f2f5f8 !important;  }
   .uhf > .nav > .nav-item > .nav-link > span { width: max-content !important; padding: 2px 14px !important; }
   }
</style>
<?php } ?>