<div class="page-wrapper page-payment bg-light">
    <div class="container booking">
        <!-- End Fail Result of Expedia booking for submit -->
        <div class="container offset-0">
            <div class="loadinvoice">
                <div class="acc_section">
                    <!-- RIGHT CONTENT -->
                    <div class="row">
                        <div class="col-md-8 offset-0 go-right order-2 order-lg-first" style="margin-bottom:50px;">
                            <div class="clearfix"></div>
                            <div class="">
                                <div class="result"></div>
                                <h1 class="text-center strong"><?php echo trans('0432');?></h1>
                                <h3 class="text-center"><?php echo trans('0431');?></h3>
                                <!-- Start Other Modules Booking left section -->

                                <h3 class="heading-title"><span><?php echo trans('088');?></span></h3>
                                <div class="bg-white-shadow pt-25 ph-30 pb-40">
                                    <?php include $themeurl.'views/includes/booking/profile.php'; ?>
                                </div>
                                <form id="bookingdetails" class="hidden-xs hidden-sm" action="" onsubmit="return false">
                                    <div class="clearfix"></div>
                                    <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                                        <?php include $themeurl.'views/includes/booking/extras.php'; ?>
                                    </div>
                                    <!--End step -->
                                    <script type="text/javascript">
                                        $(function(){
                                        $('.popz').popover({ trigger: "hover" });
                                        });
                                    </script>
                                    <!-- Complete This booking button only starting -->
                                    <div class="panel panel-default btn_section" style="display:none;">
                                        <div class="panel-body">
                                            <center>
                                        </div>
                                    </div>
                        
                                    <?php  include $themeurl.'views/includes/booking/coupon.php';  ?>
                                    <div class="clearfix"></div>
                                    <!-- Start Tour Travellers data fields -->
                                    <div class="panel panel-default">
                                        <h3 class="heading-title"><span><?php echo trans('0521');?></span></h3>
                                        <div class="panel-body">
                                            <div class="form-horizontal">
                                                <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                                                    <div class="row form-group">
                                                        <div class="col-md-4">
                                                            <label class="pure-material-textfield-outlined float-none">
                                                            <input type="" name="passport[<?php echo $i;?>][name]"  placeholder=" "/>
                                                            <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0350');?></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="pure-material-textfield-outlined float-none">
                                                            <input type="" name="passport[<?php echo $i;?>][passportnumber]"  placeholder=" "/>
                                                            <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0523');?></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="pure-material-textfield-outlined float-none">
                                                            <input type="" name="passport[<?php echo $i;?>][age]"  placeholder=" "/>
                                                            <span><?php echo trans('0524');?></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-info mt-30">
                                        <strong class="RTL go-right"><?php echo trans('045');?></strong><br>
                                        <p class="RTL" style="font-size:12px">ppp</p>
                                    </div>
                                </form>
                                <!-- End Other Modules Booking left section -->
                            </div>
                        </div>
                        <div class="col-md-4 summary">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="" class="img-responsive" alt="">
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <h6 class="m0"><strong> ppp</strong></h6>
                                        <p  class="m0"> <i class="fa fa-map-marker RTL"></i> ppp</p>
                                        <p  class="m0">
                                            stars
                                        </p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="no-margin no-padding">
                                        <li><b> <?php echo trans('07');?></b><span class="pull-right">checkin</span></li>
                                        <li><b> <?php echo trans('09');?></b><span class="pull-right">checkout</span></li>
                                        <li><b> <?php echo trans('060');?></b> <span class="pull-right">1</span></li>
                                        <li><b> <?php echo trans('0429');?></b> <span class="pull-right">USD $ 100</span></li>
                                    </ul>
                                </div>
                            </div>
                            <br>
                            <div class="panel panel-default">
                                <div class="panel-heading"><?php echo trans('016');?></div>
                                <div class="panel-body m0">
                                    <p class="m0"><i class="fa fa-bed"></i> 1 <strong>ppp</strong> <span class="pull-right">For 2 Adults - $250</span></p>
                                    <hr>
                                </div>
                            </div>
                            <div class="total_table">
                                <table class="table table_summary">
                                    <tbody>
                                        <tr class="beforeExtraspanel">
                                            <td>
                                                <?php echo trans('0153');?>
                                            </td>
                                            <td class="text-right">
                                                USD $ pp<span id="displaytax">11</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="booking-deposit-font">
                                                <strong><?php echo trans('0126');?></strong>
                                            </td>
                                            <td class="pull-right">
                                                <strong><span class="booking-deposit-font go-left">USD $<span id="displaydeposit">111</span></span></strong>
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
                                                <strong><?php echo trans('0124');?></strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>USD $<span id="displaytotal">1111</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- Booking Final Starting -->
                <div class="col-md-12 offset-0 final_section go-right">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="step-pane row" id="step4">
                                <div class="matrialprogress show">
                                    <div class="indeterminate"></div>
                                </div>
                                <h2 class="text-center"><?php echo trans('0179');?></h2>
                                <p class="text-center"><?php echo trans('0180');?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <br/>
            </div>
        </div>
    </div>
</div>