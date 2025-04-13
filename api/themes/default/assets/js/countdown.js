
setInterval(function() {
    var targetDate = new Date("December 28 2020 13:30:00 GMT+0100"); //replace with YOUR DATE
    var nowDate = new Date();
    var difference = Math.floor((targetDate.getTime() - nowDate.getTime()) / 1000);

    var seconds = fixIntegers(difference % 60);
    difference = Math.floor(difference / 60);

    var minutes = fixIntegers(difference % 60);
    difference = Math.floor(difference / 60);

    var hours = fixIntegers(difference % 24);
    difference = Math.floor(difference / 24);

    var days = difference;

    $("#seconds").html(seconds);
    $("#minutes").html(minutes);
    $("#hours").html(hours);
    $("#days").html(days);


}, 1000);
function fixIntegers(integer) {
    if (integer < 0)
        integer = 0;
    if (integer < 10)
        return "0" + integer;
    return "" + integer;
}