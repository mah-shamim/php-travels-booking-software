<br>
<br>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
<style type="text/css">
body { 
    background:#d9d9d9;
    font-weight: normal;
    font-family: 'Noto Sans', sans-serif !important;
}
.mytable td {
    padding:2px 10px;
}
.panel, .panel-default {
    border-radius: 10px;
    box-shadow: 0 0px 0px rgba(0,0,0,0.19), 0 2px 2px rgba(0,0,0,0.23);
}
.panel-heading {
    border-radius: 10px 10px 0px 0px !important;
}
</style>
<div class="container">
    <div id="data_invoice"></div>
    <form action="<?php echo site_url("juniper/booking_confirm"); ?>" method="post" id="booking_form" onsubmit="return check_email();" >
        <?php // dd($data); // echo $commission; ?>
        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Passengers Information
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($data['type'] == 'SGL') { 
                                    $count = $data['required'];
                                    for ($i=0; $i < $count ; $i++) { 
                                        ?>
                                        <h4><?=trans('0435')?> <?=$i+1?> Passenger <?=trans('0177');?></h4>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="leader[<?=$i?>][title]" class="form-control" required="required">
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="Passenger Name" required="required"  name="leader[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="Passenger Surname" required="required"  name="leader[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                    <?php } 
                                }
                                ?>
                                <?php if ($data['type'] == 'TSU') { 
                                    $count = $data['required'];
                                    for ($i=0; $i < $count ; $i++) { 
                                        ?>
                                        <h4><?=trans('0435')?> <?=$i+1?> Passenger <?=trans('0177');?></h4>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="leader[<?=$i?>][title]" class="form-control" required="required">
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="Passenger Name" required="required"  name="leader[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="Passenger Surname" required="required"  name="leader[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                    <?php } 
                                }
                                ?>
                                <?php if ($data['type'] == 'TWN') { 
                                    $count = $data['required'];
                                    for ($i=0; $i < $count ; $i++) { 
                                        ?>
                                        <h4><?=trans('0435')?> <?=$i+1?> Passenger <?=trans('0177');?></h4>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="leader[<?=$i?>][title]" class="form-control" required="required">
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="First Passenger Name" required="required"  name="leader[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="First Passenger Surname" required="required"  name="leader[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="passenger[<?=$i?>][title]" class="form-control" >
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Second Passenger Name" required="required"  name="passenger[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Second Passenger Surname" required="required"  name="passenger[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                        <br>
                                    <?php } 
                                } ?>
                                <?php if ($data['type'] == 'DBL') { 
                                    $count = $data['required'];
                                    for ($i=0; $i < $count ; $i++) { 
                                        ?>
                                        <h4><?=trans('0435')?> <?=$i+1?> Passenger <?=trans('0177');?></h4>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="leader[<?=$i?>][title]" class="form-control" required="required">
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="First Passenger Name" required="required"  name="leader[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="First Passenger Surname" required="required"  name="leader[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="passenger[<?=$i?>][title]" class="form-control"  required="required">
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Second Passenger Name" required="required"  name="passenger[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Second Passenger Surname" required="required"  name="passenger[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                        <br>
                                    <?php } 
                                } ?>
                                <?php if ($data['type'] == 'TRP') { 
                                    $count = $data['required'];
                                    for ($i=0; $i < $count ; $i++) { 
                                        ?>
                                        <h4><?=trans('0435')?> <?=$i+1?> Passenger <?=trans('0177');?></h4>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="leader[<?=$i?>][title]" class="form-control" required="required">
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="First Passenger Name" required="required"  name="leader[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" required="required" placeholder="First Passenger Surname" required="required"  name="leader[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="passenger[<?=$i?>][title]" class="form-control" >
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Second Passenger Name" required="required"  name="passenger[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Second Passenger Surname" required="required"  name="passenger[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="passenger[<?=$i?>][title]" class="form-control" >
                                                    <option value=""><?=trans('089');?></option>
                                                    <option value="MR"><?=trans('0567');?></option>
                                                    <option value="MS"><?=trans('0568');?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Third Passenger Name" required="required"  name="passenger[<?=$i?>][name]">
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" type="text" placeholder="Third Passenger Surname" required="required"  name="passenger[<?=$i?>][surname]">
                                            </div>
                                        </div>
                                        <br>
                                    <?php } 
                                } ?>
                            </div>
                        </div>
                    </div>
                </div> 
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?=trans('0170')?>
                    </div>
                    <div class="panel-body">
                        <input type="text" name="name" placeholder="User Name" class="form-control">
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" required="required" type="email" placeholder="Email" required="required"  name="email" id="email" value="">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" type="email" placeholder="Confirm Email" required="required" id="cemail" name="confirmemail" value="">
                            </div>
                            <div class="col-md-6">
                                <br>
                                <input class="form-control" type="text" placeholder="phone" required="required" name="phone" value="">
                            </div>
                            <div class="col-md-6">
                                <br>
                                <input class="form-control" placeholder="Address" type="text" required="required" name="address" value="">
                            </div>
                            <div class="col-md-12">
                                <br>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="required go-right hidden-xs"><?=trans('0178')?></label>
                                        </div>
                                        <div class="col-md-10 col-xs-10">
                                            <textarea class="form-control" placeholder="You can enter any additional notes or information you want included with your order here..." rows="4" style="resize: none;" name="additionalnotes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p><?=trans('0416');?></p>
                    </div>
                    <div class="panel-footer" style="border-radius: 0px 0px 10px 10px">
                        <button type="submit" class="btn btn-primary" style="border-radius: 5px;"><?=trans('0306')?></button>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?=trans('0411')?>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-condensed">
                            <tr>
                                <td><?=trans('0100');?> <?=trans('0350');?></td>
                                <td>
                                    <?=get_city_name($data['juniper_city'])?>
                                </td>
                            </tr>
                            <tr>
                                <td><?=trans('0405');?> <?=trans('0350');?></td>
                                <td><?=$data['hotel_name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td><?=trans('0405')?> <?=trans('098')?></td>
                            <td><?=$data['hotel_address'];?>
                        </td>
                    </tr>
                    <tr>
                        <td><?=trans('07');?> <?=trans('08');?></td>
                        <td><?=$data['juniper_checkin_date'];?></td>
                    </tr>
                    <tr>
                        <td><?=trans('09');?> <?=trans('08');?></td>
                        <td>
                            <?=$data['juniper_checkout_date'];?>

                        </td>
                    </tr>

                    <tr>
                        <td><?=trans('0246')?></td>
                        <td><?=abbreviation($data['type']);?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="total_table" style="border-radius: 10px;box-shadow: 0 0px 0px rgba(0,0,0,0.19), 0 2px 2px rgba(0,0,0,0.23);">
            <table class="table table_summary">
                <tbody>
                    <tr class="beforeExtraspanel">
                        <td>Room Prices</td>
                        <td class="text-right"><?php echo $data['hotel_currency']." ".calculate_commission($data['hotel_total'],$commission); ?></td>
                    </tr>
                    <tr beforeExtraspanel>
                        <td>Required Rooms</td>
                        <td class="text-right">
                            <?=$data['required'];?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="margin-bottom:0px" class="table table_summary">
                <tbody>
                    <tr style="border-top: 1px dotted white;">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="tr10">
                        <td class="booking-deposit-font">
                            <strong><?=trans('0124');?></strong>
                        </td>
                        <td class="text-right">
                            <?php echo $data['hotel_currency']." ".calculate_commission($data['hotel_total'],$commission); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong><?=trans('0382');?></strong></h3>
            </div>
            <div class="panel-body text-chambray">
                <p><?=trans('0381');?></p>
                <hr>
                <p> <i class="fa fa-phone"></i> +92-3311442244 </p>
                <hr>
                <p><i class="fa fa-envelope-o"></i> info@phptravels.com</p>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="juniper_nationality" value="<?=$data['juniper_nationality']?>">
<input type="hidden" name="juniper_checkin_date" value="<?=$data['juniper_checkin_date'];?>">
<input type="hidden" name="juniper_checkout_date" value="<?=$data['juniper_checkout_date'];?>">
<input type="hidden" name="juniper_city" value="<?=$data['juniper_city']?>">
<input type="hidden" name="hotel_code" value="<?=$data['hotel_code']?>">
<input type="hidden" name="agreement" value="<?=$data['hotel_booking_id']?>">
<input type="hidden" name="hotel_name" value="<?=$data['hotel_name'];?>">
<input type="hidden" name="hotel_address" value="<?=$data['hotel_address'];?>">
<input type="hidden" name="type" value="<?=$data['type']?>">
<input type="hidden" name="currency" value="<?php echo $data['hotel_currency']; ?>">
<input type="hidden" name="price_per_room" value="<?=$data['hotel_total'];?>">
<input type="hidden" name="required" value="<?=$data['required'];?>">
<input type="hidden" name="total_price_room" value="<?=$data['hotel_total'];?>">
</form>    
</div>
<script type="text/javascript">
    function check_email(){
        var email = document.getElementById('email').value;
        var cemail = document.getElementById('cemail').value;
        if (email == cemail) {
            return true;
        } else {
            $("#data_invoice").html("<div class='alert alert-danger' style='background:red;color:white;'>Email do not match</div>");
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        }
    }
    
    $( document ).ready(function() {
        $(".go-left").hide();
    });
</script>