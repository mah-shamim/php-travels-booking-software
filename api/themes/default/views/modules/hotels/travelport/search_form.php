<style> .modal-backdrop { z-index: 0; } </style>

<form autocomplete="off" name="hotelportSearch" action="<?php echo base_url('travelport_hotels/hotelApi'); ?>" method="GET" role="search">
    <div class="col-md-4 col-xs-12 go-text-right go-right form-group bgwhite h50">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-41"></i>
            <input type="text" name="destination" class="tp-widget-select2" required value="">
        </div>
    </div>
    <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput" id="dpd1">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-53"></i>
            <input type="text" placeholder="<?php echo trans('07'); ?>" name="checkin" value="" class="form input-lg hpcheckin" required>
        </div>
    </div>
    <div id="dpd2" class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-53"></i>
            <input type="text" placeholder="<?php echo trans('09'); ?>" name="checkout" value="" class="form input-lg hpcheckout" required>
        </div>
    </div>
    <div class="bgfade col-md-2 form-group go-right col-xs-12">
    <div class="row">
    <select class="form-control fs12 form input-lg" name="adults">
        <option value="1">1 <?php echo trans('010');?></option>
        <option selected value="2">2 <?php echo trans('010');?></option>
        <option value="3">3 <?php echo trans('010');?></option>
        <option value="4">4 <?php echo trans('010');?></option>
        <option value="5">5 <?php echo trans('010');?></option>
    </select>
    </div>
    </div>
    <div class="col-md-2 form-group go-right col-xs-12 search-button">
    <button type="submit"  class="btn-primary btn btn-lg btn-block pfb0"><i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?></button>
    </div>
</form>

<script>
$(function(){
    $("[name=hotelportSearch] .tp-widget-select2").select2({
        placeholder: "Enter Location",
        minimumInputLength: 3,
        width: '100%',
        maximumSelectionSize: 1,
        ajax:{
            url: '<?php echo base_url('Suggestions/airports/tport'); ?>',
            dataType: 'json',
            data: function(term) {
                return {
                    q: term
                }
            },
            results: function(data) {
                return {
                    results: data
                }
            }
        },
        initSelection : function (element, callback) {
            var elementText = $(element).val();
            callback({"text": elementText, "id": elementText});
        }
    });

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    // Checkin time
    var checkin = $('[name=hotelportSearch] .hpcheckin').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    })
    .on('changeDate', function(e){
        $(this).datepicker('hide');
        var newDate = new Date(e.date);
        checkout.setValue(newDate.setDate(newDate.getDate() + 1));
        $('[name=hotelportSearch] .hpcheckout').focus();
    }).data('datepicker');

    // Checkout time
    var checkout = $('[name=hotelportSearch] .hpcheckout').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(){
        $(this).datepicker('hide');
    }).data('datepicker');

    // Default fill up date
    if(checkin.element.val()) {
        checkin.setValue(checkin.element.val());
    }
    if(checkout.element.val()) {
        checkout.setValue(checkout.element.val());
    }
});
</script>