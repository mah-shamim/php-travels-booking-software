<script>
$('#location').on('change', function () {
var location = $(this).val();
$.post(baseURL + 'tours/tourajaxcalls/onChangeLocation', {location: location}, function (resp) {
var response = $.parseJSON(resp);
console.log(response);
if (response.hasResult) {
$("#tourtype").html(response.optionsList);
} else {
$("#tourtype").html(response.optionsList);
}
mySelectUpdate();
})
});
</script>