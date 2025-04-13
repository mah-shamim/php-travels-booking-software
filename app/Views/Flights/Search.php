<form id="flights-search" class="content m-0 search_box">
    <?php if(isset($_SESSION['flights_type']) == "" ) { $_SESSION['flights_type'] = "oneway"; }?>

    <div class="row mb-3 g-2 pt-2" style="justify-content: space-between;">

        <div class="col-md-4 flight_types m-0">
            <div class="row">
                <div class="d-flex gap-4 m-1">
                    <div class="form-check d-flex align-items-center gap-2 p-0">
                        <input class="form-check-input m-0" type="radio" name="trip" id="one-way" onclick="oneway();"
                            value="oneway"
                            <?php if ($_SESSION['flights_type'] == "oneway") { echo "checked"; } else {} ?>>
                        <label class="form-check-label" for="one-way">
                            <!--<i class="icon mdi mdi-arrow-missed"></i>--> <?=T::one_way?>
                        </label>
                    </div>

                    <div class="form-check d-flex align-items-center gap-2 p-0">
                        <input class="form-check-input m-0" type="radio" name="trip" id="round-trip" value="return"
                            <?php if ($_SESSION['flights_type'] == "return") { echo "checked"; } else {} ?>>
                        <label class="form-check-label" for="round-trip">
                            <!--<i class="icon mdi mdi-import-export"></i>--> <?=T::round_trip?>
                        </label>
                    </div>

                    <?php 
                    $modules=(base()->modules);
                    foreach($modules as $m){
                        if ($m->name=="travelport"){ ?>
                    
                       <div class="form-check d-flex align-items-center gap-2 p-0">
                        <input class="form-check-input m-0" type="radio" name="trip" id="multi-trip"
                            onclick="multiway();" value="multiway"
                            <?php if ($_SESSION['flights_type'] == 'multiway') { echo "checked"; } else {} ?>>
                        <label class="form-check-label" for="multi-trip"> <?=T::multi_way?></label>
                    </div>

                    <?php } } ?>

                </div>
            </div>
        </div>
        <div class="col-md-2 mt-0">
            <select name="" id="flight_type" class="flight_type form-select form-select-sm px-3">
                <?php if (isset($_SESSION['flights_class']) == '') { $_SESSION['flights_class']=strtolower(T::flights_economy); } else { } ?>
                <option value="economy"
                    <?php if ($_SESSION['flights_class'] == strtolower("economy")) { echo "selected"; } else { } ?>>
                    <?=T::flights_economy?></option>
                <option value="economy_premium"
                    <?php if ($_SESSION['flights_class'] == strtolower("economy_premium")) { echo "selected"; } else { } ?>>
                    <?=T::flights_economy_premium?></option>
                <option value="business"
                    <?php if ($_SESSION['flights_class'] == strtolower("business")) { echo "selected"; } else { } ?>>
                    <?=T::flights_business?></option>
                <option value="first"
                    <?php if ($_SESSION['flights_class'] == strtolower("first")) { echo "selected"; } else { } ?>>
                    <?=T::flights_first?></option>
            </select>
        </div>
    </div>


    <div class="row mb-0 g-2 flight_search" id="onereturn">
        <div class="col-md-3">
            <div class="input-items from_flights">
                <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Transport" transform="translate(-624.000000, 0.000000)">
                                <g id="flight_takeoff_line" transform="translate(624.000000, 0.000000)">
                                    <path
                                        d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                        id="MingCute" fill-rule="nonzero"> </path>
                                    <path
                                        d="M20.9999,20 C21.5522,20 21.9999,20.4477 21.9999,21 C21.9999,21.51285 21.613873,21.9355092 21.1165239,21.9932725 L20.9999,22 L2.99988,22 C2.44759,22 1.99988,21.5523 1.99988,21 C1.99988,20.48715 2.38591566,20.0644908 2.8832579,20.0067275 L2.99988,20 L20.9999,20 Z M7.26152,3.77234 C7.60270875,3.68092 7.96415594,3.73859781 8.25798121,3.92633426 L8.37951,4.0147 L14.564,9.10597 L18.3962,8.41394 C19.7562,8.16834 21.1459,8.64954 22.0628,9.68357 C22.5196,10.1987 22.7144,10.8812 22.4884,11.5492 C22.1394625,12.580825 21.3287477,13.3849891 20.3041894,13.729249 L20.0965,13.7919 L5.02028,17.8315 C4.629257,17.93626 4.216283,17.817298 3.94116938,17.5298722 L3.85479,17.4279 L0.678249,13.1819 C0.275408529,12.6434529 0.504260903,11.8823125 1.10803202,11.640394 L1.22557,11.6013 L3.49688,10.9927 C3.85572444,10.8966111 4.23617877,10.9655 4.53678409,11.1757683 L4.64557,11.2612 L5.44206,11.9612 L7.83692,11.0255 L3.97034,6.11174 C3.54687,5.57357667 3.77335565,4.79203787 4.38986791,4.54876405 L4.50266,4.51158 L7.26152,3.77234 Z M7.40635,5.80409 L6.47052,6.05484 L10.2339,10.8375 C10.6268063,11.3368125 10.463277,12.0589277 9.92111759,12.3504338 L9.80769,12.4028 L5.60866,14.0433 C5.29604667,14.1654333 4.9460763,14.123537 4.67296914,13.9376276 L4.57438,13.8612 L3.6268,13.0285 L3.15564,13.1547 L5.09121,15.7419 L19.5789,11.86 C20.0227,11.7411 20.3838,11.4227 20.5587,11.0018 C20.142625,10.53815 19.5333701,10.3022153 18.9191086,10.3592364 L18.7516,10.3821 L14.4682,11.1556 C14.218,11.2007714 13.9615551,11.149698 13.7491184,11.0154781 L13.6468,10.9415 L7.40635,5.80409 Z"
                                        id="形状" fill="#09244B"> </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="form-floating">
                <select id="" name="city" class="origin flight_location form-control" required>
                <?php if(isset($_SESSION['flights_origin'])){ ?> 
                <option value="<?=strtoupper($_SESSION['flights_origin'])?>" selected><?=strtoupper($_SESSION['flights_origin'])?></option>
                <?php } else {?>
                <option value="Select City"><?=T::select_city?></option>
                <?php } ?>
                </select>
                <label style="margin: 0 24px" for=""><?=T::flying_from?></label>
                </div>
            </div>
            <div class="d-block d-sm-none"></div>
        </div>

        <div class="col-md-3">
            <div id="swap" class="position-absolute">
                <div class="swap-places">
                    <span class="swap-places__arrow --top">
                        <svg width="13" height="6" viewBox="0 0 13 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 4V6L0 3L3 0V2H13V4H3Z"></path>
                        </svg>
                    </span>
                    <span class="swap-places__arrow --bottom">
                        <svg width="13" height="6" viewBox="0 0 13 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 4V6L0 3L3 0V2H13V4H3Z"></path>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="input-items flights_arrival to_flights">
                <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 16px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Transport" transform="translate(-576.000000, 0.000000)">
                                <g id="flight_land_line" transform="translate(576.000000, 0.000000)">
                                    <path
                                        d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                        id="MingCute" fill-rule="nonzero"> </path>
                                    <path
                                        d="M20.99989,20.0001 C21.5522,20.0001 21.99989,20.4478 21.99989,21.0001 C21.99989,21.51295 21.6138716,21.9356092 21.1165158,21.9933725 L20.99989,22.0001 L2.99989,22.0001 C2.4476,22.0001 1.99989,21.5524 1.99989,21.0001 C1.99989,20.48725 2.38592566,20.0645908 2.8832679,20.0068275 L2.99989,20.0001 L20.99989,20.0001 Z M8.10346,3.20538 C8.00550211,2.52548211 8.59636283,1.96050997 9.25436746,2.06249271 L9.36455,2.08576 L12.1234,2.82499 C12.4699778,2.91787 12.7577704,3.15444975 12.9168957,3.47137892 L12.9704,3.59387 L15.7807,11.0953 L19.4455,12.4121 C20.7461,12.8794 21.709,13.991 21.9861,15.3449 C22.1241,16.0194 21.9516,16.7079 21.4218,17.1734 C20.6038313,17.8923687 19.4996906,18.183398 18.4402863,17.9692815 L18.2291,17.9197 L3.15287,13.8799 C2.75789727,13.7740818 2.45767661,13.459338 2.36633273,13.0674492 L2.34531,12.9477 L1.71732,7.68232 C1.63740111,7.01225556 2.22049639,6.4660062 2.86699575,6.56318572 L2.98162,6.58712 L5.25293,7.19571 C5.61177444,7.29186111 5.90680062,7.54177815 6.06199513,7.87418144 L6.11349,8.00256 L6.45329,9.00701 L8.99512,9.39414 L8.10346,3.20538 Z M10.2971,4.4062 L11.165,10.4298 C11.2559176,11.0610471 10.7489114,11.6064588 10.1303657,11.5834026 L10.0132,11.5723 L5.5565,10.8935 C5.22469556,10.8429222 4.94258198,10.6316333 4.79900425,10.3341508 L4.75183,10.2187 L4.34758,9.02368 L3.87642,8.89743 L4.25907,12.1058 L18.7467,15.9878 C19.1906,16.1067 19.6625,16.0115 20.0243,15.7345 C19.8949769,15.1206538 19.4803805,14.6088858 18.9139056,14.3528832 L18.7692,14.2943 L14.673,12.8225 C14.4336857,12.7364429 14.2371306,12.5639857 14.1203003,12.3415274 L14.0687,12.2263 L11.233,4.65695 L10.2971,4.4062 Z"
                                        id="形状" fill="#09244B"> </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <div class="form-floating">
                <select id="" name="city" class="destination flight_location form-control" required>
                <?php if(isset($_SESSION['flights_destination'])){ ?> 
                <option value="<?=strtoupper($_SESSION['flights_destination'])?>" selected><?=strtoupper($_SESSION['flights_destination'])?></option>
                <?php } else {?>
                <option value="Select City"><?=T::select_city?></option>
                <?php } ?>
                </select>
                <label style="margin: 0 26px" for=""><?=T::destination_to?></label>
                </div>
            </div>
            <div class="d-block d-sm-none"></div>
        </div>

        <div class="col-md-3">
            <div class="row g-2">
                <div class="col">
                    <div class="form-floating">
                        <input class="depart form-control" id="departure" name="depart" type="text" autocomplete="off"
                            value="<?php if(isset($_SESSION['flights_departure_date'])){ echo $_SESSION['flights_departure_date']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?>">
                        <label for="checkin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <?=T::depart_date?>
                        </label>
                    </div>
                </div>
                <div class="col" id="show">
                    <div class="form-floating">
                        <input class="returning form-control dateright border-top-l0" name="returning" type="text" autocomplete="off"
                            id="return_date"
                            value="<?php if(isset($_SESSION['flights_returning_date'])){ echo $_SESSION['flights_returning_date']; } else { $d=strtotime("+5 Days"); echo date("d-m-Y", $d); } ?>">
                        <label for="checkout">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <?=T::return_date?>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="input-box">
                <div class="form-group">

                    <div class="dropdown dropdown-contain">

                        <i class="la la-user form-icon"></i>
                        <a class="dropdown-toggle dropdown-btn travellers" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <p>

                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>

                                <?=T::travellers?> <span class="guest_flights"></span>
                                <!-- <span><?=T::hotels_rooms?> <span class="roomTotal">0</span></span> -->
                            </p>
                        </a>

                        <div class="dropdown-menu dropdown-menu-wrap w-100">
                            <div class="dropdown-item adult_qty">
                                <div class="qty-box d-flex align-items-center justify-content-between"
                                    style="margin-bottom: 5px; border-bottom: 1px solid #dedede; padding-bottom: 10px;">
                                    <label style="line-height:16px">
                                        <i class="la la-user"></i> <?=T::flights_adults; ?>
                                        <div class="clear"></div>
                                        <small style="font-size:10px">+12</small>
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="adults" id="fadults"
                                            value="<?php if(isset($_SESSION['flights_adults'])){ echo $_SESSION['flights_adults']; } else { echo "1"; } ?>"
                                            class="qtyInput_flights">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item child_qty">
                                <div class="qty-box d-flex align-items-center justify-content-between"
                                    style="margin-bottom: 5px; border-bottom: 1px solid #dedede; padding-bottom: 10px;">
                                    <label style="line-height:16px">
                                        <i class="la la-female"></i> <?=T::flights_childs; ?>
                                        <div class="clear"></div>
                                        <small style="font-size:10px">2 - 11</small>
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="childs" id="fchilds"
                                            value="<?php if(isset($_SESSION['flights_childs'])){ echo $_SESSION['flights_childs']; } else { echo "0"; } ?>"
                                            class="qtyInput_flights">
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-item infant_qty">
                                <div class="qty-box d-flex align-items-center justify-content-between">
                                    <label style="line-height:16px">
                                        <i class="la la-female"></i> <?=T::flights_infants; ?>
                                        <div class="clear"></div>
                                        <small style="font-size:10px">-2</small>
                                    </label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="childs" id="finfant"
                                            value="<?php if(isset($_SESSION['flights_infants'])){ echo $_SESSION['flights_infants']; } else { echo "0"; } ?>"
                                            class="qtyInput_flights">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end dropdown -->
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <button style="height:64px" type="submit" id="flights-search"
                class="search_button w-100 btn btn-primary btn-m rounded-sm font-700 text-uppercase btn-full">
                <svg style="fill:currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"
                    class="c8LPF-icon" role="img" height="24" cleanup="">
                    <path
                        d="M174.973 150.594l-29.406-29.406c5.794-9.945 9.171-21.482 9.171-33.819C154.737 50.164 124.573 20 87.368 20S20 50.164 20 87.368s30.164 67.368 67.368 67.368c12.345 0 23.874-3.377 33.827-9.171l29.406 29.406c6.703 6.703 17.667 6.703 24.371 0c6.704-6.702 6.704-17.674.001-24.377zM36.842 87.36c0-27.857 22.669-50.526 50.526-50.526s50.526 22.669 50.526 50.526s-22.669 50.526-50.526 50.526s-50.526-22.669-50.526-50.526z">
                    </path>
                </svg>
            </button>
            <div class="loading_button" style="display:none">
                <button style="height:64px"
                    class="loading_button gap-2 w-100 btn btn-primary btn-m rounded-sm font-700 text-uppercase btn-full"
                    type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- add flight clone  -->
    <template id="add--flight-temp">
        <div class="contact-form-action multi-flight-field mb-2">
            <div class="row g-2 contact-form-action multi_flight">
                <div class="col-md-6">
                    <div class="row g-2">
                        <div class="col-md-6">
                            
                        <div class="input-items">
                <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title><?=T::flight_takeoff_line?></title>
                        <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Transport" transform="translate(-624.000000, 0.000000)">
                                <g id="flight_takeoff_line" transform="translate(624.000000, 0.000000)">
                                    <path
                                        d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                        id="MingCute" fill-rule="nonzero"> </path>
                                    <path
                                        d="M20.9999,20 C21.5522,20 21.9999,20.4477 21.9999,21 C21.9999,21.51285 21.613873,21.9355092 21.1165239,21.9932725 L20.9999,22 L2.99988,22 C2.44759,22 1.99988,21.5523 1.99988,21 C1.99988,20.48715 2.38591566,20.0644908 2.8832579,20.0067275 L2.99988,20 L20.9999,20 Z M7.26152,3.77234 C7.60270875,3.68092 7.96415594,3.73859781 8.25798121,3.92633426 L8.37951,4.0147 L14.564,9.10597 L18.3962,8.41394 C19.7562,8.16834 21.1459,8.64954 22.0628,9.68357 C22.5196,10.1987 22.7144,10.8812 22.4884,11.5492 C22.1394625,12.580825 21.3287477,13.3849891 20.3041894,13.729249 L20.0965,13.7919 L5.02028,17.8315 C4.629257,17.93626 4.216283,17.817298 3.94116938,17.5298722 L3.85479,17.4279 L0.678249,13.1819 C0.275408529,12.6434529 0.504260903,11.8823125 1.10803202,11.640394 L1.22557,11.6013 L3.49688,10.9927 C3.85572444,10.8966111 4.23617877,10.9655 4.53678409,11.1757683 L4.64557,11.2612 L5.44206,11.9612 L7.83692,11.0255 L3.97034,6.11174 C3.54687,5.57357667 3.77335565,4.79203787 4.38986791,4.54876405 L4.50266,4.51158 L7.26152,3.77234 Z M7.40635,5.80409 L6.47052,6.05484 L10.2339,10.8375 C10.6268063,11.3368125 10.463277,12.0589277 9.92111759,12.3504338 L9.80769,12.4028 L5.60866,14.0433 C5.29604667,14.1654333 4.9460763,14.123537 4.67296914,13.9376276 L4.57438,13.8612 L3.6268,13.0285 L3.15564,13.1547 L5.09121,15.7419 L19.5789,11.86 C20.0227,11.7411 20.3838,11.4227 20.5587,11.0018 C20.142625,10.53815 19.5333701,10.3022153 18.9191086,10.3592364 L18.7516,10.3821 L14.4682,11.1556 C14.218,11.2007714 13.9615551,11.149698 13.7491184,11.0154781 L13.6468,10.9415 L7.40635,5.80409 Z"
                                        id="形状" fill="#09244B"> </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <!-- <select id="" name="city" class="origin flight_location form-control" required>
                    <option value="Lahore" data-id="lahore" selected><?=T::lahore?></option>
                </select> -->
                <div class="form-floating">
                <select id="" name="city" class="origin flight_location form-control" required>
                <?php if(isset($_SESSION['flights_origin'])){ ?> 
                <option value="<?=strtoupper($_SESSION['flights_origin'])?>" selected><?=strtoupper($_SESSION['flights_origin'])?></option>
                <?php } else {?>
                <option value="Select City"><?=T::select_city?></option>
                <?php } ?>
                </select>
                <label style="margin: 0 24px" for=""><?=T::flying_from?></label>
                </div>
            </div>
            <div class="d-block d-sm-none"></div>

                        </div>
                        <div class="col-md-6">
                              
                        <div class="input-items">
                <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title><?=t::flight_takeoff_line?></title>
                        <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Transport" transform="translate(-624.000000, 0.000000)">
                                <g id="flight_takeoff_line" transform="translate(624.000000, 0.000000)">
                                    <path
                                        d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                        id="MingCute" fill-rule="nonzero"> </path>
                                    <path
                                        d="M20.9999,20 C21.5522,20 21.9999,20.4477 21.9999,21 C21.9999,21.51285 21.613873,21.9355092 21.1165239,21.9932725 L20.9999,22 L2.99988,22 C2.44759,22 1.99988,21.5523 1.99988,21 C1.99988,20.48715 2.38591566,20.0644908 2.8832579,20.0067275 L2.99988,20 L20.9999,20 Z M7.26152,3.77234 C7.60270875,3.68092 7.96415594,3.73859781 8.25798121,3.92633426 L8.37951,4.0147 L14.564,9.10597 L18.3962,8.41394 C19.7562,8.16834 21.1459,8.64954 22.0628,9.68357 C22.5196,10.1987 22.7144,10.8812 22.4884,11.5492 C22.1394625,12.580825 21.3287477,13.3849891 20.3041894,13.729249 L20.0965,13.7919 L5.02028,17.8315 C4.629257,17.93626 4.216283,17.817298 3.94116938,17.5298722 L3.85479,17.4279 L0.678249,13.1819 C0.275408529,12.6434529 0.504260903,11.8823125 1.10803202,11.640394 L1.22557,11.6013 L3.49688,10.9927 C3.85572444,10.8966111 4.23617877,10.9655 4.53678409,11.1757683 L4.64557,11.2612 L5.44206,11.9612 L7.83692,11.0255 L3.97034,6.11174 C3.54687,5.57357667 3.77335565,4.79203787 4.38986791,4.54876405 L4.50266,4.51158 L7.26152,3.77234 Z M7.40635,5.80409 L6.47052,6.05484 L10.2339,10.8375 C10.6268063,11.3368125 10.463277,12.0589277 9.92111759,12.3504338 L9.80769,12.4028 L5.60866,14.0433 C5.29604667,14.1654333 4.9460763,14.123537 4.67296914,13.9376276 L4.57438,13.8612 L3.6268,13.0285 L3.15564,13.1547 L5.09121,15.7419 L19.5789,11.86 C20.0227,11.7411 20.3838,11.4227 20.5587,11.0018 C20.142625,10.53815 19.5333701,10.3022153 18.9191086,10.3592364 L18.7516,10.3821 L14.4682,11.1556 C14.218,11.2007714 13.9615551,11.149698 13.7491184,11.0154781 L13.6468,10.9415 L7.40635,5.80409 Z"
                                        id="形状" fill="#09244B"> </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <!-- <select id="" name="city" class="origin flight_location form-control" required>
                    <option value="Lahore" data-id="lahore" selected><?=T::lahore?></option>
                </select> -->
                <div class="form-floating">
                <select id="" name="city" class="destination flight_location form-control" required>
                <?php if(isset($_SESSION['flights_destination'])){ ?> 
                <option value="<?=strtoupper($_SESSION['flights_destination'])?>" selected><?=strtoupper($_SESSION['flights_destination'])?></option>
                <?php } else {?>
                <option value="Select City"><?=T::select_city?></option>
                <?php } ?>
                </select>
                <label style="margin: 0 26px" for=""><?=T::destination_to?></label>
                </div>
            </div>
            <div class="d-block d-sm-none"></div>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">

                        <div class="form-floating">
                        <input class="dp form-control" id="departure" name="depart" type="text" value="" autocomplete="off">
                        <label for="checkin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <?=T::flights_departuredate?>
                        </label>
                    </div>


                        </div>
                    </div>
                </div>
                <!-- end col-lg-3 -->
                <div class="col-md-3 d-flex flight-remove" style="padding-left:10px;align-items:center">
                    <label class="label-text">&nbsp;</label>
                    <button style="height: 42px;" class="btn btn-outline-danger multi-flight-remove d-flex align-items-center justi-content-center"
                        type="button">
                    
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>

                    </button>
                </div>
            </div>
        </div>

       

    </template>


    <!-- MOST POPULAR OPTIONS from_flights -->
    <template id="most--popular-from">
        <div class="most--popular-from">
            <small class="mb-2 px-2 text-muted fw-bold"><?=T::most_popular?></small>
            
            <?php foreach (base()->flights_suggestions as $s) { 
            if ($s->type == "from_destination") {
            ?>

            <div class="d-flex align-items-center p-2 to--insert overflow-hidden">
                <button class="btn btn-outline-primary btn-sm mx-0" style="font-size: 12px; font-weight: bold; min-width:57px"><?=$s->city_airport?></button>
                <div class="mx-2" style="line-height: 14px;">
                    <strong><?=$s->city?> <small><?=$s->country?></small></strong> 
                    <div class="d-block">
                        <small class="d-inline-block overflow-hidden airport--name"><?=$s->airport?></small>
                    </div>
                </div>
            </div>
            <?php } } ?>
           
        </div>
    </template>

    <!-- MOST POPULAR OPTIONS to_flights -->
    <template id="most--popular-to">
        <div class="most--popular-to">
            <small class="mb-2 px-2 text-muted fw-bold"><?=T::most_popular?></small>
            
            <?php foreach (base()->flights_suggestions as $s) { 
            if ($s->type == "to_destination") {
            ?>

            <!-- <div class="select2-results__option select2-results__option--highlighted to--insert"> -->
                
            <div class="d-flex align-items-center p-2 to--insert overflow-hidden">
                <button class="btn btn-outline-primary btn-sm mx-0" style="font-size: 12px; font-weight: bold; min-width:57px"><?=$s->city_airport?></button>
                <div class="mx-2" style="line-height: 14px;">
                    <strong><?=$s->city?> <small><?=$s->country?></small></strong> 
                    <div class="d-block">
                        <small class="d-inline-block overflow-hidden airport--name"><?=$s->airport?></small>
                    </div>
                </div>
            </div>

            <!-- <div class="d-flex py-2 to--insert">
                <button class="btn btn-outline-primary btn-sm mx-2 px-2"><?=$s->city_airport?></button>
                <div style="line-height: 14px;">
                    <strong><?=$s->city?></strong>
                    <div class="d-block">
                        <small>2<?=$s->airport?></small>
                    </div>
                </div>
            </div> -->
            <?php } } ?>
           
        </div>
    </template>

    <!-- MULTI FLIGHTS -->
    <div class="multi-flight-wrap" id="multiway">
        <div class="contact-form-action multi-flight-field mb-2">
            <div class="row g-2 contact-form-action multi_flight">
                <div class="col-md-6">
                    <div class="row g-2">
                        <div class="col-md-6">
                            
                        <div class="input-items">
                <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title><?=T::flight_takeoff_line?></title>
                        <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Transport" transform="translate(-624.000000, 0.000000)">
                                <g id="flight_takeoff_line" transform="translate(624.000000, 0.000000)">
                                    <path
                                        d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                        id="MingCute" fill-rule="nonzero"> </path>
                                    <path
                                        d="M20.9999,20 C21.5522,20 21.9999,20.4477 21.9999,21 C21.9999,21.51285 21.613873,21.9355092 21.1165239,21.9932725 L20.9999,22 L2.99988,22 C2.44759,22 1.99988,21.5523 1.99988,21 C1.99988,20.48715 2.38591566,20.0644908 2.8832579,20.0067275 L2.99988,20 L20.9999,20 Z M7.26152,3.77234 C7.60270875,3.68092 7.96415594,3.73859781 8.25798121,3.92633426 L8.37951,4.0147 L14.564,9.10597 L18.3962,8.41394 C19.7562,8.16834 21.1459,8.64954 22.0628,9.68357 C22.5196,10.1987 22.7144,10.8812 22.4884,11.5492 C22.1394625,12.580825 21.3287477,13.3849891 20.3041894,13.729249 L20.0965,13.7919 L5.02028,17.8315 C4.629257,17.93626 4.216283,17.817298 3.94116938,17.5298722 L3.85479,17.4279 L0.678249,13.1819 C0.275408529,12.6434529 0.504260903,11.8823125 1.10803202,11.640394 L1.22557,11.6013 L3.49688,10.9927 C3.85572444,10.8966111 4.23617877,10.9655 4.53678409,11.1757683 L4.64557,11.2612 L5.44206,11.9612 L7.83692,11.0255 L3.97034,6.11174 C3.54687,5.57357667 3.77335565,4.79203787 4.38986791,4.54876405 L4.50266,4.51158 L7.26152,3.77234 Z M7.40635,5.80409 L6.47052,6.05484 L10.2339,10.8375 C10.6268063,11.3368125 10.463277,12.0589277 9.92111759,12.3504338 L9.80769,12.4028 L5.60866,14.0433 C5.29604667,14.1654333 4.9460763,14.123537 4.67296914,13.9376276 L4.57438,13.8612 L3.6268,13.0285 L3.15564,13.1547 L5.09121,15.7419 L19.5789,11.86 C20.0227,11.7411 20.3838,11.4227 20.5587,11.0018 C20.142625,10.53815 19.5333701,10.3022153 18.9191086,10.3592364 L18.7516,10.3821 L14.4682,11.1556 C14.218,11.2007714 13.9615551,11.149698 13.7491184,11.0154781 L13.6468,10.9415 L7.40635,5.80409 Z"
                                        id="形状" fill="#09244B"> </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <!-- <select id="" name="city" class="origin flight_location form-control" required>
                    <option value="Lahore" data-id="lahore" selected><?=T::lahore?></option>
                </select> -->
                <div class="form-floating">
                <select id="" name="city" class="origin flight_location form-control" required>
                <?php if(isset($_SESSION['flights_origin'])){ ?> 
                <option value="<?=strtoupper($_SESSION['flights_origin'])?>" selected><?=strtoupper($_SESSION['flights_origin'])?></option>
                <?php } else {?>
                <option value="Select City"><?=T::select_city?></option>
                <?php } ?>
                </select>
                <label style="margin: 0 24px" for=""><?=T::flying_from?></label>
                </div>
            </div>
            <div class="d-block d-sm-none"></div>

                        </div>
                        <div class="col-md-6">
                              
                        <div class="input-items">
                <div style="position: absolute; z-index: 10; margin-top: 16px; margin-left: 12px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title><?=t::flight_takeoff_line?></title>
                        <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Transport" transform="translate(-624.000000, 0.000000)">
                                <g id="flight_takeoff_line" transform="translate(624.000000, 0.000000)">
                                    <path
                                        d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                        id="MingCute" fill-rule="nonzero"> </path>
                                    <path
                                        d="M20.9999,20 C21.5522,20 21.9999,20.4477 21.9999,21 C21.9999,21.51285 21.613873,21.9355092 21.1165239,21.9932725 L20.9999,22 L2.99988,22 C2.44759,22 1.99988,21.5523 1.99988,21 C1.99988,20.48715 2.38591566,20.0644908 2.8832579,20.0067275 L2.99988,20 L20.9999,20 Z M7.26152,3.77234 C7.60270875,3.68092 7.96415594,3.73859781 8.25798121,3.92633426 L8.37951,4.0147 L14.564,9.10597 L18.3962,8.41394 C19.7562,8.16834 21.1459,8.64954 22.0628,9.68357 C22.5196,10.1987 22.7144,10.8812 22.4884,11.5492 C22.1394625,12.580825 21.3287477,13.3849891 20.3041894,13.729249 L20.0965,13.7919 L5.02028,17.8315 C4.629257,17.93626 4.216283,17.817298 3.94116938,17.5298722 L3.85479,17.4279 L0.678249,13.1819 C0.275408529,12.6434529 0.504260903,11.8823125 1.10803202,11.640394 L1.22557,11.6013 L3.49688,10.9927 C3.85572444,10.8966111 4.23617877,10.9655 4.53678409,11.1757683 L4.64557,11.2612 L5.44206,11.9612 L7.83692,11.0255 L3.97034,6.11174 C3.54687,5.57357667 3.77335565,4.79203787 4.38986791,4.54876405 L4.50266,4.51158 L7.26152,3.77234 Z M7.40635,5.80409 L6.47052,6.05484 L10.2339,10.8375 C10.6268063,11.3368125 10.463277,12.0589277 9.92111759,12.3504338 L9.80769,12.4028 L5.60866,14.0433 C5.29604667,14.1654333 4.9460763,14.123537 4.67296914,13.9376276 L4.57438,13.8612 L3.6268,13.0285 L3.15564,13.1547 L5.09121,15.7419 L19.5789,11.86 C20.0227,11.7411 20.3838,11.4227 20.5587,11.0018 C20.142625,10.53815 19.5333701,10.3022153 18.9191086,10.3592364 L18.7516,10.3821 L14.4682,11.1556 C14.218,11.2007714 13.9615551,11.149698 13.7491184,11.0154781 L13.6468,10.9415 L7.40635,5.80409 Z"
                                        id="形状" fill="#09244B"> </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <!-- <select id="" name="city" class="origin flight_location form-control" required>
                    <option value="Lahore" data-id="lahore" selected><?=T::lahore?></option>
                </select> -->
                <div class="form-floating">
                <select id="" name="city" class="destination flight_location form-control" required>
                <?php if(isset($_SESSION['flights_destination'])){ ?> 
                <option value="<?=strtoupper($_SESSION['flights_destination'])?>" selected><?=strtoupper($_SESSION['flights_destination'])?></option>
                <?php } else {?>
                <option value="Select City"><?=T::select_city?></option>
                <?php } ?>
                </select>
                <label style="margin: 0 26px" for=""><?=T::destination_to?></label>
                </div>
            </div>
            <div class="d-block d-sm-none"></div>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">

                        <div class="form-floating">
                        <input class="dp form-control" id="departure" name="depart" type="text" value="" autocomplete="off">
                        <label for="checkin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <?=T::flights_departuredate?>
                        </label>
                    </div>


                        </div>
                    </div>
                </div>
                <!-- end col-lg-3 -->
                <div class="col-md-3 d-flex flight-remove" style="padding-left:10px;align-items:center">
                    <label class="label-text">&nbsp;</label>
                    <button style="height: 42px;" class="btn btn-outline-danger multi-flight-remove d-flex align-items-center justi-content-center"
                        type="button">
                    
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>

                    </button>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-3 pr-0">
                <div class="form-group">
                    <button class="btn btn-outline-primary add-flight-btn margin-top-20px w-100 d-flex align-items-center gap-2 justify-content-center" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    <?=T::flights_addanotherflight?></button>
                </div>
            </div>
        </div>
    </div>

