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
                                <input type="text" data-module="<?php echo $module; ?>" class="form-control hotelsearch locationlist<?php echo $module; ?>" placeholder="<?php if ($module == 'hotels') { echo trans('026'); } elseif ($module == 'rentals') { echo trans('0526'); } ?>" value="<?php echo $rentalssearch['RentalsSearchForm']->from_code; ?> required">
                                <input type="hidden" id="txtsearch" name="txtSearch" value="<?php echo $rentalssearch['RentalsSearchForm']->from_code; ?>">

                         </div>
                        </div>
                    </div><!-- end col-lg-3 -->

                    <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('08'); ?> </label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input type="text" class="Daterentals form-control form-readonly-control text-center" placeholder="dd/mm/yyyy" value="<?=$rentalssearch['RentalsSearchForm']->checkin?>" name="checkin" required>
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0631');?></label>
                            <div class="form-group">


                            <div class="select-contain w-100">
                            <select class="select-contain-select" name="type" id="rentaltype">
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
                            <div class="form-group">
                                <div class="dropdown dropdown-contain">
                                    <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        <span><?=trans('0528')?> <span class="qtyTotal guestTotal">0</span></span>
                                        <span class="hiphens font-size-20 mx-1">-</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-wrap">

                                    <!-- old code -->
                                    <div class="form-group form-spin-group">
                                    <label for="room-amount"><?php echo trans('010');?> <small class=" text-muted font10 line-1">(12-75)</small></label>
                                    <div class="clear"></div>
                                    <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                      <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="adults" readonly value="<?=($rentalssearch['RentalsSearchForm']->adults)?$rentalssearch['RentalsSearchForm']->adults:'1'?>" placeholder="<?=($rentalssearch['RentalsSearchForm']->adults)?$rentalssearch['RentalsSearchForm']->adults:'1'?>"/>
                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="adults" readonly value="<?=($toursearch['ToursSearchForm']->adults)?$toursearch['ToursSearchForm']->adults:'1'?>" placeholder="<?=($toursearch['ToursSearchForm']->adults)?$toursearch['ToursSearchForm']->adults:'1'?>"/>
                                    </div>
                                    </div>
                                    <!-- old code -->

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
                <input type="hidden" name="module_type"/>
                <input type="hidden" name="slug"/>
                <button type="submit" class="theme-btn w-100 text-center margin-top-20px"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
                </div>
                </div>

            </div>
        </div><!-- end tab-pane -->
    </div>
 </form>

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
data: JSON.parse('<?=$data['defaultRentalsListForSearchField']?>'),
initSelection: function (element, callback) {
callback({id: 1, text: '<?=(!empty($rentalssearch['RentalsSearchForm']->from_code))? $rentalssearch['RentalsSearchForm']->from_code :lang('0526'); ?>'})
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

<!------------------------------------------------------------------->
<!-- ********************    TOURS MODULE    ********************  -->
<!------------------------------------------------------------------->