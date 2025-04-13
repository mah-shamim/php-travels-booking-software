<section id="ROOMS">
    <div class="panel panel-default">
        <div class="panel-heading go-text-right panel-default ttu"><?php echo trans('0372');?></div>
        <?php if(!empty($modulelib->stayerror)){ ?>
            <div class="panel-body">
                <div class="alert alert-danger go-text-right">
                    <?php echo trans("0420"); ?>
                </div>
            </div>
        <?php } ?>
        <table class="bgwhite table table-striped">
            <?php if(!empty($rooms)){
                ?>
            <?php foreach($rooms as $r){ if($r->maxQuantity > 0){ ?>
            <form action="<?php echo base_url().$appModule;?>/book/<?php echo $module->bookingSlug;?>" method="GET">
                <input type="hidden" name="adults" value="<?php  echo $modulelib->adults; ?>" />
                <input type="hidden" name="child" value="<?php  echo $modulelib->children; ?>" />
                <input type="hidden" name="checkin" value="<?php  echo $modulelib->checkin; ?>" />
                <input type="hidden" name="checkout" value="<?php  echo $modulelib->checkout; ?>" />
                <input type="hidden" name="roomid" value="<?php echo $r->id; ?>" />
                <tr>
                    <td class="wow fadeIn p-10-0">
                        <div class="col-xs-4 col-md-2 go-right rtl_pic">
                            <div class="img_list_rooms">
                                <div class="zoom-gallery<?php echo $r->id; ?>">
                                    <a href="<?php echo $r->thumbnail;?>" data-source="<?php echo $r->thumbnail;?>" title="<?php echo character_limiter($item->title,20);?>">
                                        <img style="max-height:180px" class="img-responsive" src="<?php echo $r->thumbnail;?>">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 col-xs-8 g0-left">
                            <div class="col-md-4 go-right" style="margin-top: 15px;">
                                <div class="row">
                                    <h4 class="RTL go-text-right mt0 list_title ttu">
                                        <a href="javascript:void(0)">
                                            <b><?php echo $r->title;?></b>
                                            <div class="clearfix"></div>
                                            <small>
                                                <strong><?php echo trans('010');?></strong> <?php echo $r->Info['maxAdults'];?>
                                                <strong><?php echo trans('011');?></strong> <?php echo $r->Info['maxChild'];?></small>
                                        </a>
                                        <!--<a href=""><b><?php echo trans('070');?> <?php echo $modulelib->stay; ?> <?php echo trans('0122');?></b></a>-->
                                    </h4>
                                    <!--<div style="margin: 7px 0px 7px 0px;" class="grey RTL fs12 hidden-xs"><?php echo character_limiter($r->desc, 230);?></div>-->
                                </div>
                                <div class="row" style="margin-top: -15px;">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-5 go-right">
                                            <h5 class="fs14"><?php echo trans('0374');?></h5>
                                        </div>
                                        <div class="col-xs-6 col-md-4 go-left">
                                            <select class="selectx input-sm" name="roomscount[<?=$r->id?>]" >
                                                <?php for($q = 1; $q <= $r->maxQuantity; $q++){ ?>
                                                    <option value="<?php echo $q;?>"><?php echo $q;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php if($r->extraBeds > 0){ ?>
                                        <div class="row">
                                            <div class="col-xs-6 col-md-5 go-right">
                                                <h5 class="fs14 mt5"><?php echo trans('0428');?></h5>
                                            </div>
                                            <div class="col-xs-6 col-md-4 go-left">
                                                <select name="extrabeds[<?=$r->id?>]" class="selectx input-sm" id="">
                                                    <option value="0">0</option>
                                                    <?php for($i = 1; $i <= $r->extraBeds; $i++){ ?>
                                                        <option value="<?php echo $i;?>"> <?php echo $i;?> <?php echo $r->currCode." ".$r->currSymbol.$i * $r->extrabedCharges;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <span class="visible-xs visible-sm">
                            <br><br>
                            </span>
                            <div class="col-md-8 book_area go-left">
                                <div class="row">
                                    <div class="col-md-6 book_buttons hidden-xs hidden-sm go-right">
                                        <button data-toggle="collapse" data-parent="#accordion" class="hidden-xs btn btn-default btn-block btn-sm"  href="#details<?php echo $r->id;?>"><?php echo trans('052');?></button>
                                        <button data-toggle="collapse" data-parent="#accordion" href="#availability<?php echo $r->id;?>" class="hidden-xs btn-block btn btn-info btn-sm"><?php echo trans('0251');?></button>
                                    </div>
                                    <div class="col-md-4 col-xs-6 go-right">
                                        <h2 class="book_price text-center mob-fs18 rooms-book-button go-right"><?php  if($r->price > 0){ ?>
                                                <small><?php echo $r->currCode;?>  </small> <strong><?php echo $r->currSymbol; ?><?php echo $r->price; ?></strong>
                                            <?php } ?>
                                        </h2>
                                    </div>
                                    <div class="col-md-2 go-right pull-right">
                                        <div class="row">
                                            <span class="hidden-xs hidden-sm">
                                            <br><br>
                                            </span>
                                            <label data-toggle="collapse" data-target="#<?php echo $r->price; ?>" aria-expanded="false" aria-controls="<?php echo $r->price; ?>" class="control control--checkbox ellipsis fs14">
                                                <!--<?php echo $r->price; ?> --> &nbsp;
                                                <input type="checkbox" name="rooms[]" value="<?=$r->id?>" id="roomsCheckbox"/>
                                                <div class="control__indicator"></div>
                                            </label>
                                            <span class="hidden-xs hidden-sm">
                                            <br><br><br><br>
                                            </span>
                                            <!--<?php  if($r->price > 0){ ?>
                                            <button type="submit" class="book_button btn btn-md btn-danger btn-block btn-block chk mob-fs10 loader"><?php echo trans('0142');?></button>
                                            <?php } ?>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="availability<?php echo $r->id;?>" class="alert alert-info panel-collapse collapse">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-12 col-lg-5">
                                        <div class="form-group">
                                            <select id="<?php echo $r->id;?>" class="form-control showcalendar">
                                                <option value="0"><?php echo trans('0232');?></option>
                                                <option value="<?php echo $first;?>"> <?php echo $from1;?> - <?php echo $to1;?></option>
                                                <option value="<?php echo $second;?>"> <?php echo $from2;?> - <?php echo $to2;?></option>
                                                <option value="<?php echo $third;?>"> <?php echo $from3;?> - <?php echo $to3;?></option>
                                                <option value="<?php echo $fourth;?>"> <?php echo $from4;?> - <?php echo $to4;?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="roomcalendar<?php echo $r->id;?>"></div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:15px;color:#333333 !important" id="details<?php echo $r->id;?>" class="alert alert-danger panel-collapse collapse">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="magnific-gallery row">
                                        <?php foreach($r->Images as $Img){ if($r->thumbnail != $Img['thumbImage']){ ?>
                                            <div class="col-md-3">
                                                <div class="zoom-gallery<?php echo $r->id; ?>">
                                                    <a href="javascript:void(0);<?php echo $Img['thumbImage'];?>" data-source="<?php echo $Img['thumbImage'];?>" title="<?php echo $r->title;?>">
                                                        <img class="img-responsive" src="<?php echo $Img['thumbImage'];?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $('.zoom-gallery<?php echo $r->id; ?>').magnificPopup({
                                                    delegate: 'a',
                                                    type: 'image',
                                                    closeOnContentClick: false,
                                                    closeBtnInside: false,
                                                    mainClass: 'mfp-with-zoom mfp-img-mobile',
                                                    image: {
                                                        verticalFit: true,
                                                        titleSrc: function(item) {
                                                            return item.el.attr('title') + ' ';
                                                        }
                                                    },
                                                    gallery: {
                                                        enabled: true
                                                    },
                                                    zoom: {
                                                        enabled: true,
                                                        duration: 300, // don't foget to change the duration also in CSS
                                                        opener: function(element) {
                                                            return element.find('img');
                                                        }
                                                    }

                                                });

                                            </script>
                                        <?php } } ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <br>
                                    <?php if(!empty($r->desc)){ ?>
                                        <p class="go-text-right RTL"><strong><?php echo trans('046');?> : </strong> </p>
                                        <span class="rooms-text"><?php echo $r->desc;?></span>
                                    <?php } ?>
                                    <hr>
                                    <?php if(!empty($r->Amenities)){ ?>
                                        <p class="RTL"><strong><?php echo trans('055');?> : </strong></p>
                                        <?php foreach($r->Amenities as $roomAmenity){ if(!empty($roomAmenity->name)){ ?>
                                            <div class="col-md-4">
                                                <ul class="list_ok RTL">
                                                    <li><?php echo $roomAmenity->name;?></li>
                                                </ul>
                                            </div>
                                        <?php } } } ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <div class="clearfix"></div>
                <?php } ?>
                <?php } ?>
                <?php }else{  echo '<div class="panel-body"><h4 class="alert alert-info">' . trans("066") . '</h4></div>'; } ?>
        </table>
        <button type="submit" class="book_button btn btn-md btn-success btn-block btn-block chk mob-fs10 loader" disabled>
            <?php echo trans('0142');?>
        </button>
        </form>
    </div>
</section>

<script>
    $("[name^=rooms").on('click', function () {
        if ($('[name="rooms[]"]:checked').length > 0) {
            $('[type=submit]').prop('disabled', false);
        } else {
            $('[type=submit]').prop('disabled', true);
        }
    });
</script>
