<script>
var options = {
url: function (phrase) {
return "https://yasen.hotellook.com/autocomplete?lang=en-US&limit=10&term=" + phrase;
},
categories: [{
listLocation: "cities"
}],
list: {
match: {
enabled: false
},
maxNumberOfElements: 10
},
getValue: "fullname",
};
$("#citiesInput").easyAutocomplete(options);

var loading = false;//to prevent duplicate
function loadNewContent() {

// get the current cache location and key..
var moreResultsAvailable = $("#moreResultsAvailable").val();
var cacheKey = $("#cacheKey").val();
var cacheLocation = $("#cacheLocation").val();
var cachePaging = $("#cachePaging").val();
var checkin = $(".dpean1").val();
var checkout = $(".dpean2").val();
var agesappend = $("#agesappendurl").val();
var adultsCount = $("#adultsCount").val();

$('#loader_new').html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
var url_to_new_content = '<?php echo base_url(); ?>ean/loadMore';

$.ajax({
type: 'POST',
data: {'moreResultsAvailable': moreResultsAvailable, 'cacheKey': cacheKey, 'cacheLocation': cacheLocation, 'checkin': checkin, 'checkout': checkout,'agesappendurl': agesappend,'adultsCount': adultsCount },
url: url_to_new_content,
success: function (data) {
// document.getElementById('loadNewdata').value = 1;
if (data != "" && data != "404") {
$('#loader_new').html('');
loading = false;
// $("#latest_record_para").html(data);
var newData = data.split("###");
$("#latest_record_para").html(newData[0]);
$("#New_data_load").append(newData[1]);
}
else
{
$('#loader_new').html('');
$("#message_noResult").html('');
}
}
});
}

//scroll to PAGE's bottom
var winTop = $(window).scrollTop();
var docHeight = $(document).height();
var winHeight = $(window).height();
$(window).scroll(function () {
var moreResultsAvailable = $("#moreResultsAvailable").val();
var foot = $("#footer").offset().top - 500;
// console.log($(window).scrollTop()+" == "+foot);
if (moreResultsAvailable != '' && moreResultsAvailable == 1) {
if ($(window).scrollTop() > foot) {
if (!loading) {
loading = true;
loadNewContent();
}
}
}
});

$(function() {
var adultPlusBtn = document.getElementById('adultPlusBtn');
var adultMinusBtn = document.getElementById('adultMinusBtn');
var childPlusBtn = document.getElementById('childPlusBtn');
var childMinusBtn = document.getElementById('childMinusBtn');
var adultInput = document.getElementById('adultInput');
var childInput = document.getElementById('childInput');
var travellersInput = document.getElementById('totalGuestsInput'); // Input label field

var updateGuestsInput = function ($adult, $child) {
var value = $adult + ' Adult ' + $child + ' Child';
travellersInput.value = value;
}
adultPlusBtn.onclick = function () {
console.log("hello");
adultInput.value = parseInt(adultInput.value) + 1;
updateGuestsInput(adultInput.value, childInput.value);
};
adultMinusBtn.onclick = function () {
var value = parseInt(adultInput.value) - 1;
adultInput.value = (value < 1) ? 0 : value;
updateGuestsInput(adultInput.value, childInput.value);
};
childPlusBtn.onclick = function () {
childInput.value = parseInt(childInput.value) + 1;
updateGuestsInput(adultInput.value, childInput.value);
};
childMinusBtn.onclick = function () {
var value = parseInt(childInput.value) - 1;
childInput.value = (value < 1) ? 0 : value;
updateGuestsInput(adultInput.value, childInput.value);
};
});
</script>