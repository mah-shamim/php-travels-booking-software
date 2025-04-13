<section class="payment-area section-bg section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-box payment-received-wrap mb-0">
                    <div class="form-title-wrap">
                        <div class="step-bar-wrap text-center">
                            <ul class="step-bar-list d-flex align-items-center justify-content-around">
                                <li class="step-bar flex-grow-1 step-bar-active">
                                    <span class="icon-element"></span>
                                    <p class="pt-2 color-text-2">
                                    <?php foreach ($invoice_details as $row){ if($row->status=='waiting'){ ?>
                                    <h4><?=lang('0409')?> <?php echo $row->status;?></h4>
                                    <?php }else { if($row->status=='processing'){ ?>
                                    <h4><?=lang('0409')?><?php echo $row->status;?></h4>
                                    <?php } } } ?>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-content">
                        <div class="payment-received-list">

                            <p class="py-1"><a href="#" class="text-color"><?=lang('0127')?> </a></p>
                            <!--<p><strong class="text-black mr-1">Phone:</strong>+ 00 222 44 5678</p>-->

                            <?php foreach ($invoice_details as $row){ ?>
                            <ul class="list-items list-items-3 list-items-4 py-4">
                                <li><span class="text-black font-weight-bold"><?=lang('0171')?></span><?php echo $row->first_name;?></li>
                                <li><span class="text-black font-weight-bold"><?=lang('0172')?></span><?php echo $row->last_name;?></li>
                                <li><span class="text-black font-weight-bold"><?=lang('0256')?></span><?php echo $row->phone;?></li>
                                <li><span class="text-black font-weight-bold"><?=lang('0273')?> <?=trans('0105')?></span><?php echo $row->from_country;?></li>
                                <li><span class="text-black font-weight-bold"><?=lang('0274')?> <?=trans('0105')?></span><?php echo $row->to_country;?></li>
                                <li><span class="text-black font-weight-bold"><?=lang('0622')?></span><?php echo $row->res_code;?></li>
                                <li><span class="text-black font-weight-bold"><?=lang('08')?></span><?php echo $row->date;?></li>
                            </ul>

                            <label for="">
                            <?=lang('0178')?>
                            </label>
                            <textarea name="" id="" cols="30" rows="4" disabled="" class="form-control">
                            <?php echo $row->notes;?>
                            </textarea>
                            <?php }?>

                        </div><!-- end card-item -->
                    </div>
                </div><!-- end payment-card -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>