<div class="panel panel-default loadeffect">
<!--<div class="panel-heading">Bookings 10/11/2021 - 10/12/2021 </div>-->
<div class="panel-body">
<div class="row text-center panels">
<div class="col-md-6 text-left">
<div class="pane">
<div class="col-md-12"><strong>Booking Status</strong></div>
<div class="col-md-4"><a href="<?=base_url($this->uri->segment('1').'/bookings/confirmed')?>"><div class="panel panel-default" style="background:#5dc560"><div class="panel-body"><i class="fa fa-check-circle"></i><strong>Confirmed</strong></div><div class="panel-foot"><?=$confirmedCount?></div></div></a></div>
<div class="col-md-4"><a href="<?=base_url($this->uri->segment('1').'/bookings/pending')?>"><div class="panel panel-default" style="background:#ea5395"><div class="panel-body"><i class="fa fa-clock-o"></i><strong>Pending</strong></div><div class="panel-foot"><?=$pendingCount?></div></div></a></div>
<div class="col-md-4"><a href="<?=base_url($this->uri->segment('1').'/bookings/cancelled')?>"><div class="panel panel-default" style="background:#ff2258"><div class="panel-body"><i class="fa fa-times-circle-o"></i><strong>Cancelled</strong></div><div class="panel-foot"><?=$cancelledCount?></div></div></a></div>
<div class="clearfix"></div>
</div>
</div>
<div class="col-md-6 text-left">
<div class="pane">
<div class="col-md-12"><strong>Payment Status</strong></div>
<div class="col-md-4"><a href="<?=base_url($this->uri->segment('1').'/bookings/paid')?>"><div class="panel panel-default" style="background:#0089ff"><div class="panel-body"><i class="fa fa-credit-card"></i><strong>Paid</strong></div><div class="panel-foot"><?=$paidCount?></div></div></a></div>
<div class="col-md-4"><a href="<?=base_url($this->uri->segment('1').'/bookings/unpaid')?>"><div class="panel panel-default" style="background:#63c7c2"><div class="panel-body"><i class="fa fa-calendar-times-o"></i><strong>Unpaid</strong></div><div class="panel-foot"><?=$unpaidCount?></div></div></a></div>
<div class="col-md-4"><a href="<?=base_url($this->uri->segment('1').'/bookings/refunded')?>"><div class="panel panel-default" style="background:#ff8100"><div class="panel-body"><i class="fa fa-thumbs-o-down"></i><strong>Refunded</strong></div><div class="panel-foot"><?=$refundedCount?></div></div></a></div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
<style>
.bookings .panel i { font-size: 26px }
.pane .panel { border-radius: 5px; color: #fff; }

.panel-foot { padding: 10px 15px; background-color: rgb(0 0 0 / 15%);border-top: 1px solid rgb(43 43 43 / 14%); }
 a:hover{text-decoration:none}
.panels .panel { color:#fff;font-size: 16px; border-radius: 4px; }
.panels i { font-size: 22px; margin-right: 10px; }
.pane { border: 1px solid rgb(0 0 0 / 25%); padding-bottom: 18px; border-radius: 4px; }
.pane strong { margin-top: 5px;padding:10px 0}
</style>