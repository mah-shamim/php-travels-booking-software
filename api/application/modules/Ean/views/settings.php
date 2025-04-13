<script>
  $(function () {
     slideout();
              $(".icon-picker").iconPicker();
          });

  (function($) {

      $.fn.iconPicker = function( options ) {

          var mouseOver=false;
          var $popup=null;
          var icons=new Array("adjust","align-center","align-justify","align-left","align-right","arrow-down","arrow-left","arrow-right","arrow-up","asterisk","backward","ban-circle","barcode","bell","bold","book","bookmark","briefcase","bullhorn","calendar","camera","certificate","check","chevron-down","chevron-left","chevron-right","chevron-up","circle-arrow-down","circle-arrow-left","circle-arrow-right","circle-arrow-up","cloud","cloud-download","cloud-upload","cog","collapse-down","collapse-up","comment","compressed","copyright-mark","credit-card","cutlery","dashboard","download","download-alt","earphone","edit","eject","envelope","euro","exclamation-sign","expand","export","eye-close","eye-open","facetime-video","fast-backward","fast-forward","file","film","filter","fire","flag","flash","floppy-disk","floppy-open","floppy-remove","floppy-save","floppy-saved","folder-close","folder-open","font","forward","fullscreen","gbp","gift","glass","globe","hand-down","hand-left","hand-right","hand-up","hd-video","hdd","header","headphones","heart","heart-empty","home","import","inbox","indent-left","indent-right","info-sign","italic","leaf","link","list","list-alt","lock","log-in","log-out","magnet","map-marker","minus","minus-sign","move","music","new-window","off","ok","ok-circle","ok-sign","open","paperclip","pause","pencil","phone","phone-alt","picture","plane","play","play-circle","plus","plus-sign","print","pushpin","qrcode","question-sign","random","record","refresh","registration-mark","remove","remove-circle","remove-sign","repeat","resize-full","resize-horizontal","resize-small","resize-vertical","retweet","road","save","saved","screenshot","sd-video","search","send","share","share-alt","shopping-cart","signal","sort","sort-by-alphabet","sort-by-alphabet-alt","sort-by-attributes","sort-by-attributes-alt","sort-by-order","sort-by-order-alt","sound-5-1","sound-6-1","sound-7-1","sound-dolby","sound-stereo","star","star-empty","stats","step-backward","step-forward","stop","subtitles","tag","tags","tasks","text-height","text-width","th","th-large","th-list","thumbs-down","thumbs-up","time","tint","tower","transfer","trash","tree-conifer","tree-deciduous","unchecked","upload","usd","user","volume-down","volume-off","volume-up","warning-sign","wrench","zoom-in","zoom-out");
          var settings = $.extend({

          }, options);
          return this.each( function() {
          	element=this;
              if(!settings.buttonOnly && $(this).data("iconPicker")==undefined ){
              	$this=$(this).addClass("form-control");
              	$wraper=$("<div>",{class:"input-group"});
              	$this.wrap($wraper);

              	$button=$("<span class=\"input-group-addon pointer\"><i class=\"glyphicon  glyphicon-picture\"></i></span>");
              	$this.after($button);
              	(function(ele){
  	            	$button.click(function(){
  			       		createUI(ele);
  			       		showList(ele,icons);
  	            	});
  	            })($this);

              	$(this).data("iconPicker",{attached:true});
              }

  	        function createUI($element){
  	        	$popup=$('<div/>',{
  	        		css: {
  		        		'top':$element.offset().top+$element.outerHeight()+6,
  		        		'left':$element.offset().left
  		        	},
  		        	class:'icon-popup'
  	        	})

  	        	$popup.html('<div class="ip-control"> \
  						          <ul> \
  						            <li><a href="javascript:;" class="btn" data-dir="-1"><span class="glyphicon  glyphicon-fast-backward"></span></a></li> \
  						            <li><input type="text" class="ip-search glyphicon  glyphicon-search" placeholder="Search" /></li> \
  						            <li><a href="javascript:;"  class="btn" data-dir="1"><span class="glyphicon  glyphicon-fast-forward"></span></a></li> \
  						          </ul> \
  						      </div> \
  						     <div class="icon-list"> </div> \
  					         ').appendTo("body");


  	        	$popup.addClass('dropdown-menu').show();
  				$popup.mouseenter(function() {  mouseOver=true;  }).mouseleave(function() { mouseOver=false;  });

  	        	var lastVal="", start_index=0,per_page=30,end_index=start_index+per_page;
  	        	$(".ip-control .btn",$popup).click(function(e){
  	                e.stopPropagation();
  	                var dir=$(this).attr("data-dir");
  	                start_index=start_index+per_page*dir;
  	                start_index=start_index<0?0:start_index;
  	                if(start_index+per_page<=210){
  	                  $.each($(".icon-list>ul li"),function(i){
  	                      if(i>=start_index && i<start_index+per_page){
  	                         $(this).show();
  	                      }else{
  	                        $(this).hide();
  	                      }
  	                  });
  	                }else{
  	                  start_index=180;
  	                }
  	            });

  	        	$('.ip-control .ip-search',$popup).on("keyup",function(e){
  	                if(lastVal!=$(this).val()){
  	                    lastVal=$(this).val();
  	                    if(lastVal==""){
  	                    	showList(icons);
  	                    }else{
  	                    	showList($element, $(icons)
  							        .map(function(i,v){
  								            if(v.toLowerCase().indexOf(lastVal.toLowerCase())!=-1){return v}
  								        }).get());
  						}

  	                }
  	            });
  	        	$(document).mouseup(function (e){
  				    if (!$popup.is(e.target) && $popup.has(e.target).length === 0) {
  				        removeInstance();
  				    }
  				});

  	        }
  	        function removeInstance(){
  	        	$(".icon-popup").remove();
  	        }
  	        function showList($element,arrLis){
  	        	$ul=$("<ul>");

  	        	for (var i in arrLis) {
  	        		$ul.append("<li><a href=\"#\" title="+arrLis[i]+"><span class=\"glyphicon  glyphicon-"+arrLis[i]+"\"></span></a></li>");
  	        	};

  	        	$(".icon-list",$popup).html($ul);
  	        	$(".icon-list li a",$popup).click(function(e){
  	        		e.preventDefault();
  	        		var title=$(this).attr("title");
  	        		$element.val("glyphicon glyphicon-"+title);
  	        		removeInstance();
  	        	});
  	        }

          });
      }

  }(jQuery));


