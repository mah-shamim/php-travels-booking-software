<script>
$(".car-startlocation").select2({
placeholder: "Search for an Item",
minimumInputLength: 3,
width: '100%',
maximumSelectionSize: 1,
ajax: {
url: '<?php echo base_url('cartrawler/getLocations'); ?>',
dataType: 'json',
type: "GET",
quietMillis: 50,
data: function (term) {
return {
term: term
}; },
results: function (data) {
return {
results: $.map(data.locations, function (item) {
return {
text: item.locationName,
code: item.locationCode,
id: item.locationName
} }) }; } } });
$(".car-endlocation").select2({
placeholder: "Search for an Item",
minimumInputLength: 3,
width: '100%',
maximumSelectionSize: 1,
ajax: {
url: '<?php echo base_url('cartrawler/getLocations'); ?>',
dataType: 'json',
type: "GET",
quietMillis: 50,
data: function (term) {
return {
term: term
}; },
results: function (data) {
return {
results: $.map(data.locations, function (item) {
return {
text: item.locationName,
code: item.locationCode,
id: item.locationName
}
}) }; } } });
$(".car-startlocation").on("select2-selecting", function (e) {
$("input[name='pickupLocationId']").val(e.object.code);
$("input[name='returnLocationId']").val(e.object.code);
$('.car-endlocation').select2('data', {
text: e.object.text,
id: e.object.text
});
});
</script>