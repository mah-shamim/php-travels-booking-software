<script>
$('#location_from_code').val('<?php echo json_encode(["code" => $query->origin, "location" => ""]); ?>');
$('#location_to_code').val('<?php echo json_encode(["code" => $query->destination, "location" => ""]); ?>');
$('#location_from').select2({
    placeholder: "<?php if (empty($query->destination)) {
        echo lang('0615');
    } else {
        echo $query->origin;
    } ?>",
    minimumInputLength: 3,
    width: '100%',
    maximumSelectionSize: 1,
    initSelection: function (element, callback) {
        var data = {id: "1", text: "<?php echo ""; ?>"};
        callback(data)
    },
    ajax: {
        url: "<?php echo base_url(); ?>admin/ajaxcalls/flightAjex",
        dataType: 'json',
        data: function (term, page) {
            return {query: term,}
        },
        results: function (data, page) {
            return {results: data}
        }
    }
});
$('#location_from').on("select2-selecting", function (e) {
    $("#location_from_code").val(e.val);
    console.log(e.val)
});
$('#location_to').select2({
    placeholder: "<?php if (empty($query->origin)) {
        echo lang('0615');
    } else {
        echo $query->destination;
    } ?>",
    minimumInputLength: 3,
    width: '100%',
    maximumSelectionSize: 1,
    initSelection: function (element, callback) {
        var data = {id: "1", text: "<?php echo ""; ?>"};
        callback(data)
    },
    ajax: {
        url: "<?php echo base_url(); ?>admin/ajaxcalls/flightAjex",
        dataType: 'json',
        data: function (term, page) {
            return {query: term,}
        },
        results: function (data, page) {
            return {results: data}
        }
    }
});
$('#location_to').on("select2-selecting", function (e) {
    $("#location_to_code").val(e.val);
    console.log(e.val)
});
$("form[name='flightmanualSearch']").on('submit', function (e) {
    e.preventDefault();
    var triptype = $("input[name='triptype']:checked"). val();
    var location_from = jQuery.parseJSON($(this).find("[name='origin']").val()).code;
    var location_to = jQuery.parseJSON($(this).find("[name='destination']").val()).code;
    var FlightsDateStart = $("#FlightsDateStart").val();
    var FlightsDateEnd = $("#FlightsDateEnd").val();
    var madult = $("input[name=adult]").val();
    var mchildren = $("input[name=children]").val();
    var infant = $("input[name=infant]").val();
    var class_trip = $( ".trip_class option:selected" ).val();
    if(FlightsDateEnd !=''){
        var slash = "/";
        var dateend = FlightsDateEnd;
    }else{
        var slash = "";
        var dateend = '';
    }
    var endpoint = $(this).attr("action");
    var new_url = endpoint+"/search/"+location_from+"/"+location_to+"/"+triptype+"/"+class_trip+"/"+FlightsDateStart +""+ slash +""+ dateend +"/"+madult +"/"+mchildren +"/"+infant;
    window.location.href = new_url;
});
</script>