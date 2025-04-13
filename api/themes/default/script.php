<!-- ###################################################################### -->
<!-- Global Script Script -->
<!-- ###################################################################### -->
<script>
$( "button[type='submit']" ).click(function (e) {
$( "button[type='submit']" ).prepend('<span id="HotelsLoad" class="spinner-grow spinner-grow-sm load" role="status" aria-hidden="true"></span>'); });

// JS for currencie change
function change_currency() {
    var selectBox = document.getElementById("selectBox");
    var currency_id = selectBox.options[selectBox.selectedIndex].value;
    // alert(currency_id);
$("#loadingbg").css("display", "block"), $.post("<?php echo base_url();?>admin/ajaxcalls/changeCurrency", {id: currency_id}, function () {
location.reload()
}) };

// cookies law div footer show hide session store status
const cookyDisablePeriodInDays = 100;

function createCookie(cookieName, cookieValue, daysToExpire) {
var date = new Date();
date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString(); }

function accessCookie(cookieName) {
var name = cookieName + "=";
var allCookieArray = document.cookie.split(';');
for (var i = 0; i < allCookieArray.length; i++) {
var temp = allCookieArray[i].trim();
if (temp.indexOf(name) == 0)
return temp.substring(name.length, temp.length);
} return ""; }

// If user accept cooky policy by clicking `Got It` button then do not show the button to the user.
const cookyGotItStatus = accessCookie("cookyGotItButton");
if (cookyGotItStatus != "" && cookyGotItStatus == "hide") {
$("#cookyGotItBtnBox").css("display", "none");
} else {
setTimeout(function () {
console.log('show');
$("#cookyGotItBtnBox").css("display", "flex");
}, 1000); }

function cookyGotItBtn() {
createCookie("cookyGotItButton", "hide", cookyDisablePeriodInDays);
$("#cookyGotItBtnBox").css("display", "none"); }

// Select2
$(".select2").select2({
width: '100%' });

/* Newsletter subscription */
$(".sub_newsletter").on("click",function(){var e=$(".sub_email").val();$.post("<?php echo base_url();?>home/subscribe",{email:e},function(e){$(".subscriberesponse").html(e).fadeIn("slow"),setTimeout(function(){$(".subscriberesponse").fadeOut("slow")},2000)})});

/* dropdown on hover */
$("ul.nav li.dropdown").hover(function(){$(this).find(".dropdown-menu").stop(!0,!0).delay(200).fadeIn(200)},function(){$(this).find(".dropdown-menu").stop(!0,!0).delay(200).fadeOut(200)});
</script>

<!-- ###################################################################### -->
<!-- Global Script Script -->
<!-- ###################################################################### -->
<?php

foreach ($modulesname as $module) {
    include $themeurl. 'views/modules/'.strtolower($module['foldername']).'/script.php';
}
?>
