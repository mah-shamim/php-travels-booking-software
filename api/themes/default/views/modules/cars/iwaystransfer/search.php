<?php
if($searchForm['searchForm']['home']!= '1') {
    $loactionfrom = $searchForm['searchForm'];
    $loactionto = $searchForm['searchTo'];

}else{
    $loactionfrom = $searchForm['searchForm']['searchForm'];
    $loactionto = $searchForm['searchForm']['searchTo'];
}
//dd($searchForm['searchForm']);
?>

<div class="tab-inner menu-horizontal-content">
    <div class="form-search-main-01">
        <form autocomplete="off" id="iways" action="<?php echo base_url('itaxi/search'); ?>" method="post" role="search">
            <div class="form-inner">
                <div class="row gap-10 mb-20 align-items-center">
                    <div class="col-lg-5 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0210')?> <?=lang('0254')?></label>
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <input class="iwaysfrom_select2 form-control" value="<?=(!empty($loactionfrom))? $loactionfrom :'dubai'; ?>" id="origi_from" name="origi_from" type="search" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0211')?> <?=lang('0254')?></label>
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <input class="iwaysfrom_select2 form-control" value="<?=($loactionto)? $loactionto :'sharjah'; ?>" id="origin_to" name="origin_to" type="search" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo trans('012'); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
