<form method="POST" action="<?php echo base_url('admin/flightsi/update_settings'); ?>">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Iati Settings
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-1 text-right">
                            <label for="authCode">AuthCode</label>
                        </div>
                        <div class="col-lg-4 text-right">
                            <input class="form-control" type="text" name="apiConfig[authCode]" id="authCode" value="<?php echo $authCode; ?>" placeholder="Enter Your Auth Code Here" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Default Listing
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                    <div class="form-group">
                        <div class="col-lg-1 text-right">
                            <label for="from">From</label>
                        </div>
                        <div class="col-lg-2 text-right">
                            <input class="form-control" type="text" name="defaultSettings[from]" id="from" value="<?php echo $from; ?>" placeholder="LHE" />
                        </div>
                        <div class="clearfix"></div>
                        </div>
                      <div class="form-group">
                        <div class="col-lg-1 text-right">
                            <label for="to">TO</label>
                        </div>
                        <div class="col-lg-2 text-right">
                            <input class="form-control" type="text" name="defaultSettings[to]" id="to" value="<?php echo $to; ?>" placeholder="DXB" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>