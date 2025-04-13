<div class="form-content">

<div class="card mb-3">
    <div class="row g-0 p-3">
     <?php require "partcials/flight.php" ?>
    </div>
</div>

<!-- end form-content -->
    <div class="card mt-2 mb-3">
        <div class="card-title px-3 pt-2 strong">
            <?=T::guest?> <?=T::information?>
        </div>
        <div class="card-body">
            <?php
            $travellers = ( json_decode($booking->booking_guest_info));
            foreach ($travellers as $index => $guest ) {
                ?>
                <div class="row">
                    <div class="col-md-5">
                        <strong><?=T::guest?> <?=$index+1?> - Title</strong> <?=$guest->title?>
                        <div class="clear"></div>
                        <strong><?=T::nationality?></strong> <?=$guest->nationality?>
                        <div class="clear"></div>
                        <strong><?=T::passport_no?></strong> <?=$guest->passport?>
                    </div>
                    <div class="col-md-7">
                    <strong><?=T::full_name?></strong> <?=$guest->first_name?> <?=$guest->last_name?>
                    <div class="clear"></div>
                        <strong><?=T::date_of_birth?></strong> <?=$guest->dob_day?>-<?=$guest->passport_month?>-<?=$guest->dob_year?>
                        <div class="clear"></div>
                        <strong><?=T::passport_expiry?></strong> <?=$guest->passport_day?>-<?=$guest->passport_month?>-<?=$guest->passport_year?>
                    </div>
                </div>
                <hr>
            <?php } ?>
        </div>
    </div>

    <div class="mb-3">
        <div class="card">
            <div class="card-title px-3 pt-2 strong">
                <?=T::bookingdetails?>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span><strong><?=T::adults?></strong>: <?=$booking->booking_adults?> </span> <span><strong><?=T::child?></strong>: <?=$booking->booking_childs?></span> - <span><strong><?=T::infants?></strong>:</span> <?=$booking->booking_childs?></li>
                <li class="list-group-item"><span><strong><?=T::bookingtax?></strong>:</span> <?=$booking->booking_curr_code?> <?=$booking->booking_tax?></li>
                <li class="list-group-item"><span><strong><?=T::depositnow?> <?=T::price?></strong>:</span> <?=$booking->booking_curr_code?> <?=$booking->booking_deposit?></li>
                <hr style="margin:0">
                <li style="background:#f1f4f8" class="list-group-item"><span class=""><strong><?=T::total?> <?=T::price?></strong>:</span> <?=$booking->booking_curr_code?> <?=$booking->total_price?></li>
            </ul>
        </div>
    </div>

    <div class="btn-box px-1">
    <div class="row g-2">
    <?php if ($booking->booking_cancellation_request == "1") { ?>
     <div class="alert alert-danger"><?=T::cancellationrequestmsg?></div>
    <?php } ?>
    <div class="col-md-4">
        <?php if ($booking->booking_cancellation_request == "0") { ?>
            <form onSubmit="if(!confirm('<?=T::areyousureforcancellationofthisbooking?>')){return false;}" action="<?=root?>hotels/cancellation" method="post">
                <input type="hidden" name="booking_no" value="<?=$booking->booking_ref_no?>" />
                <input type="hidden" name="booking_id" value="<?=$booking->booking_id?>" />
                <input type="submit" value="<?=T::requestcancellation?>" class="btn btn-outline-danger btn-block">
            </form>
        <?php } ?>
        <script>
         function show_alert() { if(!confirm("<?=T::thisrequestwillsubmitcancellation?>")) { return false; } this.form.submit(); }
        </script>
        </div>
        <div class="col-md-3 float-right text-right">
        <button class="btn btn-outline-success btn-block text-right" id="download"><i class="la la-print"></i> <?=T::downloadinvoice?></button>
        </div>
        </div>
    </div>
    </div>