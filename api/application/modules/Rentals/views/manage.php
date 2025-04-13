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
url = "<?php echo base_url();?>admin/rentals/add" ;
}else{
url = "<?php echo base_url();?>admin/rentals/manage/"+slug;
}
$.post(url,$(".rental-form").serialize() , function(response){
if($.trim(response) != "done"){
$(".output").html(response);
}else{
window.location.href = "<?php echo base_url().$adminsegment."/rentals/"?>";
}
});
})
})
</script>
<h3 class="margin-top-0"><?php //echo $tdata[0]->rental_title;?></h3>
<?php print_r($tobj); ?>
<div class="output"></div>
<form class="form-horizontal rental-form row" method="POST" action="" enctype="multipart/form-data"  onsubmit="return false;" >
  <div class="col-md-8">
  <div class="panel panel-default">
    <ul class="nav nav-tabs nav-justified" role="tablist">
      <li class="active"><a href="#GENERAL" data-toggle="tab">General</a></li>
      <!--<li class=""><a href="#PACKAGES" data-toggle="tab">Packages</a></li>-->
      <li class=""><a href="#INCLUSIONS" data-toggle="tab">Inclusions</a></li>
      <li class=""><a href="#EXCLUSIONS" data-toggle="tab">Exclusions</a></li>
      <li class=""><a href="#META_INFO" data-toggle="tab">Meta Info</a></li>
      <li class=""><a href="#POLICY" data-toggle="tab">Policy</a></li>
      <li class=""><a href="#CONTACT" data-toggle="tab">Contact</a></li>
      <li class=""><a href="#TRANSLATE" data-toggle="tab">Translate</a></li>
    </ul>
    <div class="panel-body">
      <br>
      <div class="tab-content form-horizontal">
        <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
          <div class="clearfix"></div>
          <div class="row form-group">
            <label class="col-md-12 control-label text-left">rental Name</label>
            <div class="col-md-12">
              <input class="form-control" type="text" placeholder="rental Name" name="rentalname" value="<?php echo $tdata[0]->rental_title;?>" >
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-12 control-label text-left">rental Description</label>
            <div class="col-md-12">
              <?php $this->ckeditor->editor('rentaldesc', $tdata[0]->rental_desc, $ckconfig,'rentaldesc'); ?>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12">
              <table class="table table-striped table-bordered" cellspacing="1" bgcolor="#cccccc">
                <tbody>
                  <tr bgcolor="#efefef" style="text-align:center;font-weight:bold">
                    <td width="80"></td>
                    <td width="120">Adults</td>
                    <td width="90">Child</td>
                    <td width="100">Infant</td>
                  </tr>
                  <tr bgcolor="#ffffff" style="text-align:center">
                    <td>Quantity</td>
                    <td><input type="text" class="form-control input-sm adult" name="maxadult" <?php echo $adultStatus;?> id="" size="" value="<?php echo @$tdata[0]->rental_max_adults;?>"></td>
                    <td><input type="text" class="form-control input-sm child" name="maxchild" <?php echo $childStatus;?> id="" size="" value="<?php echo @$tdata[0]->rental_max_child;?>"></td>
                    <td><input type="text" class="form-control input-sm infant" name="maxinfant" <?php echo $infantStatus;?> id="" size="" value="<?php echo @$tdata[0]->rental_max_infant;?>"></td>
                  </tr>
                  <tr bgcolor="#ffffff" style="text-align:center">
                    <td>Price</td>
                    <td><input type="text" class="form-control input-sm adult" <?php echo $adultStatus;?> name="adultprice" id="" size="" value="<?php echo @$tdata[0]->rental_adult_price;?>"></td>
                    <td><input type="text" class="form-control input-sm child" <?php echo $childStatus;?> name="childprice" id="" size="" value="<?php echo @$tdata[0]->rental_child_price;?>"></td>
                    <td><input type="text" class="form-control input-sm infant" <?php echo $infantStatus;?> name="infantprice" id="" size="" value="<?php echo @$tdata[0]->rental_infant_price;?>"></td>
                  </tr>
                  <tr bgcolor="#ffffff" style="text-align:center">
                    <td>Enable</td>
                    <td>
                      <?php if(empty($adultStatus)){ ?>
                      <span class="btn btn-danger btn-xs disabledinput btn-block" id="adult"><span id="adultbtn" >Disable</span></span>
                      <?php }else{ ?>
                      <span class="btn btn-xs enabledinput btn-success btn-block" id="adult"><span id="adultbtn">Enable</span></span>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if(empty($childStatus)){ ?>
                      <span class="btn btn-xs disabledinput btn-danger btn-block" id="child"><span id="childbtn">Disable</span> </span>
                      <?php }else{ ?>
                      <span class="btn btn-success btn-xs enabledinput btn-block" id="child"><span id="childbtn" >Enable</span> </span>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if(empty($infantStatus)){ ?>
                      <span class="btn btn-xs disabledinput btn-danger btn-block" id="infant"><span id="infantbtn">Disable</span> </span>
                      <?php }else{ ?>
                      <span class="btn btn-success btn-xs enabledinput btn-block" id="infant"><span id="infantbtn" >Enable</span> </span>
                      <?php } ?>
                    </td>
                  </tr>
                </tbody>
              </table>
              <script type='text/javascript'>//<![CDATA[
                $(function () {
                    $("#infant").on("click",function(){
                        if($(this).hasClass("enabledinput")){
                          $(this).removeClass("enabledinput");
                        $(this).addClass("disabledinput");
                        $(this).addClass("btn-danger");
                        $(this).removeClass("btn-success");
                          $(".infant").prop("readonly",false);
                        $("#infantbtn").text("Disable");
                        $("#infantstatus").val("1");
                        }else{
                        $(this).removeClass("disabledinput");
                        $(this).addClass("enabledinput");
                        $(this).removeClass("btn-danger");
                        $(this).addClass("btn-success");
                          $(".infant").prop("readonly",true);
                        $("#infantbtn").text("Enable");
                        $("#infantstatus").val("0");
                        }
                    });

                     $("#child").on("click",function(){
                        if($(this).hasClass("enabledinput")){
                          $(this).removeClass("enabledinput");
                        $(this).addClass("disabledinput");
                        $(this).addClass("btn-danger");
                        $(this).removeClass("btn-success");
                          $(".child").prop("readonly",false);
                        $("#childbtn").text("Disable");
                        $("#childstatus").val("1");

                        }else{
                        $(this).removeClass("disabledinput");
                        $(this).addClass("enabledinput");
                        $(this).removeClass("btn-danger");
                        $(this).addClass("btn-success");
                          $(".child").prop("readonly",true);
                        $("#childbtn").text("Enable");
                        $("#childstatus").val("0");

                        }
                    })
                     $("#adult").on("click",function(){
                        if($(this).hasClass("enabledinput")){
                          $(this).removeClass("enabledinput");
                        $(this).addClass("disabledinput");
                        $(this).addClass("btn-danger");
                        $(this).removeClass("btn-success");
                          $(".adult").prop("readonly",false);
                        $("#adultbtn").text("Disable");
                        $("#adultstatus").val("1");
                        }else{
                        $(this).removeClass("disabledinput");
                        $(this).addClass("enabledinput");
                        $(this).removeClass("btn-danger");
                        $(this).addClass("btn-success");
                        $(".adult").prop("readonly",true);
                        $("#adultbtn").text("Enable");
                        $("#adultstatus").val("0");
                        }
                    })
                });
                //]]>

              </script>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">Locations</div>
            <div class="panel-body">
              <?php  for($i=1; $i<=1; $i++) { $locationName =  $rentallocations[$i]->name; $locID = $rentallocations[$i]->id; ?>
              <div class="col-md-12">
              <div class="row">
              <label class="col-md-2 control-label text-left">Location <?php echo $i; ?></label>
              <div class="col-md-10">
                <input type="text" id="locationlist<?php echo $i; ?>">
                <input type="hidden" name="locations[]" id="locationid<?php echo $i;?>" required="" value="<?php echo @$rentallocations[$i]->id; ?>">
                <button id="" data-index='<?php echo $i;?>' class="btn btn-danger btn-xs reset" style="position: absolute; height: 34px; margin-left: 4px;"><i class="fa fa-times"></i></button>
              </div>
              <div class="clearfix"></div>
              <br>
              </div>
              </div>

              <script>


                $(function(){

                $("#locationlist<?php echo $i;?>").select2(
                {
                placeholder:"<?php if(empty($locationName)){ echo "Enter Location"; }else{ echo @$locationName; } ?>",
                minimumInputLength: 3,
                width:'100%', maximumSelectionSize: 1,
                initSelection: function (element, callback) {
                var data = {id: "10", text: "kuch bhi"};
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

                $("#locationlist<?php echo $i;?>").on("select2-selecting", function(e) {
                $("#locationid<?php echo $i;?>").val(e.val);
                console.log(e.val);
                });
                })
              </script>
              <?php } ?>
            </div>
          </div>
          <div class="row form-group">
          </div>

          <!-- Address and Map -->
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Map Starting Address - Point</strong></div>
            <div class="well well-sm" style="margin-bottom: 0px;">
              <div class="col-md-12 form-horizontal">
                <table class="table">
                  <tr>
                    <td>Address on Map</td>
                    <td>
                      <input type="text" class="form-control Places" id="mapaddress" name="rentalmapaddress" value="<?php echo $tdata[0]->rental_mapaddress;?>">
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Latitude</td>
                    <td><input type="text" class="form-control" id="latitude" value="<?php echo $tdata[0]->rental_latitude;?>"  name="latitude" /></td>
                  </tr>
                  <tr>
                    <td>Longitude</td>
                    <td><input type="text" class="form-control" id="longitude" value="<?php echo $tdata[0]->rental_longitude;?>"  name="longitude" /></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-12">
                <div class="thumbnail">
                  <div id="map-canvas" style="height: 200px; width:400"></div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <!-- Address and Map -->
        </div>

        <div class="tab-pane wow fadeIn animated in" id="PACKAGES">
            <?php echo $content; ?>
        </div>

        <div class="tab-pane wow fadeIn animated in" id="INCLUSIONS">
          <div class="row form-group">
            <div class="col-md-12">
              <div class="col-md-4">
                <label class="pointer"><input class="all" type="checkbox" name="" value="" id="select_all" > Select All</label>
              </div>
              <div class="clearfix"></div>
              <hr>
              <div class="clearfix"></div>
              <?php   $inclusions = explode(",",$tdata[0]->rental_amenities);
                foreach($rentalinclusions as $ti){ ?>
              <div class="col-md-4">
                <label class="pointer"><input class="checkboxcls" <?php if($submittype == "add"){ if( $ti->sett_selected == "Yes"){echo "checked";} }else{ if(in_array($ti->sett_id,$inclusions)){ echo "checked"; } } ?> type="checkbox" name="rentalamenities[]" value="<?php echo $ti->sett_id;?>"  > <?php echo $ti->sett_name;?></label>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="EXCLUSIONS">
          <div class="row form-group">
            <div class="col-md-12">
              <div class="col-md-4">
                <label class="pointer"><input class="all" type="checkbox" name="" value="" id="select_all" > Select All</label>
              </div>
              <div class="clearfix"></div>
              <hr>
              <div class="clearfix"></div>
              <?php  $exclusions = explode(",",$tdata[0]->rental_exclusions);
                foreach($rentalexclusions as $te){ ?>
              <div class="col-md-4">
                <label class="pointer"><input class="checkboxcls" <?php if($submittype == "add"){ if( $te->sett_selected == "Yes"){echo "checked";} }else{ if(in_array($te->sett_id,$exclusions)){ echo "checked"; } } ?> type="checkbox" name="rentalexclusions[]" value="<?php echo $te->sett_id;?>"  > <?php echo $te->sett_name;?></label>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="META_INFO">
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Meta Title</label>
            <div class="col-md-9">
              <input class="form-control" type="text" placeholder="Meta title" name="rentalmetatitle"  value="<?php echo $tdata[0]->rental_meta_title;?>">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Meta Keywords</label>
            <div class="col-md-9">
              <input class="form-control" type="text" placeholder="Meta keywords" name="rentalkeywords"  value="<?php echo $tdata[0]->rental_meta_keywords;?>">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Meta Description</label>
            <div class="col-md-9">
              <textarea class="form-control" placeholder="Meta description here..." name="rentalmetadesc" rows="5"><?php echo $tdata[0]->rental_meta_desc;?></textarea>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="POLICY">
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Payment Options</label>
            <div class="col-md-9">
              <select multiple class="chosen-multi-select" name="rentalpayments[]">
                <?php if(!empty($rentalpayments)){ $tpayments = explode(",",$tdata[0]->rental_payment_opt); foreach($rentalpayments as $tp){ ?>
                <option value="<?php echo $tp->sett_id;?>"  <?php if($submittype == "add"){ if( $tip->sett_selected == "Yes"){echo "selected";} }else{ if(in_array($tp->sett_id,$tpayments)){ echo "selected"; } } ?> ><?php echo $tp->sett_name;?></option>
                <?php  } } ?>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Policy And Terms</label>
            <div class="col-md-9">
              <textarea class="form-control" placeholder="Privacy Policy..." name="rentalprivacy" rows="3"><?php echo $tdata[0]->rental_privacy;?> </textarea>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="CONTACT">
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">rental Operator's Email</label>
            <div class="col-md-9">
              <input class="form-control" type="email" placeholder="rental's Email" name="rentalemail"  value="<?php echo $tdata[0]->rental_email;?>" >
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Operator's Website</label>
            <div class="col-md-9">
              <input name="rentalwebsite" type="text" placeholder="Website" class="form-control " value="<?php echo @$tdata[0]->rental_website;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Operator's Phone</label>
            <div class="col-md-9">
              <input name="rentalphone" type="text" placeholder="Phone" class="form-control" value="<?php echo @$tdata[0]->rental_phone;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Operator's Full Address</label>
            <div class="col-md-9">
              <input name="rentalfulladdress" type="text" placeholder="Address" class="form-control" value="<?php echo @$tdata[0]->rental_fulladdress;?>" />
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="TRANSLATE">
          <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackrentalTranslation($lang,$rentalid); ?>
          <div class="panel panel-default">
            <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val['name']; ?></div>
            <div class="panel-body">
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">rental Name</label>
                <div class="col-md-10">
                  <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="rental Name" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                </div>
              </div>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">rental Description</label>
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
      <input type="hidden" id="slug" value="<?php echo @$tdata[0]->rental_slug;?>" />
      <input type="hidden" name="submittype" value="<?php echo $submittype;?>" />
      <input type="hidden" name="rentalid" value="<?php echo @$rentalid;?>" />
      <input type="hidden" name="adultstatus" id="adultstatus" value="<?php echo $adultInput;?>" />
      <input type="hidden" name="childstatus" id="childstatus" value="<?php echo $childInput;?>" />
      <input type="hidden" name="infantstatus" id="infantstatus" value="<?php echo $infantInput;?>" />
      <button class="btn btn-primary btn-lg btn-block submitfrm" id="<?php echo $submittype; ?>"> Submit </button>
    </div>
  </div>
  </div>
  <div class="col-md-4 sticky">
    <div class="panel panel-default">
     <div class="panel-heading">Main Settigs</div>
      <div class="panel-body">
       <div class="row form-group">
            <label class="col-md-3 control-label text-left">Status</label>
            <div class="col-md-9">
              <select  class="form-control" name="rentalstatus">
                <option value="Yes" <?php if($tdata[0]->rental_status == "Yes"){echo "selected";} ?> >Enabled</option>
                <option value="No" <?php if($tdata[0]->rental_status == "No"){echo "selected";} ?> >Disabled</option>
              </select>
            </div>
          </div>

          <div class="row form-group">
            <?php if($isadmin){ ?>
            <label class="col-md-3 control-label text-left">Stars</label>
            <div class="col-md-9">
              <select  class="form-control" name="rentalstars">
                <option value="0">Select</option>
                <?php
                  for($stars=0;$stars <=5;$stars++){?>
                <option value="<?php echo $stars;?>" <?php if($stars == $tdata[0]->rental_stars ){echo "selected";} ?> ><?php echo $stars;?></option>
                <?php   } ?>
              </select>
            </div>
            <?php }else{ ?>
            <input type="hidden" name="rentalstars" value="<?php echo @$tdata[0]->rental_stars;?>">
            <?php } ?>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">rental Hours</label>
            <div class="col-md-9">
              <input type="text"  class="form-control" name="rentalhours" value="<?php echo @$tdata[0]->rental_hours; ?>">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">rental Days</label>
            <div class="col-md-9">
              <input type="text"  class="form-control" name="rentaldays" value="<?php echo @$tdata[0]->rental_days; ?>">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">rental Nights</label>
            <div class="col-md-9">
              <input type="text"  class="form-control" name="rentalnights" value="<?php echo @$tdata[0]->rental_nights; ?>">
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">rental Type</label>
            <div class="col-md-9">
              <select  class="chosen-select" name="rentaltype">
                <option value="">Select</option>
                <?php if(!empty($rentaltypes)){
                  foreach($rentaltypes as $tt){ ?>
                <option value="<?php echo $tt->sett_id;?>" <?php if($tdata[0]->rental_type ==  $tt->sett_id ){echo "selected";} ?> ><?php echo $tt->sett_name;?></option>
                <?php  } } ?>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <?php if($isadmin){ ?>
            <label class="col-md-3 control-label text-left">Featured</label>
            <div class="col-md-3">
              <select  Placeholder="No" class="form-control" Placeholder="No" name="isfeatured" id="isfeatured" onchange="changecollapse(this.options[this.selectedIndex].value,'Featured')">
                <option  value="no" <?php if($tdata[0]->rental_is_featured == "no"){echo "selected";} ?> >No</option>
                <option  value="yes" <?php if($tdata[0]->rental_is_featured == "yes"){echo "selected";} ?> >Yes</option>
              </select>
            </div>
            <div class="col-md-6" style="margin-left:-15px">
            <div class="row">
            <div class="col-md-6">
            <div class="row">
              <input class="form-control dpd1" type="text" placeholder="From" value="<?php if(empty($tdata[0]->rental_featured_forever)){ echo pt_show_date_php($tdata[0]->rental_featured_from);}?>" name="ffrom" >
            </div>
            </div>
            <div class="col-md-6">
            <div class="row">
              <input class="form-control dpd2" type="text" placeholder="To" value="<?php if(empty($tdata[0]->rental_featured_forever)){ echo pt_show_date_php($tdata[0]->rental_featured_to);}?>" name="fto" >
            </div>
            </div>
            </div>
            </div>
            <?php  }else{ ?>
            <input type="hidden" name="isfeatured" value="<?php echo @$tdata[0]->rental_is_featured; ?>">
            <input type="hidden" name="ffrom" value="<?php if(empty($tdata[0]->rental_featured_forever)){ echo pt_show_date_php($tdata[0]->rental_featured_from);}?>">
            <input type="hidden" name="fto" value="<?php if(empty($tdata[0]->rental_featured_forever)){ echo pt_show_date_php($tdata[0]->rental_featured_to);}?>">
            <?php } ?>
          </div>
           <div class="row form-group">
            <label class="col-md-3 control-label text-left text-success">Deposit</label>
            <div class="col-md-5">
              <?php  if($isadmin){ ?>
              <select name="deposittype" class="form-control">
                <option value="fixed" <?php if($rentaldeposittype == "fixed"){ echo "selected";} ?> >Fixed</option>
                <option value="percentage" <?php if($rentaldeposittype == "percentage"){ echo "selected";} ?> selected>Percentage</option>
              </select>
              <?php }else{ ?><input type="text" class="form-control" name="deposittype" value="<?php echo $rentaldeposittype; ?>" readonly="readonly"><?php } ?>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" id="" placeholder="" name="depositvalue" value="<?php echo $rentaldepositval; ?>" <?php if(!$isadmin){ echo "readonly"; } ?>  >
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left text-danger">Vat Tax</label>
            <div class="col-md-5">
              <select name="taxtype" class="form-control">
                <option value="fixed" <?php if($rentaltaxtype == "fixed"){ echo "selected";} ?> >Fixed</option>
                <option value="percentage" <?php if($rentaltaxtype == "percentage"){ echo "selected";} ?> >Percentage</option>
              </select>
            </div>
            <div class="col-md-4">
              <input class="form-control" id="" Placeholder="" type="text" name="taxvalue" value="<?php echo $rentaltaxval; ?>"  />
            </div>
          </div>
          <div class="row form-group" style='<?php if($adminsegment == "supplier"){ echo "display:none;"; } ?>'>
            <label class="col-md-3 control-label text-left">Related rentals</label>
            <div class="col-md-9">
              <select multiple class="chosen-multi-select" name="relatedrentals[]">
                <?php if(!empty($all_rentals)){ $rentalrelated = explode(",",$tdata[0]->rental_related);
                  foreach($all_rentals as $t):
                  ?>
                <option value="<?php echo $t->rental_id;?>" <?php if(in_array($t->rental_id,$rentalrelated)){echo "selected";} ?>  ><?php echo $t->rental_title;?></option>
                <?php endforeach; } ?>
              </select>
            </div>
          </div>

     </div>
    </div>
  </div>
</form>
<!-- google places -->
<script>
    $(".reset").click(function (e) {
        var i = $(this).data('index');
        $("#locationlist"+i).val(null).trigger('change');
        $("#locationid"+i).val(null);
        $("#locationlist"+i).attr('placeholder', 'Enter Location');
        $("#locationlist"+i).val(null).trigger('change');
        $("#locationid"+i).val(null);

    });
  function initAutocomplete() {
    var markers = [];
    var ex_latitude = $('#latitude').val();
    var ex_longitude = $('#longitude').val();
      if (ex_latitude != '' && ex_longitude != ''){
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
      center: {lat: parseFloat(ex_latitude), lng: parseFloat(ex_longitude)},
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

         var marker = new google.maps.Marker(

            {
                map: map,
                draggable:true,
                icon: "<?php echo PT_DEFAULT_IMAGE . 'marker.png'; ?>",
                animation: google.maps.Animation.DROP,
                position: new google.maps.LatLng(ex_latitude, ex_longitude)
            });
        markers.push(marker);
        google.maps.event.addListener(marker, 'dragend', function()
        {
            var marker_positions = marker.getPosition();
            $('#latitude').val(marker_positions.lat());
            $('#longitude').val(marker_positions.lng());
        });
      }else{
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
      }

    // Create the search box and link it to the UI element.
    var input = document.getElementById('mapaddress');
    var searchBox = new google.maps.places.SearchBox(input);
   // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();
      if (places.length == 0) {
        return;
      }
  map.setZoom(16);
      // Clear out the old markers.
      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];

      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };

        var marker = new google.maps.Marker({
          map: map,
          icon: "<?php echo PT_DEFAULT_IMAGE . 'marker.png'; ?>",
          title: place.name,
          position: place.geometry.location,
          draggable: true,
          animation: google.maps.Animation.DROP,
        });
        // Create a marker for each place.
        markers.push(marker);

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      google.maps.event.addListener(marker, 'dragend', function()
        {
            var marker_positions = marker.getPosition();
            $('#latitude').val(marker_positions.lat());
            $('#longitude').val(marker_positions.lng());
        });
  $('#latitude').val(place.geometry.location.lat());
  $('#longitude').val(place.geometry.location.lng());
      });
      map.fitBounds(bounds);
      map.setZoom(16);
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $appSettings->mapApi; ?>&libraries=places&callback=initAutocomplete"
  async defer></script>
<!-- Google Places -->
<script>
  $(document).ready(function() {
      if (window.location.hash != "") {
          $('a[href="' + window.location.hash + '"]').click()
      }
  });
</script>