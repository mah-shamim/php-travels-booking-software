<form name="configuration" role="form" action="#" method="post">
  <div class="panel panel-default">
    <div class="panel-heading">Travelport Settings</div>
      <div class="panel-body">
        <br>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Target</label>
              <div class="col-md-4">
                <select  class="form-control" name="target">
                  <option  value="_self" <?php echo ($travelportConf->get_target() == '_self') ? "selected" : ""; ?> >Self</option>
                  <option  value="_blank" <?php echo ($travelportConf->get_target() == '_blank') ? "selected" : ""; ?> >Blank</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Header Title</label>
              <div class="col-md-4">
                <input type="text" name="header_title" class="form-control" placeholder="title" value="<?php echo $travelportConf->get_header_title(); ?>" />
              </div>
            </div>
            <hr>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">API User ID</label>
              <div class="col-md-4">
                <input type="text" name="api_username" placeholder="API User ID" class="form-control" value="<?php echo $travelportConf->get_api_username(); ?>" >
              </div>
            </div>

            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Preprod Password</label>
              <div class="col-md-4">
                <input type="text" name="api_password" class="form-control" placeholder="Preprod Password" value="<?php echo $travelportConf->get_api_password(); ?>" >
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Branch Code</label>
              <div class="col-md-4">
                <input type="text" name="branch_code" class="form-control" placeholder="Branch Code" value="<?php echo $travelportConf->get_branch_code(); ?>" >
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">PCC</label>
              <div class="col-md-4">
                <input type="text" name="pcc" class="form-control" placeholder="PCC" value="<?php echo $travelportConf->get_pcc(); ?>" >
              </div>
            </div>

            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Link</label>
              <div class="col-md-4">
                <input type="text" name="api_endpoint" class="form-control" placeholder="API Endpoint" value="<?php echo $travelportConf->get_api_endpoint(); ?>" >
              </div>
            </div>

          <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Testing Mode</label>
              <div class="col-md-4">
                <select  class="form-control" name="sandbox_mode">
                  <option  value="1" <?php echo ($travelportConf->get_sandbox_mode() == 1) ? "selected" : ""; ?> > On </option>
                  <option  value="0" <?php echo ($travelportConf->get_sandbox_mode() == 0) ? "selected" : ""; ?> > Off </option>
                </select>
              </div>
            </div>
            <hr>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Destination</label>
              <div class="col-md-4">
                <input class="form-control" type="text" placeholder="Default Destination" name="default_destination"  value="<?php echo $travelportConf->get_default_destination(); ?>">
              </div>
            </div>
          <div class="clearfix"></div>
          <hr>
            <h4 class="text-danger">SEO</h4>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Meta Keywords</label>
              <div class="col-md-10">
                <input class="form-control" type="text" placeholder="Meta Keywords" name="meta_keywords" value="<?php echo $travelportConf->get_meta_keywords(); ?>">
              </div>
              <div class="clearfix form-group"></div>
              <label  class="col-md-2 control-label text-left">Meta Description</label>
              <div class="col-md-10">
                <input class="form-control" type="text" placeholder="Meta Description" name="meta_description"  value="<?php echo $travelportConf->get_meta_description(); ?>">
              </div>
            </div>
          <div class="clearfix"></div>
      </div>
    <div class="panel-footer">
      <input type="hidden" readonly name="id" value="<?php echo $travelportConf->get_id(); ?>" />
      <button class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>

<script>
  $("form[name='configuration']").on("submit", function(e) {
      e.preventDefault();
      var update_configuration_endpoint = base_url + "admin/travelport_hotel/ajaxController/update_configuration";
      var formDataPayload = $(this).serializeArray();
      $.post(update_configuration_endpoint, formDataPayload, function(response) {
          if (response.status == 'success') {
              new PNotify({ title: 'Changes saved!', type: 'success', animation: 'fade' });
          } else {
              new PNotify({ title: 'Unable to save changes!', type: 'warning', animation: 'fade' });
          }
      });
  });
</script>