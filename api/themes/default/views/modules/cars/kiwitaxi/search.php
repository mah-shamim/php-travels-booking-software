<?php
if($searchForm['searchForm']['home']!= '1') {
    $loactionfrom = $searchForm['searchForm'];
    $loactionto = $searchForm['searchTo'];

}else{
    $loactionfrom = $searchForm['searchForm']['searchForm'];
    $loactionto = $searchForm['searchForm']['searchTo'];
}
?>
<div class="tab-inner menu-horizontal-content">
    <div class="form-search-main-01">
        <form autocomplete="off" id="kiwitaxi" action="<?php echo base_url('taxi/search'); ?>" method="GET" role="search">
            <div class="form-inner">
                <div class="row gap-10 mb-20 row-reverse">
                    <div class="col-lg-5 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0210')?> <?=lang('0254')?></label>
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <input class="kiwifrom_select2 form-control" value="<?=(!empty($loactionfrom))? $loactionfrom :''; ?>" id="origin_from" name="origin_from" type="search" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0211')?> <?=lang('0254')?></label>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <input class="kiwito_select2 form-control" value="<?=($loactionto)? $loactionto :''; ?>" id="origin_to" name="origin_to" type="search" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="carCheck11">
                            <label class="custom-control-label" for="carCheck11">Return car to the same location</label>
                        </div>
                    </div>-->
                    <!--<div class="col-md-4 col-xs-12">
                            <div class="col-inner">
                                <div class="form-people-thread">
                                    <div class="row gap-5 align-items-center">
                                        <div class="col">
                                            <div class="form-group form-spin-group">
                                                <label for="room-amount"><?php echo trans('010');?> <small class=" text-muted font10 line-1">(12-75)</small></label>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly value="<?=($_SESSION['hotel_adults'])?$_SESSION['hotel_adults']:'1'?>" placeholder="<?=($_SESSION['hotel_adults'])?$_SESSION['hotel_adults']:'1'?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group form-spin-group">
                                                <label for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1">(2-12)</small></label>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly value="<?=($_SESSION['hotel_child'])?$_SESSION['hotel_child']:'0'?>" placeholder="<?=($_SESSION['hotel_child'])?$_SESSION['hotel_child']:'0'?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    <div class="col-lg-2 col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo trans('012'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
