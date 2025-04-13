<?php //dd($toursearch['ToursSearchForm']->from_code);?>
<style>
    .form-control{
        overflow:hidden;
        -webkit-appearance:none;
    }
</style>
<?php $ci = get_instance();
$location = $ci->session->userdata('Viator_location');
$start_date = $ci->session->userdata('Viator_startdate');
$end_date = $ci->session->userdata('Viator_endDate');
$Viator_country = $ci->session->userdata('Viator_country');

?>
<div class="ftab-inner menu-horizontal-content">
    <div class="form-search-main-01 tour-search">
        <form autocomplete="off" action="<?php echo base_url()?>packages/search" method="get" role="search">
            <div class="form-inner">
                <div class="row gap-10 mb-20 row-reverse">
                    <div class="col-lg-3 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0120')?></label>
                            <div class="clear"></div>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <!-- id = textsearch is used to get data in jquery script -->
                                <input type="text" name="location" id="textsearch" class="form-control viatorsearch"   required>
                            </div>
                        </div>
                    </div>
                    <!--Starting Date-->
                    <div class="col-lg-3 col-xs-12">
                        <div class="col-inner">
                            <div class="row gap-10 mb-15">
                                <div class="col-md-12">
                                    <div class="col-inner">
                                        <div class="form-people-thread">
                                            <div class="row gap-5 align-items-center">
                                                <div id="airDatepickerRange-hotel" class="col">
                                                    <div class="form-group form-spin-group">
                                                        <label for="room-amount" class="text-left"><?=lang('0273')?> <?php echo trans('08');?></label>
                                                        <div class="clear"></div>
                                                        <div class="form-icon-left">
                                                            <span class="icon-font text-muted" style="margin-left:12px"><i class="bx bx-calendar"></i></span>
                                                            <input type="text" id="DateTours" class="DateTours form-control form-readonly-control" placeholder="dd/mm/yyyy" value="<?=!empty($start_date) ? $start_date : "" ?>" name="startDate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Ending Date-->
                    <div class="col-lg-3 col-xs-12">
                        <div class="col-inner">
                            <div class="row gap-10 mb-15">
                                <div class="col-md-12">
                                    <div class="col-inner">
                                        <div class="form-people-thread">
                                            <div class="row gap-5 align-items-center">
                                                <div id="airDatepickerRange-hotel" class="col">
                                                    <div class="form-group form-spin-group">
                                                        <label for="room-amount" class="text-left" style=""><?=lang('0274')?> <?php echo trans('08');?></label>
                                                        <div class="clear"></div>
                                                        <div class="form-icon-left">
                                                            <span class="icon-font text-muted" style="margin-left:12px"><i class="bx bx-calendar"></i></span>
                                                            <input type="text" id="EndDateTours" class="DateTours form-control form-readonly-control" placeholder="dd/mm/yyyy" value="<?=!empty($end_date) ? $end_date : "" ?>" name="endDate" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-12">
                        <input type="hidden" name="module_type"/>
                        <input type="hidden" value="<?=!empty($location) ? $location : "" ?>" name="slug"/>
                        <button type="submit"  class="btn btn-primary btn-block"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="searching" class="searching" value="<?php echo $_GET['searching']; ?>">
            <input type="hidden" class="modType" name="modType" value="<?php echo $_GET['modType']; ?>">
            <script>

                $("#textsearch").val("<?=(!empty($location))? $Viator_country."/".$location :''; ?>");

                $(function () {
                    $(".viatorsearch").select2({
                        minimumInputLength: 3,
                        width: '100%',
                        maximumSelectionSize: 1,
                        ajax: {
                            url: "<?=base_url('home/suggestions_v2/hotels')?>", dataType: 'json', data: function (term) {
                                return {q: term}
                            }, results: function (data) {
                                return {results: data}
                            }
                        },
                        initSelection: function (element, callback) {
                            callback({id: "<?=(!empty($location))? $Viator_country."/".$location :''; ?>", text: '<?=(!empty($location))? $Viator_country.",".$location :'Search by City Name'; ?>'})
                        }
                    });
                    $(".viatorsearch").on("select2-selecting", function (e) {
                        $("input[name=module_type]").val(e.object.module);
                        $("input[name=slug]").val(e.object.id)
                    });


                })
            </script>
                <script>
                    $("form").submit(function ( event ) {
                        event.preventDefault();
                        var textsearch = $("#textsearch").val();
                        var startDate = $("#DateTours").val().replace(/\//g,"-");
                        var endDate = $("#EndDateTours").val().replace(/\//g,"-");
                        var arr = [textsearch,startDate,endDate];

                        window.location.href = base_url + 'packages/search/' + arr.join("/");

                        // var root = base_url + 'vtour/' + $("#textsearch").val() + "/" + startDate + "/" + endDate;
                        // alert(root);
                    });
                </script>
        </form>
    </div>
</div>

<!------------------------------------------------------------------->
<!-- ********************    TOURS MODULE    ********************  -->
<!------------------------------------------------------------------->