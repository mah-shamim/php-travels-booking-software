<body onload=display_ct();>
<!-- ================================
       START DASHBOARD NAV
================================= -->
<?php require "sidebar.php"?>
<!-- ================================
    START DASHBOARD AREA
================================= -->
<section class="dashboard-area">
    <div class="dashboard-content-wrap">
        <?php require "headbar.php"?>
        <div class="dashboard-main-content">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-box">
                            <div class="form-title-wrap border-bottom-0 pb-0">
                                <h3 class="title"><?=T::profileinformation?></h3>
                            </div>
                            <div class="form-content">
                            <form action="<?= root ?>account/profile_update" method="post">
                                <div class="table-form table-responsive contact-form-action">
                                <div class="alert alert-success d-none">
                                   <i class="la la-info-circle"></i> <?=T::profileupdatedsuccessfully?>
                                </div>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::firstname?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-user form-icon"></span>
                                                 <input class="form-control" type="text" name="firstname" value="<?=$profile_data->ai_first_name?>">
                                                <input class="form-control" type="hidden" name="id" value="<?=$profile_data->accounts_id?>">
                                                </div>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::lastname?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-user form-icon"></span>
                                                 <input class="form-control" type="text" name="lastname" value="<?=$profile_data->ai_last_name?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::phone?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-phone form-icon"></span>
                                                 <input class="form-control" type="text" name="phone" value="<?=$profile_data->ai_mobile?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::email?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-envelope form-icon"></span>
                                                 <input class="form-control" type="email" name="email" value="<?=$profile_data->accounts_email?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::password?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-star-of-life form-icon"></span>
                                                 <input class="form-control" type="password" name="password" value="demouser">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::country?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                <span class="la la-flag form-icon"></span>
                                                <div class="input-items">
                                                <select id="from_country" name="country" class="select_ form-control">
                                                <option value="<?=$profile_data->ai_country?>"><?=$profile_data->ai_country?></option>
                                                <?= countries_list();?>
                                                </select>
                                                </div>
                                                </div>
                                                <!--<div class="form-group">
                                                  <span class="la la-globe form-icon"></span>
                                                  <select name="" id="" class="select_">
                                                   <?= countries_list(); ?>
                                                  </select>
                                                 <input class="form-control" type="text" name="country" value="<?=$profile_data->ai_country?>">
                                                </div>-->

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::state?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-map-marker form-icon"></span>
                                                 <input class="form-control" type="text" name="state" value="<?=$profile_data->ai_state?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::city?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-map form-icon"></span>
                                                 <input class="form-control" type="text" name="city" value="<?=$profile_data->ai_city?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::fax?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-phone form-icon"></span>
                                                 <input class="form-control" type="text" name="fax" value="<?=$profile_data->ai_fax?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::postal_code?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-box form-icon"></span>
                                                 <input class="form-control" type="text" name="zip" value="<?=$profile_data->ai_postal_code?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::address?></h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-home form-icon"></span>
                                                 <input class="form-control" type="text" name="address1" value="<?=$profile_data->ai_address_1?>">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pl-0">
                                                    <div class="table-content">
                                                        <h3 class="title font-weight-medium"><?=T::address?> 2</h3>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <td>
                                                <div class="form-group">
                                                  <span class="la la-home form-icon"></span>
                                                 <input class="form-control" type="text" name="address2" value="<?=$profile_data->ai_address_2?>">
                                                </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="section-block"></div>
                                <div class="btn-box mt-4">
                                    <button type="submit" class="theme-btn"><?=T::updateprofile?></button>
                                </div>
                                </form>
                            </div>
                        </div><!-- end form-box -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
                <div class="border-top mt-4"></div>
            </div>
        </div>
    </div>
</section>

<script>
if (location.pathname.substring(1) == 'account/profile/success'){ $(".alert-success").removeClass("d-none"); };
</script>
<style>.cta-area{display:none}</style>