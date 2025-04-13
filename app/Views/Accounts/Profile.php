<div class="container">
    <div class="row g-2">
        <?php 
        $profile_data=$meta['data'];
        $countries=$meta['countries'];
        ?>

<div class="col-md-3">
        <?php require "Sidebar.php" ?>
        </div>
      
        <!-- ================================
    START PROFILE AREA
================================= -->
        <section class="col-md-9">
        
                <div class="">
                <div class="px-3 py-3">
                    <div class="row">
                        <div class="">
                            <div class="form-box">
                                <div class="form-title-wrap border-bottom-0 pb-0">
                                    <h5 class="fw-bold mb-3"><?= T::profileinformation ?></h5>
                                </div>
                                <div class="border p-4">
                                    <form id="profile" action="<?= root ?>profile" method="post">
                                        <div class="">
                                            <div class="alert alert-success d-none">
                                                <?= T::profileupdatedsuccessfully ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input required type="text" class="form-control" name="first_name"
                                                            id="<?= T::first_name ?>" placeholder=" "
                                                            value="<?= $profile_data->first_name ?>">
                                                        <label for="<?= T::first_name ?>"><?= T::first_name ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input required type="text" class="form-control" name="last_name"
                                                            id="<?= T::last_name ?>" placeholder=" "
                                                            value="<?= $profile_data->last_name ?>">
                                                        <label for="<?= T::last_name ?>"><?= T::last_name ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input required type="email" class="form-control" name="email"
                                                            id="<?= T::email ?>" placeholder=" "
                                                            value="<?= $profile_data->email ?>" readonly>
                                                        <label for="<?= T::email ?>"><?= T::email ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-4">
                                                    <div class="form-floating mb-3">
                                                        <input required type="password" name="password" class="form-control"
                                                            name="" id="<?= T::password ?>" placeholder=" " value="">
                                                        <label for="<?= T::password ?>"><?= T::password ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <select required name="phone_country_code"
                                                            class="selectpicker phone w-100" data-live-search="true"
                                                            required>
                                                            <option value=""><?= T::select ?> <?= T::country ?></option>
                                                            <?php foreach ($countries as $c) { ?>
                                                                <option value="<?= $c->id ?>"
                                                                    data-content="<img class='' src='./assets/img/flags/<?= strtolower($c->iso) ?>.svg' style='width: 20px; margin-right: 14px;color:#fff'><span class='text-dark'> <?= $c->nicename ?> <strong>+<?= $c->phonecode ?></strong></span>">
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <script>
                                                        $('.phone').val('<?= $profile_data->phone_country_code ?>')
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input required type="number" class="form-control" name="phone"
                                                            id="<?= T::phone ?>" placeholder=" "
                                                            value="<?= $profile_data->phone ?>">
                                                        <label for="<?= T::phone ?>"><?= T::phone ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <select required name="country_code" class="selectpicker country w-100"
                                                            data-live-search="true" required>
                                                            <option value=""><?= T::select ?> <?= T::country ?></option>
                                                            <?php foreach ($countries as $c) { ?>
                                                                <option value="<?= $c->id ?>"
                                                                    data-content="<img class='' src='./assets/img/flags/<?= strtolower($c->iso) ?>.svg' style='width: 20px; margin-right: 14px;color:#fff'><span class='text-dark'> <?= $c->nicename ?></span>">
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <script>
                                                        $('.country').val('<?= $profile_data->country_code ?>')
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input required type="text" class="form-control" name="state"
                                                            id="<?= T::state ?>" placeholder=" "
                                                            value="<?= $profile_data->state ?>">
                                                        <label for="<?= T::state ?>"><?= T::state ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3">
                                                        <input required type="text" class="form-control" name="city"
                                                            id="<?= T::city ?>" placeholder=" "
                                                            value="<?= $profile_data->city ?>">
                                                        <label for="<?= T::city ?>"><?= T::city ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3">
                                                        <input required type="text" class="form-control" name="address1"
                                                            id="<?= T::address ?>" placeholder=" "
                                                            value="<?= $profile_data->address1 ?>">
                                                        <label for="<?= T::address ?>"><?= T::address ?> 1</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="address2"
                                                            id="<?= T::address ?>" placeholder=" "
                                                            value="<?= $profile_data->address2 ?>">
                                                        <label for="<?= T::address ?>"><?= T::address ?> 2</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-box mt-4">
                                                <button style="height:44px" type="submit" class="w-100 submit_button btn btn-primary btn-m rounded-sm"><?= T::updateprofile ?></button>
                                            
                                                <div class="loading_button" style="display:none">
                                    <button style="height:44px"
                                        class="loading_button w-100 btn btn-primary btn-m rounded-sm"
                                        type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                    </button>
                                </div>
                                            </div>

                                            <input type="hidden" name="form_token" value="<?= $_SESSION["form_token"] ?>">
                                            <input type="hidden" name="user_id" value="<?= $profile_data->user_id ?>">
                                    </form>
                                </div>
                            </div><!-- end form-box -->
                        </div><!-- end col-lg-12 -->
                    </div><!-- end row -->
                </div>
            </div>
    </div>
    </section>
    <script>
    $("#profile").submit(function() {
    $('.submit_button').hide();
    $('.loading_button').show();
    })
    </script>

    <style>
     .newsletter-section {display:none}
    </style>