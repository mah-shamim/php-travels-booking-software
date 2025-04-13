<?php
$ci = get_instance();
if($module["module_name"] == 'expedia') {
    $ci->load->model('Ean/HotelsSearchModel');
}else{
    $ci->load->model($module["module_name"] . '/HotelsSearchModel');
}
if($module["module_name"] == 'expedia'){
    $module = 'Ean';
}else{
    $module = $module["module_name"];
}
$search = unserialize($ci->session->userdata($module));
if(empty($search))
{
    $search = new HotelsSearchModel();
}
?>
<script>
var HOTELS = $("form[name=HOTELS]");   
var select2_default_text = "<?=$search->hotellocation?>" || "<?php echo trans('026');?>";
$(".hotelsearch").select2({
minimumInputLength: 3,
width: '100%',
maximumSelectionSize: 1,
ajax: {
url: "<?=$search->location_url?>", dataType: 'json', data: function (term) {
return {q: term}
}, results: function (data) {
return {results: data}
}
},
initSelection: function (element, callback) {
callback({id: 1, text: '<?=(!empty($search->hotellocation))? $search->hotellocation :'Search by Hotel or City Name'; ?>'})
}
});
$("form[name=HOTELS] .select2-choice .select2-chosen").text(select2_default_text);
$(".hotelsearch").on("select2-selecting", function (e) {
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
var p_5 = data.children;
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
    values['checkin'] = $("#HotelsDateEnd").val().split(' - ')[0];
    values['checkout'] = $("#HotelsDateEnd").val().split(' - ')[1];
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

<!-- Linging page priceranger script -->

<!--<script>
$("#price_range").ionRangeSlider({
type: "double",
grid: true,
min: <?=$minprice?>,
max: <?=$maxprice?>,
from: <?=$minprice?>,
to: <?=$maxprice?>,
<?php if(strpos($currenturl,'book') == false && $app_settings[0]->multi_curr == 1 && empty($hideCurr)): $currencies = ptCurrencies(); ?>
prefix: " <?php echo isset($_SESSION['currencycode']) ? $_SESSION['currencycode'] : 'USD'; ?> "
<?php endif; ?>
});
</script>-->
<!-- Linging page priceranger script -->