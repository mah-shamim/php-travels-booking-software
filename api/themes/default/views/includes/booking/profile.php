<div class="form-box">
    <div class="form-title-wrap">
        <h3 class="title"><?php echo trans('088');?></h3>
    </div>
    <!-- form-title-wrap -->
    <div class="form-content ">
        <div class="contact-form-action">
            <div class="panel panel-primary">
                <?php if(empty($usersession)){ ?>
                <ul class="nav justify-content-center nav-pills">
                    <li role="presentation"  data-title="">
                        <a class="nav-item nav-link active" href="#Guest" id="guesttab" data-toggle="tab">
                            <i class="icon-user-7"></i>
                            <div class="visible-xs clearfix"></div>
                            <span class="hidden-xs"><?php echo trans('0167');?></span>
                        </a>
                    </li>
                    <!--  <li role="presentation" class="text-center" data-title="flight">
                        <a href="#flight" data-toggle="tab" aria-controls="home" aria-expanded="true">
                        <i class="icon_set_1_icon-16"></i>
                        <div class="visible-xs clearfix"></div>
                        <span class="hidden-xs">Register and Book</span>
                        </a>
                        </li>-->
                    <?php  if($app_settings[0]->allow_registration == "1"){ ?>
                    <li role="presentation" class="text-center" data-title="">
                        <a class="nav-item nav-link" href="#Sign-In" id="signintab" data-toggle="tab" >
                            <i class="icon-key-4"></i>
                            <div class="visible-xs clearfix"></div>
                            <span class="hidden-xs"><?php echo trans('0168');?></span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <hr>
                
                <div class="panel-body">
                    <!-- PHPTRAVELS Booking tabs ending  -->
                    <div class="tab-content pt-30" style="height: inherit;">
                        <!-- PHPTRAVELS Guest Booking Starting  -->
                        <div class="tab-pane fade in active show" id="Guest">
                            <form id="guestform" class="booking_page">
                                <div class="row">
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('0171');?></label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="firstname" placeholder="<?php echo trans('0171');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('0172');?></label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="lastname" placeholder="<?php echo trans('0172');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('094');?></label>
                                            <div class="form-group">
                                                <span class="la la-envelope-o form-icon"></span>
                                                <input class="form-control" type="email" name="email" placeholder="<?php echo trans('094');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('0175');?></label>
                                            <div class="form-group">
                                                <span class="la la-envelope-o form-icon"></span>
                                                <input class="form-control" type="email" name="confirmemail" placeholder="<?php echo trans('0175');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('098');?></label>
                                            <div class="form-group">
                                                <span class="la la-map-marked form-icon"></span>
                                                <input class="form-control" type="text" name="address" placeholder="<?php echo trans('098');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-12 -->
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('0105');?></label>
                                            <div class="form-group">
                                                <div class="select-contain w-auto">
                                                    <select class="select-contain-select" name="country">
                                                        <option value=""><?php echo trans('0484');?></option>
                                                        <?php foreach($allcountries as $country){ ?>
                                                        <option value="<?php echo $country->iso2;?>" <?php if($profile[0]->ai_country == $country->iso2){echo "selected";}?> ><?php echo $country->short_name;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('0414');?></label>
                                            <div class="form-group">
                                                <span class="la la-phone form-icon"></span>
                                                <input class="form-control" type="text" name="phone" placeholder="<?php echo trans('0414');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <div class="custom-checkbox mb-0">
                                                <input type="checkbox" id="receiveChb" />
                                                <label for="receiveChb" data-toggle="collapse" data-target="#special" aria-expanded="false" aria-controls="special" class="">
                                                <?php echo trans('0178');?>
                                                </label>
                                            </div>
                                            <div id="special" aria-expanded="false" class="collapse">
                                                <textarea class="form-control" placeholder="" rows="4" name="additionalnotes"></textarea>
                                                <?php echo trans('0415');?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-12 -->
                                </div>
                            </form>
                        </div>
                        <!-- PHPTRAVELS Guest Booking Ending  -->
                        <!-- PHPTRAVELS Sign in Starting  -->
                        <div class="tab-pane fade" id="Sign-In">
                            <form action="" method="POST" id="loginform" class="booking_page">
                                <div class="row">
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('094');?></label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="username" placeholder="<?php echo trans('094');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('095');?></label>
                                            <div class="form-group">
                                                <span class="la la-asterisk form-icon"></span>
                                                <input class="form-control" type="password" name="password" placeholder="<?php echo trans('095');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                </div>
                                <div class="panel-body">
                                    <div class="panel panel-default guest" style="margin-bottom:-15px">
                                        <div class="panel-heading d-flex">
                                            <label data-toggle="collapse" data-target="#special2" aria-expanded="false" aria-controls="special" class="">
                                            <input type="checkbox" />
                                            <?php echo trans('0178');?>
                                            </label>
                                        </div>
                                        <div id="special2" aria-expanded="false" class="collapse">
                                            <textarea class="form-control" placeholder=" " rows="4" name="additionalnotes"></textarea>
                                            <span><?php echo trans('0415');?></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php }else{ ?>
                    <!-- PHPTRAVELS LoggeIn Booking Starting  -->
                    <div id="loggeduserdiv">
                        <form id="loggedform">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('0171');?></label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="" placeholder="<?php echo trans('0171');?>" value="<?php echo $profile[0]->ai_first_name?>" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-6 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('0172');?></label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="" placeholder="<?php echo trans('0171');?>" value="<?php echo $profile[0]->ai_last_name?>" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-6 -->
                                    <div class="col-lg-12 responsive-column">
                                        <div class="input-box">
                                            <label class="label-text"><?php echo trans('094');?></label>
                                            <div class="form-group">
                                                <span class="la la-user form-icon"></span>
                                                <input class="form-control" type="text" name="" placeholder="<?php echo trans('094');?>" value="<?php echo $profile[0]->accounts_email?>" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col-lg-12 -->
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group ">
                                            <label  class="required go-right"><?php echo trans('0178');?></label>
                                            <textarea class="form-control form-bg-light" placeholder="<?php echo trans('0415');?>" rows="4" name="additionalnotes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- PHPTRAVELS LoggedIn User Booking Ending  -->
                    <?php } ?>
                </div>
                <?php  if(!empty($customerloggedin)){ ?>
                <?php }else{ if($allowreg == "1"){ ?>
            </div>
            <?php } } ?>
            <script>
                $("#guesttab").on("click", function() {
                $(".completebook").prop("name", "guest");
                });

                $("#signintab").on("click", function() {
                $(".completebook").prop("name", "login");
                });
            </script>
            <!-- PHPTRAVELS Sign in Ending  -->
        </div>
    </div>
</div>