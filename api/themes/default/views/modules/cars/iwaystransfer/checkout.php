<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 68px;
        height: 34px;
    }
    @media screen and (max-width:768px){
        .switch{
            width:73px;
        }
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #26a65b;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #26a65b;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
    .switch-border{
        border:1px solid #eee;
        border-radius: 30px;
    }
    
</style>



<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-action">
    <div class="page-wrapper page-payment bg-light">
        <div class="container">
            <div class="row gap-30">
                <div class="col-12 col-lg-4 order-lg-last">
                    <aside class="sticky-kit sidebar-wrapper">
                        <a href="#" class="product-small-item">
                            <div class="image">
                                <img style="height: 65px; padding: 30px 0px 0px 10px;" src="<?=$parms->img;?>" alt="image" />
                            </div>
                            <div class="content">
                                <div class="content-body">
                                    <h6><?=$parms->name;?></h6>
                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <?=$parms->name_form;?></span>
                                    <div class="row"></div>
                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <?=$parms->name_to;?></span>
                                </div>
                            </div>
                        </a>
                        <div class="clear"></div>
                        <div class="booking-selection-box">
                            <div class="content">
                                <!--<h5 class="font-serif font400"><?=lang('0411')?></h5>
                                <ul class="booking-amount-list clearfix mb-20">
                                    <li>
                                        23-11-2019<span class="font700">Mon</span>
                                    </li>
                                    <li class="text-right">
                                        26-11-2019<span class="font700">Wed</span>
                                    </li>
                                </ul>-->
                                <h5 class="font-serif font400"><?=lang('0127')?></h5>
                                <div class="hotel-room-sm-item mb-30">
                                    <!--<div class="the-room-item">
                                        <h6><?=lang('0528')?> <?=lang('0259')?></h6>
                                        <div class="clearfix">
                                            <span class="amount">75 min.</span>
                                        </div>
                                    </div>-->
                                    <div class="the-room-item">
                                        <h6><i class="ion-location text-info"></i> <?=lang('0273')?> <?=$parms->name_form;?></h6>
                                        <div class="clearfix">
                                            <span class="amount"><i class="ion-location text-info"></i> <?=lang('0274')?> <?=$parms->name_to;?></span>
                                            <!--<span class="price"></span>-->
                                        </div>
                                    </div>
                                </div>
                                <h5 class="font-serif font400"><?=lang('070')?></h5>
                                <ul class="summary-price-list">
                                    <li><?=lang('0563')?> <span class="absolute-right">USD <?=$parms->usd;?></span></li>
                                    <li class="total"><?=lang('0124')?> <?=$parms->curr_code?> <span class="text-main amount_cal absolute-right"> <?=$parms->price;?></span></li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="content-wrapper">
                        <div class="success-box">
                            <div class="icon">
                                <span><i class="ri ri-check-square"></i></span>
                            </div>
                            <div class="content">
                                <h4><?=lang('047')?></h4>
                                <p><?=lang('045')?></p>
                            </div>
                        </div>
                        <?php if($userAuthorization == 0){?>
                        <div class="alert alert-warning pt-10 pb-10 mb-30" role="alert"><i class="fas fa-info-circle mr-5"></i><?=lang('0473')?> <?=lang('0294')?>? <a href="javascript:void(0)" onclick="loginFunction()" class="letter-spacing-0"><b><?=lang('0236')?></b></a></div>
                        <?php } ?>
                        <form  name="iwaysBookingForm" class="payment-form-wrapper">
                            <input type="hidden" name="transfer_id" value="<?=$parms->transfer_id?>" />
                            <input type="hidden" name="flight_form" value="<?=$parms->name_form;?>" />
                            <input type="hidden" name="amount" id="amount" value="<?=$parms->price;?>" />
                            <input type="hidden" name="oneway_amount" id="oneway_amount" value="<?=$parms->price;?>" />
                            <input type="hidden" name="start_place_point" id="start_place_point" value="<?=$parms->start_place_point;?>" />
                            <input type="hidden" name="finish_place_point" id="finish_place_point" value="<?=$parms->finish_place_point;?>" />
                            <input type="hidden" name="laoction_form" id="laoction_form" value="<?=$parms->laoction_form;?>" />
                            <input type="hidden" name="laoction_to" id="laoction_to" value="<?=$parms->laoction_to;?>" />
                            <h3 class="heading-title"><span><?=lang('0460')?></span></h3>
                            <p class="post-heading"><?=lang('045')?></p>
                            <div class="bg-white-shadow pt-25 ph-30">
                                <div class="row gap-20 mb-0">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label><?=lang('090')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" value="<?=$fakedata->fname?>" name="first_name" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label><?=lang('091')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" value="<?=$fakedata->lname?>" name="last_name" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group">
                                            <label><?=lang('0173')?></label>
                                            <input type="text" class="form-control form-bg-light" name="phone" value="<?=$fakedata->phone_number?>" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group">
                                            <label><?=lang('094')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" name="email" value="<?=$fakedata->email?>" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group">
                                            <label><?=lang('0178')?></label>
                                            <textarea name="msg" id="msg" cols="30" rows="3" class="form-control form-bg-light" placeholder="<?=lang('0415')?>"><?=$fakedata->text?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-40"></div>
                            <h3 class="heading-title"><span><?=lang('0127')?></span></h3>
                            <p class="post-heading"><?=lang('0128')?></p>
                            <div class="bg-white-shadow pt-25 ph-30">
                                <!--<h6>Room #1</h6>-->
                                <div class="row gap-20 mb-0">
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group chosen-bg-light">
                                            <label><?=lang('0564')?> <?=lang('0434')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" name="flight_no" value="<?=$fakedata->flightno?>" required />
                                            <input type="hidden" value="<?=$parms->img;?>" class="form-control form-bg-light" name="taxi_image"/>
                                            <input type="hidden" value="<?=$parms->name;?>" class="form-control form-bg-light" name="taxi_name"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><?=lang('0625')?> </label>
                                            <input type="text" class="form-control form-bg-light kiwidate" name="date" value="<?=$fakedata->date?>" autocomplete="off" required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><?=lang('0259')?></label>
                                            <select class="chosen-the-basic form-control" name="time" required>
                                                <option value="<?php echo $faketime; ?>"><?php echo $faketime; ?></option>
                                                <?php foreach ($data['kiwiModTiming'] as $time) { ?>
                                                <option value="<?php echo $time; ?>" <?php makeSelected($data['pickupTime'], $time); ?> >
                                                    <?php echo $time; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><?=lang('0626')?> </label>
                                            <input type="text" class="form-control form-bg-light iwaysdate" name="idate" value="<?=$fakedata->date?>" autocomplete="off" required />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label><?=lang('0259')?></label>
                                            <select class="chosen-the-basic form-control" name="itime" required>
                                                <option value="<?php echo $faketime; ?>"><?php echo $faketime; ?></option>
                                                <?php foreach ($data['kiwiModTiming'] as $time) { ?>
                                                    <option value="<?php echo $time; ?>" <?php makeSelected($data['pickupTime'], $time); ?> >
                                                        <?php echo $time; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group chosen-bg-light">
                                            <label><?=lang('0120')?> <?=lang('032')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" name="loaction" value="<?=$fakedata->destloaction?>" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group chosen-bg-light">
                                            <label><?=lang('078')?> <?=lang('0528')?> <span class="font12 text-danger">*</span></label>
                                            <select name="pax" data-placeholder="Smoking Refernce" class="chosen-the-basic form-control" tabindex="2">
                                            <option value="1" selected="selected">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group chosen-bg-light">
                                            <label><?=lang('0627')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" name="pax_name" value="<?=$fakedata->paxname?>" required />
                                            <input type="hidden" class="form-control form-bg-light" name="pax_name" value="<?=$fakedata->paxname?>" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group chosen-bg-light">
                                            <label><?=lang('0628')?> <?=lang('032')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" name="pax_number" value="<?=$fakedata->paxmobile?>" required />
                                            <input type="hidden" class="form-control form-bg-light" name="pax_number" value="<?=$fakedata->paxmobile?>" required />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-40"></div>

                            <div class="mb-40"></div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" <?=$fakedata->checkbox;?> class="custom-control-input" id="acceptTerm" />
                                <label class="custom-control-label" for="acceptTerm"><?=lang('0416')?></label>
                            </div>
                            <div class="alert alert-danger" style="display:none"; id="error-msg"></div>
                            <button type="submit" id="booknow" class="btn btn-primary mt-20 btn-block"><?=lang('0142')?> <i class="fa fa-long-arrow-right"></i>
                                <span class="spinner-border spinner-border-sm" id="wait" style="display:none"; role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="fullwidth-horizon-sticky border-0">&#032;</div>

            <!-- is used to stop the above stick menu -->
        </div>
    </div>
</div>
<!-- end Main Wrapper -->
<script>
    $("[name='iwaysBookingForm']").on('submit', function(e) {
        e.preventDefault();
        var accept = document.getElementById('acceptTerm').checked;
        if(accept == true) {
            $("#wait").css("display", "inline-block");
            $("#booknow").attr("disabled", true);
            var form = $(this);
            var payload = form.serializeArray();
            $.post(base_url + 'itaxi/booking', payload, function (response) {
                result = jQuery.parseJSON(response);
                if (result.status == 1) {
                    $(location).attr('href', result.msg);
                }else{
                    $('#booknow').removeAttr("disabled");
                    $("#wait").css("display", "none");
                    $("#error-msg").css("display", "block");
                    $("#error-msg").empty().append(result.msg);

                }
            });
        }else{
            $('#booknow').removeAttr("disabled");
            $("#wait").css("display", "none");
            $("#error-msg").css("display", "block");
            $("#error-msg").empty().append("Please accept terms and conditions");
        }
    });
</script>
<script>
    function loginFunction() {
        var email = prompt("email");
        var pass = prompt("password");
        const payload = {
            email: email,
            password: pass
        };
        if(email !='' && pass !=''){
            $.post(base_url + 'auth/signin', payload, function (response) {
                if (response.status == 'success') {
                    location.reload();
                } else {
                    alert('Authentication Error: ' + response.message);
                }
            });
        }else{
            alert("Please Fill this input fields");
        }
    }
</script>
<script>
// $("[name='return_transfer']").on('click',function () {
// var ret = document.getElementById('return').checked;
// if(ret == true){
// var price = $("#amount").val() * 2;
// $("#amount").val(price);
// $(".amount_cal").text(price);
// }else{
// var price1 = $("#amount").val();
// var price2 = $("#oneway_amount").val();
// var org =  price1 - price2;
// $("#amount").val(org);
// $(".amount_cal").text(org);
// }
// });
// $('#return').on('change',function(){
// this.checked == true ? $('.switch-border').css('border-color','#26a65b') :
// $('.switch-border').css('border-color','#eee')
// })
</script>
