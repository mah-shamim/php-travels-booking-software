<script>
var baseURL = "<?php echo base_url(); ?>";
var totalsVal = $("#cartotals").val();
if (totalsVal == "1") {
$(".showTotal").show()
} else {
$(".showTotal").hide()
}
var pickupLocation = $('#pickuplocation').val();
var dropoffLocation = $('#droplocation').val();
$('#carlocations').on('change', function () {
var location = $(this).val();
$.post(baseURL + 'cars/carajaxcalls/onChangeLocation', {location: location}, function (resp) {
var response = $.parseJSON(resp);
if (response.hasResult) {
$("#carlocations2").html(response.optionsList).select2({width: '100%', maximumSelectionSize: 1})
}
})
});
$('#pickuplocation').on('change', function () {
var location = $('#pickuplocation').val();
var carid = $("#itemid").val();
var pickupDate = $("#departcar").val();
var dropoffDate = $("#returncar").val();
$.post(baseURL + 'cars/carajaxcalls/getDropoffLocations', {
location: location,
carid: carid,
pickupDate: pickupDate,
dropoffDate: dropoffDate
}, function (resp) {
var response = $.parseJSON(resp);
console.log(response);
if (response.hasResult) {
$(".showTotal").show();
$(".totaldeposit").html(response.priceInfo.depositAmount);
$(".totalTax").html(response.priceInfo.taxAmount);
$(".grandTotal").html(response.priceInfo.grandTotal);
$("#droplocation").html(response.optionsList);
}
})
});
$('.carDates').blur(function () {
setTimeout(function () {
getCarPrice()
}, 500)
});
$('#droplocation').on("change", (function () {
getCarPrice()
}));

function getCarPrice() {
var pickupLocation = $('#pickuplocation').val();
var dropoffLocation = $('#droplocation').val();
var carid = $("#itemid").val();
var pickupDate = $("#departcar").val();
var dropoffDate = $("#returncar").val();
$.post(baseURL + 'cars/carajaxcalls/getCarPriceAjax', {
pickupLocation: pickupLocation,
dropoffLocation: dropoffLocation,
carid: carid,
pickupDate: pickupDate,
dropoffDate: dropoffDate
}, function (resp) {
var response = $.parseJSON(resp);
console.log(response);
$(".showTotal").show();
$(".totaldeposit").html(response.depositAmount);
$(".totalTax").html(response.taxAmount);
$(".grandTotal").html(response.grandTotal)
})
};
</script>