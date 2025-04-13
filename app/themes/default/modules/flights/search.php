<?php if(isset($_SESSION['flights_type']) == "" ) { $_SESSION['flights_type'] = "oneway"; }?>
<form autocomplete="off" class="main_search">
    <div class="row mb-3 g-1" style="justify-content: space-between;">
        <div class="col-md-4 flight_types">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trip" id="one-way" onclick="oneway();" value="oneway" <?php if ($_SESSION['flights_type'] == "oneway") { echo "checked"; } else {} ?>>
                        <label class="form-check-label" for="one-way"><!--<i class="icon mdi mdi-arrow-missed"></i>--> <?=T::flights_oneway?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trip" id="round-trip" value="return" <?php if ($_SESSION['flights_type'] == "return") { echo "checked"; } else {} ?>>
                        <label class="form-check-label" for="round-trip"><!--<i class="icon mdi mdi-import-export"></i>--> <?=T::flights_roundtrip?></label>
                    </div>
                </div>
                <!--<div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trip" id="multi-trip" onclick="multiway();" value="multi" <?php if ($_SESSION['flights_type'] == 'multiway') { echo "checked"; } else {} ?>>
                        <label class="form-check-label" for="multi-trip"> <?=T::flights_multiway?></label>
                    </div>
                </div>-->
            </div>
        </div>
        <div class="col-md-2">
            <select name="" id="flight_type" class="form-select form-select-sm">
                <?php if (isset($_SESSION['flights_class']) == '') { $_SESSION['flights_class']=strtolower(T::flights_economy); } else { } ?>
                <option value="economy" <?php if ($_SESSION['flights_class'] == strtolower(T::flights_economy)) { echo "selected"; } else { } ?>><?=T::flights_economy?></option>
                <option value="business" <?php if ($_SESSION['flights_class'] == strtolower(T::flights_business)) { echo "selected"; } else { } ?>><?=T::flights_business?></option>
                <option value="first" <?php if ($_SESSION['flights_class'] == strtolower(T::flights_first)) { echo "selected"; } else { } ?>><?=T::flights_first?></option>
            </select>
        </div>
    </div>
    <div class="row contact-form-action g-1" id="onereturn">
        <div class="col-md-6">
            <div class="row g-1">
                <div class="col-md-6">
                    <div class="input-box input-items">
                        <label class="label-text"><?=T::flights_flyingfrom?></label>
                        <div class="form-group">
                            <span class="la la-plane-departure form-icon"></span>
                            <input class="form-control autocomplete-airport" type="search" placeholder="<?=T::flights_flyingfrom?>" name="from" id="autocomplete" value="<?php if(isset($_SESSION['flights_origin'])){ echo strtoupper($_SESSION['flights_origin']); } else {} ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-box input-items">
                        <label class="label-text"><?=T::flights_todestination?></label>
                        <div class="form-group">
                            <span class="la la-plane-arrival form-icon"></span>
                            <input class="form-control autocomplete-airport focus" type="search" placeholder="<?=T::flights_todestination?>" name="to" id="autocomplete2" value="<?php if(isset($_SESSION['flights_destination'])){ echo strtoupper($_SESSION['flights_destination']); } else {} ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row g-0">
                <div class="col">
                    <div class="input-box">
                        <label class="label-text"><?=T::flights_departuredate?></label>
                        <div class="form-group">
                            <span class="la la-calendar form-icon"></span>
                            <input class="depart form-control" id="departure" name="depart" type="text" value="<?php if(isset($_SESSION['flights_departure_date'])){ echo $_SESSION['flights_departure_date']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>">
                        </div>
                    </div>
                </div>
                <div class="col" id="show">
                    <div class="input-box">
                        <label class="label-text"><?=T::flights_returndate?></label>
                        <div class="form-group">
                            <span class="la la-calendar form-icon"></span>
                            <input class="returning form-control dateright border-top-l0" name="returning" type="text" id="return" value="<?php if(isset($_SESSION['flights_returning_date'])){ echo $_SESSION['flights_returning_date']; } else { $d=strtotime("+5 Days"); echo date("d-m-Y", $d); } ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1 pr-0">
            <div class="input-box">
                <label class="label-text"><?=T::flights_passengers?></label>
                <div class="form-group">
                    <div class="dropdown dropdown-contain">
                        <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="la la-user form-icon"></i>
                        <span><span class="guest_flights d-block text-center">0</span></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-wrap">
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-user"></i> <?=T::flights_adults; ?> <!--<small>(+12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="adults" id="fadults" value="<?php if(isset($_SESSION['flights_adults'])){ echo $_SESSION['flights_adults']; } else { echo "1"; } ?>" class="qtyInput_flights">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-female"></i> <?=T::flights_childs; ?>  <!--<small>(-12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text"name="childs" id="fchilds" value="<?php if(isset($_SESSION['flights_childs'])){ echo $_SESSION['flights_childs']; } else { echo "0"; } ?>" class="qtyInput_flights">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label>
                                        <i class="la la-female"></i> <?=T::flights_infants; ?>  <!--<small>(-12)</small>-->
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="childs" id="finfant" value="<?php if(isset($_SESSION['flights_infants'])){ echo $_SESSION['flights_infants']; } else { echo "0"; } ?>" class="qtyInput_flights">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col-lg-3 -->
        <div class="col-md-2">
            <div class="btn-search text-center">
                <button type="button" id="flights-search" class="effect" data-style="zoom-in"><i class="mdi mdi-search"></i> <?=T::search?></button>
            </div>
        </div>
    </div>
    <input type="hidden" class="form-control" name="language" id="language" value="<?=$session_lang;?>">
    <div class="multi-flight-wrap" id="multiway">
        <div class="contact-form-action multi-flight-field">
            <div class="row g-1 contact-form-action multi_flight">
                <div class="col-md-6">
                    <div class="row g-1">
                        <div class="col-md-6">
                            <div class="input-box input-items">
                                <label class="label-text"><?=T::flights_flyingfrom?></label>
                                <div class="form-group">
                                    <span class="la la-plane-departure form-icon"></span>
                                    <div class="autocomplete-wrapper _1 row_1">
                                        <input class="form-control autocomplete-airport" type="search" placeholder="<?=T::flights_flyingfrom?>" name="from" id="autocomplete3" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-box input-items">
                                <label class="label-text"><?=T::flights_todestination?></label>
                                <div class="form-group">
                                    <span class="la la-plane-arrival form-icon"></span>
                                    <div class="autocomplete-wrapper _1 row_2">
                                        <input class="form-control autocomplete-airport" type="search" placeholder="<?=T::flights_todestination?>" name="to" id="autocomplete4" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="input-box">
                                <label class="label-text"><?=T::flights_departuredate?></label>
                                <div class="form-group">
                                    <span class="la la-calendar form-icon"></span>
                                    <input class="dp form-control" id="departure" name="depart" type="text" value="26-02-2021">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col-lg-3 -->
                <div class="col-md-3 d-flex flight-remove" style="padding-left:10px;align-items:center">
                 <label class="label-text">&nbsp;</label>
                 <button class="btn multi-flight-remove d-flex align-items-center justi-content-center" type="button"><i class="la la-remove"></i></button>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-3 pr-0">
                <div class="form-group">
                    <button class="theme-btn add-flight-btn margin-top-20px w-100" type="button"><i class="la la-plus mr-1"></i><?=T::flights_addanotherflight?></button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- search loading animation -->
<div class="modal-popup">
<style>#flights_load{margin:0px!important;padding-left:0px!important;padding-right: 0px !important;}</style>
<div class="modal fade" id="flights_load" tabindex="1" role="dialog" aria-hidden="ture">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:100%;height:100%;margin:0px!important">
<div class="modal-content" style="border-radius:0px;height:100vh">
<div class="text-center d-flex justify-content-center">
<img src="<?=api_url;?>uploads/global/logo.png" class="img-fluid mx-auto d-block" style="max-width: 300px;;position:absolute;margin:50px auto;background:transparent" alt="" />
</div>
<div id="loading_flight" class="loading-results-globe-wrapper" style="background:#fff;height:80vh;overflow:hidden;border-radius:15px">
<div class="loading-results-globe ski-svg-responsive ski-svg-globe-geometry-loadingpage" style="margin-top:-200px">
<span class="origin"><small><?=T::flights_flyingfrom?></small>
<div class="clear"></div>
<strong><span class="flying_from"></span>
<div class="clear"></div>
</strong><small class="date"></small></span>
<span class="destination-prefix"><?=T::flights_todestination?></span> <span class="destination flying_to" id=""></span>
<div class="loading-results-track">
<div class="loading-results-track-progress is-active"></div>
<div class="loading-results-progress is-active"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<script>

// show loading model of flights
function load_modal() {
var flying_from = $("#autocomplete").val();
$('.flying_from').append(flying_from);
var flying_to = $("#autocomplete2").val();
$('.flying_to').append(flying_to);
var date = $("#departure").val();
$('.date').append(date);
$('#flights_load').modal('show'); };

// URL beurify and search action
$("#flights-search").click(function() {
var trip_type = $('input[name=trip]:checked').val();
var origin = $("#autocomplete").val().toLowerCase();
var destination = $("#autocomplete2").val().toLowerCase();
var cdeparture = $("#departure").val();
var returnn = $("#return").val();
var flight_type = $("#flight_type").val().toLowerCase();
var adult = $("#fadults").val();
var children  = $("#fchilds").val();
var infant  = $("#finfant").val();
var language = $('#language').val();
var origin_split = origin.split(' ');
var origin = origin_split[0];
var destination_split = destination.split(' ');
var destination = destination_split[0];
if(origin == ''){
alert('<?=T::flights_pleasefilloutorigin?>');
$('#autocomplete').focus();
}else if(destination == ''){
alert('<?=T::flights_pleasefilloutdestination?>');
$('#autocomplete2').focus();

// main params of get url
}else{ var actionURL = language +'/'+ '<?=strtolower($session_currency);?>' +'/'+'<?=flights?>/';

// for oneway
if (trip_type == 'oneway') { var finelURL = actionURL +origin+'/'+destination+'/'+trip_type+'/'+flight_type+'/'+cdeparture+'/'+adult+'/'+children+'/'+infant;
window.location.href = '<?=root?>'+finelURL;
load_modal();

// for return
}else if(trip_type == 'return'){ var finelURL = actionURL +origin+'/'+destination+'/'+trip_type+'/'+flight_type+'/'+cdeparture+'/'+returnn+'/'+adult+'/'+children+'/'+infant;
window.location.href = '<?=root?>'+finelURL;
load_modal();

// for multi way
}else{ var finelURL = actionURL +origin+'/'+destination+'/'+cdeparture+'/'+origin+'/'+destination+'/'+cdeparture+'/'+origin+'/'+destination+'/'+cdeparture+'/'+trip_type+'/'+flight_type+'/'+adult+'/'+children+'/'+infant;
window.location.href = '<?=root?>'+finelURL;
load_modal();
}}});

/* oneway */
document.getElementById("one-way").onclick = function() {
document.getElementById("show").className = "col hide";
document.getElementById("onereturn").className = "row g-1 contact-form-action";
document.getElementById("multiway").className = "";
document.getElementById("departure").className = "depart form-control"; }

/* return */
document.getElementById("round-trip").onclick = function() {
document.getElementById("show").className = "col show";
document.getElementById("onereturn").className = "row g-1 contact-form-action";
document.getElementById("multiway").className = "";
document.getElementById("departure").className = "depart form-control dateleft border-top-r0"; }

/* multiway */
/*document.getElementById("multi-trip").onclick = function() {
document.getElementById("multiway").className = "multi-flight-wrap show";
document.getElementById("show").className = "col hide";
document.getElementById("departure").className = "depart form-control"; }*/
</script>

<?php  if ($_SESSION['flights_type'] == 'return') { ?>
<script>
document.getElementById("show").className = "col show";
document.getElementById("onereturn").className = "row contact-form-action g-1";
document.getElementById("multiway").className = "";
document.getElementById("departure").className = "depart form-control dateleft";
</script>
<?php } else { } ?>

<?php  if ($_SESSION['flights_type'] == 'multiway') { ?>
<script>
document.getElementById("multiway").className = "multi-flight-wrap show";
document.getElementById("show").className = "col hide";
document.getElementById("departure").className = "depart form-control";
</script>
<?php } else { } ?>

<style>
.hide { display: none; }
.show { display: block !important; }
#show,#multiway { display: none; }
</style>