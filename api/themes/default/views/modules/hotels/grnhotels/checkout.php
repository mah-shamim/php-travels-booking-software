<style>
    .nav-tabs>li>a {
        background: rgba(0, 0, 0, 0.09);
        border-radius: 0px;
        color: #000 !important;
        padding: 10px;
        font-size: 14px;
    }
    .nav-tabs>li>a{display:block}
    .nav-tabs>li{flex:1}
    .form-bg-light{background:#f9f9f9}
    .form-control{font-size:1rem!important}
    .nav-tabs>li>a.active{background:#76ce85!important;position:relative}
    .select2-container .select2-choice>.select2-chosen {
        padding-top:7px !important;
    }
    .select2-container .select2-choice {
        float:none !important;
        left: 10px;
    }
    .content-body .ion-location:before{
        float:none !important;
    }
    .select2-container.form-control{
        overflow:hidden;
    }
</style>
<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-action">
    <?php const BOOKING = 'booking';
    if ($api_response->status == 'error'): ?>
        <div class="container">
            <div class="alert alert-danger"><?=$api_response->data?></div>
        </div>
    <?php else: ?>
    <div class="page-wrapper page-payment bg-light">
        <div class="container">
            <div class="row gap-30">
                <div class="col-12 col-lg-4 order-lg-last">
                    <aside class="sticky-kit sidebar-wrapper">
                        <a data-toggle="collapse" href="#details" class="product-small-item">
                            <div class="image">
                                <img  style="height: 100px; padding: 4px 0px 0px 4px;" src="<?=$hotel['image']?>" style="width: 100%;" alt="WY">
                            </div>
                            <div class="content">
                                <div class="content-body">
                                    <h6 class="float-none"><?=$hotel['hotel_name']?></h6>
                                        <span class="meta text-muted"></i>  <?=$hotel['room_name']?> </span>
                                        <div class="row"></div>
                                    <span class="meta text-muted"></i>  <?=$hotel['currency']." ".$hotel["price"]?> </span>

                                </div>
                            </div>
                        </a>
                        <div class="clear"></div>
                    </aside>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="content-wrapper">
                        <div class="success-box">
                            <div class="icon">
                                <span><i class="ri ri-check-square"></i></span>
                            </div>
                            <div class="content">
                                <h4><?=lang('0566')?></h4>
                                <div class="clear"></div>
                                <p class="go-text-right"><?=lang('045')?></p>
                            </div>
                        </div>
                        <div class="alert alert-danger text-center font-size-h2" id="countdown">00:00</div>
                        <!-- <form > -->

                        <form method="post" id="paymentFrm" action="<?php echo base_url('grnhotels/' . BOOKING . ''); ?>" class="bg-white-shadow pt-25 ph-30 pb-40 mt-30" name="ticketBookingForm">
                            <div>
                                <div class="row gap-20 mb-0">
                                    <div class="col-md-12">
                                        <?php foreach ($passengers as $index => $passenger): ?>
                                            <section>
                                                <h4 class="mb-0"><strong class="text-primary"><?= ucfirst($passenger) .' '. ($index + 1)?></strong></h4>
                                                <div class="clear"></div>
                                                <input name="type[]" type="hidden" value="<?=($passenger=="Adult")?"AD":"CH"?>">
                                                <hr>
                                                <div class="row row-reverse">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="title"><?=lang('089')?></label>
                                                            <select class="form-control" id="title" name="title[]" required>
                                                                <option value="Mr."><?php echo trans('0567');?>.</option>
                                                                <option value="Ms."><?php echo trans('0568');?>.</option>
                                                                <option value="Master."><?php echo trans('0569');?>.</option>
                                                                <option value="Miss."><?php echo trans('0570');?>.</option>
                                                                <option value="Mrs."><?php echo trans('0571');?>.</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="name"><?=lang('0350')?></label>
                                                            <input type="text" class="form-control" id="name" name="name[]" required value="<?php echo $fakedata->name; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="surname">Surname</label>
                                                            <input type="text" class="form-control" id="surname" name="surname[]" required value="<?php echo $fakedata->surname; ?>">
                                                        </div>
                                                    </div>
                                                </div>



                                            </section>
                                        <?php endforeach; ?>
                                    </div>
                                </div>


                                <div class="mb-40"></div>
                                <h3 class="heading-title"><span><?=lang('0407')?></span></h3>
                                <div class="clear"></div>
                                <p class="post-heading go-text-right"><?=lang('0159')?></p>
                                <div class="bg-white-shadow pt-25 ph-30 pb-40">
                                    <div class="clear mb-20"></div>
                                    <h6><?=lang('0265')?></h6>
                                    <div class="clear"></div>
                                    <div id="payment-errors"></div>
                                    <div class="payment-option-box">
                                        <div class="payment-option-item">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="paymentOptionCreditBar" name="paymentOption" class="custom-control-input" checked  />
                                                <label class="custom-control-label" for="paymentOptionCreditBar"><?=lang('0609')?></label>
                                                <div class="clear"></div>
                                                <div class="payment-desc">
                                                    <div class="card-form">
                                                        <div class="row gap-20 mb-0 row-reverse">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="title"><?=lang('089')?></label>
                                                                    <select class="form-control" id="title" name="card[title]" required>
                                                                        <option value="Mr."><?php echo trans('0567');?>.</option>
                                                                        <option value="Ms."><?php echo trans('0568');?>.</option>
                                                                        <option value="Master."><?php echo trans('0569');?>.</option>
                                                                        <option value="Miss."><?php echo trans('0570');?>.</option>
                                                                        <option value="Mrs."><?php echo trans('0571');?>.</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group ">
                                                                    <label  class="required"><?php echo trans('0350');?></label>
                                                                    <input type="text" class="form-control" name="card[name]" value="<?php echo $fakedata->name; ?>" required id="card-number" placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group ">
                                                                    <label  class="required"><?php echo "Surname";?></label>
                                                                    <input type="text" class="form-control" name="card[surname]" value="<?php echo $fakedata->surname; ?>" required id="card-number" placeholder="Surname Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label  class="required"><?php echo trans('0316');?></label>
                                                                    <input type="text" class="form-control" name="card[pan_number]" value="<?php echo $fakedata->card_number; ?>" required id="card-number" placeholder="Pan Card Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label  class="required"><?php echo "Phone Number";?></label>
                                                                    <input type="text" class="form-control" name="card[phone_number]" value="<?php echo $fakedata->phone_number; ?>" required id="card-number" placeholder="Phone Number">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group ">
                                                                    <label  class="required"><?php echo "Email";?></label>
                                                                    <input type="text" class="form-control" name="card[email]" value="<?php echo $fakedata->email; ?>" required id="card-number" placeholder="Phone Number">
                                                                </div>
                                                            </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group ">
                                                                <label  class="required"><?php echo trans('0105');?></label>
                                                                <select data-placeholder="Select" id="country" name="card[client_nationality]" class="form-control">
                                                                    <option value=""> <?php echo trans('0158');?> <?php echo trans('0105');?> </option>
                                                                    <?php foreach($allcountries as $c){ ?>
                                                                        <option value="<?php echo $c->iso2;?>" <?=($c->iso2=="IN")?"selected":''; ?> ><?php echo $c->short_name;?></option>
                                                                    <?php }  ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ ."panel panel-default: Payment Information -->
                                <div class="alert alert-danger mt-20">
                                    <strong class="RTL go-right"><?php echo trans('045');?></strong>
                                    <hr>
                                    <p class="RTL" style="font-size:12px"><?php echo trans('0461');?></p>
                                </div>
                                <div class="mb-40"></div>
                                <div class="custom-control custom-checkbox form-group acceptterm">
                                    <input type="checkbox" class="custom-control-input" id="acceptTerm" />
                                    <label class="custom-control-label" for="acceptTerm"><?=lang('0416')?></label>
                                </div>
                                <input type="hidden" name="currency" value="<?= $hotel["currency"]?>">
                                <input type="hidden" name="price" value="<?= $hotel["price"]; ?>">
                                <input type="hidden" name="payload" value='<?= $final_payload; ?>'>
                                <button onclick="scrollWin(0, -15000)" type="submit" class="btn btn-primary btn-lg btn-block completebook upClick" id="confirmBooking"><?php echo trans('0335');?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="fullwidth-horizon-sticky border-0">&#032;</div>
            <!-- is used to stop the above stick menu -->
        </div>
    </div>
</div>

<?php endif; ?>
<style>
    .select2-choice {
        height: 36px!important;
        line-height: 60px!important;
    }
    .select2-container .select2-choice>.select2-chosen {
        line-height: 25px;
    }
</style>
<br><br><br>

<!-- end Main Wrapper -->
<!--/ .scroll up -->

<script>
    function scrollWin(x, y) {
        window.scrollBy(x, y);
    }

    $(document).ready(function() {
        $("[name^=nationality]").select2();

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        const countdownBox = 'countdown';

        // Set the date we're counting down to
        var expiry_minutes = '10';
        var countDownDate = new Date(new Date().getTime() + expiry_minutes * 60000).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById(countdownBox).innerHTML = minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                // Unhold seats.
                if (v.seats.length > 0) {
                    v.unHoldSeat(v.seats);
                } else {
                    document.getElementById(countdownBox).innerHTML = "EXPIRED";
                    setTimeout(function () { window.location.href = '<?=base_url()?>'; }, 3000);
                }
            }
        }, 1000);
    });




    $("[name='ticketBookingForm']").on('submit', function(e) {
        e.preventDefault();
        var datastring = $("[name='ticketBookingForm']").serialize();
        $.ajax({
            type: "POST",
            url: "<?=base_url('grnhotels/bookings')?>",
            data: datastring,
            success: function(data) {
                var data = JSON.parse(data)
                if(data.status){
                    window.location.href = data.url
                }else{
                    alert("Error from server side try latter");
                }

            },
            error: function() {
            }
        });

    });

</script>