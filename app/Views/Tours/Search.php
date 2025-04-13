<form id="tours-search" class="content m-0 search_box">
   <div class="row mb-0 pt-1 g-2">
      <div class="col-md-4">
         <div class="input-items">
            <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="10" r="3"/>
                  <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/>
               </svg>
            </div>
            <select id="tours_city" name="city" class="tours_city form-control" required>
               <?php if(isset($_SESSION['tours_location'])){ ?>
               <option value="<?=$_SESSION['tours_location_id']; ?>/<?=$_SESSION['tours_location']; ?>">
                  <?=str_replace("-", " ", $_SESSION['tours_location']); ?>
               </option>
               <?php } else { ?>
               <option value=""> <?=T::searchbycity?></option>
               <?php } ?>
            </select>
         </div>
         <div class="d-block d-sm-none"></div>
      </div>
      <div class="col-md-4">
         <div class="form-floating">
         <input name="date" class="dp form-control" id="date" type="text" placeholder="" value="<?php if(isset($_SESSION['tours_date'])){ echo $_SESSION['tours_date']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>" readonly="readonly"/>
            <label for="checkin">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                  <line x1="16" y1="2" x2="16" y2="6"></line>
                  <line x1="8" y1="2" x2="8" y2="6"></line>
                  <line x1="3" y1="10" x2="21" y2="10"></line>
               </svg>
               <?=T::date?>
            </label>
         </div>
      </div>
       
      <div class="col-md-3">
         <div class="input-box">
            <div class="form-group">
               
            <div class="dropdown dropdown-contain">
                        <a class="dropdown-toggle dropdown-btn travellers" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <p class="m-0 d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                           <circle cx="9" cy="7" r="4"></circle>
                           <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                           <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <?=T::travellers?> <span class="guest_tours"></span></p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-wrap w-100">
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-user"></i> <?=T::adults?> <!--<small>(+12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="adults" id="tours_adults" value="<?php if(isset($_SESSION['tours_adults'])){ echo $_SESSION['tours_adults']; } else { echo "1"; } ?>" class="qtyInput_tours">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-female"></i> <?=T::child?>  <!--<small>(-12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="childs" id="tours_child" value="<?php if(isset($_SESSION['tours_childs'])){ echo $_SESSION['tours_childs']; } else { echo "0"; } ?>" class="qtyInput_tours">
                                    </div>
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
            <button style="height:64px" class="gap-2 w-100 btn btn-primary btn-m rounded-sm font-700 text-uppercase btn-full" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status"
               aria-hidden="true"></span>
            </button>
         </div>
      </div>
   </div>
  
</form>

<!-- MOST POPULAR OPTIONS TOURS -->
<template id="most--popular-tours">
   <div class="most--popular-tours">
      <small class="mb-2 px-2 text-muted fw-bold">Most popular Tours</small>

       <?php foreach(base()->tours_suggestions as $suggestions) {?>
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

// collecting params to send for beutified URI
$("#tours-search").submit(function() {
event.preventDefault();  

   // LOADING EFFECT
   // $("body").load(
   //    '<?=root?>App/Views/Loading.php', 
   //    {
   //       'root': '<?=root?>',
   //       'color': '<?=base()->app->default_theme?>'
   //    },
   //    function() {
   //          $("body").addClass("loadingfadein")
   //    }
   //    );

$('.search_button').hide();
$('.loading_button').show();
$('body').fadeOut(250);

var city_id = $('.tours_city').val();
var city = $("#tours_city option:selected").text().toLowerCase();
var date = $('#date').val();
var tours_adults = $('#tours_adults').val();
var tours_child = $('#tours_child').val();
var city_trims = city.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');

// REMOVE - DASH FROM END OF THE CITY
if(city_trims.slice(-1) == '-') { var city_ = city_trims.slice(0, -1);
} else { var city_name = city_trims; }

var finelURL = './tours/'+city_id +'/'+city_name+'/'+date+'/'+tours_adults+'/'+tours_child+'/';
var URL = finelURL.replace("/undefined","");
// PAGE TOP
$("html, body").animate({ scrollTop: 0 }, "fast");

/* REDIRECT */
window.location.href = '<?=root?>' + URL;

});

</script>

<script>

   var root = "<?=root?>";

   // select 2 location init for tours search 
   var $ajax = $(".tours_city");
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
           url: "<?=root.api_url?>tours_locations",
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

   let _mostPolpularTours;   
   $(document).on('select2:open', function(e) {
      document.querySelector('.select2-search__field').focus();

      if(e.target.classList.contains('tours_city')) {

         setTimeout(() => $('.select2-results > ul > li').hide(), 10)
         _mostPolpularTours = document.querySelector('#most--popular-tours').content.cloneNode(true);
         mostPopularTours(e.target);
      }
   });


   function mostPopularTours(_selectedId) {
      setTimeout(() => addEventTours(_mostPolpularTours, _selectedId), 10)
   }

   function addEventTours(tempCars, thisId) {
      let sibiling = $(thisId).siblings('.select2.select2-container')
      let change = $(sibiling).find('.select2-selection__rendered')

      
      let len = tempCars.querySelectorAll('div > .to--insert')

      len.forEach(li => {
         li.addEventListener('click', function(e) { 
               let outterText = this.querySelector('div.mx-2 > strong').textContent;
               let getTxt = outterText.split(',')

               change.html( `${getTxt[0].trim()} <small><strong class="mt-1"> ${getTxt[1].trim()} </strong></small>` );
               thisId.querySelector('option').value = getTxt[0].trim();
               thisId.querySelector('option').textContent = getTxt[0].trim();

               // document.querySelector('.select2.select2-container.select2-container--default.select2-container--open').classList.remove('select2-container--open')
               // document.querySelector('.select2-container.select2-container--default.select2-container--open:last-child').remove()

               $('.tours_city').select2('close');
         })

      })

      $('.select2-results > ul').append(_mostPolpularTours);

      // WHEN SELECT2 GET OPENED ADD FADE ANIMATION TO THE SELECT2 
         document.querySelector('.select2-results').classList.remove("select2--fadeout");
         document.querySelector('.select2-results').classList.add("select2--fadein");
        
        // GET THE THE RESULT PARENT 
        // scope @global
      //   _select2Result = document.querySelector(".select2-results");

      // ADD @KEYUP EVENT TO THE SELECT2 SEARCH INPUT 
      // document.querySelector(".select2-search__field").addEventListener("keyup", function () {
      //    setTimeout(() => {
      //          let _newHeight = document.querySelector("ul.select2-results__options" ).offsetHeight;
      //          _select2Result.style.height = _newHeight + "px";
      //    }, 300);
      // });
   }

   // WHENEVER SELECT2 GET CLOSE
   $(document).on('select2:closing', function() {
      document.querySelector('.select2-results').classList.remove("select2--fadein");
      document.querySelector('.select2-results').classList.add("select2--fadeout");
      // _select2Result.style.height = "auto";
   })
   
   $('.select_').select2({ placeholder: { id: '1', text: 'Select Category' } });
   
</script>

<style>
   .to--insert { height: 54px; }
</style>

