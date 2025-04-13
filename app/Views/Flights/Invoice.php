<?php 
$data=($meta['data']);
include "App/Views/Invoice_header.php";
?>

    <table class="table table-bordered">
        <thead class="bg-light">
            <tr>
                <th class="text-center"><?=T::booking?> <?=T::id?></th>
                <th class="text-center"><?=T::booking?> <?=T::reference?></th>
                <th class="text-center"><?=T::pnr?></th>
                <th class="text-center"><?=T::booking?> <?=T::date?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="text-center"><?=$data->booking_id?></th>
                <th class="text-center"><?=$data->booking_ref_no?></th>
                <th class="text-center"><?=$data->pnr?></th>
                <th class="text-center"><?=$data->booking_date?></th>
            </tr>
        </tbody>
    </table>

    <p class="border mb-0 p-2 px-3"><strong class="text-uppercase"><small><?=T::travellers?></small></strong></p>
    <table class="table table-bordered">
        <thead class="bg-light">
            <tr>
                <th class="text-center"><?=T::no?></th>
                <th class="text-center"><?=T::sr?></th>
                <th class="text-center"><?=T::name?></th>
                <th class="text-center"><?=T::passport?> <?=T::no?>.</th>
                <th class="text-center"><?=T::passport?> <?=T::issue?> - <?=T::expiry?></th>
                <th class="text-center"><?=T::dob?></th>
            </tr>
        </thead>
        <tbody>

        <?php 
        $travellers=(json_decode($data->guest));
        foreach($travellers as $i => $t){
        ?>
            <tr>
                <th class="text-center"><?=$i+1?></th>
                <th class="text-center"><?=$t->title?></th>
                <th class="text-center"><?=$t->first_name?> <?=$t->last_name?></th>
                <th class="text-center"><?=$t->passport?></th>
                <th class="text-center"><?=$t->passport_issuance_day?><small>/</small><?=$t->passport_issuance_month?><small>/</small><?=$t->passport_issuance_year?> -- <?=$t->passport_day_expiry?><small>/</small><?=$t->passport_month_expiry?><small>/</small><?=$t->passport_year_expiry?></th>
                <th class="text-center"><?=$t->dob_day?><small>/</small><?=$t->dob_month?><small>/</small><?=$t->dob_year?></th>
            </tr>
            <?php } ?>

        </tbody>
    </table>

    <p class="border mb-0 p-2 px-3"><strong class="text-uppercase"><small><?=T::flights?></small></strong></p>

    <?php $segment = json_decode($data->routes);

    $count = 0;
    foreach($segment->segments as $i => $route) {
    $count++;
    
    foreach($route as $l => $r) {

        if($count == 1){
            $flight_type = T::oneway;
        }else{
            $flight_type = T::return;
        }
    ?>

    <div class="mb-4">

    <div class="border">
    <div class="row g-1 p-2">
    <div class="col-md-1 d-flex align-items-center col-3">
        <img style="width:50px" src="<?=airline_logo($r->img)?>" class="px-2" alt="">
    </div>
    <div class="col-md-7 col-9">
        <div class="p-2 lh-sm mt-2">
        <small class="mb-0"><strong class="border p-2 rounded mt-5 mx-3"><?=$flight_type?> <?=$r->flight_no?></strong></small>
        <small class="mb-0"><?=$r->airline?></small>
        </div>            
    </div>
    <div class="col-md-3 col-9">
        <div class="p-2 lh-sm">
        <small class="mb-0"><strong><?=T::cabin_baggage?>: <?=$r->cabin_baggage?></strong></small>
        <small class="d-block mb-0"><?=T::baggage?>: <?=$r->baggage?></small>
        </div>            
    </div>
    <div class="col-md-1 d-flex align-items-center col-3">
    <svg  fill="#393e4b" height="35px" width="35px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"> <g> <g> <path d="M389.742,77.553H329.99V30.417h15.146V0H166.865v30.417h15.146v47.135h-59.752c-19.059,0-34.566,15.506-34.566,34.566 V438.41c0,19.059,15.506,34.566,34.566,34.566h26.268V512h30.417v-39.024h154.114V512h30.417v-39.024h26.268 c19.059,0,34.566-15.506,34.566-34.566V112.119C424.308,93.058,408.802,77.553,389.742,77.553z M179.349,408.086h-30.417V229.638 h30.417V408.086z M212.426,30.417h87.146v47.135h-87.146V30.417z M240.589,408.086h-30.417V229.638h30.417V408.086z M301.829,408.086h-30.417V229.638h30.417V408.086z M316.834,190.41H195.166v-46.294h121.669V190.41z M363.068,408.086h-30.417 V229.638h30.417V408.086z"/> </g> </g> </svg>
    </div>
    </div>
    </div>

    <div class="p-3 bg-light rounded-3 border" style="border-top-left-radius: 0px !important; border-top-right-radius: 0px !important;">
        <div class="position-relative">
            <!-- <div class="position-absolute border bg-light invoice--time-line" style="width: 1px; height: 53px; top: 37px; left: 23px; border-color: #000 !important;"></div> -->
            <div class="position-absolute border bg-light invoice--time-line"></div>
            <div class="d-flex align-items-center">
                <span class="position-relative mb-2 me-4 align-self-start">
                <?=circle_icon()?>
                </span>
                <div class="d-flex flex-wrap">
                <div class="flight--ddt fw-bold d-flex align-items-center gap-2 flex-wrap">
                    <?=calender_icon()?>
                    <span><?=$r->departure_date?></span>
                    <?=clock_icon()?>
                    <span class="me-3 d-flex align-items-center gap-2">
                    <?=$r->departure_time?>
                    </span>
                </div>
                <small class="d-sm-inline"><?=T::depart_from?> <b><?=$r->departure_code?></b> (<?=$r->departure_airport?>)</small>
                </div>
            </div>
            <div class="mt-1 h6" style="margin-left: 42px; font-size: 14px;">
                <span><?=T::flights_tripduration?></span>
                <span><?=$r->duration_time?></span>
            </div>
            <div class="d-flex align-items-center mt-2">
                <span class="me-4">
                <?=circle_icon()?>
                </span>
                <div class="d-flex flex-wrap">
                <div class="flight--ddt fw-bold d-flex align-items-center gap-2 flex-wrap">
                    <?=calender_icon()?>
                    <span><?=$r->arrival_date?></span>
                    <div>
                    <?=clock_icon()?>
                    </div>
                    <span class="me-3 d-flex align-items-center gap-2">
                    <?=$r->arrival_time?> </span>
                </div>
                <small class="d-sm-inline"><?=T::arrive_at?> <b><?=$r->arrival_code?></b> ( <?=$r->arrival_airport?> )</small>
                </div>
            </div>
            </div>
    
        </div>
    </div>
    <?php } } ?>

    <p><strong><?=T::fare_details?></strong></p>
    <table class="table table-bordered">
        <thead class="">
            <tr>
                <th class="text-start"><?=T::ticket_fare?></th>
                <th class="text-end"><?=($data->currency_markup)?> <?=($data->price_markup)?></th>
            </tr>
            <tr>
                <th class="text-start"><?=T::gst?></th>
                <th class="text-end">% 0</th>
            </tr>
            <tr>
                <th class="text-start"><?=T::vat?></th>
                <th class="text-end">% 0</th>
            </tr>
            <tr>
                <th class="text-start"><?=T::tax?></th>
                <th class="text-end">% 0</th>
            </tr>
            <tr class="bg-light">
                <th class="text-start"><strong><?=T::total?></strong></th>
                <th class="text-end"><strong><?=($data->currency_markup)?> <?=($data->price_markup)?></strong></th>
            </tr>
        </thead>
    </table>

<?php include "App/Views/Invoice_footer.php"; ?>
<style>
    .invoice--time-line {
        width: 1px;
        height: 53px;
        top: calc(16px + 14px);
        left: 7px;
        border-color: #000 !important;
    }


    @media only screen and (min-width: 320px) {
        .invoice--time-line {
            width: 1px;
            height: calc(100% - 71px);
            top: calc(16px + 5px);
            left: 7px;
            border-color: #000 !important;
        }    
    }
    @media only screen and (min-width: 345px) {
        .invoice--time-line {
        height: calc(100% - 55px);
        }
    }
    @media only screen and (min-width: 475px) {
        .invoice--time-line {
            height: calc(100% - 40px);
        }
    }
    @media only screen and (max-width: 767px) {
        table {
            font-size: 9px;
        }
        .table>:not(caption)>*>* {
            padding: 0;
        }
    }
</style>