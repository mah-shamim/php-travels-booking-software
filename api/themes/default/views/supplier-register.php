<style>
  .signup-wrapper {
  background: #04429a;
  padding-top: 140px;
  padding-bottom: 60px;
  }
  .signup-wrapper h3{
  font-weight:300;
  }
  .nav-tabs .nav-link.active{
  background:#f8f9fa!important;
  border:none !important;
  }
  .nav-tabs {
  border:none
  }
  .nav-tabs .nav-link:hover{
  border:none;
  }
  .nav-tabs .nav-link{
  border:none;
  }
  .process-box{
  background-color: white;
  border:0.5px solid #eee;
  border-radius: 6px;
  padding:20px;
  text-align:center;
  min-height:320px;
  }
  .process-box h4{
    margin-top:0 
  }
  .icon-60x{
    font-size:60px;
  }
  .icon-50x{
font-size:50px
  }
  .signup-text h1,
  .signup-text h2,
  .signup-text p
  {
color:#fff;
margin:0;
line-height:normal;
  }
  .signup-text p{
    font-size:25px;
    font-weight: 100;
  }
  .signup-text h4{
    letter-spacing:1px;
    line-height:30px;
  }
  @media(max-width:768px){
    .signup-text{
      text-align:center;
      margin-bottom:40px;
    }
  }
