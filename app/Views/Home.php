<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script src="<?=root?>assets/js/plugins/slick.js"></script>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<div class="mb-0" style="min-height:380px">
   <div class="hero"></div>
   
   <div class="container mb-5 mt-5 search-panel">
      <div class="hero_text">
         <h4 class="text-white"><strong><?=T::hero_text1?></strong></h4>
         <p class="text-white"><?=T::hero_text2?></p>
      </div>
      <div class="main_search rounded-F3">
         <div class="bgw rounded-3">
            <div class="p-5 hide_loading justify-content-center align-items-center featured" style="min-height:231.4px;display:flex; border-radius: 8px;">
               <div class="loading_home">
                  <div class="bg-white">
                  </div>
               </div>
            </div>
            <div class="ShowSearchBox" style="display:none">
               <script>

                  // LOADING ANIMATION FOR HOME SEARCH
                  setTimeout( function(){ 
                  $('.hide_loading').fadeOut(10)
                  $('.ShowSearchBox').fadeIn(250)
                  }  , 2000 );

               </script>
               <ul class="nav nav-tabs mb-3 d-flex gap-0 p-0" id="tab" role="tablist">
                  <?php 
                     $keys = array_column($module_status, 'order');
                     array_multisort($keys, SORT_ASC, $module_status);
                     
                     // echo "<pre>";
                     // print_r($module_status);
                     // echo "</pre>";
                     
                     foreach ($module_status as $module){
                     ?>
                  <?php if (isset($module->type)){ if ($module->type == "hotels"){ ?>
                  <li class="nav-item" role="presentation">
                     <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#tab-hotels" type="button" role="tab"
                        aria-controls="home-tab-pane" aria-selected="true">
                        <svg viewBox="0 0 24 24" width="25" height="25" fill="currentColor" class="block" data-v-ee08ca94="">
                           <path d="M14.655 3.75a.675.675 0 0 1 .67.59l.005.085h2.595A2.175 2.175 0 0 1 20.1 6.6v12.067a1.425 1.425 0 0 1-1.425 1.425H5.107c-.75 0-1.357-.607-1.357-1.357v-7.966a2.228 2.228 0 0 1 2.047-2.242v-.015a.675.675 0 0 1 1.345-.085l.005.085v.007h2.738v-1.92a2.175 2.175 0 0 1 2.047-2.17v-.004a.675.675 0 0 1 1.345-.085l.006.085h.697a.674.674 0 0 1 .675-.675Zm-4.77 6.12H5.97a.877.877 0 0 0-.545.196l-.073.067a.879.879 0 0 0-.251.63v7.972c0 .003.003.007.007.007h4.778V9.87h-.001Zm2.712-4.096h-.537a.825.825 0 0 0-.825.826v12.142h2.063v-1.305a1.425 1.425 0 0 1 1.313-1.42l.111-.005h.548c.788 0 1.425.638 1.425 1.425v1.304l1.98.001a.07.07 0 0 0 .052-.022l.017-.023.006-.03V6.6a.825.825 0 0 0-.825-.825h-3.27l-.01-.001h-2.048Zm2.673 11.588h-.547a.075.075 0 0 0-.075.075v1.304h.697v-1.304a.075.075 0 0 0-.023-.052l-.023-.017-.029-.006Zm-6.758-.99a.675.675 0 0 1 .085 1.345l-.085.005h-2.04a.676.676 0 0 1-.084-1.345l.084-.005h2.04Zm0-2.76a.675.675 0 0 1 .085 1.345l-.085.005h-2.04a.676.676 0 0 1-.084-1.345l.084-.005h2.04Zm5.46-.322a.675.675 0 0 1 .085 1.345l-.085.005h-1.364a.676.676 0 0 1-.085-1.345l.085-.005h1.364Zm3.406 0a.675.675 0 0 1 .084 1.345l-.084.005h-1.366a.676.676 0 0 1-.084-1.345l.084-.005h1.366Zm-8.866-2.438a.675.675 0 0 1 .085 1.345l-.085.005h-2.04a.676.676 0 0 1-.084-1.345l.084-.005h2.04Zm5.46-.292a.675.675 0 0 1 .085 1.345l-.085.005h-1.364a.676.676 0 0 1-.085-1.345l.085-.005h1.364Zm3.406 0a.675.675 0 0 1 .084 1.345l-.084.005h-1.366a.676.676 0 0 1-.084-1.345l.084-.005h1.366Zm-3.405-2.723a.675.675 0 0 1 .084 1.345l-.085.005h-1.364a.675.675 0 0 1-.085-1.344l.085-.006h1.364Zm3.405 0a.675.675 0 0 1 .084 1.345l-.084.005h-1.366a.675.675 0 0 1-.084-1.344l.084-.006h1.366Z" fill-rule="evenodd"></path>
                        </svg>
                        <!-- <svg fill="" width="20" height="20" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                           <path d="M 5.2892 21.9935 L 10.9031 21.9935 L 10.9031 18.8154 C 10.9031 16.7507 12.0630 15.6372 14.1508 15.6372 L 22.3861 15.6372 C 24.4739 15.6372 25.6338 16.7507 25.6338 18.8154 L 25.6338 21.9935 L 30.6446 21.9935 L 30.6446 18.8154 C 30.6446 16.7507 31.8045 15.6372 34.0084 15.6372 L 41.7333 15.6372 C 43.9373 15.6372 45.0970 16.7507 45.0970 18.8154 L 45.0970 21.9935 L 50.7108 21.9935 L 50.7108 15.6604 C 50.7108 11.5544 48.5305 9.4665 44.5402 9.4665 L 11.4598 9.4665 C 7.4930 9.4665 5.2892 11.5544 5.2892 15.6604 Z M 0 44.8668 C 0 46.0035 .7423 46.7226 1.9022 46.7226 L 3.2013 46.7226 C 4.3380 46.7226 5.0803 46.0035 5.0803 44.8668 L 5.0803 41.5726 C 5.3355 41.6422 6.0779 41.6886 6.6114 41.6886 L 49.4118 41.6886 C 49.9454 41.6886 50.6647 41.6422 50.9198 41.5726 L 50.9198 44.8668 C 50.9198 46.0035 51.6619 46.7226 52.7988 46.7226 L 54.1210 46.7226 C 55.2579 46.7226 56 46.0035 56 44.8668 L 56 31.6670 C 56 27.4682 53.6573 25.1716 49.4118 25.1716 L 6.5883 25.1716 C 2.3430 25.1716 0 27.4682 0 31.6670 Z" />
                           </svg> -->
                        <span><?=T::hotels?></span>
                     </button>
                  </li>
                  <?php } } ?>
                  <?php if (isset($module->type)){ if ($module->type == "flights"){ ?>
                  <li class="nav-item" role="presentation">
                     <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#tab-flights" type="button"
                        role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        <svg style="transform: rotate(90deg);" viewBox="0 0 24 24" width="25" height="25" fill="currentColor" class="block" data-v-ee08ca94="">
                           <path d="M5.557 5.565c.45-.45.713-.435 1.163-.06l.105.09a.75.75 0 0 1 .112.105l.255.255 3 3.293a.667.667 0 0 0 .675.195l1.988-.555a.682.682 0 0 0 .48-.75l-.045-.165a.376.376 0 0 1 0-.09l.075-.105c.067-.075.135-.158.21-.233l.113-.105c.12-.12.247-.127.33-.052l.682.682a.667.667 0 0 0 .66.173l2.37-.675a1.013 1.013 0 0 1 .982.217l.06.06h-.052l-6.105 2.82a.676.676 0 0 0-.217 1.065l3.217 3.525a.667.667 0 0 0 .75.158l1.5-.698a.188.188 0 0 1 .248.038.173.173 0 0 1 0 .217L15 18.098l-.082.097a.165.165 0 0 1-.233.045.172.172 0 0 1-.068-.195l.075-.135.69-1.5a.668.668 0 0 0-.157-.75l-3.518-3.217a.674.674 0 0 0-1.072.217l-2.85 6.09-.045-.052h-.038a1.012 1.012 0 0 1-.202-.96l.682-2.385a.667.667 0 0 0-.172-.66l-.698-.705a.187.187 0 0 1 0-.263l.12-.127a2.36 2.36 0 0 1 .24-.218l.105-.075h.18a.674.674 0 0 0 .863-.45l.57-2.01a.683.683 0 0 0-.195-.682l-3.293-3-.187-.18a1.92 1.92 0 0 1-.465-.63c-.09-.24 0-.45.3-.788h.007Zm10.373 13.5 3.082-3.075a1.5 1.5 0 0 0 .24-1.965l-.06-.09a1.5 1.5 0 0 0-1.875-.435l-1.035.473-2.25-2.475 5.25-2.438h.06a1.328 1.328 0 0 0 .33-2.205l-.044-.105-.128-.09a2.318 2.318 0 0 0-2.198-.45l-1.95.54-.42-.427a1.56 1.56 0 0 0-2.182.082 3.761 3.761 0 0 0-.75.863v.075a.668.668 0 0 0-.06.24v.165l-1.012.277-2.806-3.052-.18-.188a4.337 4.337 0 0 0-.36-.285 2.002 2.002 0 0 0-3 .15 1.995 1.995 0 0 0-.6 2.25l.045.105c.23.474.563.889.975 1.215l3 2.753-.3 1.035h-.165a.646.646 0 0 0-.307.097 3.54 3.54 0 0 0-.75.585l-.24.248a1.553 1.553 0 0 0 .06 2.047l.435.443-.563 1.987a2.325 2.325 0 0 0 .533 2.25l.052.053A1.327 1.327 0 0 0 9 19.365v-.067l2.43-5.25 2.475 2.25-.473 1.035.068-.083a1.516 1.516 0 1 0 2.453 1.778" fill-rule="evenodd"></path>
                        </svg>
                        <span><?=T::flights?></span>
                     </button>
                  </li>
                  <?php } } ?>
                  <?php if (isset($module->type)){ if ($module->type == "tours"){ ?>
                  <li class="nav-item" role="presentation">
                     <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#tab-tours" type="button" role="tab"
                        aria-controls="profile-tab-pane" aria-selected="false">
                        <svg viewBox="0 0 24 24" width="25" height="25" fill="currentColor" class="block" data-v-ee08ca94="">
                           <path d="M12 3a3.376 3.376 0 0 1 3.351 3H16.5a2.25 2.25 0 0 1 2.25 2.25v3.095A3.001 3.001 0 0 1 21 14.25v2.25a1.5 1.5 0 0 1-1.5 1.5h-.75a3 3 0 0 1-3 3h-7.5a3 3 0 0 1-3-3H4.5a1.5 1.5 0 0 1-1.496-1.388L3 16.5v-2.25a3 3 0 0 1 2.25-2.902V8.25A2.25 2.25 0 0 1 7.5 6h1.146A3.375 3.375 0 0 1 12 3Zm5.25 9-.997.75a3.75 3.75 0 0 1-2.002.742l-.001.758a.75.75 0 0 1-1.495.088l-.005-.088v-.75h-1.5v.75a.75.75 0 0 1-1.495.088l-.005-.088v-.758a3.75 3.75 0 0 1-1.838-.625l-.165-.117L6.75 12v6a1.5 1.5 0 0 0 1.388 1.496l.112.004h7.5a1.5 1.5 0 0 0 1.5-1.5v-6Zm-3 4.5a.75.75 0 0 1 .088 1.495L14.25 18h-4.5a.75.75 0 0 1-.087-1.495l.087-.005h4.5Zm4.5-3.548V16.5h.75v-2.25a1.5 1.5 0 0 0-.683-1.258l-.066-.04Zm-13.5-.001-.056.033a1.5 1.5 0 0 0-.69 1.153l-.004.113v2.25h.75v-3.549ZM16.5 7.5h-9a.75.75 0 0 0-.75.75v1.875l1.898 1.425a2.25 2.25 0 0 0 1.102.436v-.736a.75.75 0 0 1 1.495-.088l.005.088V12h1.5v-.75a.75.75 0 0 1 1.495-.088l.005.088v.736a2.25 2.25 0 0 0 .97-.344l.132-.092 1.898-1.425V8.25a.75.75 0 0 0-.663-.745L16.5 7.5Zm-4.5-3c-.911 0-1.67.65-1.84 1.493L10.158 6h3.68l-.025-.104a1.876 1.876 0 0 0-1.69-1.392L12 4.5Z"></path>
                        </svg>
                        <span><?=T::tours?></span>
                     </button>
                  </li>
                  <?php } } ?>
                  <?php if (isset($module->type)){ if ($module->type == "cars"){ ?>
                  <li class="nav-item" role="presentation">
                     <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#tab-cars" type="button" role="tab"
                        aria-controls="profile-tab-pane" aria-selected="false">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path fill-rule="evenodd" clip-rule="evenodd" d="M6.77988 6.77277C6.88549 6.32018 7.28898 6 7.75372 6H16.2463C16.711 6 17.1145 6.32018 17.2201 6.77277L17.7398 9H17H7H6.26019L6.77988 6.77277ZM2 11H2.99963C2.37194 11.8357 2 12.8744 2 14V15C2 16.3062 2.83481 17.4175 4 17.8293V20C4 20.5523 4.44772 21 5 21H6C6.55228 21 7 20.5523 7 20V18H17V20C17 20.5523 17.4477 21 18 21H19C19.5523 21 20 20.5523 20 20V17.8293C21.1652 17.4175 22 16.3062 22 15V14C22 12.8744 21.6281 11.8357 21.0004 11H22C22.5523 11 23 10.5523 23 10C23 9.44772 22.5523 9 22 9H21C20.48 9 20.0527 9.39689 20.0045 9.90427L19.9738 9.77277L19.1678 6.31831C18.851 4.96054 17.6405 4 16.2463 4H7.75372C6.35949 4 5.14901 4.96054 4.8322 6.31831L4.02616 9.77277L3.99548 9.90426C3.94729 9.39689 3.51999 9 3 9H2C1.44772 9 1 9.44772 1 10C1 10.5523 1.44772 11 2 11ZM7 11C5.34315 11 4 12.3431 4 14V15C4 15.5523 4.44772 16 5 16H6H18H19C19.5523 16 20 15.5523 20 15V14C20 12.3431 18.6569 11 17 11H7ZM6 13.5C6 12.6716 6.67157 12 7.5 12C8.32843 12 9 12.6716 9 13.5C9 14.3284 8.32843 15 7.5 15C6.67157 15 6 14.3284 6 13.5ZM16.5 12C15.6716 12 15 12.6716 15 13.5C15 14.3284 15.6716 15 16.5 15C17.3284 15 18 14.3284 18 13.5C18 12.6716 17.3284 12 16.5 12Z" fill=""/>
                        </svg>
                        <span><?=T::cars?></span>
                     </button>
                  </li>
                  <?php } } ?>
                  <?php if (isset($module->type)){ if ($module->type == "visa"){ ?>
                  <li class="nav-item" role="presentation">
                     <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#tab-visa" type="button" role="tab"
                        aria-controls="profile-tab-pane" aria-selected="false">
                        <svg width="20" height="20" height="800px" width="800px" version="1.1" id="_x32_"
                           xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                           viewBox="0 0 512 512" xml:space="preserve">
                           <g>
                              <path class="st0"
                                 d="M270.465,279.817c4.674-3.824,9.136-9.612,12.926-16.946c1.258-2.431,2.414-5.116,3.519-7.887h-26.634v29.032 c1.334-0.069,2.651-0.171,3.968-0.29C266.327,282.775,268.408,281.5,270.465,279.817z" />
                              <path class="st0"
                                 d="M216.295,200.236h35.457v-37.674h-29.626C218.743,173.636,216.643,186.485,216.295,200.236z" />
                              <path class="st0"
                                 d="M215.947,254.984h-21.51c1.64,2.015,3.417,3.969,5.27,5.822c8.286,8.303,18.382,14.745,29.643,18.748 c-3.059-3.714-5.83-7.98-8.295-12.774C219.159,263.134,217.493,259.182,215.947,254.984z" />
                              <path class="st0"
                                 d="M241.535,279.817c2.058,1.683,4.139,2.958,6.222,3.909c1.334,0.119,2.652,0.221,3.994,0.29v-29.032h-26.703 C229.476,266.058,235.281,274.701,241.535,279.817z" />
                              <path class="st0"
                                 d="M222.083,246.452h29.669v-37.682h-35.474C216.626,222.519,218.709,235.37,222.083,246.452z" />
                              <path class="st0"
                                 d="M295.706,208.769h-35.43v37.682h29.626C293.259,235.37,295.341,222.537,295.706,208.769z" />
                              <path class="st0"
                                 d="M282.644,279.554c11.269-4.003,21.365-10.445,29.676-18.748c1.853-1.853,3.604-3.807,5.27-5.822h-21.536 C292.536,264.656,288.049,273.019,282.644,279.554z" />
                              <path class="st0"
                                 d="M289.919,162.562h-29.643v37.674h35.472C295.375,186.485,293.31,173.636,289.919,162.562z" />
                              <path class="st0"
                                 d="M304.23,200.236h31.292c-0.722-13.794-4.98-26.634-11.838-37.674h-24.85 C302.029,173.908,303.899,186.69,304.23,200.236z" />
                              <path class="st0"
                                 d="M296.055,154.021h21.536c-1.666-2.023-3.417-3.96-5.27-5.813c-8.303-8.294-18.399-14.737-29.651-18.748 c3.051,3.706,5.83,7.989,8.278,12.765C292.842,145.862,294.533,149.84,296.055,154.021z" />
                              <path class="st0"
                                 d="M270.465,129.188c-2.057-1.666-4.139-2.941-6.221-3.892c-1.318-0.119-2.634-0.221-3.968-0.298v29.023h26.677 C282.55,142.938,276.729,134.295,270.465,129.188z" />
                              <path class="st0"
                                 d="M298.817,246.452h24.867c6.858-11.048,11.116-23.881,11.838-37.682h-31.249 C303.916,222.333,302.004,235.098,298.817,246.452z" />
                              <polygon class="st0"
                                 points="225.329,373.625 217.307,398.467 233.692,398.467 225.651,373.625 	" />
                              <path class="st0"
                                 d="M394.486,0h-276.97C83.453,0,55.84,27.612,55.84,61.674v388.66c0,34.054,27.613,61.666,61.676,61.666h276.97 c34.062,0,61.674-27.612,61.674-61.666V61.674C456.16,27.612,428.548,0,394.486,0z M256.009,104.712 c55.113,0,99.791,44.668,99.791,99.791c0,55.131-44.678,99.791-99.791,99.8c-55.13-0.009-99.791-44.669-99.808-99.8 C156.218,149.38,200.879,104.712,256.009,104.712z M164.037,399.615h-12.629c-0.424,0-0.629,0.204-0.629,0.62v23.694 c0,0.629-0.407,1.045-1.036,1.045h-13.259c-0.628,0-1.053-0.416-1.053-1.045v-68.881c0-0.629,0.424-1.046,1.053-1.046h27.553 c15.451,0,24.731,9.289,24.731,22.853C188.768,390.215,179.385,399.615,164.037,399.615z M256.859,424.974h-13.564 c-0.731,0-1.156-0.314-1.36-1.045l-4.079-12.417h-24.833l-3.978,12.417c-0.204,0.731-0.612,1.045-1.343,1.045H194.02 c-0.731,0-0.935-0.416-0.731-1.045l24.424-68.881c0.205-0.629,0.629-1.046,1.36-1.046h13.156c0.731,0,1.139,0.417,1.36,1.046 l24,68.881C257.794,424.558,257.59,424.974,256.859,424.974z M289.765,426.122c-11.066,0-21.807-4.386-27.348-9.706 c-0.408-0.416-0.629-1.147-0.103-1.776l7.938-9.077c0.408-0.526,1.038-0.526,1.564-0.11c4.692,3.765,11.065,7.308,18.578,7.308 c7.411,0,11.592-3.442,11.592-8.456c0-4.173-2.515-6.782-10.963-7.929l-3.757-0.519c-14.414-1.988-22.454-8.77-22.454-21.298 c0-13.045,9.824-21.705,25.156-21.705c9.399,0,18.17,2.812,24.119,7.411c0.628,0.416,0.73,0.833,0.204,1.564l-6.357,9.493 c-0.424,0.526-0.952,0.628-1.461,0.314c-5.439-3.544-10.658-5.422-16.504-5.422c-6.255,0-9.485,3.23-9.485,7.717 c0,4.071,2.924,6.68,11.049,7.836l3.772,0.518c14.601,1.981,22.336,8.661,22.336,21.502 C317.642,416.628,308.14,426.122,289.765,426.122z M351.908,426.122c-11.065,0-21.825-4.386-27.348-9.706 c-0.426-0.416-0.629-1.147-0.102-1.776l7.92-9.077c0.424-0.526,1.054-0.526,1.564-0.11c4.708,3.765,11.065,7.308,18.578,7.308 c7.41,0,11.592-3.442,11.592-8.456c0-4.173-2.499-6.782-10.964-7.929l-3.756-0.519c-14.397-1.988-22.436-8.77-22.436-21.298 c0-13.045,9.807-21.705,25.156-21.705c9.4,0,18.152,2.812,24.102,7.411c0.629,0.416,0.731,0.833,0.221,1.564l-6.374,9.493 c-0.408,0.526-0.934,0.628-1.462,0.314c-5.422-3.544-10.64-5.422-16.487-5.422c-6.272,0-9.502,3.23-9.502,7.717 c0,4.071,2.923,6.68,11.065,7.836l3.756,0.518c14.618,1.981,22.334,8.661,22.334,21.502 C379.766,416.628,370.264,426.122,351.908,426.122z" />
                              <path class="st0"
                                 d="M225.1,154.021h26.652v-29.023c-1.343,0.077-2.66,0.178-3.994,0.298c-2.082,0.951-4.164,2.226-6.222,3.892 c-4.674,3.825-9.118,9.62-12.909,16.946C227.36,148.582,226.195,151.259,225.1,154.021z" />
                              <path class="st0"
                                 d="M163.102,367.252h-11.694c-0.424,0-0.629,0.212-0.629,0.629v17.847c0,0.416,0.205,0.628,0.629,0.628h11.694 c6.459,0,10.334-3.756,10.334-9.502C173.436,371.118,169.561,367.252,163.102,367.252z" />
                              <path class="st0"
                                 d="M213.184,162.562h-24.867c-6.858,11.04-11.099,23.881-11.838,37.674h31.249 C208.085,186.681,209.997,173.908,213.184,162.562z" />
                              <path class="st0"
                                 d="M229.357,129.46c-11.252,3.994-21.357,10.454-29.651,18.748c-1.853,1.853-3.629,3.79-5.27,5.813h21.51 C219.465,144.366,223.978,135.987,229.357,129.46z" />
                              <path class="st0"
                                 d="M213.184,246.452c-3.212-11.354-5.065-24.118-5.413-37.682h-31.292c0.739,13.802,4.98,26.634,11.838,37.682 H213.184z" />
                           </g>
                        </svg>
                        <span><?=T::visa?></span>
                     </button>
                  </li>
                  <?php } } ?>
                  <?php } ?>
                  <li class="nav-item" role="presentation">
                     <a class="nav-link w-100" href="<?=root?>more-services">
                        <svg fill="" width="22" height="22" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                           <path d="M15.586,7.09l-5.5,2.5a.991.991,0,0,0-.5.5l-2.5,5.5A1,1,0,0,0,8.414,16.91l5.5-2.5a.991.991,0,0,0,.5-.5l2.5-5.5A1,1,0,0,0,15.586,7.09Zm-2.841,5.655-2.731,1.241,1.241-2.731,2.731-1.241ZM12,1A11,11,0,1,0,23,12,11.013,11.013,0,0,0,12,1Zm0,20a9,9,0,1,1,9-9A9.01,9.01,0,0,1,12,21Z"/>
                        </svg>
                        <span><?=T::more_services?></span>
                     </a>
                  </li>
               </ul>
               <div class="border rounded p-3 main_search bg-white" id="tab-group-events">
                  <div class="tab-content" id="tab">
                     <?php 
                        $keys = array_column($module_status, 'order');
                        array_multisort($keys, SORT_ASC, $module_status);
                        foreach ($module_status as $m){
                        ?>
                     <?php if (isset($m->type)){ if ($m->type == "hotels"){ ?>
                     <div class="tab-pane fade" id="tab-hotels" role="tabpanel" tabindex="0">
                        <?php require_once "./App/Views/Hotels/Search.php"; ?>
                     </div>
                     <?php } } ?>
                     <?php if (isset($m->type)){ if ($m->type == "flights"){ ?>
                     <div class="tab-pane fade" id="tab-flights" role="tabpanel" tabindex="0">
                        <?php require_once "./App/Views/Flights/Search.php"; ?>
                     </div>
                     <?php } } ?>
                     <?php if (isset($m->type)){ if ($m->type == "tours"){ ?>
                     <div class="tab-pane fade" id="tab-tours" role="tabpanel" tabindex="0">
                        <?php require_once "./App/Views/Tours/Search.php"; ?>
                     </div>
                     <?php } } ?>
                     <?php if (isset($m->type)){ if ($m->type == "cars"){ ?>
                     <div class="tab-pane fade" id="tab-cars" role="tabpanel" tabindex="0">
                        <?php require_once "./App/Views/Cars/Search.php"; ?>
                     </div>
                     <?php } } ?>
                     <?php if (isset($m->type)){ if ($m->type == "visa"){ ?>
                     <div class="tab-pane fade" id="tab-visa" role="tabpanel" tabindex="0">
                        <?php require_once "./App/Views/Visa/Search.php"; ?>
                     </div>
                     <?php } } ?>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   $(".main_search ul li:first-child button").addClass("active");
   $(".main_search .tab-content div:first-child").addClass("show active");
</script>
<!-- 
<svg style="position: relative;bottom: 0;left: 0;width: 100%;height: 50px;fill: #fff;z-index: 100;margin-top: -78px;"
class="hero-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
<path d="M0 10 0 0 A 90 59, 0, 0, 0, 100 0 L 100 10 Z"></path>
</svg> 
-->
<?php foreach ($module_status as $m){ if (isset($m->type)){ if ($m->type == "hotels"){ ?>
<?php include "App/Views/Hotels/Featured.php"; ?>
<?php } } }?>
<?php foreach ($module_status as $m){ if (isset($m->type)){ if ($m->type == "flights"){ ?>
<?php include "App/Views/Flights/Featured.php"; ?>
<?php } } }?>
<?php foreach ($module_status as $m){ if (isset($m->type)){ if ($m->type == "tours"){ ?>
<?php include "App/Views/Tours/Featured.php"; ?>
<?php } } }?>
<?php foreach ($module_status as $m){ if (isset($m->type)){ if ($m->type == "cars"){ ?>
<?php include "App/Views/Cars/Featured.php"; ?>
<?php } } }?>
<?php foreach ($module_status as $m){ if (isset($m->type)){ if ($m->type == "extra" && $m->name == 'Blog'){ ?>
<?php include "App/Views/Blog/Featured.php"; ?>
<?php } } }?>

<div data-aos="fade-up" class="home-body-container mb-3 mt-0 pb-5">
<div class="container">
   <div class="pb-1 mt-0 info-area info-bg text-center rounded-4">
      <div class="row">
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                  </svg>
               </div>
               <div class="mt-4 text-white">
                  <h4 class="h5 mb-0"><strong><?=T::hero_sub1?></strong></h4>
                  <p class="info__desc">
                     <?=T::hero_sub1_?>
                  </p>
               </div>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                     <line x1="4" y1="22" x2="4" y2="15"></line>
                  </svg>
               </div>
               <div class="mt-4 text-white">
                  <h4 class="h5 mb-0"><strong><?=T::hero_sub2?></strong></h4>
                  <p class="info__desc">
                     <?=T::hero_sub2_?>
                  </p>
               </div>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path
                        d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                     </path>
                  </svg>
               </div>
               <div class="mt-4 text-white">
                  <h4 class="h5 mb-0"><strong><?=T::hero_sub3?></strong></h4>
                  <p class="info__desc">
                     <?=T::hero_sub3_?>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>

<script>
   AOS.init();
</script>