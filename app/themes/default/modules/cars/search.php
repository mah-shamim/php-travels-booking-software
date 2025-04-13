<form id="cars-search" method="post">
    <div class="main_search contact-form-action">
        <div class="row mb-3 g-1">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cars_type" id="cars_oneway" onclick="cars_oneway();" value="oneway" checked>
                            <label class="form-check-label" for="cars_oneway"><!--<i class="icon mdi mdi-arrow-missed"></i>--> <?=T::cars_oneway?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cars_type" id="cars_return" value="return">
                            <label class="form-check-label" for="cars_return"><!--<i class="icon mdi mdi-import-export"></i>--> <?=T::cars_return?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-1">
            <div class="col-md-5">
            <div class="row g-1">
            <div class="col-md-6">
                <div class="input-wrapper">
                    <span class="label-text"><?=T::cars_origin?></span>
                    <div class="form-group">
                        <span class="la la-map-marker form-icon"></span>
                        <div class="input-items">
                        <select id="carfrom" name="city" class="city form-control" required>
                        <?php if(isset($_SESSION['carfrom_location'])){ ?>
                        <option value="<?=$_SESSION['carfrom_location']; ?>"> <?= str_replace("-", " ", $_SESSION['carfrom_location']); ?></option>
                        <?php } else { ?>
                        <option value=""> <?=T::searchbycity?></option>
                        <?php } ?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-wrapper">
                    <span class="label-text"><?=T::cars_destination?></span>
                    <div class="form-group">
                        <span class="la la-map-marker form-icon"></span>
                        <div class="input-items">
                        <select id="carto" name="city" class="city form-control" required>
                        <?php if(isset($_SESSION['carto_location'])){ ?>
                        <option value="<?=$_SESSION['carto_location']; ?>"> <?= str_replace("-", " ", $_SESSION['carto_location']); ?></option>
                        <?php } else { ?>
                        <option value=""> <?=T::searchbycity?></option>
                        <?php } ?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <div class="col-md-3">
                <div class="row g-0 items-center">
                    <div class="col-md-6">
                        <span class="label-text"><?=T::cars_fromdate?></span>
                        <div class="form-group">
                        <span class="la la-calendar form-icon"></span>
                        <input name="" class="carfrom form-control form-control-lg border-top-r0" id="datefrom" type="text" placeholder="" value="<?php if(isset($_SESSION['carfromdate'])){ echo $_SESSION['carfromdate']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="label-text"><?=T::cars_todate?></span>
                        <div class="form-group">
                        <span class="la la-calendar form-icon"></span>
                        <input name="" class="carto form-control form-control-lg border-top-l0" id="dateto" type="text" placeholder="" value="<?php if(isset($_SESSION['cartodate'])){ echo $_SESSION['cartodate']; } else { $d=strtotime("+4 Days"); echo date("d-m-Y", $d); } ?>" readonly="readonly" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            <div class="input-box">
                <label class="label-text"><?=T::travellers?></label>
                <div class="form-group">
                    <span class="la la-male form-icon"></span>
                    <div class="dropdown dropdown-contain">
                        <a class="dropdown-toggle dropdown-btn travellers" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <p><?=T::travellers?> <span class="guest_cars"></span></p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-wrap">
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-user"></i> <?=T::adults?> <!--<small>(+12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="adults" id="cars_adults" value="<?php if(isset($_SESSION['cars_adults'])){ echo $_SESSION['cars_adults']; } else { echo "1"; } ?>" class="qtyInput_cars">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-female"></i> <?=T::child?>  <!--<small>(-12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="childs" id="cars_child" value="<?php if(isset($_SESSION['cars_childs'])){ echo $_SESSION['cars_childs']; } else { echo "0"; } ?>" class="qtyInput_cars">
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
<div class="modal fade" id="tours_load" tabindex="1" role="dialog" aria-hidden="ture">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:100%;height:100%;margin:0px!important">
<div class="modal-content" style="border-radius:0px;height:100vh">
<div class="text-center d-flex justify-content-center">
<img src="<?=api_url;?>uploads/global/logo.png" class="img-fluid mx-auto d-block" style="max-width:300px;position:absolute;margin:80px auto;" alt="" />
</div>
<img src="<?=root.theme_url;?>/assets/img/hotel_loading.gif" class="img-fluid mx-auto d-block" style="max-width:180px; position: relative; display: flex !important; align-items: center; justify-content: center; margin-top: 150px; left: 0; right: 0; top: 26px;" alt="" />
<p class="text-center" style="padding-top: 40px; position: relative;text-transform: capitalize;"><strong class="cityname"></strong> <i class="la la-arrow-right"></i> <span class="ci"></span> - <span class="co"></span> <?=T::hotels_adults?> <span class="a"></span> <?=T::hotels_child?> <span class="c"></span> <?=T::hotels_rooms?> <span class="r"></span></p>
</div>
</div>
</div>
</div>

<script>

// collecting params to send for beutified URI
$("#cars-search").submit(function() {
event.preventDefault();
var carfrom = $('#carfrom').val().toLowerCase();
var carto = $('#carto').val().toLowerCase();
var datefrom = $('#datefrom').val();
var dateto = $('#dateto').val();
var cars_type = $('input[name=cars_type]:checked').val();
var cars_adults = $('#cars_adults').val();
var cars_child = $('#cars_child').val();
var carfrom_trim = carfrom.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var carto_trim = carto.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var actionURL = '<?=strtolower($session_lang);?>' +'/'+ '<?=strtolower($session_currency);?>' +'/'+'<?=cars?>/';
var finelURL = actionURL + carfrom_trim+'/'+carto_trim+'/'+datefrom+'/'+dateto+'/'+cars_type+'/'+cars_adults+'/'+cars_child;

/* append in search box */
// $('.cityname').append(city);
// $('.d').append(date);
// $('.a').append(tours_adults);
// $('.c').append(tours_child);

/* final call to URI */
window.location.href = '<?=root?>'+finelURL;
// $('#tours_load').modal('show');
});
</script>