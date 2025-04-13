<script>
var HOTELS = $("form[name=HOTELS]");
var select2_default_text = "<?=$_SESSION['hotel_select2']['text']?>" || "<?php echo trans('026');?>";
$(".locationlisthotels").select2({
minimumInputLength: 3,
width: '100%',
maximumSelectionSize: 1,
ajax: {
url: "<?php echo base_url(); ?>home/suggestions_v2/hotels", dataType: 'json', data: function (term) {
return {q: term}
}, results: function (data) {
return {results: data}
}
}
});
$("form[name=HOTELS] .select2-choice .select2-chosen").text(select2_default_text);
$(".locationlisthotels").on("select2-selecting", function (e) {
$("input[name=module_type]").val(e.object.module);
$("input[name=dest]").val(e.object.id);
$("input[name=slug]").val(e.object.id)
});

function create_slug(data) {
var p_1 = data.dest;
p_1 = (p_1) ? p_1 : "null";
var p_2 = data.checkin;
p_2 = (p_2) ? p_2.replace(/\/+/g, '-') : "null";
var p_3 = data.checkout;
p_3 = (p_3) ? p_3.replace(/\/+/g, '-') : "null";
var p_4 = data.adults;
p_4 = (p_4) ? p_4 : 0;
var p_5 = data.child;
p_5 = (p_5) ? p_5 : 0;
var url = "";
if (p_1 != "null") {
url += "/" + p_1
}
return url + "/" + p_2 + "/" + p_3 + "/" + p_4 + "/" + p_5
}

HOTELS.on("submit", function (e) {
e.preventDefault();
var values = {};
$.each($(this).serializeArray(), function (i, field) {
values[field.name] = field.value
});
var slug = $("input[name=slug]").val();
if (slug != '' && slug != undefined) {
values.dest = slug
}
if ($("input[name=module_type]").val() == 'hotel') {
window.location.href = '<?=base_url("hotels/detail")?>' + create_slug(values)
} else {
window.location.href = $(this).attr('action') + create_slug(values)
}
});

</script>