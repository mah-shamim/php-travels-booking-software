<form id="visa-submit" class="content m-0 search_box">
   <div class="row mb-0 pt-1 g-2">
      
    <div class="col-md-4">
         <div class="input-items">
            <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="10" r="3"/>
                  <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/>
               </svg>
            </div>

            <div class="form-floating select2custom">
            <select id="" name="city" class="visa_from form-control" required>
                <option value=""><?=T::selectcountry?></option>
                <?= countries_list();?>
            </select>
            <label style="margin: 5px 24px" for=""><?=T::traveling_from?></label>
            </div>
            
         </div>
         <div class="d-block d-sm-none"></div>
      </div>

      <div class="col-md-4">
         <div class="input-items">
            <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
               <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="10" r="3"/>
                  <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/>
               </svg>
            </div>

            <div class="form-floating select2custom">
            <select id="" name="city" class="visa_to form-control" required>
                <option value=""><?=T::selectcountry?></option>
                <?= countries_list();?>
            </select>
            <label style="margin: 5px 24px" for=""><?=T::traveling_from?></label>
            </div>
            
         </div>
         <div class="d-block d-sm-none"></div>
      </div>

      <div class="col-md-3">
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

<script>
// visa submit
$("#visa-submit").submit(function() {
event.preventDefault();

$("html, body").fadeOut(250);
$('.search_button').hide();
$('.loading_button').show();

var from_co = $('.visa_from').val().toLowerCase();
var to_co = $('.visa_to').val().toLowerCase();
var date = $('#date').val();
var from_c = from_co.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var to_c = to_co.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var finelURL = 'visa'+'/'+'submit'+'/'+from_c+'/'+ to_c+'/'+date;

// BACK TOP
$("html, body").animate({ scrollTop: 0 }, "fast");

// alert(finelURL);
window.location.href = '<?=root?>'+finelURL; });


$('.visa_from').select2({ placeholder: { id: '1', text: 'Select Category' } });
$('.visa_to').select2({ placeholder: { id: '1', text: 'Select Category' } });
</script>
