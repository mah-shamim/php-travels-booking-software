<div class="">
                    <div class="">
                    
                    <!-- adults -->
                    <?php if (isset($_SESSION['flights_adults'])) {
                    $travellers = $_SESSION['flights_adults'];
                    } else $travellers = 1; for ($i = 1; $i <= $travellers; $i++) { ?>
                     <div class="card mb-3">
                        <div class="card-header">
                            <?=T::adult?> <?=T::traveller?> <strong><?=$i?></strong>
                        </div>
                        <div class="card-body">

                        <?php
                        // generate random words
                        $range1 = range('A', 'Z');  $index1 = array_rand($range1);
                        $range2 = range('A', 'Z');  $index2 = array_rand($range2); ?>

                        <!-- personal info -->
                        <div class="row">
                        <div class="col-md-2">
                        <input type="hidden" name="traveller_type_<?=$i?>" value="adults">

                        <div class="form-floating">
                        <select name="title_<?=$i?>" class="form-select">
                        <option value="Mr"><?=T::mr?></option>
                        <option value="Miss"><?=T::miss?></option>
                        <option value="Mrs"><?=T::mrs?></option>
                        </select>
                        <label class="label-text"><?=T::title?></label>

                        </div>

                    </div>
                        <div class="col-md-4">
                        <div class="form-floating">

                        <input required type="text" name="first_name_<?=$i?>" class="form-control" placeholder="<?=T::first_name?>" value="<?php if (dev == 1){echo "Elan".$range1[$index1];}?>"/>
                        <label class="label-text"><?=T::first_name?></label>
    
                    </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-floating">

                        <input required type="text" name="last_name_<?=$i?>" class="form-control" placeholder="<?=T::last_name?>" value="<?php if (dev == 1){echo "Mask".$range2[$index2];}?>"/>
                        <label class="label-text"><?=T::last_name?></label>
   
                    </div>
                        </div>
                        </div>

                        <!-- nationality and personality -->
                        <div class="row mt-3">
                        <div class="col-md-6">
                        <div class="form-floating">
                        <select required class="form-select nationality" name="nationality_<?=$i?>">
                        <?php if (dev == 1){?>
                        <option value="pakistan">Pakistan</option>
                        <?php }?>
                        <?=countries_list();?>
                        </select>
                        <label class="label-text"><?=T::nationality?></label>

                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="dob_month_<?=$i?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text"><?=T::date_of_birth?></label>

                        </div>
                        </div>
                        <div class="col-3">
                        <div class="form-floating">

                        <select name="dob_day_<?=$i?>" class="form-select form-select">
                        <?=month_days()?>
                        </select>
                        
                        <label class="label-text"><?=T::day?></label>


                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="dob_year_<?=$i?>">
                            <?php 
                            $already_selected_value = 1984;
                            $earliest_year = 1920;
                            foreach (range(date('Y'), $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>
                        <label class="label-text"><?=T::year?></label>

                    </div>
                    </div>
                        </div>
                        </div>
                        </div>

                        <hr>

                        <!-- passport credentials -->
                        <div class="row mt-3">
                        <div class="col-md-12">
                        <p class="m-0 text-end" style="position: absolute; z-index: 99; right: 32px; color: #b2b2b2; margin: 16px !important;"><small><strong>6 - 15 <?=T::numbers?></strong></small></p>
                        <div class="form-floating">

                        <input required type="text" name="passport_<?=$i?>" class="form-control" placeholder="<?=T::passport_or_id?>" value="<?php if (dev == 1){echo "6655899745626";}?>"/>
                        <label class="label-text"><?=T::passport_or_id?></label>

                       </div>
                       </div>

                        <div class="col-md-6 mt-3"> 
                        <div class="row g-2">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_month_<?=$i?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text"> <?=T::issuance_date?></label>

                        </div>
                        </div>
                        <div class="col-3">
                        <div class="form-floating">

                            <select class="form-select form-select" name="passport_issuance_day_<?=$i?>">
                            <?=month_days()?>
                            </select>
                            <label class="label-text"><?=T::day?></label>

                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_year_<?=$i?>">
                            <?php 
                            $already_selected_value = 2020;
                            $earliest_year = 1920;
                            foreach (range(date('Y'), $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>    
                        <label class="label-text"><?=T::year?></label>
                    
                        </div>
                        </div>
                        </div>
                        </div>

                        <div class="col-md-6 mt-3">
                        <div class="row g-2">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_month_expiry_<?=$i?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text"><?=T::expiry_date?></label>

                        </div>
                        </div>
                        <div class="col-3">
                        <div class="form-floating">

                            <select class="form-select form-select" name="passport_day_expiry_<?=$i?>">
                            <?=month_days()?>
                            </select>
                            <label class="label-text"><?=T::day?></label>

                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_year_expiry_<?=$i?>">
                            <?php 
                            $already_selected_value = date('Y')+2;
                            $earliest_year = date('Y');
                            foreach (range(date('Y')+20, $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>
                        <label class="label-text"><?=T::year?></label>

                        </div>
                        </div>
                        </div>
                        </div>

                        </div>

                        </div>
                     </div>
                     <?php } ?>

                     <!-- child -->
                     <?php if (isset($_SESSION['flights_childs'])) {
                    $travellers = $_SESSION['flights_childs'];
                    } else $travellers = 1; for ($i = 1; $i <= $travellers; $i++) { ?>
                     <div class="card mb-3">
                        <div class="card-header">
                             <!-- childs -->
                             <?=T::childs?> <?=T::traveller?> <strong><?=$i+$_SESSION['flights_adults']?></strong>
                        </div>
                        <div class="card-body">

                        <?php
                        // generate random words
                        $range1 = range('A', 'Z');  $index1 = array_rand($range1);
                        $range2 = range('A', 'Z');  $index2 = array_rand($range2); ?>

                        <!-- personal info -->
                        <div class="row">
                        <div class="col-md-2">
                            
                        <input type="hidden" name="traveller_type_<?=$i+$_SESSION['flights_adults']?>" value="child">
                        <div class="form-floating">

                        <select name="title_<?=$i+$_SESSION['flights_adults']?>" class="form-select">
                        <option value="Mr"><?=T::mr?></option>
                        <option value="Miss"><?=T::miss?></option>
                        <option value="Mrs"><?=T::mrs?></option>
                        </select>
                        <label class="label-text"><?=T::title?></label>

                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-floating">

                        <input required type="text" name="first_name_<?=$i+$_SESSION['flights_adults']?>" class="form-control" placeholder="<?=T::first_name?>" value="<?php if (dev == 1){echo "Elan".$range1[$index1];}?>"/>
                        <label class="label-text"><?=T::first_name?></label>
    
                    </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-floating">

                        <input required type="text" name="last_name_<?=$i+$_SESSION['flights_adults']?>" class="form-control" placeholder="<?=T::last_name?>" value="<?php if (dev == 1){echo "Mask".$range2[$index2];}?>"/>
                        <label class="label-text"><?=T::last_name?></label>
    
                    </div>
                        </div>
                        </div>

                        <!-- nationality and personality -->
                        <div class="row mt-3">
                        <div class="col-md-6">
                        <div class="form-floating">

                        <select required class="form-select form-select nationality" name="nationality_<?=$i+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="pakistan">Pakistan</option>
                        <?php }?>
                        <?=countries_list();?>
                        </select>
                        <label class="label-text"><?=T::nationality?></label>

                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="dob_month_<?=$i+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text"><?=T::date_of_birth?></label>

                        </div>
                        </div>
                        <div class="col-3">
                        <div class="form-floating">

                         <select name="dob_day_<?=$i+$_SESSION['flights_adults']?>" class="form-select form-select">
                        <?=month_days()?>
                        </select>
                        <label class="label-text"><?=T::day?></label>

                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="dob_year_<?=$i+$_SESSION['flights_adults']?>">
                            <?php 
                            $already_selected_value = 1984;
                            $earliest_year = 1920;
                            foreach (range(date('Y'), $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>

                        <label class="label-text"><?=T::year?></label>

                        </div>
                        </div>
                        </div>
                        </div>
                        </div>

                        <hr>

                        <!-- passport credentials -->
                        <div class="row mt-3">
                        <div class="col-md-12">
                        <p class="m-0 text-end" style="position: absolute; z-index: 99; right: 32px; color: #b2b2b2; margin: 16px !important;"><small><strong>6 - 15 <?=T::numbers?></strong></small></p>

                        <div class="form-floating">

                        <input required type="text" name="passport_<?=$i+$_SESSION['flights_adults']?>" class="form-control" placeholder="<?=T::passport_or_id?>" value="<?php if (dev == 1){echo "6655899745626";}?>"/>
                        <label class="label-text"><?=T::passport_or_id?></label>
   
                    </div>
                        </div>

                        <div class="col-md-6 mt-3">
                        <div class="row g-2">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_month_<?=$i+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text"><?=T::issuance_date?></label>

                        </div>
                        </div>
                        <div class="col-3">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_day_<?=$i+$_SESSION['flights_adults']?>">
                        <?=month_days()?>
                        </select>
                        <label class="label-text"><?=T::day?></label>

                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_year_<?=$i+$_SESSION['flights_adults']?>">
                            <?php 
                            $already_selected_value = 2020;
                            $earliest_year = 1920;
                            foreach (range(date('Y'), $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>
                        <label class="label-text"><?=T::month?></label>

                         </div>
                        </div>
                        </div>
                        </div>

                        <div class="col-md-6 mt-3">
                        <div class="row g-2">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_month_expiry_<?=$i+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text"><?=T::expiry_date?></label>

                        </div>
                        </div>
                        <div class="col-3">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_day_expiry_<?=$i+$_SESSION['flights_adults']?>">
                        <?=month_days()?>
                        </select>
                        
                        <label class="label-text"><?=T::day?></label>

                         </div>
                         </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_year_expiry_<?=$i+$_SESSION['flights_adults']?>">
                            <?php 
                            $already_selected_value = date('Y')+2;
                            $earliest_year = date('Y');
                            foreach (range(date('Y')+20, $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>

                        <label class="label-text"><?=T::year?></label>


                         </div>
                         </div>
                        </div>
                        </div>

                        
                        </div>

                        </div>
                     </div>
                     <?php } ?>

                     <!-- infants -->
                     <?php if (isset($_SESSION['flights_infants'])) {
                    $travellers = $_SESSION['flights_infants'];
                    } else $travellers = 1; for ($i = 1; $i <= $travellers; $i++) { ?>
                     <div class="card mb-3">
                        <div class="card-header">
                            <?=T::infant?> <?=T::traveller?> <strong><?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?></strong>
                        </div>
                        <div class="card-body">

                        <?php
                        // generate random words
                        $range1 = range('A', 'Z');  $index1 = array_rand($range1);
                        $range2 = range('A', 'Z');  $index2 = array_rand($range2); ?>

                        <!-- personal info -->
                        <div class="row">
                        <div class="col-md-2">
                        <input type="hidden" name="traveller_type_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>" value="infant">
                        <div class="form-floating">

                        <select name="title_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>" class="form-select">
                        <option value="Mr"><?=T::mr?></option>
                        <option value="Miss"><?=T::miss?></option>
                        <option value="Mrs"><?=T::mrs?></option>
                        </select>
                        <label class="label-text"><?=T::title?></label>

                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-floating">

                        <input required type="text" name="first_name_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>" class="form-control" placeholder="<?=T::first_name?>" value="<?php if (dev == 1){echo "Elan".$range1[$index1];}?>"/>
                        <label class="label-text"><?=T::first_name?></label>
  
                    </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-floating">

                        <input required type="text" name="last_name_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>" class="form-control" placeholder="<?=T::last_name?>" value="<?php if (dev == 1){echo "Mask".$range2[$index2];}?>"/>
                        <label class="label-text"><?=T::last_name?></label>
    
                    </div>
                        </div>
                        </div>

                        <!-- nationality and personality -->
                        <div class="row mt-3">
                        <div class="col-md-6">
                        <div class="form-floating">

                        <select required class="form-select form-select nationality" name="nationality_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="pakistan">Pakistan</option>
                        <?php }?>
                        <?=countries_list();?>
                        </select>
                        <label class="label-text"><?=T::nationality?></label>

                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="row">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="dob_month_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text"><?=T::date_of_birth?></label>

                        </div>
                        </div>
                        <div class="col-3">
                        <div class="form-floating">

                        <select name="dob_day_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>" class="form-select form-select">
                        <?=month_days()?>
                        </select>
                        <label class="label-text"><?=T::day?></label>


                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="dob_year_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                            <?php 
                            $already_selected_value = 1984;
                            $earliest_year = 1920;
                            foreach (range(date('Y'), $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>
                        <label class="label-text"><?=T::month?></label>

                         </div>
                        </div>
                        </div>
                        </div>
                        </div>

                        <hr>

                        <!-- passport credentials -->
                        <div class="row mt-3">
                        <div class="col-md-12">
                        <p class="m-0 text-end" style="position: absolute; z-index: 99; right: 32px; color: #b2b2b2; margin: 16px !important;"><small><strong>6 - 15 <?=T::numbers?></strong></small></p>

                        <div class="form-floating">

                        <input required type="text" name="passport_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>" class="form-control" placeholder="<?=T::passport_or_id?>" value="<?php if (dev == 1){echo "6655899745626";}?>"/>
                        <label class="label-text"><?=T::passport_or_id?></label>
   
                    </div>
                        </div>

                        <div class="col-md-6 mt-3">
                        <div class="row g-2">
                        <div class="col-5">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_month_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>

                        <label class="label-text"><?=T::issuance_date?></label>

                        </div>
                        </div>
                        <div class="col-3">
                         
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_day_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                        <?=month_days()?>
                        </select>
                        <label class="label-text"><?=T::day?></label>


                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_issuance_year_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                            <?php 
                            $already_selected_value = 2020;
                            $earliest_year = 1920;
                            foreach (range(date('Y'), $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>
                        <label class="label-text"><?=T::year?></label>

                        </div>
                        </div>
                        </div>
                        </div>
                        
                        <div class="col-md-6 mt-3">

                        <div class="row g-2">
                        <div class="col-5">

                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_month_expiry_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                        <?php if (dev == 1){?>
                        <option value="01">01 January</option>
                        <?php }?>
                        <!-- <option value="1"><?=T::month?></option> -->
                        <?php months_list()?>
                        </select>
                        <label class="label-text">  <?=T::expiry_date?></label>

                        </div>
                        </div>
                        <div class="col-3">

                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_day_expiry_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                        <?=month_days()?>
                        </select>
                        <label class="label-text"><?=T::day?></label>

                         </div>
                         </div>
                        <div class="col-4">
                        <div class="form-floating">

                        <select class="form-select form-select" name="passport_year_expiry_<?=$i+$_SESSION['flights_childs']+$_SESSION['flights_adults']?>">
                            <?php 
                            $already_selected_value = date('Y')+2;
                            $earliest_year = date('Y');
                            foreach (range(date('Y')+20, $earliest_year) as $x) { ?>
                                <?php print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>'; ?>
                            <?php } ?>
                        </select>
                        <label class="label-text"><?=T::year?></label>

                         </div>
                         </div>
                        </div>
                        </div>

                        </div>

                        </div>
                     </div>
                     <?php } ?>
                    </div>
                 </div>