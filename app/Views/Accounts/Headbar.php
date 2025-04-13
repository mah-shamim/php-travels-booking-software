<?php

// PARAMS TO SEND IN API
$params = array(
"api_key" => api_key,
"user_id" => $_SESSION['phptravels_client']->user_id,
);

// REQUEST TO API 
$account = POST(api_url.'profile',$params);
// pre($account->data[0]->balance);

$details = array(
    "reviews"=>"0",
    "pending_nvoices"=>"0",
    "totel_booking"=>"0",
    "balance"=>($account->data[0]->currency_id),
    "currency"=>($account->data[0]->balance),
);

$da = json_encode($details);
$dashboard_details = json_decode($da);

// CALL API GET DATA
$params = array( "api_key" => api_key, "user_id" => $_SESSION['phptravels_client']->user_id, );
$bookings = POST(api_url.'user_bookings', $params)->data;
if (isset($bookings->flights)){ $flights_bookings = $bookings->flights; } else { $flights_bookings = 0; }
if (isset($bookings->hotels)){ $hotels_bookings = $bookings->hotels; } else { $hotels_bookings = 0; }
if (isset($bookings->tours)){ $tours_bookings = $bookings->tours; } else { $tours_bookings = 0; }
if (isset($bookings->cars)){ $cars_bookings = $bookings->cars; } else { $cars_bookings = 0; }
if (isset($bookings->visa)){ $visa_bookings = $bookings->visa; } else { $visa_bookings = 0; }
$total_bookings = count($flights_bookings) + count($hotels_bookings) + count($tours_bookings) + count($cars_bookings) + count($visa_bookings);

// PENDING BOOKINGS FOR PAYMENT

// FLIGHTS
$pending_flights=array();
foreach($flights_bookings as $flights){
    if ($flights->payment_status=="unpaid"){ array_push($pending_flights,$flights); }
}

// HOTELS
$pending_hotels=array();
foreach($hotels_bookings as $hotels){
    if ($hotels->payment_status=="unpaid"){ array_push($pending_hotels,$hotels); }
}

// TOURS
$pending_tours=array();
foreach($tours_bookings as $tours){
    if ($tours->payment_status=="unpaid"){ array_push($pending_tours,$tours); }
}

// CARS
$pending_cars=array();
foreach($cars_bookings as $cars){
    if ($cars->payment_status=="unpaid"){ array_push($pending_cars,$cars); }
}

// CARS
$pending_visa=array();
foreach($visa_bookings as $visa){
    if ($visa->payment_status=="unpaid"){ array_push($pending_visa,$visa); }
}

$pending_bookings = count($pending_flights) + count($pending_hotels) + count($pending_tours) + count($pending_cars) + count($pending_visa);

?>

<div class="mt-3">
    <div class="card p-3">
        
        <!-- <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="breadcrumb-content">
                    <div class="section-heading">
                         <h6 class="mb-0 font-size-30"><?=T::hi?>, <span style="text-transform:capitalize"><strong><?=$_SESSION['phptravels_client']->first_name?> <?=$_SESSION['phptravels_client']->last_name?></strong></span> <?=T::welcomeback?></h6> 
                    </div>
                </div> 
            </div> 
            <div class="col-lg-6">
                <div class="breadcrumb-list text-right">
                    <p style="font-weight:bold;color:#fff" id="ct"></p>
                </div>< 
            </div> 
        </div>  -->


        <div class="row mt-1">

        <div class="col-lg-4 responsive-column-m user_wallet icon-box icon-layout-2 dashboard-icon-box">
        <div class="p-4 rounded-2" style="background:#ecf8f1">
            <div class="info-icon icon-element flex-shrink-0 mx-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                    <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                    <line x1="6" y1="6" x2="6.01" y2="6"></line>
                    <line x1="6" y1="18" x2="6.01" y2="18"></line>
                </svg>
            </div>
            <!-- end info-icon-->
            <p class="mb-0"><small><?=T::walletbalance?></small></p>
            <h1 class=""><small><?=$dashboard_details->balance?></small> <strong><?=$dashboard_details->currency?></strong> </h1>
        </div>
        
        </div>
        <!-- end col-lg-3 -->

        <div class="col-lg-4 responsive-column-m user_wallet icon-box icon-layout-2 dashboard-icon-box">
        <div class="p-4 rounded-2" style="background:#ebf8fe">
            <div class="info-icon icon-element flex-shrink-0 mx-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2V6l-3-4H6zM3.8 6h16.4M16 10a4 4 0 1 1-8 0"/></svg>
            </div>
            <!-- end info-icon-->
            <p class="mb-0"><small><?=T::totalbookings?></small></p>
            <h1 class=""><strong><?=$total_bookings?></strong> </h1>
        </div>
         
        </div>
        <!-- end col-lg-3 -->

        <div class="col-lg-4 responsive-column-m user_wallet icon-box icon-layout-2 dashboard-icon-box">
        <div class="p-4 rounded-2" style="background:#f1eeff">
            <div class="info-icon icon-element flex-shrink-0 mx-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <!-- end info-icon-->
            <p class="mb-0"><small><?=T::pendinginvoices?></small></p>
            <h1 class=""><strong><?=$pending_bookings?></strong> </h1>
        </div>
         
        </div>
        <!-- end col-lg-3 -->

            <!-- <div class="col-lg-6 responsive-column-m">
            <div class="icon-box icon-layout-2 dashboard-icon-box bg-white p-4 rounded-1 mb-0">
                    <div class="d-flex">
                    <div class="info-icon icon-element flex-shrink-0 mx-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>
                        </div> 
                        <div class="d-flex align-items-center">
                            <div>
                            <p class="mb-0"><small><?=T::reviews?></small></p>
                            <h5 class="info__title"><strong><?=$dashboard_details->reviews?></strong></h5>
                            </div>
                            </div>
                    </div>
                </div>
            </div>  -->


        </div> 
    </div>
</div><!-- end dashboard-bread -->

<style>
.icon-box .info-icon::before { background-color: rgb(230 230 230); }
.icon-box .info-icon { color: #fff; border-radius: 50%; background: rgb(255 255 255 / 91%); }
.info-icon svg { stroke: #000 !important; height: 26px; width: 26px; }
</style>