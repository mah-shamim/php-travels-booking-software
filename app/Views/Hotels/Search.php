<form id="hotels-search" class="content m-0 search_box">
   <div class="row mb-0 pt-1 g-2">
      <div class="col-md-4">
         <div class="input-items">
            <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="10" r="3"/>
                  <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/>
               </svg>
            </div>
            <select id="hotels_city" name="city" class="hotels_select2 form-control" required>
               <?php if(isset($_SESSION['hotels_location'])){ ?>
               <option value="<?=$_SESSION['hotels_location']; ?>"><?= str_replace("-", " ", $_SESSION['hotels_location']); ?></option>
               <?php } else { ?>
               <option value=""> <?=T::searchbycity?></option>
               <?php } ?>
            </select>
         </div>
         <div class="d-block d-sm-none"></div>
      </div>
      <div class="col-6 col-md-2">
         <div class="form-floating">
            <input type="text" class="checkin form-control" id="checkin" placeholder="checkin" value="<?php if(isset($_SESSION['hotels_checkin'])){ echo $_SESSION['hotels_checkin']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>">
            <label for="checkin">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                  <line x1="16" y1="2" x2="16" y2="6"></line>
                  <line x1="8" y1="2" x2="8" y2="6"></line>
                  <line x1="3" y1="10" x2="21" y2="10"></line>
               </svg>
               <?=T::hotels_checkin?>
            </label>
         </div>
      </div>
      <div class="col-6 col-md-2">
         <div class="form-floating">
            <input type="text" class="checkout form-control" id="checkout" placeholder="" value="<?php if(isset($_SESSION['hotels_checkout'])){ echo $_SESSION['hotels_checkout']; } else { $d=strtotime("+4 Days"); echo date("d-m-Y", $d); } ?>">
            <label for="checkout">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                  <line x1="16" y1="2" x2="16" y2="6"></line>
                  <line x1="8" y1="2" x2="8" y2="6"></line>
                  <line x1="3" y1="10" x2="21" y2="10"></line>
               </svg>
               <?=T::hotels_checkout?>
            </label>
         </div>
      </div>
      <div class="col-md-3">
         <div class="input-box">
            <div class="form-group">
               <div class="dropdown dropdown-contain">
                  <a class="dropdown-toggle dropdown-btn travellers d-flex align-items-center" href="#" role="button"
                     data-toggle="dropdown" aria-expanded="false">
                     <p class="m-0 d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                           <circle cx="9" cy="7" r="4"></circle>
                           <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                           <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <?=T::travellers?> <span class="guest_hotels"></span>
                        <span><?=T::hotels_rooms?> <span class="roomTotal">0</span></span>
                     </p>
                  </a>
                  <div class="dropdown-menu dropdown-menu-wrap">
                     <div class="dropdown-item">
                        <div class="roomBtn d-flex align-items-center justify-content-between">
                           <label class="travellers-option">
                              <svg fill="#000000" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                 <path d="M5 10C3.355469 10 2 11.355469 2 13L2 28.1875C2.003906 28.25 2.015625 28.3125 2.03125 28.375C2.03125 28.386719 2.03125 28.394531 2.03125 28.40625C1.582031 29.113281 1.214844 29.867188 0.9375 30.6875C0.316406 32.519531 0.0507813 34.621094 0 37L0 38C0 38.03125 0 38.0625 0 38.09375L0 50L7 50L7 46C7 45.167969 7.203125 44.734375 7.46875 44.46875C7.734375 44.203125 8.167969 44 9 44L41 44C41.832031 44 42.265625 44.203125 42.53125 44.46875C42.796875 44.734375 43 45.167969 43 46L43 50L50 50L50 38.15625C50.003906 38.105469 50.003906 38.050781 50 38C50 37.65625 50.007813 37.332031 50 37C49.949219 34.621094 49.683594 32.519531 49.0625 30.6875C48.785156 29.875 48.414063 29.136719 47.96875 28.4375C47.988281 28.355469 48 28.273438 48 28.1875L48 13C48 11.355469 46.644531 10 45 10 Z M 5 12L45 12C45.5625 12 46 12.4375 46 13L46 26.15625C45.753906 25.949219 45.492188 25.75 45.21875 25.5625C44.550781 25.101563 43.824219 24.671875 43 24.3125L43 20C43 19.296875 42.539063 18.75 42.03125 18.40625C41.523438 18.0625 40.902344 17.824219 40.125 17.625C38.570313 17.226563 36.386719 17 33.5 17C30.613281 17 28.429688 17.226563 26.875 17.625C26.117188 17.820313 25.5 18.042969 25 18.375C24.5 18.042969 23.882813 17.820313 23.125 17.625C21.570313 17.226563 19.386719 17 16.5 17C13.613281 17 11.429688 17.226563 9.875 17.625C9.097656 17.824219 8.476563 18.0625 7.96875 18.40625C7.460938 18.75 7 19.296875 7 20L7 24.3125C6.175781 24.671875 5.449219 25.101563 4.78125 25.5625C4.507813 25.75 4.246094 25.949219 4 26.15625L4 13C4 12.4375 4.4375 12 5 12 Z M 16.5 19C19.28125 19 21.34375 19.234375 22.625 19.5625C23.265625 19.726563 23.707031 19.925781 23.90625 20.0625C23.988281 20.117188 23.992188 20.125 24 20.125L24 22C17.425781 22.042969 12.558594 22.535156 9 23.625L9 20.125C9.007813 20.125 9.011719 20.117188 9.09375 20.0625C9.292969 19.925781 9.734375 19.726563 10.375 19.5625C11.65625 19.234375 13.71875 19 16.5 19 Z M 33.5 19C36.28125 19 38.34375 19.234375 39.625 19.5625C40.265625 19.726563 40.707031 19.925781 40.90625 20.0625C40.988281 20.117188 40.992188 20.125 41 20.125L41 23.625C37.441406 22.535156 32.574219 22.042969 26 22L26 20.125C26.007813 20.125 26.011719 20.117188 26.09375 20.0625C26.292969 19.925781 26.734375 19.726563 27.375 19.5625C28.65625 19.234375 30.71875 19 33.5 19 Z M 24.8125 24C24.917969 24.015625 25.019531 24.015625 25.125 24C25.15625 24 25.1875 24 25.21875 24C35.226563 24.015625 41.007813 25.0625 44.09375 27.1875C45.648438 28.257813 46.589844 29.585938 47.1875 31.34375C47.707031 32.875 47.917969 34.761719 47.96875 37L2.03125 37C2.082031 34.761719 2.292969 32.875 2.8125 31.34375C3.410156 29.585938 4.351563 28.257813 5.90625 27.1875C8.992188 25.058594 14.785156 24.011719 24.8125 24 Z M 2 39L48 39L48 48L45 48L45 46C45 44.832031 44.703125 43.765625 43.96875 43.03125C43.234375 42.296875 42.167969 42 41 42L9 42C7.832031 42 6.765625 42.296875 6.03125 43.03125C5.296875 43.765625 5 44.832031 5 46L5 48L2 48Z"/>
                              </svg>
                              <?=T::hotels_rooms?>
                           </label>
                           <div class="qtyBtn d-flex align-items-center">
                              <input type="text" name="roomInput" id="hotels_rooms"
                                 value="<?php if(isset($_SESSION['hotels_rooms'])){ echo $_SESSION['hotels_rooms']; } else { echo "1"; } ?>"
                                 class="">
                           </div>
                        </div>
                     </div>
                     <div class="dropdown-item">
                        <div class="qty-box d-flex align-items-center justify-content-between">
                           <label class="travellers-option">
                              <svg fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M16 16.75c4.28 0 7.75-3.47 7.75-7.75s-3.47-7.75-7.75-7.75c-4.28 0-7.75 3.47-7.75 7.75v0c0.005 4.278 3.472 7.745 7.75 7.75h0zM16 2.75c3.452 0 6.25 2.798 6.25 6.25s-2.798 6.25-6.25 6.25c-3.452 0-6.25-2.798-6.25-6.25v0c0.004-3.45 2.8-6.246 6.25-6.25h0zM30.41 29.84c-1.503-6.677-7.383-11.59-14.41-11.59s-12.907 4.913-14.391 11.491l-0.019 0.099c-0.011 0.048-0.017 0.103-0.017 0.16 0 0.414 0.336 0.75 0.75 0.75 0.357 0 0.656-0.25 0.731-0.585l0.001-0.005c1.351-5.998 6.633-10.41 12.945-10.41s11.594 4.413 12.929 10.322l0.017 0.089c0.076 0.34 0.374 0.59 0.732 0.59 0 0 0.001 0 0.001 0h-0c0.057-0 0.112-0.007 0.165-0.019l-0.005 0.001c0.34-0.076 0.59-0.375 0.59-0.733 0-0.057-0.006-0.112-0.018-0.165l0.001 0.005z"></path>
                              </svg>
                              <?=T::hotels_adults?>
                           </label>
                           <div class="qtyBtn d-flex align-items-center">
                              <input type="text" name="adults" id="hotels_adults"
                                 value="<?php if(isset($_SESSION['hotels_adults'])){ echo $_SESSION['hotels_adults']; } else { echo "2"; } ?>"
                                 class="qtyInput_hotels">
                           </div>
                        </div>
                     </div>
                     <div class="dropdown-item">
                        <div class="qty-box d-flex align-items-center justify-content-between">
                           <label class="travellers-option">
                              <svg fill="#000000" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M13 16.168c1.918-0.007 3.635-0.864 4.793-2.215l0.007-0.009c0.93 1.101 2.312 1.796 3.856 1.796 2.782 0 5.036-2.255 5.036-5.036s-2.255-5.036-5.036-5.036c-1.171 0-2.248 0.4-3.104 1.070l0.011-0.008c-1.106-1.979-3.187-3.294-5.576-3.294-3.516 0-6.366 2.85-6.366 6.366s2.85 6.366 6.366 6.366c0.005 0 0.009 0 0.014 0h-0.001zM19.152 8.172c0.643-0.643 1.532-1.040 2.513-1.040 1.964 0 3.556 1.592 3.556 3.556s-1.592 3.556-3.556 3.556c-1.244 0-2.339-0.639-2.974-1.606l-0.008-0.013c0.432-0.824 0.689-1.8 0.696-2.835v-0.002c-0.008-0.582-0.094-1.141-0.247-1.671l0.011 0.044zM13 4.909c2.695 0 4.879 2.185 4.879 4.879s-2.185 4.879-4.879 4.879-4.879-2.185-4.879-4.879c0-0 0-0 0-0.001v0c0.003-2.694 2.186-4.876 4.88-4.879h0zM30.732 24.996c-0.938-4.22-4.648-7.328-9.085-7.328-1.725 0-3.34 0.47-4.725 1.289l0.043-0.024c-1.18-0.434-2.543-0.687-3.965-0.689h-0.001c-5.713 0.024-10.488 4.013-11.717 9.356l-0.016 0.081c-0.011 0.048-0.017 0.103-0.017 0.16 0 0.414 0.336 0.75 0.75 0.75 0.357 0 0.656-0.25 0.731-0.585l0.001-0.005c1.071-4.757 5.261-8.258 10.268-8.258s9.196 3.5 10.254 8.188l0.013 0.070c0.076 0.34 0.374 0.59 0.732 0.59 0 0 0.001 0 0.001 0h-0c0.057-0 0.112-0.007 0.165-0.019l-0.005 0.001c0.34-0.076 0.59-0.375 0.59-0.733 0-0.057-0.006-0.112-0.018-0.165l0.001 0.005c-0.79-3.454-2.981-6.285-5.929-7.916l-0.062-0.031c0.863-0.358 1.864-0.566 2.915-0.566 3.72 0 6.83 2.609 7.602 6.097l0.010 0.052c0.076 0.34 0.374 0.59 0.732 0.59 0 0 0.001 0 0.001 0h-0c0.057-0 0.112-0.007 0.165-0.019l-0.005 0.001c0.34-0.076 0.59-0.375 0.59-0.733 0-0.057-0.006-0.112-0.018-0.165l0.001 0.005z"></path>
                              </svg>
                              <?=T::hotels_childs?>
                           </label>
                           <div class="qtyBtn d-flex align-items-center child_ages">
                              <input type="text" name="childs" id="hotels_childs"
                                 value="<?php if(isset($_SESSION['hotels_childs'])){ echo $_SESSION['hotels_childs']; } else { echo "0"; } ?>"
                                 class="qtyInput_hotels">
                           </div>
                        </div>
                     </div>
                     <ol class="row g-1 m-0 p-1" id="append">
                        <?php
                           if (isset($_SESSION['ages'])) {
                           $ages = json_decode($_SESSION['ages']);
                           // dd($ages);
                           foreach ($ages as $key => $val) {
                           ?>
                        <li class="col px-2" id="child_ages">
                           <div class="dropdown-item p-2" style="margin-top:-36px">
                              <p style="color:#000"><small> <strong class="px-2"> <?=T::child?> <?=T::age?></strong></small></p>
                              <div class="form-group">
                                 <span class="la la-child select form-icon"></span>
                                 <div class="input-items">
                                    <select onchange="show_values(`<?=$key+1?>`);" class="form-select child_<?=$key+1?>" id="ages<?=$key+1?>" name="ages[<?=$key+1?>]">
                                       <option value="0" selected disabled>0</option>
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                       <option value="4">4</option>
                                       <option value="5">5</option>
                                       <option value="6">6</option>
                                       <option value="7">7</option>
                                       <option value="8">8</option>
                                       <option value="9">9</option>
                                       <option value="10">10</option>
                                       <option value="11">11</option>
                                       <option value="12">12</option>
                                       <option value="13">13</option>
                                       <option value="14">14</option>
                                       <option value="15">15</option>
                                       <option value="16">16</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </li>
                        <?php } } ?>
                     </ol>
                     <?php
                        if (isset($_SESSION['ages'])) {
                        $ages = json_decode($_SESSION['ages']);
                        // dd($ages);
                        foreach ($ages as $key => $val) {?>
                     <script>
                        $('.child_<?=$key+1?> option[value=<?=$val->ages?>]')
                        .attr('selected', 'selected');
                     </script>
                     <?php } } ?>
                     <div class="dropdown-item">
                        <div class="form-floating">
                           <select style="background-color:#e9eef2" class="form-select nationality"
                              id="nationality">
                           <?=countries_list();?>
                           </select>
                           <label for="floatingSelect">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                 <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                                 <line x1="4" y1="22" x2="4" y2="15"></line>
                              </svg>
                              <?=T::nationality?>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end dropdown -->
            </div>
         </div>
      </div>
      <div class="col-md-1">
         <button style="height:64px" type="submit" class="search_button w-100 btn btn-primary btn-m rounded-sm font-700 text-uppercase btn-full">
            <svg style="fill:currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="c8LPF-icon" role="img" height="24" cleanup="">
               <path d="M174.973 150.594l-29.406-29.406c5.794-9.945 9.171-21.482 9.171-33.819C154.737 50.164 124.573 20 87.368 20S20 50.164 20 87.368s30.164 67.368 67.368 67.368c12.345 0 23.874-3.377 33.827-9.171l29.406 29.406c6.703 6.703 17.667 6.703 24.371 0c6.704-6.702 6.704-17.674.001-24.377zM36.842 87.36c0-27.857 22.669-50.526 50.526-50.526s50.526 22.669 50.526 50.526s-22.669 50.526-50.526 50.526s-50.526-22.669-50.526-50.526z"></path>
            </svg>
         </button>
         <div class="loading_button" style="display:none">
            <button style="height:64px" class="loading_button gap-2 w-100 btn btn-primary btn-m rounded-sm font-700 text-uppercase btn-full" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status"
               aria-hidden="true"></span>
            </button>
         </div>
      </div>
   </div>
   <!-- <div class="divider mb-4 mt-2"></div> -->
   <input type="hidden" name="" value="" id="" class="nationality__">
