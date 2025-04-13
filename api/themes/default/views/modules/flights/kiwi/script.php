<?php
$ci = get_instance();
$ci->load->model($module["module_name"].'/FlightsSearchModel');
$search = unserialize($ci->session->userdata($module["module_name"]));
if(empty($search))
{
    $search = new FlightsSearchModel();
}

?>
<script>
$('#location_from_code').val('<?php    echo json_encode(["code" => $search->origin, "location" => ""]); ?>');
$('#location_to_code').val('<?php echo json_encode(["code" => $search->destination, "location" => ""]); ?>');
$('#location_from').select2({
    placeholder: "<?php if (empty($search->origin)) {
        echo lang('0615');
    } else {
        echo $search->origin;
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
    },
    initSelection: function (element, callback) {
        callback({id: 1, text: '<?=(!empty($search->origin))? $search->origin :lang('0615'); ?>'})
    }
});
$('#location_from').on("select2-selecting", function (e) {
    $("#location_from_code").val(e.val);
    console.log(e.val)
});
$('#location_to').select2({
    placeholder: "<?php if (empty($search->destination)) {
        echo lang('0615');
    } else {
        echo $search->destination;
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
    },
    initSelection: function (element, callback) {
        callback({id: 1, text: '<?=(!empty($search->destination))? $search->destination :lang('0615'); ?>'})
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
    var madult = $("input[name=fadults]").val();
    var mchildren = $("input[name=fchildren]").val();
    var infant = $("input[name=finfant]").val();
    var class_trip = $( ".trip_class option:selected" ).val();
    if(FlightsDateEnd !=''){
        var slash = "/";
        var dateend = FlightsDateEnd;
    }else{
        var slash = "";
        var dateend = '';
    }
    var endpoint = $(this).attr("action");
    var new_url = endpoint+""+location_from+"/"+location_to+"/"+triptype+"/"+class_trip+"/"+FlightsDateStart +""+ slash +""+ dateend +"/"+madult +"/"+mchildren +"/"+infant;
    window.location.href = new_url;
});
</script>