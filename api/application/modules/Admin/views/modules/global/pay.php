<style>
    .chosen-single{ height:3.5rem !important; padding-top: 12px !important; font-size:1rem !important; }
    .chosen-container-single .chosen-single div{ top:6px !important; }
    .active-result{ font-size:1rem; } #response  input[value="Pay Now"], #showPaymentPage{ transition: all .3s; text-transform: uppercase; font-size: 13px; font-weight: 500; padding-top: 9px; padding-bottom: 7px; border-radius: 3px; background: #3F51B5; border-color: #3F51B5; color: #FFF; }
    .btn-success { color: #28a745; background-color: #fff; border-color: #28a745; }
</style>
<div class="row">
    <div class="col-12">
        <?php if (!empty($errormsg)) { ?>
        <div style="background-color: #ff3939; color: white; font-family: Tahoma; margin-bottom: 15px; padding: 16px; font-weight: lighter; text-transform: uppercase; letter-spacing: 6px; width: 571px; margin: auto;">
            <?php echo $errormsg; ?>
        </div>
        <?php } ?>
        <?php if ($invoice->status == "unpaid") {
            if (time() < $invoice->expiryUnixtime) { ?>

        <div class="row">
            <?php if ($payOnArrival) { ?>
            <div class="col-12 pr-0">
                <button class="btn btn-success theme-btn arrivalpay btn-block" data-module="<?php echo $invoice->module; ?>" id="<?php echo $invoice->id; ?>"><?php echo trans("0345"); ?></button>
            </div>
            <?php } if ($singleGateway != "payonarrival") { ?>
            <div class="col-12">
                <button class="btn btn-primary theme-btn btn-block" type="button" data-toggle="collapse" data-target="#pay" aria-expanded="false" aria-controls="pay"><?php echo trans("0117"); ?></button>
            </div>
            <?php } ?>
        </div>
        <?php } } ?>
    </div>
</div>
<div class="collapse" id="pay">
    <div class="well">
        <!--<div class="modal fade" id="banktrans" tabindex="-1" role="dialog" aria-labelledby="banktrans" aria-hidden="true">
            <div class="modal-dialog">
                    <div class="modal-content">
                            <div class="modal-header" style="margin-bottom: 0px;">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><?php echo trans('0355');?></h4>
                            </div>
                            <div class="modal-body">
                                    <?php echo "banktransfer"; ?>
                            </div>
                    </div>
            </div>
            </div>-->
        <div class="modal-header justify-content-center" style="margin-bottom: 0px;">
            <h4 class="modal-title " id="myModalLabel"><?php echo trans('0377');?></h4>
        </div>
        <div class="modal-body">
            <div class="form text-left">
                <div class="row form-group justify-content-center align-items-center">
                    <label for="form-input" class="hidden-xs col-md-2 col-lg-2 control-label text-left" style="padding: 5px; font-size: 24px;"><?php echo trans('0154');?></label>
                    <div class="col-sm-12 col-md-6 select-contain">
                        <select class="form-control-lg" name="gateway" id="gateway">
                            <option value=""><?php echo trans('0159');?></option>
                            <?php foreach ($paymentGateways as $pay) { if($pay['name'] != "payonarrival"){ ?>
                            <option value="<?php echo $pay['name']; ?>" <?php makeSelected($invoice->paymethod, $pay['name']); ?> ><?php echo $pay['gatewayValues'][$pay['name']]['name']; ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <center>
                        <div id="response"></div>
                    </center>
                </div>
                <div class="col-sm-12 creditcardform" style="display:none;">
                    <form  role="form" action="<?php echo base_url();?>creditcard" method="POST">
                        <fieldset>
                            <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="required "><?php echo trans('0171');?></label>
                                            <div class="clear"></div>
                                            <input type="text" class="form-control" name="firstname" id="card-holder-firstname" placeholder="<?php echo trans('0171');?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="required "><?php echo trans('0172');?></label>
                                            <div class="clear"></div>
                                            <input type="text" class="form-control" name="lastname" id="card-holder-lastname" placeholder="<?php echo trans('0172');?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12  ">
                                        <div class="form-group ">
                                            <label class="required "><?php echo trans('0316');?></label>
                                            <div class="clear"></div>
                                            <input type="text" class="form-control" name="cardnum" id="card-number" placeholder="<?php echo trans('0316');?>" onkeypress="return isNumeric(event)" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group ">
                                            <label style="font-size:13px"class="required  "><?php echo trans('0329');?></label>
                                            <div class="clear"></div>
                                            <select class="form-control" name="expMonth" id="expiry-month">
                                                <option value="01"><?php echo trans('0317');?> (01)</option>
                                                <option value="02"><?php echo trans('0318');?> (02)</option>
                                                <option value="03"><?php echo trans('0319');?> (03)</option>
                                                <option value="04"><?php echo trans('0320');?> (04)</option>
                                                <option value="05"><?php echo trans('0321');?> (05)</option>
                                                <option value="06"><?php echo trans('0322');?> (06)</option>
                                                <option value="07"><?php echo trans('0323');?> (07)</option>
                                                <option value="08"><?php echo trans('0324');?> (08)</option>
                                                <option value="09"><?php echo trans('0325');?> (09)</option>
                                                <option value="10"><?php echo trans('0326');?> (10)</option>
                                                <option value="11"><?php echo trans('0327');?> (11)</option>
                                                <option value="12"><?php echo trans('0328');?> (12)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required ">&nbsp;</label>
                                            <div class="clear"></div>
                                            <select class="form-control" name="expYear" id="expiry-year">
                                                <?php for($y = date("Y");$y <= date("Y") + 10;$y++){?>
                                                <option value="<?php echo $y?>"><?php echo $y; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required ">&nbsp;</label>
                                            <div class="clear"></div>
                                            <input type="text" class="form-control" name="cvv" id="cvv" placeholder="<?php echo trans('0331');?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="required  d-block pt-5">&nbsp;</label>
                                        <div class="clear"></div>
                                        <img src="<?php echo base_url(); ?>assets/img/cc.png" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="alert alert-danger submitresult"></div>
                                <input type="hidden" name="paymethod" id="creditcardgateway" value="" />
                                <input type="hidden" name="bookingid" id="bookingid" value="<?php echo $invoice->bookingID;?>" />
                                <input type="hidden" name="refno" id="bookingid" value="<?php echo $invoice->code;?>" />
                                <button type="submit" class="btn btn-success btn-lg paynowbtn go-right" onclick="return expcheck();"><?php echo trans('0117');?></button>
                                <div class="clear"></div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>