</form>

<!-- MOST POPULAR OPTIONS HOTELS -->
<template id="most--popular-hotels">
   <div class="most--popular-hotels">
      <small class="mb-2 px-3 text-muted fw-bold"><?=T::most_popular?></small>
                  
      <?php foreach(base()->hotels_suggestions as $suggestions) {?>
      <div class="d-flex align-items-center p-2 to--insert overflow-hidden">
            <!-- <button class="btn btn-outline-primary btn-sm mx-0 d-none" style="font-size: 12px; font-weight: bold; min-width:57px"><?=$suggestions->city?> </button> -->
            <div class="mx-2" style="line-height: 14px;">
               <strong><?=$suggestions->city?>, 
               <small><?=$suggestions->country?></small>
            </strong> 
               <div class="d-block">
                  <!-- <small class="d-inline-block overflow-hidden airport--name">1King Abdulaziz International Airport</small> -->
               </div>
            </div>
      </div>
      <?php } ?>
      
   </div>
</template>

<script>

var child_age = "<?=T::child_age?>";

// COLLECTING PARAMS TO SEND FOR API
$("#hotels-search").submit(function() {
    event.preventDefault();     

   // LOADING EFFECT
   $("body").load(
      '<?=root?>App/Views/Loading.php', 
      {
         'root': '<?=root?>',
         'color': '<?=base()->app->default_theme?>'
      },
      function() {
         $("body").addClass("loadingfadein")
      }
   );

   
    $('.search_button').hide();
    $('.loading_button').show();

    var city_id = $('.hotels_select2').val();
    var city_name = $("#hotels_city option:selected").text().toLowerCase();
    var checkin = $('#checkin').val();
    var checkout = $('#checkout').val();
    var rooms = $('#hotels_rooms').val();
    var nationality = $('#nationality').val();
    var language = $('#language').val();
    var adults = $('#hotels_adults').val();
    var child = $('#hotels_childs').val();
    var room = $('#room').val();
    var city_trims_ = city_name.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');

    // REMOVE - DASH FROM END OF THE CITY
    if(city_trims_.slice(-1) == '-') { var city__ = city_trims_.slice(0, -1);
    } else { var city__ = city_trims_; }

    /* REDIRECT */
    window.location.href = '<?=root?>' + './hotels/'+city__+'/'+checkin+'/'+checkout+'/'+rooms+'/'+adults+'/'+child+'/'+nationality;

    // PAGE TOP
    $("html, body").animate({ scrollTop: 0 }, "fast");
    
});

