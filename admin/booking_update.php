<?php
require_once '_config.php';
auth_check();
$title = T::booking .' '. T::edit;
?>
    <div class="page_head">
        <div class="panel-heading">
            <div class="float-start">
                <p class="m-0 page_title"><?=T::edit.' '. T::booking?></p>
            </div>
            <div class="float-end">
                <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a>
            </div>
        </div>
    </div>

    <div class="mt-1">

    <div class="p-3">
    <?=T::booking.' '.T::id?>
    <strong><?php 
    if (isset($_GET['booking'])){ echo $_GET['booking']; }?></strong>
    <hr>

    <?php
    if(!empty($_GET['booking_id']) && !empty($_GET['module']) && !empty($_GET['booking_status'])  && !empty($_GET['payment_status'])){
        $table_name = $_GET['module']."_bookings";
        $data = $db->update($table_name,['booking_status' => $_GET['booking_status'],'payment_status'=>$_GET['payment_status']],['booking_ref_no'=>$_GET['booking_id']]);
        REDIRECT('./bookings.php');
    }
    if(!empty($_GET['booking']) && !empty($_GET['module'])){
        $table_name = $_GET['module']."_bookings";
        $parm = [
            'booking_ref_no' => $_GET['booking'] ?? '',
        ];
        $data = $db->select($table_name, "*",$parm);
    } else{
        REDIRECT('./bookings.php');
    }

    ?>
<form class="row g-2" id="search">
    <div class="col-md-2">
        <div class="form-floating">
            <select  class="form-select booking_status" id="search_type" name="booking_status">
                <option value="">select type</option>
                <option value="pending" <?= ($data[0]['booking_status'] ?? '') === "pending" ? "selected" : "";?>><?=T::pending?></option>
                <option value="confirmed" <?= ($data[0]['booking_status'] ?? '') === "confirmed" ? "selected" : "";?>><?=T::confirmed?></option>
                <option value="cancelled" <?= ($data[0]['booking_status'] ?? '') === "cancelled" ? "selected" : "";?>><?=T::cancelled?></option>
            </select>
            <label for=""><?=T::booking?> <?=T::status?></label>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-floating">
            <select id="search_type" name="payment_status" class="form-select payment_status">
                <option value="">select type</option>
                <option value="paid" <?= ($data[0]['payment_status'] ?? '') === "paid" ? "selected" : "";?>><?=T::paid?></option>
                <option value="unpaid" <?= ($data[0]['payment_status'] ?? '') === "unpaid" ? "selected" : "";?>><?=T::unpaid?></option>
                <option value="refunded" <?= ($data[0]['payment_status'] ?? '') === "refunded" ? "selected" : "";?>><?=T::refunded?></option>
            </select>
            <label for=""><?=T::payment?> <?=T::status?></label>
        </div>
    </div>
    <input type="hidden" id="booking_id" name="booking_id" value="<?=$_GET['booking']?>">
    <input type="hidden" id="module" name="module" value="<?=$_GET['module']?>">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100 h-100 rounded-4" style="border-radius: 8px !important;"><?=T::submit?></button>
    </div>

</form>

<script>
    $("#search").submit(function() {
        event.preventDefault()
        var booking_id = $("#booking_id").val();
        var module = $("#module").val();
        var booking_status = $(".booking_status").val();
        var payment_status = $(".payment_status").val();

        window.location.href = "<?=$root?>/admin/booking_update.php?booking_id="+booking_id+"&module="+module+"&booking_status="+booking_status+"&payment_status="+payment_status;

    });
</script>
<script>
    //function booking_status(data)
    //{
    //    var booking_id = $("#booking_id").val();
    //    var module = $("#module").val();
    //    alert(data.value);
    //    window.location.href = "<?//=$root?>//booking_update.php?booking="+booking_id+"&module="+module+"&booking_status="+data.value;
    //}

</script>
</div>
<?php include "_footer.php" ?>
