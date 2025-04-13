<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container" id="main_div">

    <div id="overlay" style="display: block">
        <div id="text">
            <br>
            <img class="img-responsive" src="<?php echo base_url(''); ?>uploads/images/flights/airlines/flight.gif" alt="Searching flight"><br>
            <h4 class="cw"><?=lang('0427')?></h4>
            <br>
        </div>
    </div>

</div>



<script type="text/javascript">

    var data_array = {};
    data_array['args'] = '<?=$args?>';
    $.ajax({
        data: data_array,
        type:"post",
        url: "<?=base_url("FlightTarco/listing_result")?>",
        success: function(result){
            $("#main_div").html(result);
        }});
    $("input:radio").click(function () {
        var showAll = true;
        $('form').hide();
        $('input[type=radio]').each(function () {
            if ($(this)[0].checked) {
                showAll = false;
                var value = $(this).val();
                if ($(this).data('filtertype') === 'carrier') {
                    console.log('div[data-carrier="' + value + ':0"]');
                    $('div[data-carrier="' + value + ':0"]').parent().parent().parent().show();
                } else if ($(this).data('filtertype') === 'stops') {
                    console.log('div[data-stops="' + value + ':0"]');
                    $('div[data-stops="' + value + ':0"]').parent().parent().parent().show();
                }
            }
        });
        if(showAll) {
            $('form').show();
        }
    });
</script>

