<?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
<form action="" method="POST">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title"> Trip Advisor Settings</div>
    </div>
    <div class="panel-body">
      <div class="spacer20px">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Configuration </h3>
          </div>
          <div class="panel-body">
            <div class="form-horizontal  col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                <div class="form-group">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td>API Key</td>
                        <td>
                          <input type="" class="form-control" name="apikey" placeholder="TripAdvisor API Key" value="<?php echo $settings[0]->apikey;?>" />
                        </td>
                        <td>Input your TripAdvisor API Key here</td>
                      </tr>
                      <tr>
                        <td>API version</td>
                        <td>
                          <input type="text" name="version" class="form-control" placeholder="API version" value="<?php echo $settings[0]->cid;?>" />
                        </td>
                        <td>Type TripAdvisor API version here</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="updatesettings" value="1" />
    <input type="hidden" name="updatefor" value="tripadvisor" />
    <div class="panel-footer">
      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
    </div>
  </div>
</form>