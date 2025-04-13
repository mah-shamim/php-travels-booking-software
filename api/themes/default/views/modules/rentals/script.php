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

var nowTemp4 = new Date();
var now4 = new Date(nowTemp4.getFullYear(), nowTemp4.getMonth(), nowTemp4.getDate(), 0, 0, 0, 0);
var checkin4 = $('.tchkin').datepicker({
format: fmt, onRender: function (date) {
return date.valueOf() < now4.valueOf() ? 'disabled' : ''
}
}).on('changeDate', function (ev) {
var tdate = new Date(ev.date);
});
</script>