
<div class="ftab-inner menu-horizontal-content">
<div class="form-search-main-01">
<form name="fHotelbedsSearch" autocomplete="off" action="<?=base_url('hotelb/search')?>" method="GET" role="search">
    <div class="form-inner">
        <div class="row gap-10 mb-15 align-items-end">
            <div class="col-md-3 col-xs-12 o4">
                <div class="form-group">
                    <label class="fr"><?=lang('0120')?></label>
                    <div class="clear"></div>
                    <div class="form-icon-left">
                    <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                    <input type="text" id="location" name="destination" value="<?=$_SESSION['hb_s2_id']?>" class="form-control hotelsearch locationlist<?=$module?>" autocomplete="off" placeholder="<?php echo trans('026'); ?>">
                 </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 o3">
                <div class="col-inner">
                    <div id="airDatepickerRange-hotel" class="row gap-10 mb-15">
                        <div class="col-6 o2">
                            <div class="form-group">
                                <label class="fr"><?php echo trans('07'); ?></label>
                                <div class="clear"></div>
                                <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                      <input type="text" placeholder="<?php echo trans('07'); ?>"  value="<?=$_SESSION['hb_checkin']?>"  name="checkin" class="form form-control form-readonly-control hcheckin" required >
                                </div>
                            </div>
                        </div>
                        <div class="col-6 o1">
                            <div class="form-group">
                                <label class="fr"><?php echo trans('09'); ?></label>
                                <div class="clear"></div>
                                <div class="form-icon-left">
                                    <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                     <input type="text" placeholder="<?php echo trans('09'); ?>"  value="<?=$_SESSION['hb_checkout']?>" name="checkout" class="form form-control form-readonly-control hcheckout" required >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 o2">
                <div class="col-inner">
                    <div class="row gap-10 mb-15">
                        <div class="col-12">
                            <div class="col-inner">
                                <div class="form-people-thread">
                                    <div class="row gap-5 align-items-center">
                                        <div class="col o2">
                                            <div class="form-group form-spin-group">
                                                <label class="fr" for="room-amount"><?php echo trans('010');?> <small class=" text-muted font10 line-1">(12-75)</small></label>
                                                <div class="clear"></div>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input name="adults" id="" type="text" class="form-control touch-spin-03 form-readonly-control"  value="<?=$adults?>" placeholder="2" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col 01">
                                            <div class="form-group form-spin-group">
                                                <label class="fr" for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1">(2-12)</small></label>
                                                <div class="clear"></div>
                                                <div class="form-icon-left">
                                                    <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                                    <input type="text" name="child" id="" class="form-control touch-spin-03 form-readonly-control" value="<?=$childs?>" placeholder="0" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col 03">
                                            <div class="form-group form-spin-group">
                                                <label class="fr" for="room-amount"> <?php echo trans('011');?><?php echo trans('0524');?></label>
                                                <div class="clear"></div>
                                                <div class="form-icon-left">
                                                <select name="childAge[]" class="form-control input-sm">
                                                <option value="1" selected="selected">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 o1">
            <input type="hidden" name="module_type"/>
            <input type="hidden" name="slug"/>
            <input type="hidden" name="childages" id="childages" value="<?php echo $themeData->childages; ?>">
            <input type="hidden" name="search" value="search" >
            <button type="submit"  class="btn btn-primary btn-block pfb0 loader"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
            </div>
        </div>
    </div>
</form>
</div>
</div>




<script src="<?=base_url('assets/js/mustache.min.js')?>"></script>








































<form name="fHotelbedsSearch" autocomplete="off" action="<?=base_url('hotelb/search')?>" method="GET" role="search">

                                    <span class="input-group-btn">
                                    <button class="btn btn-secondary btn-sm" type="button" id="hadultMinusBtn"><i class="fa fa-minus"></i></button>
                                    </span>
                    
                                    <span class="input-group-btn">
                                    <button class="btn btn-secondary btn-sm" type="button" id="hadultPlusBtn"><i class="fa fa-plus"></i></button>
                                    </span>

                                    <button class="btn btn-secondary btn-sm" type="button" id="hchildMinusBtn"><i class="fa fa-minus"></i></button>
                                    </span>


                                    <span class="input-group-btn">
                                    <button class="btn btn-secondary btn-sm" type="button" id="hchildPlusBtn"><i class="fa fa-plus"></i></button>
                                    </span>
      
</form>

