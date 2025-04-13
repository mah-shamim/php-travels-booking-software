<?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
<form action="<?php echo base_url('admin/viator/update_settings'); ?>" method="POST">
    <div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title pull-left">Viator Settings</span>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="spacer20px">
            <div class="panel-body">
                <div class="form-horizontal  col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <div class="form-group">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>API Environment</td>
                                        <td>
                                            <select name="api_environment" id="api_environment" class="form-control">
                                                <option value="production" <?=($moduleSetting->settings->api_environment == 'production') ? 'selected' : ''?>>Production</option>
                                                <option value="sandbox" <?=($moduleSetting->settings->api_environment == 'sandbox') ? 'selected' : ''?>>Sandbox</option>
                                            </select>
                                        </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td>API Endpoint</td>
                                        <td>
                                            <input type="" class="form-control" name="api_endpoint" placeholder="Api Endpoint" value="<?php echo $moduleSetting->settings->api_endpoint;?>" />
                                        </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td>Api Key</td>
                                        <td>
                                        <input type="" class="form-control" name="apiKey" placeholder="Enter Api Key" value="<?php echo $moduleSetting->settings->apiKey;?>" />
                                        </td>
                                        <td></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
    </div>
    </div>
</form>