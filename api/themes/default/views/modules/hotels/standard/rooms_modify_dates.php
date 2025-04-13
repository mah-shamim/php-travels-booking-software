<form action="" name="fModifySearch" method="GET" >

<div class="tab-content" id="myTabContent3">
        <div class="tab-pane fade show active" id="one-way" role="tabpanel" aria-labelledby="one-way-tab">
            <div class="contact-form-action">
                <div class="row align-items-center">

                    <div class="col-lg-5 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('07'); ?> / <?php echo trans('09'); ?></label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input id="HotelsDateEnd" class="form-control datehotels" type="text" name="daterange" placeholder="<?php echo trans('0472'); ?>" value="<?php echo $search->departure_date; ?>" vlue="<?php echo $search->arrival; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="input-box">
                            <label class="label-text"><?=trans('0528')?></label>
                            <div class="form-group">
                                <div class="dropdown dropdown-contain">
                                    <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        <span><?=trans('0528')?> <span class="qtyTotal guestTotal">0</span></span>
                                        <span class="hiphens font-size-20 mx-1">-</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-wrap">
                                        <div class="dropdown-item">
                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                               <label><?php echo trans('010');?></label>
                                                <div class="qtyBtn d-flex align-items-center">
                                                    <input type="text" name="qtyInput" value="0">
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="adults" readonly value="<?=$search->hoteladult?>" placeholder="<?=$search->hoteladult?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-item">
                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                <label><?php echo trans('011');?></label>
                                                <div class="qtyBtn d-flex align-items-center">
                                                    <input type="text" name="qtyInput" value="0">
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="children"  readonly value="<?=$search->hotelchildren?>" placeholder="<?=$search->hotelchildren?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end dropdown -->
                            </div>
                        </div>
                    </div>

                <div class="col-lg-2 pl-0">
                <button type="submit"  class="theme-btn w-100 text-center margin-top-20px">
                <?php echo trans('012'); ?>
                </button>
                </div>
                </div>

            </div>
        </div><!-- end tab-pane -->
    </div>



<input type="hidden" name="hotelname" value="<?php echo $hotelname; ?>" />
<input type="hidden" name="city" value="<?php echo $city; ?>" />
</form>
<script>
$("form[name=fModifySearch]").submit(function (e) {
e.preventDefault();
var values = {};
$.each($(this).serializeArray(), function(i, field) {
values[field.name] = field.value;
});
redirectUrl = values.city+'/'+values.hotelname+'/'+values.checkin.replace(/\//g,'-')+'/'+values.checkout.replace(/\//g,'-')+'/'+values.adults+'/'+values.child;
window.location.href = '<?=base_url('hotels/detail/')?>'+redirectUrl;
});
</script>