<form method="POST" action="<?php echo base_url('admin/juniper/update_settings'); ?>">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Juniper API Settings</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Api End Point</span>
                            <input class="form-control" id="actor" name="apiConfig[ent_point]" value="<?=$moduleSetting->apiConfig->ent_point?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">User</span>
                            <input class="form-control" id="user" name="apiConfig[user]" value="<?=$moduleSetting->apiConfig->user?>"/>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Password</span>
                            <input class="form-control" id="jpassword" name="apiConfig[jpassword]" value="<?=$moduleSetting->apiConfig->jpassword?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">Mark Up</span>
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
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">API Mode</span>
                            <select class="form-control" name="apiConfig[mode]">
                                <option value="0" <?php if($moduleSetting->apiConfig->mode == 0){ echo "selected"; }  ?>>Sandbox</option>
                                <option value="1" <?php if($moduleSetting->apiConfig->mode == 1){ echo "selected"; }  ?>>Production</option>
                            </select>
                        </div>
                    </div>
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
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?=base_url('admin')?>" class="btn btn-default">Back</a>
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