</style>
<div class="signup-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <div class="signup-text ">
          <h1><strong><?php echo $app_settings[0]->site_title;?></strong></h1>
          <h2><?php echo trans('0494');?></h2>
          <p class="mt-4 ">
          <?php echo trans('0192');?>
          <?php echo trans('0193');?> <br>
          <?php echo trans('0495');?> <br>
          <?php echo trans('0496');?> <br>
          <?php echo trans('0497');?> <br>
          <?php echo trans('0498');?> <br>
          <?php echo trans('0499');?> <br>
          <?php echo trans('0500');?> <br>
          </p>
        </div>
      </div>
      <div class="col-md-5">
      <div class="py-20">
      <?php if(!empty($success)){   ?>
  <div class="alert alert-success">
    <i class="fa fa-check"></i>
    <?php  echo trans('0244');  ?>
  </div>
  <?php   }else{
    if(!empty($error)){  ?>
  <div class="alert alert-danger">
    <?php  echo @$error;  ?>
  </div>
  <?php } } ?>
      </div>
        <ul class="nav nav-tabs nav-justified bg-white" id="myTab" role="tablist">
          <?php  if(isModuleActive('tours')){ ?>
          <li class="nav-item">
            <a class="nav-link text-dark showform active" id="tours" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" ><strong><?php echo trans('0271');?></strong></a>
          </li>
          <?php } ?>
          <?php  if(isModuleActive('cars')){ ?>
          <li class="nav-item">
            <a class="nav-link text-dark showform" id="cars" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" ><strong><?php echo trans('Cars');?></strong></a >
          </li>
          <?php } ?>
          <?php  if(isModuleActive('hotels')){ ?>
          <li class="nav-item">
            <a class="nav-link text-dark showform" id="hotels" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" ><strong><?php echo trans('0405');?></strong></a >
          </li>
          <?php } ?>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active">
            <div class="bg-light p-4">
              <form  action="" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">
                    <span class="modulelabel" id="hotelslabel"><?php echo trans('0405');?></span><span class="modulelabel" id="tourslabel"> <?php echo trans('0271'); ?> </span><span class="modulelabel" id="carslabel"><?php echo trans('Cars'); ?></span>
                    <?php echo trans('0243');?>
                    <?php echo trans('0350');?>
                    </label>
                    <input data-original-title="<?php echo trans('0350');?>" data-toggle="tooltip" data-placement="top" class="form-control" type="text" placeholder="<?php echo trans('0350');?>" name="itemname"  value="<?php echo set_value('itemname'); ?>" required >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputCity"><?php echo trans('090');?></label>
                    <input data-original-title="<?php echo trans('090');?>" data-toggle="tooltip" data-placement="top" class="form-control" type="text" placeholder="<?php echo trans('090');?>" name="fname"  value="<?php echo set_value('fname'); ?>" required >
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputState"><?php echo trans('091');?></label>
                    <input data-original-title="<?php echo trans('091');?>" data-toggle="tooltip" data-placement="top" class="form-control" type="text" placeholder="<?php echo trans('091');?>" name="lname" value="<?php echo set_value('lname'); ?>" required >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4"><?php echo trans('094');?></label>
                    <input data-original-title="<?php echo trans('094');?>" data-toggle="tooltip" data-placement="top" class="form-control" type="email" placeholder="<?php echo trans('094');?>" name="email" value="<?php echo set_value('email'); ?>" required >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputCity"><?php echo trans('092');?></label>
                    <input data-original-title="<?php echo trans('092');?>" data-toggle="tooltip" data-placement="top" class="form-control py-2" type="text" placeholder="<?php echo trans('092');?>" name="mobile" value="<?php echo set_value('mobile'); ?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputState"><?php echo trans('0105');?></label>
                    <select data-original-title="<?php echo trans('0105');?>" data-toggle="tooltip" data-placement="top" data-placeholder="Select" name="country" class="form-control chosen-the-basic"  required>
                      <option value=""> <?php echo trans('0484');?> </option>
                      <?php foreach($allcountries as $c){ ?>
                      <option value="<?php echo $c->iso2;?>"><?php echo $c->short_name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputCity"><?php echo trans('0101');?></label>
                    <input data-original-title="<?php echo trans('0101');?>" data-toggle="tooltip" data-placement="top" class="form-control" type="text" placeholder="<?php echo trans('0101');?>" name="state" value="<?php echo set_value('state'); ?>" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputState"><?php echo trans('0100');?></label>
                    <input data-original-title="<?php echo trans('0100');?>" data-toggle="tooltip" data-placement="top" class="form-control" type="text" placeholder="<?php echo trans('0100');?>" name="city" value="<?php echo set_value('city'); ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputAddress"><?php echo trans('098');?></label>
                  <input data-original-title="<?php echo trans('098');?>" data-toggle="tooltip" data-placement="top" class="form-control form" type="text" placeholder="<?php echo trans('098');?>" name="address1" value="<?php echo set_value('address1'); ?>" required>
                </div>
                <div class="form-group">
                  <label for="inputAddress2"><?php echo trans('099');?></label>
                  <input data-original-title="<?php echo trans('099');?>" data-toggle="tooltip" data-placement="top" class="form-control" type="text" placeholder="<?php echo trans('099');?>" name="address2" value="<?php echo set_value('address2'); ?>" required>
                </div>
                <input type="hidden" name="addaccount" value="1" />
                <input type="hidden" name="type" value="supplier" />
                <div class="panel-footer">
                  <input type="hidden" id="applyfor" name="applyfor" value="">
                  <div class="clearfix"></div> 
                  <button type="submit" class="btn btn-primary btn-block btn-lg">
                  <?php echo trans('05');?>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-5 mx-auto">
      <h3 class="mt-30 text-center"><?php echo trans('0502');?></h3>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4 mt-30">
      <div class="process-box">
      <div><i class="ion-android-contact icon-60x text-primary"></i></div>
        <h4><strong><?php echo trans('0115');?></strong></h4>
        <p><?php echo trans('0504');?></p>
      </div>
    </div>
    <div class="col-md-4 mt-30">
      <div class="process-box">
      <div class="pt-10">
      <i class="ion-android-checkmark-circle icon-50x text-primary"></i>
      </div>
        <h4 class="mt-10"><strong><?php echo trans('0505');?></strong></h4>
        <p><?php echo trans('0507');?></p>
      </div>
    </div>
    <div class="col-md-4 mt-30">
      <div class="process-box">
      <div style="transform: rotate(90deg);"><i class="ion-key icon-60x text-primary"></i></div>
        <h4><strong><?php echo trans('0508');?></strong></h4>
        <p><?php echo trans('0510');?></p>
      </div>
    </div>
  </div>
  <a class="btn btn-primary btn-lg btn-block mt-40" href="#top"> <?php echo trans('0511');?> </a>
</div>
<script type="text/javascript">
$(function(){
$("#apply").hide();
$("#hotelslabel").hide();
$("#tourslabel").hide();
$("#carslabel").hide();
$(".showform").on("click",function(){
var module = $(this).prop('id');
$("#applyfor").val(module);
$(".modulelabel").hide();
$("#"+module+"label").show();
$("#apply").slideDown();
})
})
</script>