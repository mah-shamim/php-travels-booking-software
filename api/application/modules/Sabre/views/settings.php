<form method="POST" action="<?php echo base_url('admin/sabre/update_settings'); ?>">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Sabre API Settings</div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="user_id">User ID</label>
                            <input class="form-control" id="user_id" name="apiConfig[user_id]" value="<?=$moduleSetting->apiConfig->user_id?>"/>
                        </div>
                        <div class="col-md-6">
                            <label for="password">Password</label>
                            <input class="form-control" id="password" name="apiConfig[password]" value="<?=$moduleSetting->apiConfig->password?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ipcc">IPCC (Internet Pseudo City Code)</label>
                            <input class="form-control" id="ipcc" name="apiConfig[ipcc]" value="<?=$moduleSetting->apiConfig->ipcc?>"/>
                        </div>
                        <div class="col-md-6">
                            <label for="group">Group (PCC)</label>
                            <input class="form-control" id="group" name="apiConfig[group]" value="<?=$moduleSetting->apiConfig->group?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="domain">Domain</label>
                            <input class="form-control" id="domain" name="apiConfig[domain]" value="<?=$moduleSetting->apiConfig->domain?>"/>
                        </div>
                        <div class="col-md-6">
                            <label for="tripType">Trip Type</label>
                            <select name="settings[tripType]" id="tripType" class="form-control">
                                <option value="oneWay" <?=($moduleSetting->settings->tripType=='oneWay')?'selected':''?>>One Way</option>
                                <option value="return" <?=($moduleSetting->settings->tripType=='return')?'selected':''?>>Return</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="classOfService">Class of Service</label>
                            <select name="settings[classOfService]" id="classOfService" class="form-control">
                                <option value="ECONOMY" <?=($moduleSetting->settings->classOfService=='ECONOMY')?'selected':''?>>ECONOMY</option>
                                <option value="BUSINESS" <?=($moduleSetting->settings->classOfService=='BUSINESS')?'selected':''?>>BUSINESS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="mode">API Mode</label>
                            <select name="settings[mode]" id="mode" class="form-control">
                                <option value="production" <?=($moduleSetting->settings->mode=='production')?'selected':''?>>Production</option>
                                <option value="sandbox" <?=($moduleSetting->settings->mode=='sandbox')?'selected':''?>>Sandbox</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?=base_url('admin/modules')?>" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</form>