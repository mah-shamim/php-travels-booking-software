<form method="POST" action="<?php echo base_url('admin/hotelston/update_settings'); ?>">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Hotelston API Settings</div>
            <div class="panel-body">
                <div class="form-group">
                	<label for="staticDataService">StaticDataService wsdl</label>
                	<input class="form-control" id="staticDataService" name="apiConfig[staticDataService]" value="<?=$moduleSetting->apiConfig->staticDataService?>"/>
                </div>
                <div class="form-group">
                    <label for="staticDataService_end">StaticDataService Endpoint </label>
                    <input class="form-control" id="staticDataService_end" name="apiConfig[staticDataService_end]" value="<?=$moduleSetting->apiConfig->staticDataService_end?>"/>
                </div>
                <div class="form-group">
                    <label for="hotelService">HotelService wsdl</label>
                    <input class="form-control" id="hotelService" name="apiConfig[hotelService]" value="<?=$moduleSetting->apiConfig->hotelService?>"/>
                </div>
                <div class="form-group">
                    <label for="hotelService_end">HotelService Endpoint </label>
                    <input class="form-control" id="hotelService_end" name="apiConfig[hotelService_end]" value="<?=$moduleSetting->apiConfig->hotelService_end?>"/>
                </div>
                <div class="form-group">
                	<label for="email">Email</label>
                	<input class="form-control" id="email" name="apiConfig[email]" value="<?=$moduleSetting->apiConfig->email?>"/>
                </div>
                <div class="form-group">
                	<label for="password">Password</label>
                	<input class="form-control" id="password" name="apiConfig[password]" value="<?=$moduleSetting->apiConfig->password?>"/>
                </div>
                <div class="form-group">
                	<label for="currency">Currency</label>
                	<input class="form-control" id="currency" name="apiConfig[currency]" value="<?=$moduleSetting->apiConfig->currency?>"/>
                </div>
                <div class="form-group">
                    <label for="markup">Mark Up</label>
                    <select name="settings[markup]" id="markup" class="form-control">
                        <option value="0">0%</option>
                        <option value="1" <?=($moduleSetting->settings->markup == 1)?'selected':''?>>1%</option>
                        <option value="2" <?=($moduleSetting->settings->markup == 2)?'selected':''?>>2%</option>
                        <option value="3" <?=($moduleSetting->settings->markup == 3)?'selected':''?>>3%</option>
                        <option value="4" <?=($moduleSetting->settings->markup == 4)?'selected':''?>>4%</option>
                        <option value="5" <?=($moduleSetting->settings->markup == 5)?'selected':''?>>5%</option>
                        <option value="6" <?=($moduleSetting->settings->markup == 6)?'selected':''?>>6%</option>
                        <option value="7" <?=($moduleSetting->settings->markup == 7)?'selected':''?>>7%</option>
                        <option value="8" <?=($moduleSetting->settings->markup == 8)?'selected':''?>>8%</option>
                        <option value="9" <?=($moduleSetting->settings->markup == 9)?'selected':''?>>9%</option>
                        <option value="10" <?=($moduleSetting->settings->markup == 10)?'selected':''?>>10%</option>
                        <option value="11" <?=($moduleSetting->settings->markup == 11)?'selected':''?>>11%</option>
                        <option value="12" <?=($moduleSetting->settings->markup == 12)?'selected':''?>>12%</option>
                        <option value="13" <?=($moduleSetting->settings->markup == 13)?'selected':''?>>13%</option>
                        <option value="14" <?=($moduleSetting->settings->markup == 14)?'selected':''?>>14%</option>
                        <option value="15" <?=($moduleSetting->settings->markup == 15)?'selected':''?>>15%</option>
                        <option value="16" <?=($moduleSetting->settings->markup == 16)?'selected':''?>>16%</option>
                        <option value="17" <?=($moduleSetting->settings->markup == 17)?'selected':''?>>17%</option>
                        <option value="18" <?=($moduleSetting->settings->markup == 18)?'selected':''?>>18%</option>
                        <option value="19" <?=($moduleSetting->settings->markup == 19)?'selected':''?>>19%</option>
                        <option value="20" <?=($moduleSetting->settings->markup == 20)?'selected':''?>>20%</option>
                        <option value="21" <?=($moduleSetting->settings->markup == 21)?'selected':''?>>21%</option>
                        <option value="22" <?=($moduleSetting->settings->markup == 22)?'selected':''?>>22%</option>
                        <option value="23" <?=($moduleSetting->settings->markup == 23)?'selected':''?>>23%</option>
                        <option value="24" <?=($moduleSetting->settings->markup == 24)?'selected':''?>>24%</option>
                        <option value="25" <?=($moduleSetting->settings->markup == 25)?'selected':''?>>25%</option>
                        <option value="26" <?=($moduleSetting->settings->markup == 26)?'selected':''?>>26%</option>
                        <option value="27" <?=($moduleSetting->settings->markup == 27)?'selected':''?>>27%</option>
                        <option value="28" <?=($moduleSetting->settings->markup == 28)?'selected':''?>>28%</option>
                        <option value="29" <?=($moduleSetting->settings->markup == 29)?'selected':''?>>29%</option>
                        <option value="30" <?=($moduleSetting->settings->markup == 30)?'selected':''?>>30%</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="markup">Booking Method</label>
                    <select name="settings[booking_method]" id="booking_method" class="form-control">
                        <option value="Book After Payment" <?=($moduleSetting->settings->booking_method == 'Book After Payment')?'selected':''?>>Book After Payment</option>
                        <option value="Book Without Payment" <?=($moduleSetting->settings->booking_method == 'Book Without Payment')?'selected':''?>>Book Without Payment</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">Booking Email</label>
                    <input class="form-control" id="book_email" name="apiConfig[book_email]" value="<?=$moduleSetting->apiConfig->book_email?>"/>
                </div>

            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?=base_url('admin')?>" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</form>
