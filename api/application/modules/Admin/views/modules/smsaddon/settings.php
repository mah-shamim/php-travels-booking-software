
<div class="<?php echo body;?>">
  
  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <form action="" method="POST">
    <div class="panel panel-primary">

    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-cog"></i> SMS Addon Settings</span>
      <div class="pull-right">
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>

            <div class="panel-body">  <?php
            $number = $lib->testnumber;
           // print_r($lib->send_sms("This is a test message",$number));?>
              <div class="form-horizontal  col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <div class="form-group">
                    <table class="table table-striped">
                      <tbody>
                                            <tr>

                      <td>Mobile Number</td>
                      <td style="width:200px">
            <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" value="<?php echo $settings[0]->mobile;?>" > </td>
                      <td>Enter Mobile number to send test sms for testing module</td>
                      </tr>
                      <tr>

                      <td>Status</td>
                      <td style="width:200px">
<select class="form-control" name="status" id="">
<option value="1" <?php if($status == "1"){ echo "selected"; }?> >Enabled</option>
<option value="0" <?php if($status == "0"){ echo "selected"; }?> >Disabled</option>
</select>                      </td>
                      <td>Status of sms module</td>
                      </tr>

                      <tr>
                      <td>Providers URL</td>
                      <td style="width:380px">
                      <input type="text" name="url" class="form-control" placeholder="URL" value="<?php echo $settings[0]->url;?>" >
                      </td>
                      <td>SMS Service providers URL Goes Here, for example : http://api.domain/send</td>
                      </tr>
                    <!--  <tr>
                      <td>Balance Enquiry URL</td>
                      <td style="width:380px">
                      <input type="text" name="burl" class="form-control" placeholder="Balance URL" value="<?php echo $settings[0]->url;?>" >
                      </td>
                      <td>SMS Service providers Balance Enquiry URL to get the remaining credits Information.</td>
                      </tr>-->

                      <tr>
                      <td>Message Parameter</td>
                      <td>
                      <input type="text" name="msg_parameter" class="form-control" placeholder="message premeter" value="<?php echo $settings[0]->msg_parameter;?>" >
                      </td>
                      <td>SMS Service providers message parameter, for example : http://api.domain/send?MESSAGE=xxx</td>
                      </tr>

                      <tr>
                      <td>Receiver Parameter</td>
                      <td>
                      <input type="text" name="receiver_parameter" class="form-control" placeholder="receiver premeter" value="<?php echo $settings[0]->receiver_parameter;?>" >
                      </td>
                      <td>SMS Service providers receiver parameter, for example : http://api.domain/send?TO=xxx</td>
                      </tr>

                      <tr>
                      <td>Sender Parameter</td>
                      <td>
                      <input type="text" name="sender_parameter" class="form-control" placeholder="sender premeter" value="<?php echo $settings[0]->sender_parameter;?>" >
                      </td>
                      <td><input type="text" name="sender_value" class="form-control" placeholder="sender value" value="<?php echo $settings[0]->sender_value;?>" > </td>
                      </tr>

                      <tr>
                      <td>Username Parameter</td>
                      <td>
                      <input type="text" name="username_parameter" class="form-control" placeholder="username parameter" value="<?php echo $settings[0]->username_parameter;?>" >
                      </td>
                      <td><input type="text" name="username_value" class="form-control" placeholder="username value" value="<?php echo $settings[0]->username_value;?>" >   </td>
                      </tr>

                      <tr>
                      <td>Password Parameter</td>
                      <td>
                      <input type="text" name="password_parameter" class="form-control" placeholder="password premeter" value="<?php echo $settings[0]->password_parameter;?>" >
                      </td>
                      <td><input type="text" name="password_value" class="form-control" placeholder="password value" value="<?php echo $settings[0]->password_value;?>" > </td>
                      </tr>

                      <tr>
                      <td>Optional Field 1</td>
                      <td>
                      <input type="text" name="optional1_parameter" class="form-control" placeholder="optional parameter 1" value="<?php echo $settings[0]->opt1_parameter;?>" >
                      </td>
                      <td><input type="text" name="optional1_value" class="form-control" placeholder="optional value 1" value="<?php echo $settings[0]->opt1_value;?>" ></td>
                      </tr>

                      <tr>
                      <td>Optional Field 2</td>
                      <td>
                      <input type="text" name="optional2_parameter" class="form-control" placeholder="optional parameter 2" value="<?php echo $settings[0]->opt2_parameter;?>" >
                      </td>
                      <td><input type="text" name="optional2_value" class="form-control" placeholder="optional value 2" value="<?php echo $settings[0]->opt2_value;?>" >  </td>
                      </tr>

                      <tr>
                      <td>Optional Field 3</td>
                      <td>
                      <input type="text" name="optional3_parameter" class="form-control" placeholder="optional parameter 3" value="<?php echo $settings[0]->opt3_parameter;?>" >
                      </td>
                      <td><input type="text" name="optional3_value" class="form-control" placeholder="optional value 3" value="<?php echo $settings[0]->opt3_value;?>" > </td>
                      </tr>

                      </tbody>
                      </table>
                      <!--Allowed Templates--->
                      <h3>SMS Permission</h3>
                      <?php foreach($templates as $tmps){ ?>
                      <input type="checkbox" name="temps[]" value="<?php echo $tmps->temp_name; ?>" <?php if(in_array($tmps->temp_name,$allowedtemplates)){ echo "checked"; } ?>  /> <?php echo $tmps->temp_title; ?> <br>
                      <?php  } ?>

                      <!--End Allowed Templates--->

          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="updatesettings" value="1" />
    <button type="submit" class="btn btn-primary btn-lg pull-right"><i class="fa fa-save"></i> Submit</button>
  </form>
</div>