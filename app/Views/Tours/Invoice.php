<?php 
$data=($meta['data']);
include "App/Views/Invoice_header.php";
?>

    <table class="table table-bordered">
        <thead class="bg-light">
            <tr>
                <th class="text-center"><?=T::booking?> <?=T::id?></th>
                <th class="text-center"><?=T::booking?> <?=T::reference?></th>
                <!-- <th class="text-center"><?=T::booking?> <?=T::pnr?></th> -->
                <th class="text-center"><?=T::booking?> <?=T::date?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="text-center"><?=$data->booking_id?></th>
                <th class="text-center"><?=$data->booking_ref_no?></th>
                <!-- <th class="text-center"><?=$data->pnr?></th> -->
                <th class="text-center"><?=$data->booking_date?></th>
            </tr>
        </tbody>
    </table>

    <p class="border mb-0 p-2 px-3 bg-light"><strong class="text-uppercase"><small><?=T::travellers?></small></strong></p>
    <table class="table table-bordered">
        <thead class="">
            <tr>
                <th class="text-center"><?=T::no?></th>
                <th class="text-center"><?=T::sr?></th>
                <th class="text-center"><?=T::name?></th>
             </tr>
        </thead>
        <tbody>

        <?php 

        //$travellers=(json_decode($data->guest));
        $guest=(json_decode($data->guest));

        foreach($guest as $i => $t){
        ?>
            <tr>
                <th class="text-center"><?=$i+1?></th>

                <?php if(!empty($t->age)){?>
                <th class="text-center"><?=T::child?> <?=T::age?> <?=$t->age?></th>
                <?php }else{ ?>
                <th class="text-center"><?=$t->title?></th>
                <?php } ?>

                <th class="text-center"><?=$t->first_name?> <?=$t->last_name?></th>
             </tr>
            <?php } ?>

        </tbody>
    </table>

    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?=root.'uploads/'.$data->tour_img?>" class="img-fluid">
            </div>
            <div class="col-md-8">
                <div class="card-body p-3 pb-0 px-3">
                <h5 class="card-title m-0"><strong><?=$data->tours_name?></strong></h5>
                <span class="d-flex mt-1">               
                <?php for ($i = 1; $i <= $data->tour_stars; $i++) { ?>
                    <svg class="stars" style="margin-right:-3px" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <?php } ?>
                </span>
                <p class="m-0 card-text ttc"><small class="text-muted"><?=$data->tour_location?></small></p>

                <div style="font-size:13px;line-height:20px;">

                    <?php if ($data->booking_status == "confirmed") { ?>
                    <?php if (!empty($data->location_cords)) {?>
                    <p class="m-0 py-0 card-text"><a target="_target" href="https://www.google.com/maps/?q=<?=$data->location_cords.','.$data->location_cords?>" class="text-color">
                    <strong class="text-black mr-1"><?=T::hotel?>:</strong>
                    <i class="la la-map-marker"></i> <?=T::location?> </a></p>
                    <?php } ?>
                    <?php if (!empty($data->hotel_phone)) {?>
                    <a href="tel:<?=$data->hotel_phone?>">
                    <p class="m-0 py-0 card-text">
                    <strong class="text-black mr-1"><?=T::phone?>:</strong> +<?=$data->hotel_phone?></a></p>
                    <?php } ?>
                    <?php if (!empty($data->hotel_email)) {?>
                    <p class="m-0 py-0 card-text"><a target="_target" href="mailto:<?=$data->hotel_email?>" class="text-color"><strong class="text-black mr-1"><?=T::hotel?> <?=T::email?>:</strong> <i class="la la-envelope"></i> <?=$data->hotel_email?> </a></p>
                    <?php } ?>
                    <?php if (!empty($data->hotel_website)) {?>
                    <p class="m-0 py-0 card-text"><a target="_target" href="http://<?=$data->hotel_website?>" class="text-color"><strong class="text-black mr-1"><?=T::hotel?> <?=T::website?>:</strong> <i class="la la-globe"></i> <?=$data->hotel_website?> </a></p>
                    <?php } ?>
                    <?php } ?>

                </div>

                </div>
            </div>
        </div>
    </div>

    <!-- <div class="mb-3">
        <div class="card">
        <div class="card-title px-3 pt-2 strong">
        <?=T::room?> <?=T::details?>
        </div>
        <ul class="list-group list-group-flush">
            <?php foreach(json_decode($data->room_data) as $room){ ?>
            <li class="list-group-item"><span><strong><?=T::hotels_checkin?> </strong>:</span> <?=$data->checkin?> <strong><?=T::hotels_checkout?> </strong>:</span> <?=$data->checkout?> <strong><?=T::total?> <?=T::nights?> </strong> : 
        
            <?php 
            // CANCLULATE NIGHTS FROM 2 DATES
            $earlier = new DateTime($data->checkin);
            $later = new DateTime($data->checkout);
            $nights = $later->diff($earlier)->format("%a");
            echo $nights;

            ?>

            </li>
            <li class="list-group-item"><span><strong><?=T::room?> <?=T::type?></strong>:</span> <?=$room->room_name?></li>
            <li class="list-group-item"><span><strong><?=T::room?> <?=T::quantity?></strong>:</span> <?=$room->room_qaunitity?></li>
            <?php } ?>
        
        </ul>
        </div>
    </div> -->


    <p><strong><?=T::fare_details?></strong></p>
    <table class="table table-bordered">
        <thead class="">
            <tr>
                <th class="text-start"><?=T::total?></th>
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

<?php 

 include "App/Views/Invoice_footer.php"; ?>
