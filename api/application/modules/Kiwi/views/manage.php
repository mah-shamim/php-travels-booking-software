<!--This is javascript write for ajex call to add data in the database-->
<script type="text/javascript">
    $(function(){var slug=$("#slug").val();$(".submitfrm").submit(function(){var submitType="<?php echo $submittype; ?>";for(instance in CKEDITOR.instances)
    {CKEDITOR.instances[instance].updateElement()}
    $(".output").html("");$('html, body').animate({scrollTop:$('body').offset().top},'slow');if(submitType=="add"){url="<?php echo base_url();?>admin/routes/add_post"}else{url="<?php echo base_url();?>admin/routes/manage_post/"}
    $.post(url,$(".tour-form").serialize(),
            function(response){if($.trim(response)!="done"){
                    $(".output").html(response)
                    window.location.href = "<?php echo  base_url();?>"+"admin/flights/routes";
            }})})})
</script>
<style>
    .hide { width: 0px; height: 0px; position: absolute; margin-top: -30px; }
    thead { background: #eee; text-transform: uppercase; letter-spacing: 1px; }
    thead th { padding: 14px 10px !important; border: 1px solid #c0c0c0; }
</style>
<!-- End Location Css Here-->
<h3 class="margin-top-0"></h3>
<?php print_r($tobj); ?>
<div class="output"></div>
<!--Form is start from here which we will submit to RouteFlights manage function and add function-->
<form class="form-horizontal tour-form submitfrm" method="POST" action="" enctype="multipart/form-data"  onsubmit="return false;" >
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Flights Management</div>
            <div class="panel-body">
                <div class="tab-content form-horizontal">
                    <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
                        <div class="clearfix"></div>
                        <?php
                            if($checkType == "add")
                            {
                                    $mainSize = 1;
                                    $type = "";
                            }else{
                                    $mainSize = count($mainArray);
                                    $type = "return";

                            }
                            for($index = 0;$index<$mainSize;$index++)
                            {
                                    if($index == 0)
                                    {
                                            $type = "";
                                    }else{
                                            $type = "return";
                                    }
                                    ?>
                        <div class="panel panel-default remove_<?=$type ?>" id="return_div">
                            <div class="panel-heading header_txt" ><?php if($index == 0)echo "One Way"; else echo "Return"; ?></div>
                            <div class="panel-body">
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
                                                    <td>Price</td>
                                                    <td><input type="text" required  class="form-control input-sm adult"  name="adultprice[]" id="" size="" value="<?=$mainArray[$index]->price->adultprice?>"></td>
                                                    <td><input type="text" class="form-control input-sm child"  name="childprice[]" id="" size="" value="<?=$mainArray[$index]->price->childprice?>"></td>
                                                    <td><input type="text" class="form-control input-sm infant"  name="infantprice[]" id="" size="" value="<?=$‌mianArray[$index]->price->infantprice?>"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <table class="table table-striped" id="t1">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>City - Airport</th>
                                            <th>Airline</th>
                                            <th>Flight No.</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Checkout</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($checkType == "add")
                                            {
                                                    $size = 2;
                                            }else{
                                                    $size = count($mainArray[$index]->locations);
                                            }
                                            for($i=0;$i<$size;$i++)
                                            {?>
                                        <tr id="template" class="template_class">
                                            <th><input type=""  class="form-control title_template" placeholder="Flight" style="width:100px" value="<?php if($i==0) { echo "Departure";} elseif($i==$size-1){echo "Arrival";}else{ echo "Transit";} ?>" disabled="disabled"/></th>
                                            <th>
                                                <input name=""  id='locationlist_<?=$type.$i?>' class="location_class<?=$type.$i?>">
                                                <input name="locations_<?=$type?>[]" required  id="locationsid_<?=$type.$i?>" value='<?php echo json_encode($mainArray[$index]->locations[$i]); ?>' class="locations<?=$type.$i?>" style="opacity:0.1;    width: 0px;height: 0px;position: absolute;margin-top: -30px;" >
                                                </input>
                                            </th>
                                            <th>
                                                <input name="" id='aeroplanes_<?=$type.$i?>' class="aeroplane_class<?=$type.$i?>" value="" style="width:250px">
                                                <input name="aeroplanes_<?=$type?>[]" required  id="aeroplanes_id<?=$type.$i?>" class="aeroplane_id_class<?=$type.$i?>"  style="opacity:0.1;    width: 0px;height: 0px;position: absolute;margin-top: -30px;" >
                                                </input>
                                            </th>
                                            <th><input type="" class="form-control flights_class"  name="flightnos_<?=$type?>[]" placeholder="Flight No" value="<?php echo $mainArray[$index]->flight_no[$i]; ?>" style="width:100px"/></th>
                                            <th>
                                                <input class="form-control dpd3 date_class<?=$i?>" type="text"  placeholder="Optional Date" value="<?php if($mainArray[$index]->dates[$i] == "00/00/0000")echo "";else echo $mainArray[$index]->dates[$i];?>" name="date_<?=$type?>[]" >
                                            </th>
                                            <th><input name="times_<?=$type?>[]" type="text" required placeholder="Check In" class="form-control timepicker time_click0  clockface-open"  data-format="hh:mm A" value="<?php echo $mainArray[$index]->times[$i];?>" /> </th>
                                            <th><input name="times_<?=$type?>[]" type="text" required placeholder="Check Out" class="form-control timepicker time_click1  clockface-open"  data-format="hh:mm A" value="<?php echo $mainArray[$index]->times[$i];?>" /> </th>
                                            <th id="btnTh_<?=$type.$i?>" class="cross_remove_<?=$type.$i?>"></th>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <button class="btn btn-success addtrans" type="button" id="addtrans" onclick="add2('remove_<?=$type ?>','<?=$type ?>')">Add Transit</button>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">Description and Baggage info</div>
                            <div class="panel-body">
                                <textarea name="desc" id="editor1" rows="10" cols="80">
                                <?php echo $desc_flight; ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <input type="hidden" name="routeId" id="" value="<?php echo $routeId;?>" />
                <button type="submit" class="btn btn-primary btn-block btn-lg" id="<?php echo $submittype; ?>"> Submit </button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Main Settings</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label text-left">Status</label>
                    <div class="col-md-9">
                        <select  class="form-control" name="flightstatus">
                            <option value="Enable" <?php if($flightstatus == "Enable"){echo "selected";} ?> >Enabled</option>
                            <option value="Disable" <?php if($flightstatus == "Disable"){echo "selected";} ?> >Disabled</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label text-left">Total Hours</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                            <input type="text" required  class="form-control" name="total_hours" value="<?php if(!empty($total_hours)){ echo $total_hours;}?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label text-left">Vat Tax</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon">%</span>
                            <input type="text"  class="form-control" name="tax" value="<?php if(!empty($tax)){ echo $tax;}?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label text-left">Deposite</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon">%</span>
                            <input type="text"  class="form-control" name="deposite" value="<?php if(!empty($deposite)){ echo $deposite;}?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label text-left">Flight Type</label>
                    <div class="col-md-9">
                        <select  class="chosen-select" name="flighttype">
                        <?php
                            if($flight_type == "economy")
                            {
                                    echo "<option value=\"economy\" selected>Economy</option>
                            <option value=\"business\">Business</option>";


                            }else{
                                    echo "<option value=\"economy\" >Economy</option>
                            <option value=\"business\" selected>Business</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label text-left">Refundable</label>
                    <div class="col-md-9">
                        <select  class="chosen-select" name="refundable">
                        <?php
                            if($refundable == "Refundable")
                            {
                                    echo "<option value=\"Refundable\" selected>Refundable</option>
                            <option value=\"Non Refundable\">Non Refundable</option>";
                            }else{
                                    echo "<option value=\"Refundable\" >Refundable</option>
                            <option value=\"Non Refundable\" selected>Non Refundable</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label text-left">Direction</label>
                    <div class="col-md-9">
                        <select  class="chosen-select" id="flight_type"  name="flightmode">
                        <?php
                            if($flightmode == "oneway")
                            {
                                    echo "<option selected value=\"oneway\">One Way</option>
                            <option value=\"return\">Return</option>";
                            }else{
                                    echo "<option value=\"oneway\">One Way</option>
                            <option selected value=\"return\">Return</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!--Form is Ending here-->
<script>
    $(document).ready(function() {
            if (window.location.hash != "") {
                    $('a[href="' + window.location.hash + '"]').click()
            }
            return_function();
            $('#flight_type').change(function(){
                    if($("#flight_type").val() == "oneway") {
                            $('.remove_return').remove();

                    }else{
                            var return_div = $('#return_div');
                            var clone_div = return_div.clone();
                            clone_div.attr('class' , 'panel panel-default remove_return');
                            return_div.after(clone_div);
                            $(".remove_return").find(".template_class").find(".location_class0").attr("id", "locationlist_return0");
                            $(".remove_return").find(".template_class").find(".location_class1").attr("id", "locationlist_return1");
                            $(".remove_return").find(".template_class").find(".locations0").attr("id", "locationsid_return0");
                            $(".remove_return").find(".template_class").find(".locations1").attr("id", "locationsid_return1");
                            $(".remove_return").find(".template_class").find(".date_class0").attr("id", "dpd2");
                            $(".remove_return").find(".template_class").find(".date_class1").attr("id", "dpd3");
                            $(".remove_return").find(".template_class").find(".cross_remove_0").attr("class", "cross_remove_return0");
                            $(".remove_return").find(".template_class").find(".locations0").attr("name", "locations_return[]");
                            $(".remove_return").find(".template_class").find(".locations1").attr("name", "locations_return[]");
                            $(".remove_return").find(".template_class").find(".date_class0").attr("name", "date_return[]");
                            $(".remove_return").find(".template_class").find(".date_class1").attr("name", "date_return[]");
                            $(".remove_return").find(".template_class").find(".time_click0").attr("name", "times_return[]");
                            $(".remove_return").find(".template_class").find(".aeroplane_class0").attr("id", "aeroplanes_return0");
                            $(".remove_return").find(".template_class").find(".aeroplane_class1").attr("id", "aeroplanes_return1");
                            $(".remove_return").find(".template_class").find(".aeroplane_id_class0").attr("name", "aeroplanes_return[]");
                            $(".remove_return").find(".template_class").find(".flights_class").attr("name", "flightno_return[]");
                            $(".remove_return").find(".template_class").find(".aeroplane_id_class1").attr("name", "aeroplanes_return[]");
                            $(".remove_return").find(".template_class").find(".aeroplane_id_class0").attr("id", "aeroplanes_idreturn0");
                            $(".remove_return").find(".template_class").find(".aeroplane_id_class1").attr("id", "aeroplanes_idreturn1");

                            $('[name="times_return[]"]').clockface();
                            $("#aeroplanes_return1").addClass("aeroplane_classreturn1")
                            $("#aeroplanes_return1").removeClass("aeroplane_class1")

                            var nowTemp = new Date();
                            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

                            var date2 = $('#dpd2').datepicker({
                                    format: fmt,
                                    onRender: function(date) {
                                            return date.valueOf() < now.valueOf() ? 'disabled' : '';
                                    }
                            })
                                    .on('changeDate', function(ev) {
                                            date2.hide();
                                    })
                                    .data('datepicker');
                        var date3 = $('#dpd3').datepicker({
                                                            format: fmt,
                                                            onRender: function(date) {
                                                                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                                                            }
                                                    })
                                                            .on('changeDate', function(ev) {
                                                                    date2.hide();
                                                            })
                                                            .data('datepicker');


                            $('.header_txt')[1].innerHTML = "Return";
                            $(".addtrans")[1].outerHTML = "<button class='btn btn-success addtrans' type='button' id='addtrans' onclick='add2(\"remove_return\",\"return\")'>Add Transit</button>"
                            clone_function()
                    }
            });

            CKEDITOR.replace( 'editor1' );


            function return_function(type) {

                    <?php
        if($checkType != "add")
        {
                $mainSize = count($mainArray);
        }
        for($index = 0;$index<$mainSize;$index++)
        {
        if($index == 0)
        {
                ?> type = "" <?php
        }else{ ?>
                                type = "return" <?php
        }

        if($checkType == "add")
        {
                $size = 2;
        }else{
                $size = count($mainArray[$index]->locations);
        }
        ?>

                    <?php for($i = 0;$i<$size;$i++) {
        if(($i != 0) && ($i != $size-1)) {
                ?>
                    $("#btnTh_"+type+"<?=$i?>").html('<button class="btn btn-danger" id="btnCross'+type+'<?=$i?>"><i class="fa fa-times"></i></button>');
                    $("#btnCross"+type+"<?=$i?>").on("click", function() {
                            $(this).parent().parent().remove();
                    });
                    <?php }?>

                    $("#locationlist_"+type+"<?=$i?>").select2(
                            {
                                    placeholder: "<?php if(empty($mainArray[$index]->locations[$i]->label)){ echo "Enter City Or Airport"; }else{ echo $mainArray[$index]->locations[$i]->label; } ?>",
                                    minimumInputLength: 3,
                                    width:'100%', maximumSelectionSize: 1,
                                    initSelection: function (element, callback) {
                                            var data = {id: "1", text: "<?php echo @$locationName; ?>"
                                            };
                                            callback(data);
                                    },
                                    ajax: {
                                            url: "<?php echo base_url(); ?>admin/ajaxcalls/flightAjex",
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
                    $('#locationlist_'+type+'<?=$i?>').on("select2-selecting", function(e) {
                            $("#locationsid_"+type+"<?=$i?>").val(e.val);
                            console.log("#locationsid_"+type+"<?=$i?>")
                            console.log(e.val);
                    });
                    $("#aeroplanes_id"+type+"<?=$i?>").val("<?php if(empty($mainArray[$index]->aeroplanes[$i])){ echo ""; }else{ echo $mainArray[$index]->aeroplanes[$i]; } ?>");

                    $('#aeroplanes_'+type+'<?=$i?>').select2(
                            {
                                    placeholder: "<?php if(empty($mainArray[$index]->aeroplanes[$i])){ echo "Enter Arline Name"; }else{ echo $mainArray[$index]->aeroplanes[$i]; } ?>",
                                    minimumInputLength: 3,
                                    width:'100%', maximumSelectionSize: 1,
                                    initSelection: function (element, callback) {
                                            var data = {id: "1", text: "<?php echo @$locationName; ?>"};
                                            callback(data);
                                    },
                                    ajax: {
                                            url: "<?php echo base_url(); ?>admin/ajaxcalls/AeroAjex",
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

                    $('#aeroplanes_'+type+'<?=$i?>').on("select2-selecting", function(e) {
                                    $("#aeroplanes_id"+type+"<?=$i?>").val(e.val);
                            $('.aeroplane_class<?=$i+1?> .select2-chosen').text(e.val);
                            $("#aeroplanes_id"+type+"<?=$i+1?>").val(e.val);


                    });

                    <?php } } ?>


            }
            function clone_function() {


                    <?php for($i = 0;$i<2;$i++) {?>

                    $("#locationlist_return<?=$i?>").select2(
                            {
                                    placeholder: "Enter City Or Airport",
                                    minimumInputLength: 3,
                                    width:'100%', maximumSelectionSize: 1,
                                    initSelection: function (element, callback) {
                                            var data = {id: "1", text: "<?php echo @$locationName; ?>"
                                            };
                                            callback(data);
                                    },
                                    ajax: {
                                            url: "<?php echo base_url(); ?>admin/ajaxcalls/flightAjex",
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
                    $('#locationlist_return<?=$i?>').on("select2-selecting", function(e) {
                            $("#locationsid_return<?=$i?>").val(e.val);
                            console.log("#locationsid_return<?=$i?>")
                            console.log(e.val);
                    });

                    $('#aeroplanes_return<?=$i?>').select2(
                            {
                                    placeholder: "Enter Aeroplane Name",
                                    minimumInputLength: 3,
                                    width:'100%', maximumSelectionSize: 1,
                                    initSelection: function (element, callback) {
                                            var data = {id: "1", text: "<?php echo @$locationName; ?>"};
                                            callback(data);
                                    },
                                    ajax: {
                                            url: "<?php echo base_url(); ?>admin/ajaxcalls/AeroAjex",
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
                    $('#aeroplanes_return<?=$i?>').on("select2-selecting", function(e) {
                                    $("#aeroplanes_idreturn<?=$i?>").val(e.val);
                            $('.aeroplane_classreturn1 .select2-chosen').text(e.val);
                            $("#aeroplanes_idreturn"+"<?=$i+1?>").val(e.val);
                            console.log(e.val);
                    });
                    <?php }
        ?>
            }
    });
    $("#btnCross2").on("click", function() {
            $(this).parent().parent().remove();
    });
</script>
<script>
    $(document).ready(function() {
            $('.select2').select2();
    });

    function add2(parent,checkType) {
            var template = $('.'+parent).find('#template:first-child');
            var row = template.clone();

            row.find(".cross_"+parent+"0").attr('id' , 'crossBtn'+parent);
            row.find(".title_template").val("Transit");
            row.find('.location_class0').attr('id' , "dynamicLoction"+parent);
            row.find('.aeroplane_class0').attr('id' , 'aero_list1'+parent);
            row.find('.locations0').attr('id' , 'locationid_'+parent);
            row.find('.time_class0').attr('id' , 'timeid_'+parent);
            row.find('.aeroplane_template').attr('id' , 'aeroplane_template_id'+parent);
            row.find('.dpd3').attr('id' , 'date4');

            template.after(row);
            $("#crossBtn"+parent).html('<button class="btn btn-danger" id="btnCross'+parent+'"><i class="fa fa-times"></i></button>');

            $('[name="times_return[]"]').clockface();
            $('[name="times[]"]').clockface();
            $('#locationid_'+parent).val("");
            $('#aeroplane_template_id'+parent).val("");

            $('#dynamicLoction'+parent).select2(
                    {
                            placeholder: "<?php if(empty($locationName)){ echo "Enter City Or Airport"; }else{ echo @$locationName; } ?>",
                            minimumInputLength: 3,
                            width:'100%', maximumSelectionSize: 1,
                            initSelection: function (element, callback) {
                                    var data = {id: "1", text: "<?php echo @$locationName; ?>"};
                                    callback(data);
                            },
                            ajax: {
                                    url: "<?php echo base_url(); ?>admin/ajaxcalls/flightAjex",
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
            $('#dynamicLoction'+parent).on("select2-selecting", function(e) {
                    $("#locationid_"+parent).val(e.val);
                    console.log(e.val);
            });
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

            var date4 = $('#date4').datepicker({
                    format: fmt,
                    onRender: function(date) {
                            return date.valueOf() < now.valueOf() ? 'disabled' : '';
                    }
            })
                    .on('changeDate', function(ev) {
                            date4.hide();
                    })
                    .data('datepicker');

            $('#aero_list1'+parent).select2(
                    {
                            placeholder: "<?php if(empty($locationName)){ echo "Enter Aeroplane Name"; }else{ echo @$locationName; } ?>",
                            minimumInputLength: 3,
                            width:'100%', maximumSelectionSize: 1,
                            initSelection: function (element, callback) {
                                    var data = {id: "1", text: "<?php echo @$locationName; ?>"};
                                    callback(data);
                            },
                            ajax: {
                                    url: "<?php echo base_url(); ?>admin/ajaxcalls/AeroAjex",
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
            $('#aero_list1'+parent).on("select2-selecting", function(e) {
                    $("#aeroplane_template_id"+parent).val(e.val);
                    $('.aeroplane_class'+checkType+'1 .select2-chosen').text(e.val);
                    $("#aeroplanes_id"+checkType+"<?=$i+1?>").val(e.val);

            });

            $("#btnCross"+parent).on("click", function() {
                    $(this).parent().parent().remove();
            });
    }
</script>