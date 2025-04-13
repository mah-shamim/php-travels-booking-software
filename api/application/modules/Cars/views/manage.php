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
    url = "<?php echo base_url();?>admin/cars/add" ;
    }else{
    url = "<?php echo base_url();?>admin/cars/manage/"+slug;
    }
    $.post(url,$(".car-form").serialize() , function(response){
    if($.trim(response) != "done"){
    $(".output").html(response);
    }else{
    window.location.href = "<?php echo base_url().$adminsegment."/cars/"?>";
    }
    });
    })
    })
</script>
<h3 class="margin-top-0"><?php //echo $cdata[0]->car_title;?></h3>
<div class="output"></div>
<form class="form-horizontal car-form row" method="POST" action="" enctype="multipart/form-data"  onsubmit="return false;" >
    <div class="col-md-8">
        <div class="panel panel-default">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="active"><a href="#GENERAL" data-toggle="tab">General</a></li>
                <li class=""><a href="#META_INFO" data-toggle="tab">Meta Info</a></li>
                <li class=""><a href="#POLICY" data-toggle="tab">Policy</a></li>
                <li class=""><a href="#TRANSLATE" data-toggle="tab">Translate</a></li>
            </ul>
            <div class="panel-body">
                <br>
                <div class="tab-content form-horizontal">
                    <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
                        <div class="clearfix"></div>
                        <div class="row form-group">
                            <label class="col-md-12 control-label text-left">Car Name</label>
                            <div class="col-md-12">
                                <input class="form-control" type="text" placeholder="Car Name" name="carname" value="<?php echo $cdata[0]->car_title;?>" >
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-12 control-label text-left">Car Description</label>
                            <div class="col-md-12">
                                <?php $this->ckeditor->editor('cardesc', @$cdata[0]->car_desc, $ckconfig,'cardesc'); ?>
                            </div>
                        </div>
                        <!--  <label class="col-md-2 control-label text-left">Cancel Anytime</label>
                            <div class="col-md-2">
                                <select class="form-control" name="cancel">
                                    <option value="yes" <?php makeSelected("yes",@$cdata[0]->car_cancel_anytime); ?> >Yes</option>
                                    <option value="no" <?php makeSelected("no",@$cdata[0]->car_cancel_anytime); ?> >No</option>
                                </select>
                            </div>

                            <label class="col-md-2 control-label text-left">Free Amendment</label>
                            <div class="col-md-2">
                                                <select  class="form-control" name="amend">
                                                <option value="yes" <?php makeSelected("yes",@$cdata[0]->car_free_amend); ?> >Yes</option>
                                                <option value="no" <?php makeSelected("no",@$cdata[0]->car_free_amend); ?> >No</option>
                                            </select>
                            </div>
                                <label class="col-md-2 control-label text-left">Unlimited mile</label>
                            <div class="col-md-2">
                                                <select  class="form-control" name="mile">
                                                <option value="yes" <?php makeSelected("yes",@$cdata[0]->car_unlimited_mile); ?> >Yes</option>
                                                <option value="no" <?php makeSelected("no",@$cdata[0]->car_unlimited_mile); ?> >No</option>
                                            </select>
                            </div>

                            -->
                        <div class="row form-group">
                            <?php  for($i=1; $i<=10; $i++) { $price = $carlocations['price'][$i]; $pickuplocationName =  $carlocations['pickup'][$i]->name; $dropofflocationName =  $carlocations['dropoff'][$i]->name; ?>
                            <label class="col-md-1 control-label text-left">PickUp</label>
                            <div class="col-md-3">
                                <input type="text" id="pickuplocationlist<?php echo $i; ?>">
                                <input type="hidden" name="locations[<?php echo $i; ?>][pickup]" id="pickuplocationid<?php echo $i;?>" required="" value="<?php echo @$carlocations['pickup'][$i]->id; ?>">
                            </div>
                            <label class="col-md-1 control-label text-left">DropOff</label>
                            <div class="col-md-3">
                                <input type="text" id="dropofflocationlist<?php echo $i; ?>">
                                <input type="hidden" name="locations[<?php echo $i; ?>][dropoff]" id="dropofflocationid<?php echo $i;?>" required="" value="<?php echo @$carlocations['dropoff'][$i]->id; ?>">
                            </div>
                            <label class="col-md-1 control-label text-left">Price</label>
                            <div class="col-md-3">
                                <strong><input type="text" name="locations[<?php echo $i; ?>][price]" class="form-control" value="<?php echo $price; ?>"></strong>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                            <script>
                                $(function(){
                                $("#pickuplocationlist<?php echo $i;?>").select2(
                                {
                                placeholder: "<?php if(empty($pickuplocationName)){ echo "Enter Location"; }else{ echo @$pickuplocationName; } ?>",
                                minimumInputLength: 3,
                                width:'100%', maximumSelectionSize: 1,
                                initSelection: function (element, callback) {
                                var data = {id: "1", text: "<?php echo @$pickuplocationName; ?>"};
                                callback(data);
                                },
                                ajax: {
                                url: "<?php echo base_url(); ?>admin/ajaxcalls/locationsList",
                                dataType: 'json',
                                data: function (term, page) {
                                return {
                                query: term, // search term
                                };
                                },
                                results: function (data, page) {
                                return {results: data};
                                }
                                }
                                }
                                );
                                $("#dropofflocationlist<?php echo $i;?>").select2(
                                {
                                placeholder: "<?php if(empty($dropofflocationName)){ echo "Enter Location"; }else{ echo @$dropofflocationName; } ?>",
                                minimumInputLength: 3,
                                width:'100%', maximumSelectionSize: 1,
                                initSelection: function (element, callback) {
                                var data = {id: "1", text: "<?php echo @$dropofflocationName; ?>"};
                                callback(data);
                                },
                                ajax: {
                                url: "<?php echo base_url(); ?>admin/ajaxcalls/locationsList",
                                dataType: 'json',
                                data: function (term, page) {
                                return {
                                query: term, // search term
                                };
                                },
                                results: function (data, page) {
                                return {results: data};
                                }
                                }
                                }
                                );
                                $("#pickuplocationlist<?php echo $i;?>").on("select2-selecting", function(e) {
                                $("#pickuplocationid<?php echo $i;?>").val(e.val);
                                });
                                $("#dropofflocationlist<?php echo $i;?>").on("select2-selecting", function(e) {
                                $("#dropofflocationid<?php echo $i;?>").val(e.val);
                                });
                                })
                            </script>
                            <?php } ?>
                        </div>
                        <!-- Address and Map -->
                        <!-- <div class="panel panel-default">
                            <div class="panel-heading"><strong>Map Address</strong></div>
                            <div class="well well-sm" style="margin-bottom: 0px;">
                            <div class="col-md-6 form-horizontal">
                            <table class="table">
                            <tr>
                            <td>Address on Map</td>
                            <td>
                            <input type="text" class="form-control Places" id="mapaddress" name="carmapaddress" value="<?php echo $cdata[0]->car_mapaddress;?>">
                            </td>
                            </tr>
                            <tr>
                            <td></td>
                            </tr>
                            <tr>
                            <td>Latitude</td>
                            <td><input type="text" class="form-control" id="latitude" value="<?php echo $cdata[0]->car_latitude;?>"  name="latitude" /></td>
                            </tr>
                            <tr>
                            <td>Longitude</td>
                            <td><input type="text" class="form-control" id="longitude" value="<?php echo $cdata[0]->car_longitude;?>"  name="longitude" /></td>
                            </tr>
                            </table>

                            </div>
                            <div class="col-md-6">
                            <div class="thumbnail">
                            <div id="map-canvas" style="height: 200px; width:400"></div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            </div> -->
                        <!-- Address and Map -->
                    </div>
                    <div class="tab-pane wow fadeIn animated in" id="META_INFO">
                        <div class="row form-group">
                            <label class="col-md-2 control-label text-left">Meta Title</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Meta title" name="carmetatitle"  value="<?php echo $cdata[0]->car_meta_title;?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2 control-label text-left">Meta Keywords</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Meta keywords" name="carkeywords"  value="<?php echo $cdata[0]->car_meta_keywords;?>">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2 control-label text-left">Meta Description</label>
                            <div class="col-md-10">
                                <textarea class="form-control" placeholder="Meta description here..." name="carmetadesc" rows="5"><?php echo $cdata[0]->car_meta_desc;?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane wow fadeIn animated in" id="POLICY">
                        <div class="row form-group">
                            <label class="col-md-2 control-label text-left">Payment Options</label>
                            <div class="col-md-10">
                                <select multiple class="chosen-multi-select" name="carpayments[]">
                                    <?php if(!empty($carpayments)){ $tpayments = explode(",",$cdata[0]->car_payment_opt); foreach($carpayments as $tp){ ?>
                                    <option value="<?php echo $tp->sett_id;?>"  <?php if($submittype == "add"){ if( $tip->sett_selected == "Yes"){echo "selected";} }else{ if(in_array($tp->sett_id,$tpayments)){ echo "selected"; } } ?> ><?php echo $tp->sett_name;?></option>
                                    <?php  } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2 control-label text-left">Policy And Terms</label>
                            <div class="col-md-10">
                                <textarea class="form-control" placeholder="Privacy Policy..." name="carpolicy" rows="3"><?php echo $cdata[0]->car_policy;?> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane wow fadeIn animated in" id="TRANSLATE">
                        <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackCarTranslation($lang,$carid); ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val['name']; ?></div>
                            <div class="panel-body">
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Car Name</label>
                                    <div class="col-md-10">
                                        <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="car Name" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Car Description</label>
                                    <div class="col-md-10">
                                        <?php $this->ckeditor->editor("translated[$lang][desc]", @$trans[0]->trans_desc, $ckconfig,"translated[$lang][desc]"); ?>
                                        <!--    <textarea name='<?php echo "translated[$lang][desc]"; ?>' placeholder="Description..." class="form-control" id="" cols="30" rows="4"><?php echo @$trans[0]->trans_desc;?></textarea>   -->
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Meta Title</label>
                                    <div class="col-md-10">
                                        <input name='<?php echo "translated[$lang][metatitle]"; ?>' type="text" placeholder="Title" class="form-control" value="<?php echo @$trans[0]->metatitle;?>" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Meta Keywords</label>
                                    <div class="col-md-10">
                                        <textarea name='<?php echo "translated[$lang][keywords]"; ?>' placeholder="Keywords" class="form-control" id="" cols="30" rows="2"><?php echo @$trans[0]->metakeywords;?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Meta Description</label>
                                    <div class="col-md-10">
                                        <textarea name='<?php echo "translated[$lang][metadesc]"; ?>' placeholder="Description" class="form-control" id="" cols="30" rows="4"><?php echo @$trans[0]->metadesc;?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col-md-2 control-label text-left">Policy And Terms</label>
                                    <div class="col-md-10">
                                        <textarea name='<?php echo "translated[$lang][policy]"; ?>' placeholder="Policy..." class="form-control" id="" cols="15" rows="4"><?php echo @$trans[0]->trans_policy;?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <input type="hidden" id="slug" value="<?php echo @$cdata[0]->car_slug;?>" />
                <input type="hidden" name="submittype" value="<?php echo $submittype;?>" />
                <input type="hidden" name="carid" value="<?php echo @$carid;?>" />
                <button class="btn btn-primary btn btn-lg btn-block submitfrm" id="<?php echo $submittype; ?>"> Submit </button>
            </div>
        </div>
    </div>
    <div class="col-md-4 sticky">
        <div class="panel panel-default">
            <div class="panel-heading">Main Settings</div>
            <div class="panel-body">
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Status</label>
                    <div class="col-md-9">
                        <select  class="form-control" name="carstatus">
                            <option value="Yes" <?php if($cdata[0]->car_status == "Yes"){echo "selected";} ?> >Enabled</option>
                            <option value="No" <?php if($cdata[0]->car_status == "No"){echo "selected";} ?> >Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Car Type</label>
                    <div class="col-md-9">
                        <select  class="form-control chosen-select" name="cartype">
                            <option value="">Select</option>
                            <?php if(!empty($cartypes)){
                                foreach($cartypes as $tt){ ?>
                            <option value="<?php echo $tt->sett_id;?>" <?php if($cdata[0]->car_type ==  $tt->sett_id ){echo "selected";} ?> ><?php echo $tt->sett_name;?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <?php if($isadmin){ ?>
                    <label class="col-md-3 control-label text-left">Featured</label>
                    <div class="col-md-3">
                        <select  Placeholder="No" class="form-control" Placeholder="No" name="isfeatured" id="isfeatured" onchange="changecollapse(this.options[this.selectedIndex].value,'Featured')">
                            <option  value="no" <?php if($cdata[0]->car_is_featured == "no"){echo "selected";} ?> >No</option>
                            <option  value="yes" <?php if($cdata[0]->car_is_featured == "yes"){echo "selected";} ?> >Yes</option>
                        </select>
                    </div>
                    <div class="col-md-6" style="margin-left:-15px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <input class="form-control dpd1" type="text" placeholder="From" value="<?php if(empty($cdata[0]->car_featured_forever)){ echo pt_show_date_php($cdata[0]->car_featured_from);}?>" name="ffrom" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <input class="form-control dpd2" type="text" placeholder="To" value="<?php if(empty($cdata[0]->car_featured_forever)){ echo pt_show_date_php($cdata[0]->car_featured_to);}?>" name="fto" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <input type="hidden" name="isfeatured" value="<?php echo @$cdata[0]->car_is_featured; ?>">
                    <input type="hidden" name="ffrom" value="<?php if(empty($cdata[0]->car_featured_forever)){ echo pt_show_date_php($cdata[0]->car_featured_from);}?>">
                    <input type="hidden" name="fto" value="<?php if(empty($cdata[0]->car_featured_forever)){ echo pt_show_date_php($cdata[0]->car_featured_to);}?>>">
                    <?php } ?>
                </div>
                <!-- <div class="row form-group">
                    <label class="col-md-2 control-label text-left">Price</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="Car Price" name="carbasic" value="<?php echo @$cdata[0]->car_basic_price; ?>">
                    </div>


                    </div> -->
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left text-success">Deposit</label>
                    <div class="col-md-5">
                        <?php  if($isadmin){ ?>
                        <select name="deposittype" class="form-control">
                            <option value="fixed" <?php if($cardeposittype == "fixed"){ echo "selected";} ?> >Fixed</option>
                            <option value="percentage" <?php if($cardeposittype == "percentage"){ echo "selected";} ?> >Percentage</option>
                        </select>
                        <?php }else{ ?><input type="text" class="form-control" name="deposittype" value="<?php echo $cardeposittype; ?>" readonly="readonly"><?php } ?>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="" placeholder="" name="depositvalue" value="<?php echo $cardepositval; ?>" <?php if(!$isadmin){ echo "readonly"; } ?>  >
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left text-danger">Vat Tax</label>
                    <div class="col-md-5">
                        <select name="taxtype" class="form-control">
                            <option value="fixed" <?php if($cartaxtype == "fixed"){ echo "selected";} ?> >Fixed</option>
                            <option value="percentage" <?php if($cartaxtype == "percentage"){ echo "selected";} ?> >Percentage</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" id="" Placeholder="" type="text" name="taxvalue" value="<?php echo $cartaxval; ?>"  />
                    </div>
                </div>
                <div class="row form-group">
                    <?php if($isadmin){ ?>
                    <label class="col-md-3 control-label text-left">Stars</label>
                    <div class="col-md-9">
                        <select  class="form-control" name="carstars">
                            <option value="0">Select</option>
                            <?php
                                for($stars=0;$stars <=5;$stars++){?>
                            <option value="<?php echo $stars;?>" <?php if($stars == $cdata[0]->car_stars ){echo "selected";} ?> ><?php echo $stars;?></option>
                            <?php   } ?>
                        </select>
                    </div>
                    <?php }else{ ?>
                    <input type="hidden" name="carstars" value="<?php echo $cdata[0]->car_stars; ?>">
                    <?php } ?>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Passengers</label>
                    <div class="col-md-9">
                        <select  class="form-control input-sm" name="passangers">
                            <option value="4" <?php makeSelected("4",@$cdata[0]->car_passengers); ?> >4</option>
                            <option value="5" <?php makeSelected("5",@$cdata[0]->car_passengers); ?> >5</option>
                            <option value="6" <?php makeSelected("6",@$cdata[0]->car_passengers); ?> >6</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Car Doors</label>
                    <div class="col-md-9">
                        <select  class="form-control input-sm" name="doors">
                            <option value="2" <?php makeSelected("4",@$cdata[0]->car_doors); ?> >2</option>
                            <option value="3" <?php makeSelected("5",@$cdata[0]->car_doors); ?> >3</option>
                            <option value="4" <?php makeSelected("6",@$cdata[0]->car_doors); ?> >4</option>
                            <option value="5" <?php makeSelected("6",@$cdata[0]->car_doors); ?> >5</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Transmission</label>
                    <div class="col-md-9">
                        <select  class="form-control" name="transmission">
                            <option value="Auto" <?php makeSelected("Auto",@$cdata[0]->car_transmission); ?> >Auto</option>
                            <option value="Manual" <?php makeSelected("Manual",@$cdata[0]->car_transmission); ?> >Manual</option>
                            <option value="Other" <?php makeSelected("Other",@$cdata[0]->car_transmission); ?> >other</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Baggage</label>
                    <div class="col-md-9">
                        <select  class="form-control" name="baggage">
                            <option value="x1" <?php makeSelected("x1",@$cdata[0]->car_baggage); ?> >x1</option>
                            <option value="x2" <?php makeSelected("x2",@$cdata[0]->car_baggage); ?> >x2</option>
                            <option value="x3" <?php makeSelected("x3",@$cdata[0]->car_baggage); ?> >x3</option>
                            <option value="x4" <?php makeSelected("x4",@$cdata[0]->car_baggage); ?> >x4</option>
                            <option value="x5" <?php makeSelected("x5",@$cdata[0]->car_baggage); ?> >x5</option>
                            <option value="x6" <?php makeSelected("x6",@$cdata[0]->car_baggage); ?> >x6</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 control-label text-left">Airport pickup</label>
                    <div class="col-md-9">
                        <select class="form-control" name="airportpickup">
                            <option value="yes" <?php makeSelected("yes",@$cdata[0]->car_airport_pickup); ?> >Yes</option>
                            <option value="no" <?php makeSelected("no",@$cdata[0]->car_airport_pickup); ?> >No</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group" style='<?php if($adminsegment == "supplier"){ echo "display:none;"; } ?>'>
                    <label class="col-md-3 control-label text-left">Related Cars</label>
                    <div class="col-md-9">
                        <select multiple class="chosen-multi-select" name="relatedcars[]">
                            <?php if(!empty($all_cars)){ $carrelated = explode(",",$cdata[0]->car_related);
                                foreach($all_cars as $c):
                                ?>
                            <option value="<?php echo $c->car_id;?>" <?php if(in_array($c->car_id,$carrelated)){echo "selected";} ?>  ><?php echo $c->car_title;?></option>
                            <?php endforeach; } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
$(document).ready(function() {
if (window.location.hash != "") {
$('a[href="' + window.location.hash + '"]').click()
}
});
</script>