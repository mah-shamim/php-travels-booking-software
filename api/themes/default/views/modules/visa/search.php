<style>.form-control{ -webkit-appearance:none; overflow: hidden; } </style>
<form autocomplete="off" action="<?php echo base_url(); ?>visa" method="GET" role="search">

    <div class="tab-content" id="myTabContent3">
        <div class="tab-pane fade show active" id="one-way" role="tabpanel" aria-labelledby="one-way-tab">
            <div class="contact-form-action">
                <div class="row align-items-center">

                    <div class="col-lg-4 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans( '0273'); ?> <?php echo trans( '0105'); ?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                    <select type="search" name="nationality_country" id="" class="chosen-the-basic form-control" required>
                                    <option value="<?=$data['countryname'];?>"><?=$data['countryname'];?></option>
                                    <option value="">
                                        <?php echo trans( '0158'); ?>
                                        <?php echo trans( '0105'); ?>
                                    </option>
                                    <?php foreach($data['allcountries'] as $c){ ?>
                                    <option value="<?php echo $c->short_name;?>" <?php if($data['countryname']==$c->iso2){echo 'selected';}?>>
                                        <?php echo $c->short_name;?>
                                    </option>
                                    <?php } ?>
                                </select>
                           </div>
                        </div>
                    </div>

                    <div class="col-lg-4 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans( '0274'); ?> <?php echo trans( '0105'); ?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                    <select name="destination_country" id="" class="chosen-the-basic form-control" required>
                                     <option value="<?=$data['tocountry'];?>"><?=$data['tocountry'];?></option>
                                    <option value="">
                                        <?php echo trans( '0158'); ?>
                                        <?php echo trans( '0105'); ?>
                                    </option>
                                    <?php foreach($data['allcountries'] as $c){ ?>
                                    <option value="<?php echo $c->short_name;?>" <?php if($data['tocountry']==$c->iso2){echo 'selected';}?>>
                                        <?php echo $c->short_name;?>
                                    </option>
                                    <?php } ?>
                                </select>
                           </div>
                        </div>
                    </div>

                    <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('08'); ?> </label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input type="search" id="" required="" name="date" placeholder="<?php echo trans('08');?>" class="datevisa form-control form-bg-light">
                            </div>
                        </div>
                    </div>

                <div class="col-lg-2">
                <input type="hidden" name="module_type"/>
                <input type="hidden" name="slug"/>
                 <button type="submit" class="theme-btn w-100 text-center margin-top-20px"><?php echo trans('086'); ?></button>
                </div>
                </div>

            </div>
        </div><!-- end tab-pane -->
    </div>
 </form>

<!------------------------------------------------------------------->
<!-- ********************    TOURS MODULE    ********************  -->
<!------------------------------------------------------------------->