<div class="dashboard-bread dashboard--bread">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="breadcrumb-content">
                    <div class="section-heading">
                        <h2 class="sec__titles font-size-30 cw"><?=trans('075');?></h2>
                    </div>
                </div><!-- end breadcrumb-content -->
            </div><!-- end col-lg-6 -->
        </div><!-- end row -->
    </div>
</div>
<!-- end dashboard-bread -->
<!-- CONTENT -->
<div class="dashboard-main-content">
    <div class="clearfix"></div>
    <div class="container-fluid">
        <!-- CONTENT -->
        <div class="row">
            <!-- LEFT MENU -->
            <div class="col-lg-12">
                <div class="form-box">
                    <div class="clearfix"></div>

                    <div class="form-title-wrap ">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="title"><?=trans('0661');?></h3>
                                <!--<p class="font-size-14 d-none">Showing 1 to 7 of 17 entries</p>-->
                            </div>
                            <!--<span class="d-none">Total Bookings <strong class="color-text">(17)</strong></span-->>
                        </div>
                    </div>
                    <div class="form-content">
                        <div class="table-form table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"><?=trans('021');?></th>
                                        <th scope="col"><?=trans('0376');?></th>
                                        <th scope="col"><?=trans('089');?></th>
                                        <th scope="col"><?=trans('032');?></th>
                                        <th scope="col"><?=trans('0399');?> <?=trans('08');?></th>
                                        <th scope="col"><?=trans('079');?></th>
                                        <th scope="col"><?=trans('070');?></th>
                                        <th scope="col"><?=trans('080');?></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // echo "<pre>";
                                    // print_r($kiwitaxiBookings);
                                    // echo "<br>"; 
                                    // echo "<pre>";
                                    // print_r($HotelstonBookings);
                                    // echo "<br>"; 
                                    // echo "<pre>";
                                    // print_r($travelportBookings);
                                    // echo "<br>"; 
                                    // echo "<pre>";
                                    // print_r($eanbookings);
                                    // echo "<br>"; 
                                    // echo "<pre>";
                                    // print_r($bookings);
                                    // echo "<br>";
                                     ?>
                                    <?php foreach ($bookings as $b){ ?>
                                    <tr>
                                        <td><?php echo $b->id;?></td>
                                        <th scope="row"><img alt="" class="go-right img-responsive" style="max-width:96px;padding:5px" src="<?php echo $b->thumbnail;?>"></th>
                                        <td>
                                            <div class="table-content">
                                                <h3 class="title">
                                                <span class="stars"><?php echo $b->stars;?></span><br>
                                                <?php echo $b->title;?><br>
                                                <?php echo $b->code;?>
                                                </h3>
                                            </div>
                                        </td>
                                        <td><?php echo $b->location;?></td>
                                        <td><?php echo $b->date;?></td>
                                        <td><?php echo $b->expiry;?></td>
                                        <td><?php echo $b->currCode;?> <?php echo $b->currSymbol;?> <?php echo $b->checkoutTotal;?></td>
                                        <td>
                                            <?php if($b->status == "paid"){ ?>
                                            <span class="badge badge-success py-1 px-2 text-center"><?php echo trans('081');?></span>
                                            <?php }elseif($b->status == "cancelled"){ ?>
                                            <span class="badge badge-warning py-1 px-2 text-center"><?php echo trans('0347'); ?></span>
                                            <?php }elseif($b->status == "reserved"){ ?>
                                            <span class="badge badge-warning py-1 px-2 text-center"><?php echo trans('0445');?></span>
                                            <?php }else{ ?>
                                            <span class="badge badge-danger py-1 px-2 text-center"><?php echo trans('082');?></span>
                                        <?php } ?></td>
                                        <td>
                                            <div class="table-content">
                                                <a href="<?php echo base_url();?>invoice?id=<?php echo $b->id;?>&sessid=<?php echo $b->code;?>" target="_blank" class="btn btn-primary btn-action btn-block mb-2"><?php echo trans('076');?></a>
                                                <div class="clearfix"></div>
                                                <?php if($b->status == "paid"){ ?> <span class="btn btn-success btn-xs btn-block write_review" data-toggle="modal" href="#AddReview<?php echo $b->id;?>" class="btn_3"><?php if($b->reviewsData['reviewGiven'] == "yes"){ echo trans("0391"); }else{ echo trans('083');  } ?> </span> <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
                <!-- END OF TAB 1 -->
                <!-- End of Tab panes from left menu -->
            </div>
            <!-- END OF RIGHT CPNTENT -->
            <div class="clearfix"></div>
        </div>
        
        <!-- END CONTENT -->
    </div>
</div>
    <?php
    if(!empty($bookings) || !empty($eanbookings) || !empty($kiwitaxiBookings)){ if(!empty($bookings))
    {
    foreach($bookings as $b){
    ?>
<!--Comments modal -->
<div class="modal fade" id="AddReview<?php echo $b->id;?>" tabindex="" role="dialog" aria-labelledby="AddReview" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <br><br><br><br><br>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-smile-o"></i> <?php echo trans('084');?> <?php echo $b->title;?> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <?php if($b->reviewsData['reviewGiven'] == "yes"){ ?>
                <?php echo trans('08');?>: <?php echo pt_show_date_php($b->reviewsData['reviewDate']); ?><br>
                <?php echo trans('0389');?>: <?php echo $b->reviewsData['overall']; ?><br>
                <?php echo trans('043');?>: <?php echo $b->reviewsData['reviewComment']; ?><br>
                <?php }else{ ?>
                <form class="form-horizontal" method="POST" id="reviews-form-<?php echo $b->id;?>" action="" onsubmit="return false;">
                    <div class="">
                        <div id="review_result<?php echo $b->id?>" >
                        </div>
                        <div class="">
                            <div class="panel-body">
                                <div class="spacer20px row">
                                    <div class="col-lg-4">
                                        <div class="panel panel-body">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><?php echo trans('0389');?></label>
                                                <div class="col-md-5">
                                                    <label class="col-md-4 control-label"> <span class="badge badge-warning"><span id="avgall_<?php echo $b->id;?>">1</span> / 10 </span> </label>
                                                    <input type="hidden" name="overall" id="overall_<?php echo $b->id;?>" value="1" />
                                                    <input type="hidden" name="bookingid" value="<?php echo $b->id;?>" />
                                                    <input type="hidden" name="userid" value="<?php echo $profile[0]->accounts_id;?>" />
                                                    <input type="hidden" name="fullname" value="<?php echo $profile[0]->ai_first_name.' '.$profile[0]->ai_last_name;?>" />
                                                    <input type="hidden" name="reviewmodule" value="<?php echo $b->module;?>" />
                                                    <input type="hidden" name="reviewfor" value="<?php echo $b->itemid;?>" />
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><?php echo trans('030');?></label>
                                                <div class="clear"></div>
                                                <div class="col-md-12">
                                                    <select class="form-control reviewscore reviewscore_<?php echo $b->id;?>" id="<?php echo $b->id;?>" name="reviews_clean">
                                                        <option value="1"> 1 </option>
                                                        <option value="2"> 2 </option>
                                                        <option value="3"> 3 </option>
                                                        <option value="4"> 4 </option>
                                                        <option value="5"> 5 </option>
                                                        <option value="6"> 6 </option>
                                                        <option value="7"> 7 </option>
                                                        <option value="8"> 8 </option>
                                                        <option value="9"> 9 </option>
                                                        <option value="10"> 10 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><?php echo trans('031');?></label>
                                                <div class="clear"></div>
                                                <div class="col-md-12">
                                                    <select class="form-control reviewscore reviewscore_<?php echo $b->id;?>" id="<?php echo $b->id;?>" name="reviews_comfort">
                                                        <option value="1"> 1 </option>
                                                        <option value="2"> 2 </option>
                                                        <option value="3"> 3 </option>
                                                        <option value="4"> 4 </option>
                                                        <option value="5"> 5 </option>
                                                        <option value="6"> 6 </option>
                                                        <option value="7"> 7 </option>
                                                        <option value="8"> 8 </option>
                                                        <option value="9"> 9 </option>
                                                        <option value="10"> 10 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><?php echo trans('032');?></label>
                                                <div class="clear"></div>
                                                <div class="col-md-12">
                                                    <select class="form-control reviewscore reviewscore_<?php echo $b->id;?>" id="<?php echo $b->id;?>" name="reviews_location">
                                                        <option value="1"> 1 </option>
                                                        <option value="2"> 2 </option>
                                                        <option value="3"> 3 </option>
                                                        <option value="4"> 4 </option>
                                                        <option value="5"> 5 </option>
                                                        <option value="6"> 6 </option>
                                                        <option value="7"> 7 </option>
                                                        <option value="8"> 8 </option>
                                                        <option value="9"> 9 </option>
                                                        <option value="10"> 10 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><?php echo trans('033');?></label>
                                                <div class="clear"></div>
                                                <div class="col-md-12">
                                                    <select class="form-control reviewscore reviewscore_<?php echo $b->id;?>" id="<?php echo $b->id;?>" name="reviews_facilities">
                                                        <option value="1"> 1 </option>
                                                        <option value="2"> 2 </option>
                                                        <option value="3"> 3 </option>
                                                        <option value="4"> 4 </option>
                                                        <option value="5"> 5 </option>
                                                        <option value="6"> 6 </option>
                                                        <option value="7"> 7 </option>
                                                        <option value="8"> 8 </option>
                                                        <option value="9"> 9 </option>
                                                        <option value="10"> 10 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"><?php echo trans('034');?></label>
                                                <div class="clear"></div>
                                                <div class="col-md-12">
                                                    <select class="form-control reviewscore reviewscore_<?php echo $b->id;?>" id="<?php echo $b->id;?>" name="reviews_staff">
                                                        <option value="1"> 1 </option>
                                                        <option value="2"> 2 </option>
                                                        <option value="3"> 3 </option>
                                                        <option value="4"> 4 </option>
                                                        <option value="5"> 5 </option>
                                                        <option value="6"> 6 </option>
                                                        <option value="7"> 7 </option>
                                                        <option value="8"> 8 </option>
                                                        <option value="9"> 9 </option>
                                                        <option value="10"> 10 </option>
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="col-lg-12 panel panel-body">
                                            <label class="control-label"> <?php echo trans('042');?> </label>
                                            <div class="clear"></div>
                                            <textarea class="form-control" placeholder="Add review here..." rows="12" name="reviews_comments"></textarea>
                                        </div>
                                        <p class="text text-danger"><?php echo trans('Note');?>  <?php echo trans('085');?>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="email" value="<?php echo $profile[0]->accounts_email; ?>" />
                        <input type="hidden" name="addreview" value="1" />
                    </div>
                </form>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <?php if($b->reviewsData['reviewGiven'] != "yes"){ ?> <button type="button" class="btn btn-primary addreview" id="<?php echo $b->id;?>" ><i class="fa fa-save"></i> <?php echo trans('086');?></button><?php } ?>
            </div>
        </div>
    </div>
</div>
<!---Comments Modal-->
<?php } } } ?>