<div class="ftab-inner menu-horizontal-content">
<div class="form-search-main-01">
<form name="fCustomHotelSearch" autocomplete="off" action="<?php echo base_url(); ?>properties/search" method="GET" role="search">
    <div class="form-inner">
        <div class="row gap-10 mb-15 align-items-end">
            <div class="col-md-3 col-xs-12 o4">
                <div class="form-group">
                    <label class="fr"><?=lang('0120')?></label>
                    <div class="clear"></div>
                    <div class="form-icon-left">
                    <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                    <input class="form-control hotelsearch locationlist<?=$module?>" required id="citiesInput" name="city" type="search" placeholder="<?php echo trans('026'); ?>" autocomplete="off" value="<?php echo @ $_GET['city']; ?>">
                    <input type="hidden" id="txtsearch" name="txtSearch" value="<?php echo $_GET['txtSearch']; ?>">
                 </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 o3">
                <div class="col-inner">
                    <div id="airDatepickerRange-hotel" class="row gap-10 mb-15">
                        <div class="col-6 o2">
                            <div class="form-group">
                                <label class="fr"><?php echo trans('07'); ?></label>
                                <div class="clear"></div>
                                <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                    <input type="text" id="DateStartExpedia" class="form-control form-readonly-control <?php if ($module == 'hotels') { echo 'dpd1'; } elseif ($module == 'ean') { echo 'dpean1'; } elseif ($module == 'tours') { echo 'tchkin'; } ?>" value="<?php if ($module == 'ean') { echo $themeData->eancheckin; } else { echo $themeData->checkin; } ?>" name="<?php if ($module == 'hotels' || $module == 'ean') { echo 'checkin'; } elseif ($module == 'tours') { echo 'date'; } ?>" placeholder="dd/mm/yyyy" value="<?=$_SESSION['hotel_checkin']?>">

                                </div>
                            </div>
                        </div>
                        <div class="col-6 o1">
                            <div class="form-group">
                                <label class="fr"><?php echo trans('09'); ?></label>
                                <div class="clear"></div>
                                <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                    <input type="text" id="DateEndExpedia" class="form-control form-readonly-control <?php if ($module == 'hotels') { echo 'dpd2'; } elseif ($module == 'ean') { echo 'dpean2'; } ?>" placeholder="dd/mm/yyyy" value="<?php if ($module == 'ean') { echo $themeData->eancheckout; } else { echo $themeData->checkout; } ?>" name="checkout">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 o2">
                <div class="col-inner">
                    <div class="row gap-10 mb-15">
                        <!--<div class="col-4 col-sm-6 col-md-4">
                            <div class="form-group form-spin-group">
                                <label class="fr" for="room-amount">Rooms</label>
                                <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-home-alt"></i></span>
                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly />
                                </div>
                            </div>
                        </div>-->
                        <div class="col-12">
                            <div class="col-inner">
                                <div class="form-people-thread">
                                    <div class="row gap-5 align-items-center">
                                        <div class="col o2">
                                            <div class="form-group form-spin-group">
                                                <label class="fr" for="room-amount"><?php echo trans('010');?> <small class=" text-muted font10 line-1">(12-75)</small></label>
                                                <div class="clear"></div>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly value="<?=($_SESSION['hotel_adults'])?$_SESSION['hotel_adults']:'2'?>" placeholder="<?=($_SESSION['hotel_adults'])?$_SESSION['hotel_adults']:'2'?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col 01">
                                            <div class="form-group form-spin-group">
                                                <label class="fr" for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1">(2-12)</small></label>
                                                <div class="clear"></div>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly value="<?=($_SESSION['hotel_child'])?$_SESSION['hotel_child']:'0'?>" placeholder="<?=($_SESSION['hotel_child'])?$_SESSION['hotel_child']:'0'?>"/>
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
            <div class="col-md-2 col-xs-12 o1">
            <input type="hidden" name="module_type"/>
            <input type="hidden" name="slug"/>
            <input type="hidden" name="childages" id="childages" value="<?php echo $themeData->childages; ?>">
            <input type="hidden" name="search" value="search" >
            <button type="submit"  class="btn btn-primary btn-block"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
            </div>
        </div>
    </div>
</form>
</div>
</div>