<?php if(!empty($module->amenities)){ ?>
<div class="clearfix"></div>
<div class="panel panel-default">
    <div class="panel-heading go-text-right hidden-xs"><?php echo trans('048');?></div>
    <div class="panel-body">
            <div class="go-text-right">
                <?php foreach($module->amenities as $amt){ if(!empty($amt->name)){ ?>
                <div style="margin-top:6px;margin-left:0px" class="col-xs-6 col-sm-3">
                    <div class="row">
                        <span class="text-left go-text-right size14">
                            <?php if($appModule == "ean"){ ?>
                            <ul class="list_ok col-md-12 RTL" style="margin: 0 0 5px 0;">
                                <li class="go-right"> <img class="go-right" style="max-height:30px;max-witdh:40px" src="<?php echo $amt->icon;?>"> <?php echo $amt->name; ?></li>
                            </ul>
                            <?php } ?>
                            <?php if($appModule == "hotels"){ ?>
                            <div>  <img data-toggle="tooltip" data-placement="top" title="<?php echo $amt->name; ?>" class="go-right" style="max-height:30px;max-witdh:40px" src="<?php echo $amt->icon;?>"> <span class=""><?php echo $amt->name; ?></span></div>
                            <?php } ?>
                        </span>
                    </div>
                </div>
                <?php } } ?>
            </div>
    </div>
</div>
<?php } ?>