</form>

<script>
    // SEARCH MODEL
    function load_modal() {
        // LOADING EFFECT
        $("body").load(
            '<?=root?>App/Views/Loading.php', 
            {
                'root': '<?=root?>',
                'color': '<?=base()->app->default_theme?>'
            }
            ,function() {
                $("body").addClass("loadingfadein")
            }
        )
    };

    // URL beurify and search action
    $("#flights-search").submit(function(e) {

        // event.preventDefault();
        e.preventDefault();
        // $("html, body").fadeOut(200);

        // $('.search_button').hide();
        // $('.loading_button').show();

        // $("html, body").fadeOut(200);

        var trip_type = $('input[name=trip]:checked').val();
        var origin = $(".origin").val().toLowerCase();
        var destination = $(".destination").val().toLowerCase();
        var departure_date = $("#departure").val();
        var return_date = $("#return_date").val();
        var flight_type = $("#flight_type").val().toLowerCase();
        var adult = $("#fadults").val();
        var children = $("#fchilds").val();
        var infant = $("#finfant").val();
        var language = $('#language').val();
        var origin_split = origin.split(' ');
        var origin = origin_split[0];
        var destination_split = destination.split(' ');
        var destination = destination_split[0];

        if(origin === destination) {
            console.log('or', origin)
            console.log('des', destination)
            alert('Flying City and Destination City Can`t be same');
        } else if (origin == '') {
            alert('add origin');
            $('.origin').focus();
        } else if (destination == '') {
            alert('add dest');
            $('.destination').focus();

            // main params of get url
        } else {
            $('.search_button').hide();
            $('.loading_button').show();
            var actionURL = 'flights/';

            // for oneway
            if (trip_type == 'oneway') {
                var finelURL = actionURL + origin + '/' + destination + '/' + trip_type + '/' + flight_type + '/' +
                departure_date + '/' + adult + '/' + children + '/' + infant;
                $("html, body").animate({
                    scrollTop: 0
                }, "fast");
                window.location.href = '<?=root?>' + finelURL;
                load_modal();

                // Pace.restart();
                // Pace.start();

                // for return
            } else if (trip_type == 'return') {
                let date1 = new Date(departure_date);
                let date2 = new Date(return_date);

                if(date1 >= date2) {
                    alert('Departue Date must be below the Return Date')
                }
                else {
                    var finelURL = actionURL + origin + '/' + destination + '/' + trip_type + '/' + flight_type + '/' +
                    departure_date + '/' + return_date + '/' + adult + '/' + children + '/' + infant;
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    window.location.href = '<?=root?>' + finelURL;
                    load_modal();
                }

                // for multi way
            } else {
                var finelURL = actionURL + trip_type + '/' + origin + '/' + destination + '/' + cdeparture + '/' +
                    origin + '/' + destination + '/' + cdeparture + '/' + origin + '/' + destination + '/' +
                    departure_date + '/' + flight_type + '/' + adult + '/' + children + '/' + infant;
                $("html, body").animate({
                    scrollTop: 0
                }, "fast");
                window.location.href = '<?=root?>' + finelURL;
                load_modal();

            }
        }
    });

    window.onload = function() {

        /* oneway */
        document.getElementById("one-way").onclick = function() {
            document.getElementById("show").className = "col hide";
            document.getElementById("onereturn").className = "row g-2 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control";
        }

        /* return */
        document.getElementById("round-trip").onclick = function() {
            document.getElementById("show").className = "col show_";
            document.getElementById("onereturn").className = "row g-2 contact-form-action";
            document.getElementById("multiway").className = "";
            document.getElementById("departure").className = "depart form-control dateleft border-top-r0";
        }

        /* multiway */
        // document.getElementById("multi-trip").onclick = function() {
        //     document.getElementById("multiway").className = "multi-flight-wrap show_ mt-2";
        //     document.getElementById("show").className = "col hide";
        //     document.getElementById("departure").className = "depart form-control";
        // }

    };
    </script>

    <?php  if ($_SESSION['flights_type'] == 'return') { ?>
    <script>
    document.getElementById("show").className = "col show_";
    document.getElementById("onereturn").className = "row contact-form-action g-2";
    document.getElementById("multiway").className = "";
    document.getElementById("departure").className = "depart form-control dateleft";
    </script>
    <?php } else { } ?>

    <?php  if ($_SESSION['flights_type'] == 'multiway') { ?>
    <script>
    document.getElementById("multiway").className = "multi-flight-wrap show_";
    document.getElementById("show").className = "col hide";
    document.getElementById("departure").className = "depart form-control";
    </script>
    <?php } else { } ?>

    <style>
    .hide { display: none; } 
    .show_ { display: block !important; } 
    #show, #multiway { display: none; }
    </style>

    <script>

    var ajax = $(".flight_location");

    function addSelect2() {

        // select 2 location init for hotels search 
    
        function formatRepo(t) {
            return t.loading ? t.text : (console.log(t),
                '<button style="font-size: 12px; font-weight: bold;" class="btn btn-outline-primary btn-sm mx-0">' + t.id +
                '</button><div class="mx-2" style="line-height: 14px;"><strong>' + t.city + '<small class="px-1">'+ t.country + '</small>' +
                '</strong><div class="d-block"><small>' + t.airport + '<small></div></div>')
        }

        function formatRepoSelection(t) {
    
            if (typeof t.city === 'undefined') {
                var city = "";
            } else {
                var city = t.city;
            }
    
            return '<div class="mt-2">' + city + ' ' + '<small><strong class="mt-2">' + t.id +
                ' </strong></small></div>'
        }

        $(ajax).select2({
            ajax: {
                url: "<?=root?>api/flights_locations",
                dataType: "json",
                data: function(t) {
                    return {
                        city: $.trim(t.term)
                    }
                },
                processResults: function(t) {
                    console.log(t)
                    var e = [];
                    return t.forEach(function(t) {
    
                        e.push({
                            id: t.code,
                            city: t.city,
                            country: t.country,
                            airport: t.airport,
    
                        })
    
                    }), console.log(e), {
                        results: e
                    }
                },
            },
            escapeMarkup: function(t) {
                return t
            },
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            dropdownPosition: 'below',
            cache: !0
        });
    }

    addSelect2();

    // TO STORE THE SELECT2 RESULT WRAPERR 
    var _select2Result;

    var _tempTemp;

    let _mostPolpularFlights;

    // $(ajax).on('select2:open', function(e) {
    $(document).on('select2:open', function(e) {
        document.querySelector('.select2-search__field').focus();

        if( ($('input[type="radio"]:checked').val() === 'oneway' || $('input[type="radio"]:checked').val() === 'return') && $(e.target).parents('#flights-search').length !== 0  ) {
            if( $(e.target).parents('.from_flights').length !== 0 ) {
                setTimeout(() => $('.select2-results > ul > li').hide(), 10)
                _mostPolpularFlights = document.querySelector('#most--popular-from').content.cloneNode(true);
                mostPopularFlights(e.target);
            }
            else if( $(e.target).parents('.to_flights').length !== 0 ) {
                setTimeout(() => $('#select2--results > li').hide(), 10)
                _mostPolpularFlights = document.querySelector('#most--popular-to').content.cloneNode(true);
                mostPopularFlights(e.target);
            }
        }

    });

    function mostPopularFlights(_selectedId) {
        setTimeout(() => addEventFlights(_mostPolpularFlights, _selectedId), 10)
    }

    function addEventFlights(tempFlights, thisId) {
        let sibiling = $(thisId).siblings('.select2.select2-container')
        let change = $(sibiling).find('#select2--container > .mt-2')
        // let len = parent.querySelectorAll('div > .to--insert')
        let len = tempFlights.querySelectorAll('div > .to--insert')

        len.forEach(li => {
            li.addEventListener('click', function(e) { 
                // e.stopPropagation();
                let innerText = this.querySelector('.btn-outline-primary').textContent;
                let outterText = this.querySelector('div > strong').textContent;
                change.html( `${outterText} <small><strong class="mt-1"> ${innerText} </strong></small>` );

                $(thisId).find('option:not(:last-child)').remove() 
                thisId.querySelector('option').value = innerText;

                // document.querySelector('.select2.select2-container.select2-container--default.select2-container--open').classList.remove('select2-container--open')

                // document.querySelector('.select2-container.select2-container--default.select2-container--open:last-child').remove();
                // $('.flight_location').select2('close');
                $('.flight_location').select2('close');
            })

        })
        $('.select2-results > ul').append(_mostPolpularFlights);

        // WHEN SELECT2 GET OPENED ADD FADE ANIMATION TO THE SELECT2 
        document.querySelector('.select2-results').classList.remove("select2--fadeout");
        document.querySelector('.select2-results').classList.add("select2--fadein");
        
        // GET THE THE RESULT PARENT 
        // scope @global
        // _select2Result = document.querySelector(".select2-results");

        // ADD @KEYUP EVENT TO THE SELECT2 SEARCH INPUT 
        // document.querySelector(".select2-search__field").addEventListener("keyup", function () {
        //     setTimeout(() => {
        //         let _newHeight = document.querySelector("ul.select2-results__options" ).offsetHeight;
        //         _select2Result.style.height = _newHeight + "px";
        //     }, 300);
        // });
    }
    
    // WHENEVER SELECT2 GET CLOSE
    $(ajax).on('select2:closing', function() {
        document.querySelector('.select2-results').classList.remove("select2--fadein");
        document.querySelector('.select2-results').classList.add("select2--fadeout");
        // _select2Result.style.height = "auto";
    })


    // flights swap 
    document.querySelector("#swap").addEventListener("click", function() {
        var _fromFlight = document.querySelector(".from_flights");
        var _fromFlightOption = _fromFlight.querySelector("option:last-of-type");

        var _toFlight = document.querySelector(".to_flights");
        var _toFlightOption = _toFlight.querySelector("option:last-of-type");

        var _tempValue = _fromFlightOption.value;

        _fromFlightOption.value = _toFlightOption.value;
        _fromFlightOption.textContent = _toFlightOption.value;
        _toFlightOption.value = _tempValue;
        _toFlightOption.textContent = _tempValue;

        _tempValue = _fromFlight.querySelector(".mt-2").childNodes[0].nodeValue;
        ( _tempValue ) && (
            _fromFlight.querySelector(".mt-2").childNodes[0].nodeValue =  _toFlight.querySelector(".mt-2").childNodes[0].nodeValue,
            _toFlight.querySelector(".mt-2").childNodes[0].nodeValue = _tempValue
        );

        _fromFlight.querySelector(".mt-2 strong").innerHTML = _fromFlightOption.value;
        _toFlight.querySelector(".mt-2 strong").innerHTML = _toFlightOption.value;
    })


</script>

<style>
.hide { display: none; }
.show_ { display: block !important; }
#show, #multiway { display: none; }
</style>