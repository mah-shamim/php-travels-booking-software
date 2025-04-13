<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title pull-left">Edit Booking</span>
        <input type="hidden" id="currenturl" value="<?php echo current_url();?>" />
        <input type="hidden" id="baseurl" value="<?php echo base_url().$this->uri->segment(1);?>" />
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="col-md-8">
            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="bookingid" id="bookingid" value="<?php echo $bdetails->id;?>" />
                <input type="hidden" name="refcode" id="refcode" value="<?php echo $bdetails->code;?>" />
                <input type="hidden" name="itemid" id="itemid" value="<?php echo $bdetails->itemid;?>" />
                <input type="hidden" name="subitem" id="subitem" value="<?php echo $bdetails->subItem->id;?>" />
                <input type="hidden" name="btype" id="btype" value="<?php echo $bdetails->module;?>" />
                <input type="hidden" name="currencysign" id="currencysign" value="<?php echo $app_settings[0]->currency_sign;?>" />
                <input type="hidden" name="commission" id="commission" class="<?php echo $commtype;?>" value="<?php echo $commvalue;?>" />
                <input type="hidden" id="tax" class="<?php echo $tax_type; ?>" value="<?php echo $tax_val; ?>" />
                <input type="hidden" name="totalsupamount" id="totalsupamount" value="<?php echo $supptotal;?>" />
                <?php if($service == "hotels"){ ?>
                <input type="hidden" name="totalamount" id="totalroomamount" value="<?php echo $rtotal;?>" />
                <?php  } ?>
                <input type="hidden" name="grandtotal" id="alltotals"  value="<?php echo $bdetails->checkoutTotal;?>" />
                <input type="hidden" name="paymethod" id="methodname"  value="<?php echo $bdetails->paymethod;?>" />
                <input type="hidden" name="paymethodfee" id="paymethodfee"  value="0" />
                <input type="hidden" name="checkin" id="cin"  value="<?php echo $bdetails->checkin;?>" />
                <input type="hidden" name="checkout" id="cout"  value="<?php echo $bdetails->checkout;?>" />
                <input type="hidden" name="commissiontype" id="comtype" value="<?php echo $commtype;?>" />
                <input type="hidden" id="apptax" value="<?php echo $applytax;?>" />
                <input type="hidden" name="paidamount" value="<?php echo $bdetails->amountPaid;?>" />
                <?php if(!empty($service)){  ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Item</strong></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $checkinlabel;?> </label>
                            <div class="col-md-3">
                                <input class="form-control dpd1" id="<?php echo $service;?>" type="text" placeholder="Date" name=""  value="<?php echo $bdetails->checkin;?>" readonly="true" />
                            </div>
                        </div>
                        <?php if($service == "hotels"){ ?>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo $checkoutlabel;?> </label>
                            <div class="col-md-3">
                                <input class="form-control dpd2" id="<?php echo $service;?>" type="text" placeholder="Date" name=""  value="<?php echo $bdetails->checkout;?>" readonly="true" />
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Total ( Nights )</label>
                                <div class="col-md-3">
                                    <input class="form-control" id="stay" type="text" name="stay"  value="<?php echo $bdetails->nights;?>" readonly="true">
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!--Hotels-->
                        <?php
                            $histrue = $chklib->is_mod_available_enabled("hotels");
                            if($service == "hotels" && $histrue){ ?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Hotel Name</label>
                            <div class="col-md-8">
                                <?php echo $bdetails->title;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Room Name </label>
                            <div class="col-md-8">
                                <select data-placeholder="Select" id="poprooms" class="chosen-select hrooms" disabled="true" >
                                    <?php foreach($hrooms as $hr){ $roomTitle = $hotelslib->getRoomTitleOnly($hr->room_id); ?>
                                    <option value="<?php echo $hr->room_id;?>" <?php if($selectedroom == $hr->room_id){ echo "selected";}?> > <?php echo $roomTitle;?> </option>
                                    <?php } ?>
                                </select>
                                <span class="btn bookrslt" style="display:none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Room Quantity</label>
                            <div class="col-md-3">
                                <select name="title" data-placeholder="Select" class="form-control roomquantity" disabled="true">
                                    <?php for($i =1; $i <= $totalrooms;$i++ ){ ?>
                                    <option value="<?php echo $i;?>" <?php if($rquantity == $i){ echo "selected";} ?> ><?php echo $i;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Total Room Price</label>
                            <div class="col-md-3">
                                <input class="form-control" id="totalroomprice" type="text" name="totalroomprice"  value="<?php echo $rtotal;?>" readonly="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Per Night Price</label>
                            <div class="col-md-3">
                                <input class="form-control" id="roomtotal" type="text" placeholder="Price" name="roomtotal" value="<?php echo $subitemprice;?>" readonly="true">
                            </div>
                        </div>
                        <?php if($applytax == "yes"){ ?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Total Tax</label>
                            <div class="col-md-3">
                                <input class="form-control" id="taxamount" type="text" name="taxamount"  value="<?php echo $bdetails->tax;?>" readonly="true">
                            </div>
                        </div>
                        <?php }else{ ?><input id="taxamount" type="hidden" name="taxamount"  value="0"><?php } } ?>
                        <!-- Hotels-->
                        <!-- Cars-->
                        <?php
                            $cartrue = $chklib->is_mod_available_enabled("cars");
                            if($service == "cars" && $cartrue){ ?>
                        <input type="hidden" name="totalamount" id="totalcaramount" value="0" />
                        <div class="form-group">
                            <label class="col-md-3 control-label">Car Name</label>
                            <div class="col-md-8">
                                <?php echo $bdetails->title;?>
                            </div>
                        </div>
                        <?php } ?>
                        <!--Cars-->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Total Deposit</label>
                            <div class="col-md-3">
                                <input class="form-control editdeposit" type="text" id="totaltopay"  name="totaltopay"  value="<?php echo $bdetails->checkoutAmount;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Booking Status</label>
                            <div class="col-md-3">
                                <?php if($adminsegment == "admin"){ ?>
                                <select class="form-control" name="status">
                                    <option value="unpaid"  <?php if($bdetails->status == "unpaid"){ echo "selected"; }?>>Unpaid</option>
                                    <option value="paid" <?php if($bdetails->status == "paid"){ echo "selected"; }?>>Paid</option>
                                    <option value="reserved" <?php if($bdetails->status == "reserved"){ echo "selected"; }?>>Reserved</option>
                                    <option value="cancelled" <?php if($bdetails->status == "cancelled"){ echo "selected"; }?>>Cancelled</option>
                                </select>
                                <?php }else{ ?>
                                <input type="text" name="status" class="form-control" value="<?php echo ucfirst($bdetails->status); ?>" readonly>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- extras section  <div class="panel panel-default rprice supdiv" <?php if(empty($sups)){ ?>  style="display:none;" <?php } ?>>
                    <div class="panel-heading"><strong>extras</strong></div>
                    <div class="panel-body suppcontent">
                    <?php if(!empty($sups)){ ?>
                    <table class='table table-srtiped'>
                    <thead>
                    <tr>
                    <td><b>Name</b></td>
                    <td><b>Price</b></td>
                    <td><b>Order</b></td>
                    </tr>
                    </thead><tbody>
                    <?php
                        foreach($sups as $sup){ ?>
                    <tr><td><?php echo $sup->extraTitle;?></td>
                    <td><?php echo $app_settings[0]->currency_sign.$sup->extraPrice; ?> </td>
                    <td><input type='checkbox' class='extras'  id="extras_<?php echo $sup->id; ?>" data-title="<?php echo str_replace(" ","&nbsp;",$sup->extraTitle);?>" data-price="<?php echo $sup->extraPrice;?>" onclick="select_sup($(this).data('price'),$(this).data('title'),'<?php echo $sup->id;?>','<?php echo $app_settings[0]->currency_sign;?>');"  <?php if(in_array($sup->id,$bookedsups)){ echo "checked";} ?>    name='extras[]'  value="<?php echo $sup->id;?>" ></td></tr>

                    <?php   } ?>
                    </tbody></table> <?php } ?>
                    </div>
                    </div>-->
                <?php if($adminsegment == "admin"){ ?>
                <div class="panel panel-default rprice paytype">
                    <div class="panel-heading"><strong>Payment Method</strong></div>
                    <div class="panel-body">
                        <label class="col-md-3 control-label" id="" >Payment Type</label>
                        <div class="col-md-4">
                            <select  class="form-control" name="paymethod" data-placeholder="Select">
                                <option value="">Select</option>
                                <?php foreach($paygateways['activeGateways'] as $payt){ ?>
                                <option value="<?php echo $payt['name'];?>" <?php if($payt['name'] == $bdetails->paymethod){ echo "selected"; } ?> ><?php echo  $payt['displayName'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <input type="hidden" name="paymethod" value="<?php echo $bdetails->paymethod;?>">
                <?php } ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="hidden" name="updatebooking" value="1" />
                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="Update Booking">
                    </div>
                </div>
                <?php } ?>
            </form>
        </div>
        <?php if(!empty($service)){  ?>
        <div class="col-md-4 pull-right">
            <div class="panel panel-default" >
                <div style="font-size:16px" class="panel-heading"><strong>Booking Summary</strong></div>
                <table class="table summary">
                    <tr style="background-color:#ffffdf">
                        <td><b><span id="itemtitlesum"><?php echo $bdetails->title;?></span></b></td>
                        <td><span id="itempricesum"><?php if(!empty($itemprice)){ echo $app_settings[0]->currency_sign.$itemprice; } ?></span></td>
                    </tr>
                    <?php
                        if(!empty($bdetails->bookingExtras)){
                        foreach($bdetails->bookingExtras as $bextra){ ?>
                    <tr style='background-color:#ffffdf' class='sidesups' id="extras_<?php echo $bextra->id;?>">
                        <td><b><?php echo $bextra->title; ?></b></td>
                        <td> <strong><?php echo $app_settings[0]->currency_sign.$bextra->price; ?></strong> </td>
                    </tr>
                    <?php  } } ?>
                </table>
                <table class="table table-bordered">
                    <?php if($service == "hotels"){ ?>
                    <?php if($bdetails->extraBeds > 0){  ?>
                    <tr>
                        <td><b>Extra Bed (<?php echo $bdetails->extraBeds;?>)</b></td>
                        <td style="font-size:14px"><?php echo $app_settings[0]->currency_sign;?><?php echo $bdetails->extraBedsCharges;?></td>
                    </tr>
                    <?php } ?>
                    <tr style="background-color:#e7ffda" style="display:none;" id="tr_roomamount">
                        <td style="font-size:14px"><b>Total Room Amount</b></td>
                        <td style="font-size:14px"><?php echo $app_settings[0]->currency_sign;?><span id="summaryroomtotal"><?php echo $rtotal;?></span></td>
                    </tr>
                    <?php } ?>
                    <tr style="background-color:#e7ffda" class="taxesvat">
                        <td style="font-size:14px"><b>Tax & VAT </b></td>
                        <td style="font-size:14px" id="displaytax"><?php echo $app_settings[0]->currency_sign.$bdetails->tax;?></td>
                    </tr>
                    <tr style="background-color:#ffffdf">
                        <td style="font-size:14px"><b>Deposit </b></td>
                        <td style="font-size:14px" id="topaytotal"><?php echo $app_settings[0]->currency_sign.$bdetails->checkoutAmount;?></td>
                    </tr>
                    <tr style="background-color:#e7ffda">
                        <td style="font-size:18px"><b>GRAND TOTAL</b></td>
                        <td style="font-size:18px" id="grandtotal"><?php echo $app_settings[0]->currency_sign;  echo $bdetails->checkoutTotal;?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/adminbooking.js"></script>
