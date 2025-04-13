<?php if($search->form_type == "iframe"){ echo $search->form_source; }else{ ?>

<style> .form-control{ -webkit-appearance:none; overflow: hidden; } </style>
<form autocomplete="off" action="<?php echo base_url() . $module; ?>/search" method="GET" role="search">

    <div class="tab-content" id="myTabContent3">
        <div class="tab-pane fade show active" id="one-way" role="tabpanel" aria-labelledby="one-way-tab">
            <div class="contact-form-action">
                <div class="row align-items-center">

                    <div class="col-lg-4 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0120')?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                 <input type="text" data-module="<?php echo $module; ?>" class="form-control hotelsearch locationlist<?php echo $module; ?>" placeholder="<?php if ($module == 'hotels') { echo trans('026'); } elseif ($module == 'tours') { echo trans('0526'); } ?>" value="<?php echo $toursearch['ToursSearchForm']->from_code; ?>" required>
                                 <input type="hidden" id="txtsearch" name="txtSearch" value="<?php echo $toursearch['ToursSearchForm']->from_code; ?>">
                           </div>
                        </div>
                    </div><!-- end col-lg-3 -->

                    <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('08'); ?> </label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input type="text" class="daterentals form-control" placeholder="dd/mm/yyyy" value="<?=$toursearch['ToursSearchForm']->checkin?>" name="checkin" required>
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0222');?></label>
                            <div class="form-group">

                            <div class="select-contain w-100">
                            <select class="select-contain-select" name="type" id="tourtype">
                            <option value="" selected>
                            <?php echo trans('0158'); ?>
                            </option>
                            <?php foreach ($data['moduleTypes'] as $ttype) { ?>
                            <option value="<?php echo $ttype->id; ?>" <?php makeSelected($tourType, $ttype->id); ?> >
                                <?php echo $ttype->name; ?>
                            </option>
                            <?php } ?>
                            </select>

                          </div>
                         </div>
                        </div>
                       </div>

                    <div class="col-lg-2">
                        <div class="input-box">
                            <label class="label-text"><?=trans('0528')?></label>
                            <div class="form-group" >
                                <div class="single-box form-control qty-box d-flex align-items-center justify-content-between">
                                   <!--<label><?php echo trans('010');?></label>-->
                                    <div class="qtyBtn d-flex align-items-center btn-block justify-content-center">
                                        <input type="text" class="qtyInput" placeholder="0" name="adults" readonly value="<?=($toursearch['ToursSearchForm']->adults)?$toursearch['ToursSearchForm']->adults:'1'?>" placeholder="<?=($toursearch['ToursSearchForm']->adults)?$toursearch['ToursSearchForm']->adults:'1'?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="col-lg-2 pl-0">
                <input type="hidden" name="module_type"/>
                <input type="hidden" name="slug"/>
                <button type="submit" class="theme-btn w-100 text-center margin-top-20px"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
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


<?php } ?>

<input type="hidden" name="searching" class="searching" value="<?php echo $_GET['searching']; ?>">
<input type="hidden" class="modType" name="modType" value="<?php echo $_GET['modType']; ?>">
<script>
$(function () {
$(".locationlist<?php echo $module; ?>").select2({
width: '100%',
allowClear: true,
maximumSelectionSize: 1,
placeholder: "Start typing",
data: JSON.parse('<?=$data['defaultToursListForSearchField']?>'),
initSelection: function (element, callback) {
callback({id: 1, text: '<?=(!empty($toursearch['ToursSearchForm']->from_code))? $toursearch['ToursSearchForm']->from_code :lang('0526'); ?>'})
}
});

$(".locationlist<?php echo $module; ?>").on("select2-open",
function (e) {
$(".select2-drop-mask");
$(".formSection").trigger("click")
});
$(".locationlist<?php echo $module; ?>").on("select2-selecting", function (e) {
$(".modType").val(e.object.module);
$(".searching").val(e.object.id);
$("#txtsearch").val(e.object.text);
})
})
</script>
 </form>
<!------------------------------------------------------------------->
<!-- ********************    TOURS MODULE    ********************  -->
<!------------------------------------------------------------------->