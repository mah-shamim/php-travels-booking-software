<script type="text/javascript">
    $(function(){
    var slug = $("#slug").val();
    $(".submitfrm").click(function(){
    var submitType = $(this).prop('id');
    for ( instance in CKEDITOR.instances )
    {
    CKEDITOR.instances[instance].updateElement();
    }
    $(".output").html("");
    $('html, body').animate({
    scrollTop: $('body').offset().top
    }, 'slow');
    if(submitType == "add"){
    url = "<?php echo base_url();?>admin/offers/add" ;
    }else{
    url = "<?php echo base_url();?>admin/offers/manage/"+slug;
    }
    $.post(url,$(".offer-form").serialize() , function(response){
    if($.trim(response) != "done"){
    $(".output").html(response);
    }else{
    window.location.href = "<?php echo base_url().$adminsegment."/offers/"?>";
    }
    });
    })
    })
</script>
<div class="output"></div>
<form action="" method="POST" class="offer-form" onsubmit="return false;" >
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel panel-heading"><?php echo $headingText;?></div>
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="active"><a href="#GENERAL" data-toggle="tab">General</a></li>
                <li class=""><a href="#TRANSLATE" data-toggle="tab">Translate</a></li>
            </ul>
            <div class="panel-body">
                <br>
                <div class="tab-content form-horizontal">
                    <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
                        <div class="clearfix"></div>
                        <div class="row form-group">
                            <label class="col-md-12 control-label text-left">Offer Title</label>
                            <div class="col-md-12">
                                <input name="offertitle" type="text" placeholder="Offer Title" class="form-control" value="<?php echo @$offerdata[0]->offer_title;?>" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12 control-label text-left">Phone</label>
                            <div class="col-md-12">
                                <input name="offerphone" type="numbers" placeholder="Phone" class="form-control" value="<?php echo @$offerdata[0]->offer_phone;?>" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12 control-label text-left">Email</label>
                            <div class="col-md-12">
                                <input name="offeremail" type="numbers" placeholder="Email" class="form-control" value="<?php echo @$offerdata[0]->offer_email;?>" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12 control-label text-left">Offer Description</label>
                            <div class="col-md-12">
                                <?php $this->ckeditor->editor('offerdesc', @$offerdata[0]->offer_desc, $ckconfig,'offerdesc'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane wow fadeIn animated in" id="TRANSLATE">
                        <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackOffersTranslation($lang,$offerid); ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val['name']; ?></div>
                            <div class="panel-body">
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Offer Title</label>
                                    <div class="col-md-4">
                                        <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="Offer Name" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Offer Description</label>
                                    <div class="col-md-10">
                                        <?php $this->ckeditor->editor("translated[$lang][desc]", @$trans[0]->trans_desc, $ckconfig,"translated[$lang][desc]"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <input type="hidden" id="slug" value="<?php echo @$offerdata[0]->offer_slug;?>" />
                <input type="hidden" name="submittype" value="<?php echo $submittype;?>" />
                <input type="hidden" name="offerid" value="<?php echo @$offerid;?>" />
                <button class="btn btn-primary btn-block btn-lg submitfrm" id="<?php echo $submittype; ?>">Submit</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Main Settings</div>
            <div class="panel-body form-horizontal">
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Status</label>
                    <div class="col-md-9">
                        <select data-placeholder="Select" class="form-control" name="offerstatus">
                            <option value="Yes" <?php if(@$offerdata[0]->offer_status == "Yes"){ echo "selected"; }?> >Enabled</option>
                            <option value="No" <?php if(@$offerdata[0]->offer_status == "No"){ echo "selected"; }?> >Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Price</label>
                    <div class="col-md-9">
                        <strong><input name="offerprice" type="text" placeholder="Offer Price" class="form-control input-lg" value="<?php echo @$offerdata[0]->offer_price;?>" /></strong>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Availability</label>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <input name="ofrom" type="text" placeholder="From" class="form-control dpd1" value="<?php echo @$ofrom; ?>" />
                            </div>
                            <div class="col-md-6">
                                <input name="oto" type="text" placeholder="To" class="form-control dpd2" value="<?php echo @$oto; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>