<form method="POST" action="<?php echo base_url('admin/kiwitaxi/update_settings'); ?>">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?=$page_title?></div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="api_endpoint">API Endpoint</label>
                    <input class="form-control" id="api_endpoint" name="apiConfig[api_endpoint]" value="<?=$moduleSetting->apiConfig->api_endpoint?>"/>
                </div>

                <div class="form-group">
                    <label for="security_token">Security Token</label>
                    <input class="form-control" id="security_token" name="apiConfig[security_token]" value="<?=$moduleSetting->apiConfig->security_token?>"/>
                </div>

                <div class="form-group">
                    <label for="partner_id">Partner ID</label>
                    <input class="form-control" id="partner_id" name="apiConfig[partner_id]" value="<?=$moduleSetting->apiConfig->partner_id?>"/>
                </div>
                <div class="form-group">
                    <label for="api_environment">API Environment</label>
                    <select name="apiConfig[api_environment]" id="api_environment" class="form-control">
                        <option value="production" <?=($moduleSetting->apiConfig->api_environment == 'production') ? 'selected' : ''?>>Production</option>
                        <option value="sandbox" <?=($moduleSetting->apiConfig->api_environment == 'sandbox') ? 'selected' : ''?>>Sandbox</option>
                    </select>
                </div>
                <!--<div class="form-group">
                    <label for="api_environment">Image Type</label>
                    <select name="apiConfig[photo]" id="photo" class="form-control">
                        <option value="photo" <?=($moduleSetting->apiConfig->photo == 'photo') ? 'selected' : ''?>>Default</option>
                        <option value="photo2" <?=($moduleSetting->apiConfig->photo == 'photo2') ? 'selected' : ''?>>Yellow</option>
                    </select>
                </div>-->
                <div class="form-group">
                    <label for="api_environment">Currency</label>
                    <select name="apiConfig[kawitaxicurrceny]" id="kawitaxicurrceny" class="form-control">
                        <option value="USD" <?=($moduleSetting->apiConfig->kawitaxicurrceny == 'USD') ? 'selected' : ''?>>USD</option>
                        <option value="EUR" <?=($moduleSetting->apiConfig->kawitaxicurrceny == 'EUR') ? 'selected' : ''?>>EUR</option>
                        <option value="RUB" <?=($moduleSetting->apiConfig->kawitaxicurrceny == 'RUB') ? 'selected' : ''?>>RUB</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="api_environment">Pay Methods</label>
                    <select name="apiConfig[kawitaxipayment]" id="kawitaxipayment" class="form-control">
                        <option value="both" <?=($moduleSetting->apiConfig->kawitaxipayment == 'both') ? 'selected' : ''?>>Both</option>
                        <option value="full" <?=($moduleSetting->apiConfig->kawitaxipayment == 'full') ? 'selected' : ''?>>Pay online 100%</option>
                        <option value="none" <?=($moduleSetting->apiConfig->kawitaxipayment == 'none') ? 'selected' : ''?>>Pay to driver</option>
                    </select>
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