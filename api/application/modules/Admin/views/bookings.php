<?php
include "dashboard/booking_status.php";
?>

<div style="padding:15px">
<div class="backdrop">
<div class="panel panel-default">
    <div class="panel-heading">Bookings View</div>

    <div class="row" style="padding: 12px 0; border-bottom: 3px solid #efefef;">
    <div class="col-xs-6 col-sm-6 col-md-2 pad">
        <a href="<?php echo base_url().$this->uri->segment(1);?>/quickbooking?service=none" class="btn btn-success btn-block" style="text-transform:initial">
            <div class=""><i class="fa fa-dashboard fa-lg"></i> &nbsp; Add Booking</div>
        </a>
    </div>
    </div>

    <div class="panel-body">
        <table class="xcrud-list table table-striped table-hover" id="data">
            <thead>
                <tr class="xcrud-th">
                    <!--<th><input onchange="select_all_data(this)" class="all" type="checkbox" value="" id="select_all"></th>-->
                    <th class="xcrud-num" style="width: 5px !important;">#</th>
                    <th class="xcrud-column xcrud-action">ID</th>
                    <th class="xcrud-column xcrud-action">Ref No.</th>
                    <th class="xcrud-column xcrud-action">Customer</th>
                    <th class="xcrud-column xcrud-action">Module</th>
                    <th class="xcrud-column xcrud-action">Supplier</th>
                    <th class="xcrud-column xcrud-action">Booked From</th>
                    <th class="xcrud-column xcrud-action">Date</th>
                    <th class="xcrud-column xcrud-action">Total</th>
                    <th class="xcrud-column xcrud-action text-center">Booking Status</th>
                    <th class="xcrud-column xcrud-action text-center">Payment Status</th>
                    <th class="xcrud-column xcrud-action"></th>
                    <th class="xcrud-column xcrud-action"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($all_booking)) {
                    $count =1;  foreach ($all_booking as $booking):?>
                <tr class="xcrud-row xcrud-row-0">
                    <!--<td><input class="checkboxcls" type="checkbox" value="1"></td>-->
                    <td class="xcrud-current xcrud-num"><?=$count?></td>
                    <td><?=$booking->booking_id?></td>
                    <td><?=$booking->booking_ref_no?></td>
                    <td><?=$booking->ai_first_name?></td>
                    <td><?=$booking->module?></td>
                    <td><?=$booking->supplier_name?></td>
                    <td><?=$booking->booking_from?></td>
                    <td><?=pt_show_date_php($booking->booking_date)?></td>
                    <td><?=$booking->booking_curr_code?> <strong><?=$booking->total_price?></strong></td>
                    <td class="text-center">
                        <select name="" id="booking_status" class="form-control status" onchange="update_booking_status(this);">
                            <option value="<?=$booking->booking_id.','.$booking->module?>,<?=$booking->booking_status?>"><?=$booking->booking_status?></option>
                            <?php
                                $option_arr = ['Pending','Confirmed','Cancelled'];
                                foreach ($option_arr as $key => $value) {
                                if (strtolower($value) != strtolower($booking->booking_status)) {?>
                            <option class="<?= $value;?>" value="<?=$booking->booking_id.','.$booking->module.','.$value?>"><?= $value; ?></option>
                            <?php } } ?>
                        </select>
                    </td>
                    <td class="text-center">
                        <select name="" id="payment_status" class="form-control status" onchange="update_paybooking_status(this);" <?php if ($isSuperAdmin) {} else {echo "disabled";} ?> >
                            >
                            <option value="<?=$booking->booking_id.','.$booking->module?>,<?=$booking->booking_payment_status?>"><?=$booking->booking_payment_status?></option>
                            <?php
                                $option_arr2 = ['Unpaid','Paid','Refunded','Disputed'];
                                foreach ($option_arr2 as $k => $val) {
                                if (strtolower($val) != strtolower($booking->booking_payment_status)) {?>
                            <option class="<?= $val; ?>" value="<?=$booking->booking_id.','.$booking->module.','.$val?>"><?= $val; ?></option>
                            <?php } } ?>
                        </select>
                    </td>
                    <td><a class="btn btn-primary" style="padding: 6px 24px" target="_blank" href="<?=base_url('../');?><?=$booking->module?>/booking/invoice/<?=$booking->booking_ref_no?>/<?=$booking->booking_id?>" style="cursor: pointer;"><i class="fa fa-file"></i> &nbsp; Invoice</a></td>
                    <?php if ($isSuperAdmin) {?>
                    <td><button class="btn btn-danger" onclick='del("<?php echo $booking->booking_id;?>" , "<?php echo $booking->module; ?>")' style="padding: 6px 24px; min-width: 60px;" style="cursor: pointer;"><i class="fa fa-times"></i></button></td>
                    <?php } ?>
                    <!--<td class="xcrud-current xcrud-actions xcrud-fix"><span class="btn-group"><a class="xcrud-action btn btn-info btn-xcrud" title="View" href="javascript:;" data-primary="1" data-task="view"><i class="fa fa-search"></i></a>
                        <a class="xcrud-action btn btn-warning btn-xcrud"><i class="fa fa-edit"></i></a>
                        <a class="xcrud-action btn btn-danger btn-xcrud"> <i class="fa fa-times"></i></a>
                        </span></td>-->
                </tr>
                <?php $count++; endforeach;}?>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
