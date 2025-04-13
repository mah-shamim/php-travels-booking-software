<style>body{background:#eee}</style>
<br><br>
<div class="container booking">
    <div class="row">
        <form name="bookingForm" action="<?=base_url('travelport_hotels/book')?>" method="post">
            <div class="col-md-8">
                <div class="panel panel-primary guest">
                    <div class="panel-heading"><?php echo trans('00');?></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="prefix">Prefix</label>
                                <select name="prefix" id="prefix" class="form-control">
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="first_name"><?php echo trans('0171');?></label>
                                <input type="text" id="first_name" class="form-control" required placeholder="<?php echo trans('0171');?>" name="first_name" value="<?=postOldData('first_name')?>">
                            </div>
                            <div class="col-md-5">
                                <label for="last_name"><?php echo trans('0172');?></label>
                                <input type="text" id="last_name" class="form-control" required placeholder="<?php echo trans('0172');?>" name="last_name" value="<?=postOldData('last_name')?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="last_name"><?php echo trans('0172');?></label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control" required name="email" placeholder="<?php echo trans('094');?>" value="<?=postOldData('email')?>">
                            </div>
                            <div class="col-md-6">
                                <label for="address">Address</label>
                                <input type="text" id="address" class="form-control" required name="address" placeholder="<?php echo trans('097');?>" value="<?=postOldData('address')?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <label for="country_code"><?php echo trans('0105');?></label>
                                <select id="country_code" class="form-control" name="mobile_code">
                                    <option value="" disabled="">--</option>
                                    <option label="Saudi Arabia (+966)" value="SA" selected="selected">Saudi Arabia (+966)</option>
                                    <option label="United Arab Emirates (+971)" value="AE">United Arab Emirates (+971)</option>
                                    <option label="Afghanistan (+93)" value="AF">Afghanistan (+93)</option>
                                    <option label="Aland Islands (+358-18)" value="AX">Aland Islands (+358-18)</option>
                                    <option label="Albania (+355)" value="AL">Albania (+355)</option>
                                    <option label="Algeria (+213)" value="DZ">Algeria (+213)</option>
                                    <option label="American Samoa (+1-684)" value="AS">American Samoa (+1-684)</option>
                                    <option label="Andorra (+376)" value="AD">Andorra (+376)</option>
                                    <option label="Angola (+244)" value="AO">Angola (+244)</option>
                                    <option label="Anguilla (+1-264)" value="AI">Anguilla (+1-264)</option>
                                    <option label="Antarctica (+672)" value="AQ">Antarctica (+672)</option>
                                    <option label="Antigua and Barbuda (+1-268)" value="AG">Antigua and Barbuda (+1-268)</option>
                                    <option label="Argentina (+54)" value="AR">Argentina (+54)</option>
                                    <option label="Armenia (+374)" value="AM">Armenia (+374)</option>
                                    <option label="Aruba (+297)" value="AW">Aruba (+297)</option>
                                    <option label="Australia (+61)" value="AU">Australia (+61)</option>
                                    <option label="Austria (+43)" value="AT">Austria (+43)</option>
                                    <option label="Azerbaijan (+994)" value="AZ">Azerbaijan (+994)</option>
                                    <option label="Bahamas (+1-242)" value="BS">Bahamas (+1-242)</option>
                                    <option label="Bahrain (+973)" value="BH">Bahrain (+973)</option>
                                    <option label="Bangladesh (+880)" value="BD">Bangladesh (+880)</option>
                                    <option label="Barbados (+1-246)" value="BB">Barbados (+1-246)</option>
                                    <option label="Belarus (+375)" value="BY">Belarus (+375)</option>
                                    <option label="Belgium (+32)" value="BE">Belgium (+32)</option>
                                    <option label="Belize (+501)" value="BZ">Belize (+501)</option>
                                    <option label="Benin (+229)" value="BJ">Benin (+229)</option>
                                    <option label="Bermuda (+1-441)" value="BM">Bermuda (+1-441)</option>
                                    <option label="Bhutan (+975)" value="BT">Bhutan (+975)</option>
                                    <option label="Bolivia (+591)" value="BO">Bolivia (+591)</option>
                                    <option label="Bonaire, Saint Eustatius and Saba (+599)" value="BQ">Bonaire, Saint Eustatius and Saba (+599)</option>
                                    <option label="Bosnia and Herzegovina (+387)" value="BA">Bosnia and Herzegovina (+387)</option>
                                    <option label="Botswana (+267)" value="BW">Botswana (+267)</option>
                                    <option label="Bouvet Island (+47)" value="BV">Bouvet Island (+47)</option>
                                    <option label="Brazil (+55)" value="BR">Brazil (+55)</option>
                                    <option label="British Indian Ocean Territory (+246)" value="IO">British Indian Ocean Territory (+246)</option>
                                    <option label="British Virgin Islands (+1-284)" value="VG">British Virgin Islands (+1-284)</option>
                                    <option label="Brunei (+673)" value="BN">Brunei (+673)</option>
                                    <option label="Bulgaria (+359)" value="BG">Bulgaria (+359)</option>
                                    <option label="Burkina Faso (+226)" value="BF">Burkina Faso (+226)</option>
                                    <option label="Burundi (+257)" value="BI">Burundi (+257)</option>
                                    <option label="Cambodia (+855)" value="KH">Cambodia (+855)</option>
                                    <option label="Cameroon (+237)" value="CM">Cameroon (+237)</option>
                                    <option label="Canada (+1)" value="CA">Canada (+1)</option>
                                    <option label="Cape Verde (+238)" value="CV">Cape Verde (+238)</option>
                                    <option label="Cayman Islands (+1-345)" value="KY">Cayman Islands (+1-345)</option>
                                    <option label="Central African Republic (+236)" value="CF">Central African Republic (+236)</option>
                                    <option label="Chad (+235)" value="TD">Chad (+235)</option>
                                    <option label="Chile (+56)" value="CL">Chile (+56)</option>
                                    <option label="China (+86)" value="CN">China (+86)</option>
                                    <option label="Christmas Island (+61)" value="CX">Christmas Island (+61)</option>
                                    <option label="Cocos Islands (+61)" value="CC">Cocos Islands (+61)</option>
                                    <option label="Colombia (+57)" value="CO">Colombia (+57)</option>
                                    <option label="Comoros (+269)" value="KM">Comoros (+269)</option>
                                    <option label="Cook Islands (+682)" value="CK">Cook Islands (+682)</option>
                                    <option label="Costa Rica (+506)" value="CR">Costa Rica (+506)</option>
                                    <option label="Croatia (+385)" value="HR">Croatia (+385)</option>
                                    <option label="Cuba (+53)" value="CU">Cuba (+53)</option>
                                    <option label="Curacao (+599)" value="CW">Curacao (+599)</option>
                                    <option label="Cyprus (+357)" value="CY">Cyprus (+357)</option>
                                    <option label="Czech Republic (+420)" value="CZ">Czech Republic (+420)</option>
                                    <option label="Democratic Republic of The Congo (+243)" value="CD">Democratic Republic of The Congo (+243)</option>
                                    <option label="Denmark (+45)" value="DK">Denmark (+45)</option>
                                    <option label="Djibouti (+253)" value="DJ">Djibouti (+253)</option>
                                    <option label="Dominica (+1-767)" value="DM">Dominica (+1-767)</option>
                                    <option label="Dominican Republic (+1)" value="DO">Dominican Republic (+1)</option>
                                    <option label="East Timor (+670)" value="TL">East Timor (+670)</option>
                                    <option label="Ecuador (+593)" value="EC">Ecuador (+593)</option>
                                    <option label="Egypt (+20)" value="EG">Egypt (+20)</option>
                                    <option label="El Salvador (+503)" value="SV">El Salvador (+503)</option>
                                    <option label="Equatorial Guinea (+240)" value="GQ">Equatorial Guinea (+240)</option>
                                    <option label="Eritrea (+291)" value="ER">Eritrea (+291)</option>
                                    <option label="Estonia (+372)" value="EE">Estonia (+372)</option>
                                    <option label="Ethiopia (+251)" value="ET">Ethiopia (+251)</option>
                                    <option label="Falkland Islands (+500)" value="FK">Falkland Islands (+500)</option>
                                    <option label="Faroe Islands (+298)" value="FO">Faroe Islands (+298)</option>
                                    <option label="Fiji (+679)" value="FJ">Fiji (+679)</option>
                                    <option label="Finland (+358)" value="FI">Finland (+358)</option>
                                    <option label="France (+33)" value="FR">France (+33)</option>
                                    <option label="French Guiana (+594)" value="GF">French Guiana (+594)</option>
                                    <option label="French Polynesia (+689)" value="PF">French Polynesia (+689)</option>
                                    <option label="French Southern Territories (+262)" value="TF">French Southern Territories (+262)</option>
                                    <option label="Gabon (+241)" value="GA">Gabon (+241)</option>
                                    <option label="Gambia (+220)" value="GM">Gambia (+220)</option>
                                    <option label="Georgia (+995)" value="GE">Georgia (+995)</option>
                                    <option label="Germany (+49)" value="DE">Germany (+49)</option>
                                    <option label="Ghana (+233)" value="GH">Ghana (+233)</option>
                                    <option label="Gibraltar (+350)" value="GI">Gibraltar (+350)</option>
                                    <option label="Greece (+30)" value="GR">Greece (+30)</option>
                                    <option label="Greenland (+299)" value="GL">Greenland (+299)</option>
                                    <option label="Grenada (+1-473)" value="GD">Grenada (+1-473)</option>
                                    <option label="Guadeloupe (+590)" value="GP">Guadeloupe (+590)</option>
                                    <option label="Guam (+1-671)" value="GU">Guam (+1-671)</option>
                                    <option label="Guatemala (+502)" value="GT">Guatemala (+502)</option>
                                    <option label="Guernsey (+44-1481)" value="GG">Guernsey (+44-1481)</option>
                                    <option label="Guinea (+224)" value="GN">Guinea (+224)</option>
                                    <option label="Guinea-Bissau (+245)" value="GW">Guinea-Bissau (+245)</option>
                                    <option label="Guyana (+592)" value="GY">Guyana (+592)</option>
                                    <option label="Haiti (+509)" value="HT">Haiti (+509)</option>
                                    <option label="Heard Island and McDonald Islands (+ )" value="HM">Heard Island and McDonald Islands (+ )</option>
                                    <option label="Honduras (+504)" value="HN">Honduras (+504)</option>
                                    <option label="Hong Kong (+852)" value="HK">Hong Kong (+852)</option>
                                    <option label="Hungary (+36)" value="HU">Hungary (+36)</option>
                                    <option label="Iceland (+354)" value="IS">Iceland (+354)</option>
                                    <option label="India (+91)" value="IN">India (+91)</option>
                                    <option label="Indonesia (+62)" value="ID">Indonesia (+62)</option>
                                    <option label="Iran (+98)" value="IR">Iran (+98)</option>
                                    <option label="Iraq (+964)" value="IQ">Iraq (+964)</option>
                                    <option label="Ireland (Republic of) (+353)" value="IE">Ireland (Republic of) (+353)</option>
                                    <option label="Isle Of Man (+44-1624)" value="IM">Isle Of Man (+44-1624)</option>
                                    <option label="Israel (+972)" value="IL">Israel (+972)</option>
                                    <option label="Italy (+39)" value="IT">Italy (+39)</option>
                                    <option label="Ivory Coast (+225)" value="CI">Ivory Coast (+225)</option>
                                    <option label="Jamaica (+1-876)" value="JM">Jamaica (+1-876)</option>
                                    <option label="Japan (+81)" value="JP">Japan (+81)</option>
                                    <option label="Jersey (+44-1534)" value="JE">Jersey (+44-1534)</option>
                                    <option label="Jordan (+962)" value="JO">Jordan (+962)</option>
                                    <option label="Kazakhstan (+7)" value="KZ">Kazakhstan (+7)</option>
                                    <option label="Kenya (+254)" value="KE">Kenya (+254)</option>
                                    <option label="Kiribati (+686)" value="KI">Kiribati (+686)</option>
                                    <option label="Kosovo (+383)" value="XK">Kosovo (+383)</option>
                                    <option label="Kuwait (+965)" value="KW">Kuwait (+965)</option>
                                    <option label="Kyrgyzstan (+996)" value="KG">Kyrgyzstan (+996)</option>
                                    <option label="Laos (+856)" value="LA">Laos (+856)</option>
                                    <option label="Latvia (+371)" value="LV">Latvia (+371)</option>
                                    <option label="Lebanon (+961)" value="LB">Lebanon (+961)</option>
                                    <option label="Lesotho (+266)" value="LS">Lesotho (+266)</option>
                                    <option label="Namibia (+231)" value="LR">Namibia (+231)</option>
                                    <option label="Libya (+218)" value="LY">Libya (+218)</option>
                                    <option label="Liechtenstein (+423)" value="LI">Liechtenstein (+423)</option>
                                    <option label="Lithuania (+370)" value="LT">Lithuania (+370)</option>
                                    <option label="Luxembourg (+352)" value="LU">Luxembourg (+352)</option>
                                    <option label="Macao (+853)" value="MO">Macao (+853)</option>
                                    <option label="Macedonia, Rep. of (+389)" value="MK">Macedonia, Rep. of (+389)</option>
                                    <option label="Madagascar (+261)" value="MG">Madagascar (+261)</option>
                                    <option label="Malawi (+265)" value="MW">Malawi (+265)</option>
                                    <option label="Malaysia (+60)" value="MY">Malaysia (+60)</option>
                                    <option label="Maldives (+960)" value="MV">Maldives (+960)</option>
                                    <option label="Mali (+223)" value="ML">Mali (+223)</option>
                                    <option label="Malta (+356)" value="MT">Malta (+356)</option>
                                    <option label="Marshall Islands (+692)" value="MH">Marshall Islands (+692)</option>
                                    <option label="Martinique (+596)" value="MQ">Martinique (+596)</option>
                                    <option label="Mauritania (+222)" value="MR">Mauritania (+222)</option>
                                    <option label="Mauritius (+230)" value="MU">Mauritius (+230)</option>
                                    <option label="Mayotte (+262)" value="YT">Mayotte (+262)</option>
                                    <option label="Mexico (+52)" value="MX">Mexico (+52)</option>
                                    <option label="Micronesia (+691)" value="FM">Micronesia (+691)</option>
                                    <option label="Moldova (+373)" value="MD">Moldova (+373)</option>
                                    <option label="Monaco (+377)" value="MC">Monaco (+377)</option>
                                    <option label="Mongolia (+976)" value="MN">Mongolia (+976)</option>
                                    <option label="Montenegro (+382)" value="ME">Montenegro (+382)</option>
                                    <option label="Montserrat (+1-664)" value="MS">Montserrat (+1-664)</option>
                                    <option label="Morocco (+212)" value="MA">Morocco (+212)</option>
                                    <option label="Mozambique (+258)" value="MZ">Mozambique (+258)</option>
                                    <option label="Myanmar (+95)" value="MM">Myanmar (+95)</option>
                                    <option label="Namibia (+264)" value="NA">Namibia (+264)</option>
                                    <option label="Nauru (+674)" value="NR">Nauru (+674)</option>
                                    <option label="Nepal (+977)" value="NP">Nepal (+977)</option>
                                    <option label="Netherlands (+31)" value="NL">Netherlands (+31)</option>
                                    <option label="New Caledonia (+687)" value="NC">New Caledonia (+687)</option>
                                    <option label="New Zealand (+64)" value="NZ">New Zealand (+64)</option>
                                    <option label="Nicaragua (+505)" value="NI">Nicaragua (+505)</option>
                                    <option label="Niger (+227)" value="NE">Niger (+227)</option>
                                    <option label="Nigeria (+234)" value="NG">Nigeria (+234)</option>
                                    <option label="Niue (+683)" value="NU">Niue (+683)</option>
                                    <option label="Norfolk Island (+672)" value="NF">Norfolk Island (+672)</option>
                                    <option label="North Korea (+850)" value="KP">North Korea (+850)</option>
                                    <option label="Northern Mariana Islands (+1-670)" value="MP">Northern Mariana Islands (+1-670)</option>
                                    <option label="Norway (+47)" value="NO">Norway (+47)</option>
                                    <option label="Oman (+968)" value="OM">Oman (+968)</option>
                                    <option label="Pakistan (+92)" value="PK" selected="selected">Pakistan (+92)</option>
                                    <option label="Palau (+680)" value="PW">Palau (+680)</option>
                                    <option label="Palestinian Territory (+970)" value="PS">Palestinian Territory (+970)</option>
                                    <option label="Panama (+507)" value="PA">Panama (+507)</option>
                                    <option label="Papua New Guinea (+675)" value="PG">Papua New Guinea (+675)</option>
                                    <option label="Paraguay (+595)" value="PY">Paraguay (+595)</option>
                                    <option label="Peru (+51)" value="PE">Peru (+51)</option>
                                    <option label="Philippines (+63)" value="PH">Philippines (+63)</option>
                                    <option label="Pitcairn Island (+870)" value="PN">Pitcairn Island (+870)</option>
                                    <option label="Poland (+48)" value="PL">Poland (+48)</option>
                                    <option label="Portugal (+351)" value="PT">Portugal (+351)</option>
                                    <option label="Puerto Rico (+1)" value="PR">Puerto Rico (+1)</option>
                                    <option label="Qatar (+974)" value="QA">Qatar (+974)</option>
                                    <option label="Republic of the Congo (+242)" value="CG">Republic of the Congo (+242)</option>
                                    <option label="Reunion (+262)" value="RE">Reunion (+262)</option>
                                    <option label="Romania (+40)" value="RO">Romania (+40)</option>
                                    <option label="Russia (+7)" value="RU">Russia (+7)</option>
                                    <option label="Rwanda (+250)" value="RW">Rwanda (+250)</option>
                                    <option label="Saint Barthelemy (+590)" value="BL">Saint Barthelemy (+590)</option>
                                    <option label="Saint Helena (+290)" value="SH">Saint Helena (+290)</option>
                                    <option label="Saint Kitts and Nevis (+1-869)" value="KN">Saint Kitts and Nevis (+1-869)</option>
                                    <option label="Saint Lucia (+1-758)" value="LC">Saint Lucia (+1-758)</option>
                                    <option label="Saint Martin (+590)" value="MF">Saint Martin (+590)</option>
                                    <option label="Saint Pierre And Miquelon (+508)" value="PM">Saint Pierre And Miquelon (+508)</option>
                                    <option label="Saint Vincent and the Grenadines (+1-784)" value="VC">Saint Vincent and the Grenadines (+1-784)</option>
                                    <option label="Samoa (+685)" value="WS">Samoa (+685)</option>
                                    <option label="San Marino (+378)" value="SM">San Marino (+378)</option>
                                    <option label="Sao Tome And Principe (+239)" value="ST">Sao Tome And Principe (+239)</option>
                                    <option label="Senegal (+221)" value="SN">Senegal (+221)</option>
                                    <option label="Serbia (+381)" value="RS">Serbia (+381)</option>
                                    <option label="Seychelles (+248)" value="SC">Seychelles (+248)</option>
                                    <option label="Sierra Leone (+232)" value="SL">Sierra Leone (+232)</option>
                                    <option label="Singapore (+65)" value="SG">Singapore (+65)</option>
                                    <option label="Sint Maarten (+599)" value="SX">Sint Maarten (+599)</option>
                                    <option label="Slovakia (+421)" value="SK">Slovakia (+421)</option>
                                    <option label="Slovenia (+386)" value="SI">Slovenia (+386)</option>
                                    <option label="Solomon Islands (+677)" value="SB">Solomon Islands (+677)</option>
                                    <option label="Somalia (+252)" value="SO">Somalia (+252)</option>
                                    <option label="South Africa (+27)" value="ZA">South Africa (+27)</option>
                                    <option label="South Georgia and the South Sandwich Islands (+500)" value="GS">South Georgia and the South Sandwich Islands (+500)</option>
                                    <option label="Korea, (South Korea) (+82)" value="KR">Korea, (South Korea) (+82)</option>
                                    <option label="South Sudan (+211)" value="SS">South Sudan (+211)</option>
                                    <option label="Spain (+34)" value="ES">Spain (+34)</option>
                                    <option label="Sri Lanka (+94)" value="LK">Sri Lanka (+94)</option>
                                    <option label="Sudan (+249)" value="SD">Sudan (+249)</option>
                                    <option label="Suriname (+597)" value="SR">Suriname (+597)</option>
                                    <option label="Svalbard And Jan Mayen (+47)" value="SJ">Svalbard And Jan Mayen (+47)</option>
                                    <option label="Swaziland (+268)" value="SZ">Swaziland (+268)</option>
                                    <option label="Sweden (+46)" value="SE">Sweden (+46)</option>
                                    <option label="Switzerland (+41)" value="CH">Switzerland (+41)</option>
                                    <option label="Syrian Arab Republic (+963)" value="SY">Syrian Arab Republic (+963)</option>
                                    <option label="Taiwan (+886)" value="TW">Taiwan (+886)</option>
                                    <option label="Tajikistan (+992)" value="TJ">Tajikistan (+992)</option>
                                    <option label="Tanzania (+255)" value="TZ">Tanzania (+255)</option>
                                    <option label="Thailand (+66)" value="TH">Thailand (+66)</option>
                                    <option label="Togo (+228)" value="TG">Togo (+228)</option>
                                    <option label="Tokelau (+690)" value="TK">Tokelau (+690)</option>
                                    <option label="Tonga (+676)" value="TO">Tonga (+676)</option>
                                    <option label="Trinidad and Tobago (+1-868)" value="TT">Trinidad and Tobago (+1-868)</option>
                                    <option label="Tunisia (+216)" value="TN">Tunisia (+216)</option>
                                    <option label="Turkey (+90)" value="TR">Turkey (+90)</option>
                                    <option label="Turkmenistan (+993)" value="TM">Turkmenistan (+993)</option>
                                    <option label="Turks and Caicos Islands (+1-649)" value="TC">Turks and Caicos Islands (+1-649)</option>
                                    <option label="Tuvalu (+688)" value="TV">Tuvalu (+688)</option>
                                    <option label="U.S. Virgin Islands (+1-340)" value="VI">U.S. Virgin Islands (+1-340)</option>
                                    <option label="Uganda (+256)" value="UG">Uganda (+256)</option>
                                    <option label="Ukraine (+380)" value="UA">Ukraine (+380)</option>
                                    <option label="United Kingdom (+44)" value="GB">United Kingdom (+44)</option>
                                    <option label="United States (+1)" value="US">United States (+1)</option>
                                    <option label="United States Minor Outlying Islands (+1)" value="UM">United States Minor Outlying Islands (+1)</option>
                                    <option label="Uruguay (+598)" value="UY">Uruguay (+598)</option>
                                    <option label="Uzbekistan (+998)" value="UZ">Uzbekistan (+998)</option>
                                    <option label="Vanuatu (+678)" value="VU">Vanuatu (+678)</option>
                                    <option label="Vatican City State (+379)" value="VA">Vatican City State (+379)</option>
                                    <option label="Venezuela (+58)" value="VE">Venezuela (+58)</option>
                                    <option label="Vietnam (+84)" value="VN">Vietnam (+84)</option>
                                    <option label="Wallis And Futuna (+681)" value="WF">Wallis And Futuna (+681)</option>
                                    <option label="Western Sahara (+212)" value="EH">Western Sahara (+212)</option>
                                    <option label="Yemen (+967)" value="YE">Yemen (+967)</option>
                                    <option label="Zambia (+260)" value="ZM">Zambia (+260)</option>
                                    <option label="Zimbabwe (+263)" value="ZW">Zimbabwe (+263)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="phone_number"><?php echo trans('092');?></label>
                                <input type="text" id="phone_number" name="number" value="<?=postOldData('number')?>" required maxlength="12" minlength="4" placeholder="Phone Number" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default guest">
                    <div class="panel-heading"><?php echo trans('0528');?></div>
                    <div class="panel-body">
                        <?php for($i = 0; $i < $sessionHotel->totalPax; $i++): ?>
                        <div class="row form-group">
                            <div class="col-md-12"> <label><?php echo trans('0566');?> <?=$i+1?></label> </div>
                            <div class="col-md-4 col-xs-12">
                                <select class="form-control" name="type[]">
                                    <option value="AD" <?=(postOldData('type', $i) == "AD")?"selected":""?>><?php echo trans('010');?></option>
                                    <option value="CH" <?=(postOldData('type', $i) == "CH")?"selected":""?>><?php echo trans('011');?></option>
                                </select>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <input type="text" class="form-control" required placeholder="Name" name="name[]" value="<?=postOldData('name', $i)?>">
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <input type="text" class="form-control" required placeholder="Surname" name="surname[]" value="<?=postOldData('surname', $i)?>">
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="panel panel-default guest">
                    <div class="panel-heading"><?php echo trans('0407');?> <?php echo trans('0177');?></div>
                    <div class="panel-body">
                        <?php if($sessionHotel->room->rate->paymentType == 'AT_HOTEL'): ?>
                        <div class="row">
                            <div class="col-sm-7">
                                <p>In a hurry?</p>
                                <p>Pay with Visa Checkout, the easier way to pay online.</p>
                            </div>
                            <div class="col-sm-5">
                                <img class="pull-right img-responsive" src="<?php echo $theme_url; ?>assets/img/visa.png">
                            </div>
                        </div>
                        <div class="credit-card__strike"> <span class="credit-card__strike-text h4 text-chambray">Or pay with traditional checkout</span> </div>
                        <hr>
                        <div class="row credit-card__form-container">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4"> <label for="cardHolderName">Name on card*</label> </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" placeholder="Your Name" id="cardHolderName" name="cardHolderName" value="Qasim">
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-4"> <label for="cardNumber">Card number*</label> </div>
                                    <div class="col-md-8">
                                        <input class="form-control" id="cardNumber" name="cardNumber" type="text" placeholder="xxxx-xxxx-xxxx-xxxx" value="4321-87654-1112-1516">
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-4"> <label for="month">Expiration date*</label> </div>
                                    <div class="clearfix visible-xs visible-sm">&nbsp;</div>
                                    <div class="col-md-4">
                                        <select class="form-control" id="month" required name="month">
                                            <option value="01" selected>01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="clearfix visible-xs visible-sm">&nbsp;</div>
                                    <div class="col-md-4">
                                        <select class="form-control" required name="year">
                                            <option value="2018" selected>2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-4"> <label for="cardCVC">Security code*</label> </div>
                                    <div class="col-md-3 col-xs-8">
                                        <input type="text" id="cardCVC" required="required" name="cardCVC" class="form-control" placeholder="***" value="321" >
                                    </div>
                                    <div class="col-md-5 col-xs-4">
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix visible-xs visible-sm">&nbsp;</div>

                            <div class="col-md-5">
                                <div class="secure-panel">
                                    <div class="panel-body">
                                        <div class="col-md-2">
                                            <div class="row"><img src="<?php echo $theme_url; ?>assets/img/lock-icon.png" class="img-responsive" alt="secure" /></div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="text-success"><strong>100% Secure</strong></div>
                                            We use 128-bit SSL encryption.
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="col-md-2">
                                            <div class="row"><img src="<?php echo $theme_url; ?>assets/img/shield-icon.png" class="img-responsive" alt="secure" /></div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="text-success"><strong>Trusted worldwide</strong></div>
                                            We do not store or view your card data.
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="col-md-2">
                                            <div class="row"><img src="<?php echo $theme_url; ?>assets/img/credit-card-checkmark.png" class="img-responsive" alt="secure" /></div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="text-success"><strong>Easy payment</strong></div>
                                            We accept the following payment methods:
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <img class="img-responsive center-block" src="<?php echo $theme_url; ?>assets/img/credit-cards.png" alt="availble credit cards">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <h4><?php echo trans('0345');?></h4>
                        <?php endif; ?>
                    </div>
                </div>
                <p><small><?php echo trans('0416');?></small></p>
                <input type="hidden" name="rateKey" value="<?=$sessionHotel->room->rate->rateKey?>">
                <input type="hidden" name="totalNights" value="<?=$sessionHotel->totalNights?>">
                <input type="hidden" name="hotelImage" value="<?=$sessionHotel->image?>">
                <input type="hidden" name="hotelStars" value="<?=$sessionHotel->categoryName[0]?>">
                <input type="hidden" name="paymentType" value="<?=$sessionHotel->room->rate->paymentType?>">
                <button class="btn btn-success btn-block btn-lg booking_botton" type="button" id="completeBooking"><?php echo trans('0335');?></button>
            </div>
            <div class="col-md-4 summary">
                <div class="row">
                    <h4><?php echo trans('0411');?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?=$sessionHotel->image?>" class="img-responsive" alt="hotel image">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <h6 class="m0"><strong><?=$sessionHotel->name?></strong></h6>
                                <p  class="m0">Address and country name</p>
                                <p  class="m0">
                                    <?php  for($i=1; $i<=$sessionHotel->categoryName[0]; $i++) {  ?>
                                        <i class="fa fa-star text-warning"></i>
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="hotel_details_panel__checkout">
                                <ul class="no-margin no-padding">
                                    <li><b> <?php echo trans('07');?> <?php echo trans('08');?></b><span class="pull-right"><?=$sessionHotel->checkIn?></span></li>
                                    <li><b> <?php echo trans('09');?> <?php echo trans('08');?></b><span class="pull-right"><?=$sessionHotel->checkOut?></span></li>
                                    <li><b> <?php echo trans('0276');?> </b> <span class="pull-right"><?=$sessionHotel->totalNights?></span></li>
                                    <li><b> <?php echo trans('0227');?> </b> <span class="pull-right"><?=$sessionHotel->totalRooms?></span></li>
                                </ul>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo trans('016');?> </div>
                        <div class="panel-body m0">
                            <p class="m0"><i class="fa fa-bed"></i> 01. <strong><?=$sessionHotel->room->name?></strong> <span class="pull-right">For <?=$sessionHotel->totalAdults?> <?php echo trans('010');?></span></p>
                            <hr>
                            <p class="m0"><?=$sessionHotel->room->rate->boardName?></p>
                            <hr>
    <!--                        --><?php //if ($detail->room->refundable == 0) { ?>
    <!--                            <p  class="m0 text-danger strong">Non-refundable</p>-->
    <!--                        --><?php //} else { ?>
    <!--                            <p  class="m0 text-success strong">Refundable</p>-->
    <!--                        --><?php //} ?>
                        </div>
                    </div>
                    <div class="form-group total-wrapper">
    <!--                    <div class="total_msg">-->
    <!--                        VAT <span class="pull-right">USD&nbsp;0.00</span>-->
    <!--                    </div>-->
                        <div class="panel-body">
                            <div class="row">
                                <h4>
                                    <div class="pull-left"><strong><?php echo trans('078');?></strong> <small style="color:white">(incl. VAT)</small></div>
                                    <?php $currency = (in_array('hotelCurrency', $sessionHotel->room->rate))?$sessionHotel->room->rate->hotelCurrency:"TRY"?>
                                    <div class="pull-right"><strong><?=$currency?> <?=$sessionHotel->room->rate->net + $sessionHotel->room->rate->commission?></strong></div>
                                </h4>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong><?php echo trans('0382');?></strong></h3>
                        </div>
                        <div class="panel-body text-chambray">
                            <p><?php echo trans('0381');?></p>
                            <hr>
                            <?php if(!empty($phone)){ ?><p> <i class="fa fa-phone"></i> <?php echo $phone; ?> </p><?php } ?>
                            <hr>
                            <p><i class="fa fa-envelope-o"></i> <?php echo $contactemail; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div style="margin:100px"></div>

<script>
    $("button[id=completeBooking]").on("click", function() {
        var button = $(this);
        var form = $("form[name=bookingForm]");
        var oldText = button.text();
        button.text('Processing...');
        $.post(form.attr('action'), form.serialize(), function(response) {
            console.log(response);
            button.text(oldText);
            if(response.status == 'fail') {
                $("button[id=completeBooking]").after('<div style="margin-top: 10px;padding: 25px;background: #fbd5d5;">'+response.message+'</div>');
            } else {
                $("button[id=completeBooking]").after('<div style="margin-top: 10px;padding: 25px;background: #fbd5d5;">'+response.message+'</div>');
            }
            setTimeout(function() { 
                window.location.href = response.invoice_url;
            }, 3000);
        });
    });
</script>