// get users country
var requestUrl = "https://ipwhois.app/json/";
fetch(requestUrl)
.then(function(response) { return response.json(); })
.then(function(c) {

var user_country = c['country_code'];

console.log(user_country);

if( typeof user_country !== 'undefined' ) {

    <?php if(isset($_SESSION['hotels_nationality'])){ ?>
    $('.nationality option[value=<?php if(isset($_SESSION['hotels_nationality'])){ echo $_SESSION['hotels_nationality']; } ?>]').attr('selected', 'selected');
    <?php } else { ?>
    $('.nationality option[value='+user_country+']').attr('selected', 'selected');
    <?php } ?>

    $("#nation").text(c.country)

} else {
    user_country = 'US';
    console.log(user_country);

    <?php if(isset($_SESSION['hotels_nationality'])){ ?>
    $('.nationality option[value=<?php if(isset($_SESSION['hotels_nationality'])){ echo $_SESSION['hotels_nationality']; } ?>]').attr('selected', 'selected');
    <?php } else { ?>
    $('.nationality option[value='+user_country+']').attr('selected', 'selected');
    <?php } ?>
}

});
</script>

<style>
::marker {
    color: #0d6efd;
    font-size: 1em;
    font-weight: bold;
}

ol {
    list-style-position: inside;
    padding: 0;
}