</div>
</div>
</div>



<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script>
function update_booking_status(val)
{
        var values = val.value;
        var values_arr = values.split(',');
        let b_id = values_arr[0];
        let b_module = values_arr[1];
        let b_status = values_arr[2];
        let url = "<?=base_url($this->uri->segment(1).'/bookings/update_booking_status')?>";
        // alert(url);
$.ajax({
    url: url,
    type: 'POST',
    data: {booking_id: b_id, module:b_module, booking_status:b_status},
    dataType: 'JSON',
    success: function(data) {
            if (data) {
                    // alert('booking status updated successfully!');
                    location.reload();
            }
    }
});

}

function update_paybooking_status(val)
{
        var values = val.value;
        var values_arr = values.split(',');
        let b_id = values_arr[0];
        let b_module = values_arr[1];
        let b_paystatus = values_arr[2];
        let url = "<?=base_url('admin/bookings/update_paybooking_status')?>";
$.ajax({
        url: url,
        type: 'POST',
        data: {booking_id: b_id, module:b_module, update_paybooking_status:b_paystatus},
        dataType: 'JSON',
        success: function(data) {
        if (data) {
                // alert('booking payment status updated successfully!');
                location.reload();
            }}
        });
}
   
$(document).ready(function() {
$('#data').DataTable();
});

function del(id,main_module){
let del_url = "<?=base_url('admin/bookings/booking_del')?>";
if (confirm("Are you sure to delete?")) {
$.ajax({
    url: del_url,
    type: 'POST',
    data: {booking_id: id, module:main_module},
    dataType: 'JSON',
    success: function(data) {
    if (data) {
    location.reload();
    }}
}); } }

$('#payment_status option[value=<?=$booking->booking_payment_status?>]').attr('selected','selected');
$('#booking_status option[value=<?=$booking->booking_status?>]').attr('selected','selected');
</script>

<style>
#data .btn { padding: 6px 24px; min-width: 126px; font-weight: bold; letter-spacing: 1px;border:transparent }
.paid { background-color: #81c94a !important; }
.unpaid { background-color: #ff7500 !important; }
.confirmed { background-color: #0096ff !important; }
.pending { background-color: #ea5395 !important; }
.cancelled { background-color: #f45454 !important; }
.disputed { background-color: #000 !important; color: #fff !important }
.status { padding: 2px 0px 0px 12px; text-transform: uppercase; font-weight: 600; height: 28px !important;}
table.dataTable thead th, table.dataTable thead td {border-bottom: transparent }
table.dataTable.no-footer { border-bottom: transparent }
table{font-size:14px;}
select { font-size: 12px !important; }
.panel-foot{display:none}
.pane {padding-top: 12px;}
</style>
