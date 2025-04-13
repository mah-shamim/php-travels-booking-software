<form method="POST" action="<?php echo base_url('admin/grnhotels/update_settings'); ?>">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?=$page_title?></div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="api_endpoint">API Key</label>
                    <input class="form-control" id="api_key" name="apiConfig[api_key]" value="<?=$moduleSetting->apiConfig->api_key?>"/>
                </div>
                <div class="form-group">
                    <label for="api_environment">API Environment</label>
                    <select name="apiConfig[api_environment]" id="api_environment" class="form-control">
                        <option value="production" <?=($moduleSetting->apiConfig->api_environment == 'production') ? 'selected' : ''?>>Production</option>
                        <option value="sandbox" <?=($moduleSetting->apiConfig->api_environment == 'sandbox') ? 'selected' : ''?>>Sandbox</option>
                    </select>

                </div>

                <div class="form-group">
                    <div class="col-md-6" style="padding:0px;margin-bottom:15px">
                        <label for="host">Database Host</label>
                        <input class="form-control" id="host" name="database[host]" value="<?=$moduleSetting->database->host?>"/>
                    </div>
                    <div class="col-md-6" style="padding-right:0px;margin-bottom:15px;">
                        <label for="dbname">Database Name</label>
                        <input class="form-control" id="dbname" name="database[dbname]" value="<?=$moduleSetting->database->dbname?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6" style="padding:0px;">
                        <label for="username">Database Usename</label>
                        <input class="form-control" id="username" name="database[username]" value="<?=$moduleSetting->database->username?>"/>
                    </div>
                    <div class="col-md-6" style="padding-right:0px;">
                        <label for="password">Database Password</label>
                        <input class="form-control" id="password" name="database[password]" value="<?=$moduleSetting->database->password?>"/>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?=base_url('admin/modules')?>" class="btn btn-default">Back</a>
                <button id="checkconncetion" type="button" class="btn btn-primary">CheckConnection</button>

            </div>
        </div>
    </div>
</form>

<script>

    $('[id=checkconncetion]').on('click', function() {
        var host = $("#host").val();
        var dbname = $("#dbname").val();
        var password = $("#password").val();
        var username = $("#username").val();
        var payload = { 'hostname': host, 'databasename': dbname, 'password': password,'username': username };
        $.post('<?=base_url("admin/modules/ajaxController/dbckeck")?>', payload, function(response) {
            alert(response);
            //window.location.reload();
        });

    });
</script>