.most--popular-from button,.most--popular-to button  { width: 50px; font-size: 12px; font-weight: bold; }
.airport--name { height:1em; }
.to--insert { height: 54px; }
</style>


<script>

   var root = "<?=root?>";

   function update_travellers(){
   var nationality_ =  $('#nationality').find('option:selected').text(); 
   $('.nationality__').val(nationality_);
   $("#nation").text(nationality_);

   var hotels_rooms = $('#hotels_rooms').val();

   // UPDATE ROOMS COUNTER
   $(".roomTotal").text(hotels_rooms);
   
   }

   // select 2 location init for hotels search 
   var $ajax = $(".hotels_select2");
   function formatRepo(t) {  return t.loading ? t.text : (console.log(t), '<i class="flag ' + t.icon.toLowerCase() + '"></i>' + t.text +', '+'<strong>'+t.country_name+'</strong>') }
   function formatRepoSelection(t) { 
      
   if(typeof t.country_name === 'undefined') {
   var country_name_ = "";
   } else { 
   var country_name_ = t.country_name;
   }
      
   return t.text +' '+'<small><strong>'+country_name_+'</strong><small>' }
   $ajax.select2({
       ajax: {
           url: "<?=root.api_url?>hotels_locations",
           dataType: "json",
           data: function(t) {
               return {
                   city: $.trim(t.term)
               }
           },
           processResults: function(t) {
            // console.log(t.data)
               var e = [];
               return t.data.forEach(function(t) {
                   e.push({
                       id: t.id,
                       text: t.city,
                       icon: t.country_code,
                       country_name: t.country
                   })
               }), console.log(e), {
                   results: e
               }
           },
           cache: !0
       },
       escapeMarkup: function(t) {
           return t
       },
       minimumInputLength: 3,
       templateResult: formatRepo,
       templateSelection: formatRepoSelection,
       dropdownPosition: 'below',
       cache: !0
   });
   
   // TO STORE THE SELECT2 RESULT WRAPERR 
   var _select2Result;
   
   let _mostPolpularHotels;
   $(document).on('select2:open', function(e) {
      document.querySelector('.select2-search__field').focus();
      
      if(e.target.classList.contains('hotels_select2')) {
         setTimeout(() => $('.select2-results > ul > li').hide(), 10)
         _mostPolpularHotels = document.querySelector('#most--popular-hotels').content.cloneNode(true);
         mostPopularHotels(e.target);
      }
   });
   
   function mostPopularHotels(_selectedId) {
      setTimeout(() => addEventHotels(_mostPolpularHotels, _selectedId), 10)
   }

   function addEventHotels(tempHotels, thisId) {
      let sibiling = $(thisId).siblings('.select2.select2-container')
      let change = $(sibiling).find('.select2-selection__rendered')
      let len = tempHotels.querySelectorAll('div > .to--insert')
      len.forEach(li => {
         li.addEventListener('click', function(e) { 
               let outterText = this.querySelector('div > strong').textContent.trim().split(',')
               change.html( `${outterText[0]} ${outterText[1]}` );
               thisId.querySelector('option').value = outterText[0];
               thisId.querySelector('option').textContent = outterText[0];

               // document.querySelector('.select2.select2-container.select2-container--default.select2-container--open').classList.remove('select2-container--open')
               // document.querySelector('.select2-container.select2-container--default.select2-container--open:last-child').remove()

               $('.hotels_select2').select2('close');
         })
      })

      $('.select2-results > ul').append(_mostPolpularHotels);

       // WHEN SELECT2 GET OPENED ADD FADE ANIMATION TO THE SELECT2 
         document.querySelector('.select2-results').classList.remove("select2--fadeout");
         document.querySelector('.select2-results').classList.add("select2--fadein");
        
        // GET THE THE RESULT PARENT 
        // scope @global
      //   _select2Result = document.querySelector(".select2-results");

        // ADD @KEYUP EVENT TO THE SELECT2 SEARCH INPUT 
      //   document.querySelector(".select2-search__field").addEventListener("keyup", function () {
      //       setTimeout(() => {
      //           let _newHeight = document.querySelector("ul.select2-results__options" ).offsetHeight;
      //           _select2Result.style.height = _newHeight + "px";
      //       }, 300);
      //   });
   }

   // WHENEVER SELECT2 GET CLOSE
   $(document).on('select2:closing', function() {
      document.querySelector('.select2-results').classList.remove("select2--fadein");
      document.querySelector('.select2-results').classList.add("select2--fadeout");
      // _select2Result.style.height = "auto";
   })
   $('.select_').select2({ placeholder: { id: '1', text: 'Select Category' } });
   
</script>