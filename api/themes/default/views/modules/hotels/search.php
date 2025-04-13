<?php if($search->form_type == "iframe"){ echo $search->form_source; }else{ ?>
<style> .form-control{ -webkit-appearance:none; overflow: hidden; } </style>

<form name="HOTELS" autocomplete="off" action="<?=$search->hotelroute?>" method="GET" role="search">
    <div class="tab-content" id="myTabContent3">
        <div class="tab-pane fade show active" id="one-way" role="tabpanel" aria-labelledby="one-way-tab">
            <div class="contact-form-action">
                <div class="row align-items-center">

                    <!-- destination -->
                    <div class="col-lg-4 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0120')?> <?=lang('0273')?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                              <input class="form-control hotelsearch locationlist<?=$module?>" name="dest" type="search" autocomplete="off" value="<?=$search->hotellocationname?>" required>
                            </div>
                        </div>
                    </div><!-- end col-lg-3 -->

                    <!-- dates -->
                    <div class="col-lg-3 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('07'); ?> / <?php echo trans('09'); ?></label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input id="HotelsDateEnd" class="form-control datehotels" type="text" name="" value="<?php echo $search->departure_date; ?>" vlue="<?php echo $search->arrival; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- travellers -->
                    <div class="col-lg-3">
                        <div class="input-box">
                            <label class="label-text"><?=trans('0528')?></label>
                            <div class="form-group">
                                <div class="dropdown dropdown-contain">
                                    <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    <span><?=trans('0528')?> <span class="guest_hotels">0</span></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-wrap">
                                        <div class="dropdown-item">
                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                               <label><?php echo trans('010');?></label>
                                                <div class="qtyBtn d-flex align-items-center">
                                                    <input type="text" name="adults" value="<?=$search->hoteladult?>" class="qtyInput_hotels">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-item">
                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                <label><?php echo trans('011');?></label>
                                                <div class="qtyBtn d-flex align-items-center">
                                                    <input type="text" name="children" value="<?=$search->hotelchildren?>" class="qtyInput_hotels">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end dropdown -->
                            </div>
                        </div>
                    </div>

                <!-- search button -->
                <div class="col-lg-2 pl-0">
                <input type="hidden" name="module_type"/>
                <input type="hidden" name="slug"/>
                <button type="submit"  class="theme-btn w-100 text-center margin-top-20px">
                <?php echo trans('012'); ?>
                </button>
                </div>
                </div>

               <!-- <input type="text" id="checkin" class="form-control form-readonly-control" name="checkin" placeholder="<?=!empty($search->hotelcheckin) ? $search->hotelcheckin : $search->hoteldatecheckin?>" required value="<?=!empty($search->hotelcheckin) ? $search->hotelcheckin : $search->hoteldatecheckin?>">
                <input type="text" id="checkout" class="form-control form-readonly-control" name="checkout" placeholder="<?=!empty($search->hotelcheckout) ? $search->hotelcheckout : $search->hoteldatetype?>" required value="<?=!empty($search->hotelcheckout) ? $search->hotelcheckout : $search->hoteldatetype?>">-->

                <!--<div class="advanced-wrap">
                <a class="btn collapse-btn theme-btn-hover-gray font-size-15" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree">
                Advanced options <i class="la la-angle-down ml-1"></i>
                </a>
                <div class="collapse pt-3" id="collapseThree">
                <div class="row">
                <div class="col-lg-4">
                <div class="input-box">
                <label class="label-text">Preferred airline</label>
                <div class="form-group">
                <div class="select-contain w-100">
                <select class="select-contain-select">
                <option selected="selected" value=""> No preference</option>
                <option value="WS">WestJet</option>
                <option value="WM">Windward Island Airways International</option>
                <option value="MF">Xiamen Airlines</option>
                <option value="SE">XL Airways</option>
                </select>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>--><!-- end advanced-wrap -->
            </div>
        </div><!-- end tab-pane -->
    </div>
 </form>

<?php if($module == 'Hotels'){?>
<script>
$(function () {
$(".locationlist<?php echo $module; ?>").select2({
width: '100%',
allowClear: true,
maximumSelectionSize: 1,
ajax: {
url: "<?=$search->location_url?>", dataType: 'json', data: function (term) {
return {q: term}
}, results: function (data) {
if(data !=null) {
return {results: data}
}else{
return {results: JSON.parse('<?=$search->hotelloactionsearch?>')}
}
}
},
initSelection: function (element, callback) {
callback({id: 1, text: '<?=(!empty($search->hotellocation))? str_replace( ',',' ',str_replace( '-',' ',$search->hotellocation)) :lang('026'); ?>'})
}
});
});
</script>
<?php }?>
<?php } ?>