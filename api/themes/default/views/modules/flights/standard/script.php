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
        var payload = {
            triptype: manualtriptype,
            cabinclass: $('[name="cabinclass"]').val(),
            passenger: {total: totalManualPassenger, adult: madult, children: mchildren, infant: minfant},
            origin: jQuery.parseJSON($(this).find("[name='origin']").val()).code,
            destination: jQuery.parseJSON($(this).find("[name='destination']").val()).code,
            departure: $(this).find("[name='departure']").val(),
            arrival: $(this).find("[name='arrival']").val(),
        };
        $('.loader-wrapper').show();
        window.location.href = get_manual_path('flights', payload)
    });

    function get_manual_path(req, payload) {
        var return_hash = "{0}/{1}/{2}/{3}".format(req, payload.origin, payload.destination, payload.departure);
        if (payload.arrival) {
            return_hash = "{0}/{1}".format(return_hash, payload.arrival)
        } else {
            return_hash = "{0}/{1}".format(return_hash, 0)
        }
        if (payload.triptype) {
            return_hash = "{0}/{1}".format(return_hash, payload.triptype)
        }
        if (payload.cabinclass) {
            return_hash = "{0}/{1}".format(return_hash, payload.cabinclass)
        }
        if (payload.passenger.adult) {
            return_hash = "{0}/{1}".format(return_hash, payload.passenger.adult)
        }
        return_hash = "{0}/{1}".format(return_hash, payload.passenger.children);
        return_hash = "{0}/{1}".format(return_hash, payload.passenger.infant);
        return_hash = "{0}/{1}".format(return_hash, 0);
        return_hash = "{0}/{1}".format(return_hash, 0);
        return_hash = "{0}/{1}".format(return_hash, 0);
        return base_url + return_hash
    };
</script>