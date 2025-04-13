<div data-aos="fade-up" class="container py-5">
   <div class="featured_tours p-0 rounded-0 py-3">
      <h4><strong><?=T::popular_tours?></strong></h4>
      <small><?=T::these_alluring_destinations_are_picked_just_for_you?></small>
      <div class="pt-4 row">
         <div class="col-lg-8 pe-lg-0">
            <div class="d-lg-flex list-group list-group-horizontal flex-wrap flex-lg-row feature--city flex-column">
               <?php 
                  foreach(base()->featured_tours as $item){
                  $hash=base64_encode(json_encode($item->supplier));
                  $name = str_replace(' ', '-', $item->name);
                  $link = root.'tour'.'/'.$item->id.'/'.date('d-m-Y').'/'.$item->adult.'/'.$item->child.'/'.$hash; ?>
               <a class="list-group-item list-group-item-action border-0 p-0" href="<?=$link?>">
                  <div class="position-relative rounded-1 overflow-hidden h-100">
                     <img class="h-100" src="<?=root."uploads/".$item->img?>" style="scale: 1.7;">
                     <div class="position-absolute top-0 start-0 h-100 w-100 text-white fw-bold overlay w-100" style="padding: 12px;">
                        <!-- type  -->
                        <div class="h6"><?=$item->location?></div>
                        <div class="position-absolute start-0 w-100" style="bottom: 0; padding: 12px;">
                           <!-- <div class="icon">
                              <?=$item->name?>
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="white" stroke="white" stroke-width="1">
                              <path d="M17.043 8.683a.588.588 0 01.852 0l2.922 2.921c.242.244.242.609 0 .792l-2.922 2.922a.554.554 0 01-.426.182c-.366 0-.609-.243-.609-.609V12.9L3.9 12.9a.9.9 0 01-.893-.787L3 12a.9.9 0 01.9-.9l12.96-.001v-1.99c0-.146.039-.253.117-.353l.066-.073z"></path>
                              </svg>
                              </div> -->
                           <h5 class="main--city mb-0 fs-6"><strong><?=$item->name?></strong></h5>
                           <div class="text-uppercase main--country" style="font-size: 12px;"><?=currency?> <?=$item->price?></div>
                           <div class="started--from my-2"></div>
                           <?php for ($i = 1; $i <= $item->stars; $i++) { star(); } ?>
                        </div>
                     </div>
                  </div>
               </a>
               <?php } ?>
            </div>
         </div>
         <!-- right  -->
         <div class="col-lg-4 ps-lg-0 mt-3 mt-lg-0">
            <div class="d-flex flex-column h-100">
               <!-- img  -->
               <div class="rounded-2 overflow-hidden h-100">
                  <img class="w-100" src="assets/img/tours.jpg" alt="">
               </div>
               <!-- description  -->
               <div class="gap-3 align-items-center p-4 flex-column bg-white rounded-4 mt-4 h-100">
                  <div class="pt-4">
                     <h5><strong><?=T::limited_budget?></strong></h5>
                     <p><?=T::find_price_drops_and_travel_as_far_as_you_can_with_our_exclusive_deals?></p>
                  </div>
                  <hr>
                  <a href="<?=root?>tours" class="d-block btn btn-light px-3 border" style="font-weight: 600;"><?=T::view_more?></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>