</script>
<?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
<h3 class="margin-top-0">Expedia Settings</h3>
<form action="" method="POST">
  <div class="panel panel-default">
    <div class="panel-body">
      <br>
      <div class="tab-content form-horizontal">
        <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
          <div class="clearfix"></div>
          <!--<div class="row form-group">
            <label  class="col-md-2 control-label text-left">Icon Class</label>
            <div class="col-md-4">
              <input type="text" class="form-control" name="page_icon" placeholder="Write icon class" value="<?php echo $settings[0]->front_icon;?>" >
            </div>
          </div>-->
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Target</label>
            <div class="col-md-4">
              <select  class="form-control" name="target">
                <option  value="_self" <?php if($settings[0]->linktarget == "_self"){ echo "selected";} ?>   >Self</option>
                <option  value="_blank"  <?php if($settings[0]->linktarget == "_blank"){ echo "selected";} ?>  >Blank</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Header Title</label>
            <div class="col-md-4">
              <input type="text" name="headertitle" class="form-control" placeholder="title" value="<?php echo $settings[0]->header_title;?>" />
            </div>
          </div>
          <hr>
         <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Default Language</label>
            <div class="col-md-4">
              <select  class="form-control" name="language">
              <?php foreach($languages as $langKey => $langName){ ?>
              <option value="<?php echo $langKey; ?>" <?php makeSelected($langKey, $settings[0]->language); ?> ><?php echo $langName; ?></option>
              <?php } ?>
                
              </select>
            </div>
          </div>

          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Currency</label>
            <div class="col-md-4">
              <input type="text" name="currency" class="form-control" value="<?php echo $settings[0]->currency;?>" >
            </div>
          </div>

          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">API Key</label>
            <div class="col-md-4">
              <input type="text" name="apikey" class="form-control" placeholder="API Key" value="<?php echo $settings[0]->apikey;?>" >
            </div>
          </div>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">CID</label>
            <div class="col-md-4">
              <input type="text" name="cid" class="form-control" placeholder="CID" value="<?php echo $settings[0]->cid;?>" >
            </div>
          </div>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Secret Key</label>
            <div class="col-md-4">
              <input type="text" name="secret" class="form-control" placeholder="Secret" value="<?php echo $settings[0]->secret;?>" >
            </div>
          </div>

          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Minor Revision</label>
            <div class="col-md-4">
              <input type="text" name="revision" class="form-control" placeholder="Secret" value="<?php if($settings[0]->front_tax_fixed < 30){ echo '30'; }else{ echo $settings[0]->front_tax_fixed; } ?>" >
            </div>
          </div>

         <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Testing Mode</label>
            <div class="col-md-4">
              <select  class="form-control" name="mode">
                <option  value="1" <?php if($settings[0]->testing_mode == "1"){ echo "selected";} ?> > On </option>
                <option  value="0" <?php if($settings[0]->testing_mode == "0"){ echo "selected";} ?> > Off </option>
              </select>
            </div>
          </div>


          <hr>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Featured Hotels</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="home"  value="<?php echo $settings[0]->front_homepage;?>">
            </div>
            <label  class="col-md-2 control-label text-left">Homepage Featured List</label>
            <div class="col-md-2">
              <select class="form-control" name="ean_hotel_status">
                  <option>Select Status</option>
                  <option value="enable" <?=($featured_items_setting->ean_hotel_status == 'enable')?'selected':''?>>Enable</option>
                  <option value="disable" <?=($featured_items_setting->ean_hotel_status == 'disable')?'selected':''?>>Disable</option>
              </select>
            </div>
            <label  class="col-md-2 control-label text-left">City Name</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="fcity"  value="<?php echo $featuredCity;?>">
            </div>
          </div>
          <div class="clearfix"></div>
          <!--<div class="row form-group">
            <label  class="col-md-2 control-label text-left">Popular Hotels</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="popular"  value="<?php echo $settings[0]->front_popular;?>">
            </div>
            <label  class="col-md-2 control-label text-left">City Name</label>
            <div class="col-md-3">
              <input class="form-control" type="text" placeholder="" name="pcity"  value="<?php echo $popularCity;?>">
            </div>
          </div>-->
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Listing Hotels</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="listings"  value="<?php echo $settings[0]->front_listings; ?>">
            </div>
            <label  class="col-md-2 control-label text-left">City Name</label>
            <div class="col-md-3">
              <input type="text" value="<?php echo $settings[0]->front_search_city;?>" class="form-control" name="defcity" />
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Search Result Hotels</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="" name="frontsearch"  value="<?php echo $settings[0]->front_search;?>">
            </div>
          </div>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Related Hotels</label>
            <div class="col-md-2">
              <input class="form-control" type="text" placeholder="Related Hotels" name="related_hotels"  value="<?php echo $settings[0]->front_related;?>">
            </div>
          </div>
  <!--         <div class="row form-group">
    <label  class="col-md-2 control-label text-left">Related Hotels</label>
    <div class="col-md-2">
      <input class="form-control" type="text" placeholder="" name="listings"  value="<?php echo $settings[0]->front_listings;?>">
    </div>
  </div> -->
        </div>
        <div class="clearfix"></div>
        <hr>
          <h4 class="text-danger">SEO</h4>
          <div class="row form-group">
            <label  class="col-md-2 control-label text-left">Meta Keywords</label>
            <div class="col-md-4">
              <input class="form-control" type="text" placeholder="" name="keywords" value="<?php echo $settings[0]->meta_keywords;?>">
            </div>
            <label  class="col-md-2 control-label text-left">Meta Description</label>
            <div class="col-md-4">
              <input class="form-control" type="text" placeholder="" name="description"  value="<?php echo $settings[0]->meta_description;?>">
            </div>
          </div>
        <div class="clearfix"></div>
        <hr>
        <h4 class="text-danger">Search Settings</h4>
        <div class="row form-group">
          <label  class="col-md-2 control-label text-left">Minimum Price</label>
          <div class="col-md-2">
            <input class="form-control" type="text" placeholder="" name="minprice"  value="<?php echo $settings[0]->front_search_min_price;?>">
          </div>
          <label  class="col-md-2 control-label text-left">Maximum Price</label>
          <div class="col-md-2">
            <input class="form-control" type="text" placeholder="" name="maxprice"  value="<?php echo $settings[0]->front_search_max_price;?>">
          </div>
        </div>
        <hr>
      </div>
    </div>
  <div class="panel-footer">
    <input type="hidden" name="updatesettings" value="1" />
    <input type="hidden" name="updatefor" value="ean" />
    <button class="btn btn-primary">Submit</button>
  </div>
  </div>
</form>
<script>
  $(document).ready(function(){
  if(window.location.hash != "") {
  $('a[href="' + window.location.hash + '"]').click() } });
</script>