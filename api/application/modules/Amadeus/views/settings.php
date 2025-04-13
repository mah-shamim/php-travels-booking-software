<form method="POST" action="<?php echo base_url('admin/amadeus/update_settings'); ?>">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Amadeus API Settings</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Client ID</span>
                            <input class="form-control" id="client_id" name="apiConfig[client_id]" value="<?=$moduleSetting->apiConfig->client_id?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Secret Key</span>
                            <input class="form-control" id="client_secret" name="apiConfig[client_secret]" value="<?=$moduleSetting->apiConfig->client_secret?>"/>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Commission %</span>
                            <input type="number" value="<?php echo $moduleSetting->apiConfig->commission ?>" min="0" max="100" class="form-control" name="apiConfig[commission]" required="required">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?=base_url('admin')?>" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</form>