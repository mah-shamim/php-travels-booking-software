<form id="tours-search" method="post">
    <div class="main_search contact-form-action">
        <div class="row g-1">
            <div class="col-md-4">
                <div class="input-wrapper">
                    <span class="label-text"><?=T::tours_destination?></span>
                    <div class="form-group">
                        <span class="la la-map-marker form-icon"></span>
                        <div class="input-items">
                        <select id="tours_city" name="city" class="city form-control" required>
                        <?php if(isset($_SESSION['tours_location'])){ ?>
                        <option value="<?=$_SESSION['tours_location']; ?>"> <?= str_replace("-", " ", $_SESSION['tours_location']); ?></option>
                        <?php } else { ?>
                        <option value=""> <?=T::searchbycity?></option>
                        <?php } ?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row g-0 items-center">
                    <div class="col-md-12">
                        <span class="label-text"><?=T::date?></span>
                        <div class="form-group">
                        <span class="la la-calendar form-icon"></span>
                        <input name="checkin" class="dp form-control form-control-lg" id="date" type="text" placeholder="" value="<?php if(isset($_SESSION['tours_date'])){ echo $_SESSION['tours_date']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>" readonly="readonly"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="input-box">
                <label class="label-text"><?=T::travellers?></label>
                <div class="form-group">
                    <span class="la la-male form-icon"></span>
                    <div class="dropdown dropdown-contain">
                        <a class="dropdown-toggle dropdown-btn travellers" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <p><?=T::travellers?> <span class="guest_tours"></span></p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-wrap">
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
            <div class="col-md-2">
                <div class="btn-search text-center">
                 <button type="submit" id="submit" class="effect" data-style="zoom-in"><i class="mdi mdi-search"></i> <?=T::search?></button>
             </div>
            </div>
        </div>
    </div>
</form>

<!-- search loading animation -->
<div class="modal-popup">
<style>#tours_load{margin:0px!important;padding-left:0px!important;padding-right: 0px !important;}</style>
<div class="modal fade"id="tours_load" tabindex="1" role="dialog" aria-hidden="ture">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:100%;height:100%;margin:0px!important">
<div class="modal-content" style="border-radius:0px;height:100vh">
<div class="text-center d-flex justify-content-center">
<img src="<?=api_url;?>uploads/global/logo.png" class="img-fluid mx-auto d-block" style="max-width:300px;position:absolute;margin:150px auto;" alt="" />
</div>
<img src="<?=root.theme_url;?>/assets/img/tour_loading.gif" class="img-fluid mx-auto d-block" style="max-width:280px; position: relative; display: flex !important; align-items: center; justify-content: center; margin-top: 200px; left: 0; right: 0; top: 26px;" alt="" />
<p class="text-center" style="padding-top: 40px; position: relative;text-transform: capitalize;"><strong class="cityname"></strong> <i class="la la-arrow-right"></i> <span class="d"></span> <?=T::hotels_adults?> <span class="a"></span> <?=T::hotels_child?> <span class="c"></span></p>
</div>
</div>
</div>
</div>

<script>

// collecting params to send for beutified URI
$("#tours-search").submit(function() {
event.preventDefault();
var city = $('#tours_city').val().toLowerCase();
var date = $('#date').val();
var language = $('#language').val();
var tours_adults = $('#tours_adults').val();
var tours_child = $('#tours_child').val();
var pagination = $('#pagination').val();
var city_trims = city.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var actionURL = '<?=strtolower($session_lang);?>' +'/'+ '<?=strtolower($session_currency);?>' +'/'+'<?=tours?>/';
var finelURL = actionURL + city_trims+'/'+date+'/'+tours_adults+'/'+tours_child;

/* append in search box */
$('.cityname').append(city);
$('.d').append(date);
$('.a').append(tours_adults);
$('.c').append(tours_child);

/* final call to URI */
window.location.href = '<?=root?>'+finelURL;
$('#tours_load').modal('show'); });
</script>