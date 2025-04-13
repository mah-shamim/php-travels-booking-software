<?php if(!empty($reviews) > 0){ ?>
<div id="REVIEWS">
    <div class="panel panel-default">
        <div class="panel-heading go-text-right panel-yellow"><?php echo trans('0396');?></div>
        <div class="panel-body">
            <div class="tab-pane active" id="tab-newtopic">
                <div class="table-responsive">
                    <div class="fixedtopic">
                        <table class="table-hover table table-striped">
                            <?php if(!empty($reviews)){ foreach($reviews as $rev){ ?>
                            <tr class="RTL">
                                <td style="width: 100px;">
                                    <img class="go-right" style="height:80px;width:80px" src="<?php echo base_url(); ?>assets/img/user_blank.jpg" alt="<?php echo $rev->review_id;?>"/>
                                </td>
                                <td>
                                    <span class="dark"><strong class="go-right"><?php echo $rev->review_name;?> &nbsp;</strong></span> <span class="text-muted"><small><?php echo pt_show_date_php($rev->review_date);?></small>   <span class="badge badge-warning pull-right go-left"> <?php echo round($rev->review_overall,1);?> / <?php if(!empty($rev->maxRating)){ echo $rev->maxRating; }else{ echo "10"; }?></span></span> <br/>
                                   <?php if(!empty($rev->reviewUrl)){ ?>
                                   <a target="_blank" href="<?php echo $rev->reviewUrl;?>"> <?php echo character_limiter($rev->review_comment,1000);?> </a>
                                    <?php }else{ ?>
                                     <?php echo character_limiter($rev->review_comment,1000);?>
                                   <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                        <div class="line3"></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>