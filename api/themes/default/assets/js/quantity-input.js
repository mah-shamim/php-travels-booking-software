/*======== Quests quantity total number count =========*/
function qtySumary(){
    var qtyInputField = document.getElementsByClassName('qtyInput_hotels');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))
            totalNumber += parseInt(qtyInputField[i].value);
    }

    var cardQty = document.querySelector(".guest_hotels");
    if (cardQty) { cardQty.innerHTML = totalNumber; }

    var qtyInputField = document.getElementsByClassName('qtyInput_flights');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))
            totalNumber += parseInt(qtyInputField[i].value);
    }

    var cardQty = document.querySelector(".guest_flights");
    if (cardQty) { cardQty.innerHTML = totalNumber; }
}
qtySumary();

$(".qtyBtn input").before('<div class="qtyDec"><i class="la la-minus"></i></div>');
$(".qtyBtn input").after('<div class="qtyInc"><i class="la la-plus"></i></div>');
$(".roomBtn input").before('<div class="roomDec"><i class="la la-minus"></i></div>');
$(".roomBtn input").after('<div class="roomInc"><i class="la la-plus"></i></div>');
        

/*======== Room quantity total number count =========*/
function roomSumary(){
    var qtyInputField_2 = document.getElementsByName('roomInput');
    var totalNumber_2=0;
    for(var i = 0; i < qtyInputField_2.length; i++){
        if(parseInt(qtyInputField_2[i].value))
            totalNumber_2 += parseInt(qtyInputField_2[i].value);
    }

    var roomQty = document.querySelector(".roomTotal");
    var roomQty_2 = document.querySelector(".roomTotal_2");
    var roomQty_3 = document.querySelector(".roomTotal_3");
    var roomQty_4 = document.querySelector(".roomTotal_4");
    if (roomQty) {
        roomQty.innerHTML = totalNumber_2;
    }
    if (roomQty_2) {
        roomQty_2.innerHTML = totalNumber_2;
    }
    if (roomQty_3) {
        roomQty_3.innerHTML = totalNumber_2;
    }
    if (roomQty_4) {
        roomQty_4.innerHTML = totalNumber_2;
    }
}
roomSumary();

/*======== Room quantity increment decrement =========*/
$(".roomInc, .roomDec").on("click", function() {

    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

    if ($button.hasClass('roomInc')) {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }

    $button.parent().find("input").val(newVal);
    roomSumary();

});