<script src="<?=base_url('assets/js/mustache.min.js')?>"></script>
<script>
    function incChildAgeBoxes(count) {
        var template = document.querySelector('#child-age-box-template');
        console.log(template);
        // this is the node of the object you wanted
        var documentFragment = template.content;

        // this is a cloned version of the object that you can use anywhere.
        var templateClone = documentFragment.cloneNode(true);
        templateClone = $(templateClone);
        templateClone.find('#child-count').text(count);

        $("#child-age-box-container").append(templateClone);
    }

    function decChildAgeBoxes(count) {
        $("#child-age-box-container #child-age-box").last().remove();
    }

    $(document).ready(function(){
        var nowTemp6 = new Date();
        var now6 = new Date(nowTemp6.getFullYear(),nowTemp6.getMonth(),nowTemp6.getDate(),0,0,0,0);
        var checkin6 = $(".hcheckin").datepicker({
            format:"dd/mm/yyyy",
            onRender:function(e){
                return e.valueOf()<now6.valueOf()?"disabled":"";
            }
        }).on("changeDate",function(e){
            var a = new Date(e.date);
            a.setDate(a.getDate() + 0);
            checkout6.setValue(a)
            checkin6.hide();
            $(".hcheckout")[0].focus()
        }).data("datepicker");
        var checkout6 = $(".hcheckout").datepicker({
            format:"dd/mm/yyyy",
            onRender:function(e){
                return e.valueOf()<checkin6.date.valueOf()?"disabled":"";
            }}).on("changeDate",function(ev){
            var cnDate = new Date(ev.date);
            checkout6.hide();
        }).data("datepicker");

        var hadultPlusBtn = document.getElementById('hadultPlusBtn');
        var hadultMinusBtn = document.getElementById('hadultMinusBtn');
        var hchildPlusBtn = document.getElementById('hchildPlusBtn');
        var hchildMinusBtn = document.getElementById('hchildMinusBtn');
        var hadultInput = document.getElementById('hadultInput');
        var hchildInput = document.getElementById('hchildInput');
        var htravellersInput = document.getElementById('htravellersInput'); // Input label field
        var select2_default_text = "<?=$_SESSION['hb_s2_text']?>" || "<?php echo trans('026');?>";

        var updateGuestsInput = function ($adult, $child) {
            var value = $adult+' Adult '+$child+' Child';
            htravellersInput.value = value;
        }
        hadultPlusBtn.onclick = function() {
            hadultInput.value = parseInt(hadultInput.value) + 1;
            updateGuestsInput(hadultInput.value, hchildInput.value);
        };
        hadultMinusBtn.onclick = function() {
            var value = parseInt(hadultInput.value) - 1;
            hadultInput.value = (value < 1) ? 0 : value;
            updateGuestsInput(hadultInput.value, hchildInput.value);
        };
        hchildPlusBtn.onclick = function() {
            hchildInput.value = parseInt(hchildInput.value) + 1;
            updateGuestsInput(hadultInput.value, hchildInput.value);
            incChildAgeBoxes(hchildInput.value);
        };
        hchildMinusBtn.onclick = function() {
            var value = parseInt(hchildInput.value) - 1;
            hchildInput.value = (value < 1) ? 0 : value;
            updateGuestsInput(hadultInput.value, hchildInput.value);
            decChildAgeBoxes(hchildInput.value);
        };

        $(".locationlist<?=$module?>").select2({
            minimumInputLength: 3,
            width: '100%',
            maximumSelectionSize: 1,
            initSelection: function(element,callback){
                callback({
                    id: "carlton-palace-hotel/dubai",
                    text: "Carlton Palace Hotel (Dubai)"
                });
            },
            ajax:{
                url: "<?php echo base_url('suggestions/hotelbedsHotels'); ?>",
                dataType: 'json',
                data: function(term, page) {
                    return { q:term }
                },
                results:function(data, page) {
                    var results = [];
                    data.forEach(function(d) {
                        var id = d.id;
                        var text = d.title;
                        if(d.country != undefined && d.country != "") {
                            id = d.id+"/"+d.city_slug;
                            text = d.title+" ("+d.city+")";
                        }
                        results.push({
                            id: id,
                            text: text,
                            data: d
                        });
                    });
                    return { results: results }
                }
            }
        });
        $("form[name=fHotelbedsSearch] .select2-choice .select2-chosen").text(select2_default_text);
        $(".locationlist<?=$module?>").on("select2-selecting",function(e){
            $("[name=hotel_s2_text]").val(e.object.text);
        });
        function create_slug(data) {
            var p_1 = data['destination'];   p_1 = (p_1) ? p_1 : "null";
            var p_2 = data['checkin'];       p_2 = (p_2) ? p_2 : "null";
            var p_3 = data['checkout'];      p_3 = (p_3) ? p_3 : "null";
            var p_4 = data['adults'];        p_4 = (p_4) ? p_4 : 0;
            var p_5 = data['child'];         p_5 = (p_5) ? p_5 : 0;
            var url = "";
            if(p_1 != "null") {
                url += "/"+p_1.replace(/-\/-|-{2,}/g, '-');
            }
            return url+"/"+p_2.replace(/\/+/g, '-')+"/"+p_3.replace(/\/+/g, '-')+"/"+p_4+"/"+p_5+"/"+data['childAges'];
        }
        $("form[name=fHotelbedsSearch]").on("submit", function(e) {
            e.preventDefault();
            var values = {};
            var childAges = '';
            $.each($(this).serializeArray(), function(i, field) {
                if (field.name == 'childAge[]') {
                    childAges += field.value + '-';
                } else {
                    values[field.name] = field.value;
                }
            });
            values['childAges'] = childAges.slice(0, -1);
            window.location.href = $(this).attr('action')+create_slug(values);
        });
    });
</script>