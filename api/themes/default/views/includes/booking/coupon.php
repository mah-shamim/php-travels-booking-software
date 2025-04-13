<?php if(pt_is_module_enabled('coupons')){  ?>
<!-- <div class="clearfix"></div>
<div class="panel panel-default">
  <div class="panel-heading go-text-right"><i class="fa fa-asterisk"></i> <?php echo trans('0166');?></div>
  <div class="panel-body">
    <div class="col-md-5 go-right">
      <p class="RTL"><?php echo trans('0516');?><br>
        <a id="popoverData" href="javascript:void(0);" data-content="<?php echo trans('0514');?>" rel="popover" data-placement="top" data-original-title="<?php echo trans('0515');?>" data-trigger="hover"><strong><?php echo trans('0515');?></strong></a>
      </p>
    </div>
    <div class="col-md-7 go-left">
      <div class="couponresult"></div>
      <div class="col-md-6 go-right">
        <input type="text" class="RTL form-control coupon" placeholder="<?php echo trans('0166');?>">
      </div>
      <div class="col-md-6 go-left">
        <span class="btn btn-danger applycoupon btn-block"><?php echo trans('0517');?></span>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="couponmsg"></div>
  </div>
</div> -->
<h3 class="heading-title"><span><i class="fa fa-asterisk" style="font-size:18px"></i> <?php echo trans('0166');?></span></h3>
   <div class="clear"></div>
                  <div class="bg-white-shadow pt-25 pb-30 ph-30 mb-30">
                                    
                    
                    
                    <div class="row fe">
                      <div class="col-12 col-sm-9 col-md-7">
                      <a id="popoverData" class="go-right" href="javascript:void(0);" data-content="<?php echo trans('0514');?>" rel="popover" data-placement="top" data-original-title="<?php echo trans('0515');?>" data-trigger="hover"><strong class="d-block mb-2"><?php echo trans('0515');?></strong></a>
                      <div class="clear"></div>  
                      <div class="input-group row-reverse">
                             <label class="pure-material-textfield-outlined float-none coupon-label">
                                <input type="text" placeholder=" "  class="o2 coupon form-bg-light">
                               <span><?php echo trans('0166');?></span>
                                </label>
                          <div class="input-group-append o1">
                            <button class="btn btn-danger applycoupon btn-block" type="button"><?php echo trans('0517');?></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <h5><?php echo trans('0516');?></h5>
                    <div class="clear"></div>
                    <div class="couponmsg"></div>
                  </div>
<script type="text/javascript">
  $(function(){
    $(".applycoupon").on("click",function(){
      var module = $("#btype").val();
      var itemid = $("#itemid").val();
      var coupon = $(".coupon").val();
      $.post("<?php echo base_url();?>admin/ajaxcalls/checkCoupon",{coupon: coupon, module: module, itemid: itemid},function(response){
       var resp = $.parseJSON(response);
       if(resp.status == "success"){
        $("#couponid").val(resp.couponid);
        $(".couponmsg").html(" <div class='alert alert-success'> <strong> "+resp.value+"%  </strong> <?php echo trans('0512'); ?></div>");
        $(".coupon").prop("readonly","readonly");
        $(".applycoupon").hide();
       }else{
        $("#couponid").val("");
        $(".couponmsg").html("");
        if(resp.status == "irrelevant"){

          alert("<?php echo trans('0520'); ?>");

        }else{

          alert("<?php echo trans('0513'); ?>");
        }

       }
       console.log(resp);
      })
    })
  })
</script>
<?php } ?>
