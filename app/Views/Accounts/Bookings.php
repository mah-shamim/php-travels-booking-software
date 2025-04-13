
<div class="container">
<div class="row g-2">

<div class="col-md-3">
<?php require "Sidebar.php";
// if (isset($meta['data']->flights)){ $flights_bookings = $meta['data']->flights; }
// if (isset($meta['data']->hotels)){ $hotels_bookings = $meta['data']->hotels; }
// if (isset($meta['data']->tours)){ $tours_bookings = $meta['data']->tours; }
// if (isset($meta['data']->cars)){ $cars_bookings = $meta['data']->cars; }
// if (isset($meta['data']->visa)){ $visa_bookings = $meta['data']->visa; }
if (isset($meta['data'])){ $booking_array = array_merge($meta['data']->flights,$meta['data']->hotels,$meta['data']->tours,$meta['data']->cars);} else { $booking_array = []; }
?>
</div>

<!-- ================================
       START DASHBOARD NAV
================================= -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- ================================
    START DASHBOARD AREA
================================= -->

    <section class="col-md-9 mt-4">
    <div class="bg-white border">
    <div class="container-fluid pt-1">

    <div class="">
    <div class="mb-3">

    <!-- FLIGHTS -->
    <div class="bg-white" id="flights">
    <div class="form-title-wrap">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h3 class="title"><?=T::bookings?></h3>
                <h3 class="title"><?//=T::flights.' '.T::bookings?></h3>
            </div>
        </div>
    </div>
    <div class="">
        <table class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                <!-- <th><input type="checkbox" onclick="checkAll(this)"></th> -->
                <th><?=T::booking?> <?=T::id?></th>
                <th><?=T::payment?></th>
                <th><?=T::booking?></th>
                <th><?=T::module?></th>
                <th><?=T::date?></th>
                <th><?=T::price?></th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!is_null($booking_array) && !empty($booking_array)){
                foreach($booking_array as &$ma)
                $tmp[] = &$ma->booking_ref_no;
                array_multisort($tmp,SORT_DESC, $booking_array);
                foreach (($booking_array) as $i => $booking){
                ?>
                <tr>
                <!-- <td><input type="checkbox" name=""></td> -->
                <td><?=$booking->booking_ref_no?></td>
                <td><?=$booking->payment_status?></td>
                <td><?=$booking->booking_status?></td>
                <td><?=$booking->module_type?></td>
                <td><?=$booking->booking_date?></td>
                <td><strong><?=$booking->currency_markup?> <?=$booking->price_markup?></strong></td>
                <td class="d-flex justify-content-center"><a href="<?=root.$booking->module_type?>/invoice/<?=$booking->booking_ref_no?>" target="_blank" class="btn btn-dark"><?=T::booking.' '.T::details?></a></td>
                </tr>
                <?php } }?>
            </tbody>
        </table>
        </div>
         
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <script>
    $('table').DataTable({     
        "aaSorting": [],
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "iDisplayLength": 5
        } 
    );

    // function checkAll(bx) {
    // var cbs = document.getElementsByTagName('input');
    // for(var i=0; i < cbs.length; i++) {
    //     if(cbs[i].type == 'checkbox') {
    //     cbs[i].checked = bx.checked;
    //     }
    // }
    // }
    </script>

    <style>
    table{ width:100%; } 
    #example_filter{ float:right; } 
    #example_paginate{ float:right; } 
    label { display: inline-flex; margin-bottom: .5rem; margin-top: .5rem; } 
    .dataTables_filter input { margin-left: 10px; } 
    table { vertical-align: middle !important; } 
    .dataTables_filter { display: flex; justify-content: end; align-items: center; } 
    .paging_simple_numbers { display: flex; justify-content: end; align-items: center; } 
    tr:hover{background-color: rgba(128,137,150,0.1);}
    .newsletter-section {display:none}
    </style>