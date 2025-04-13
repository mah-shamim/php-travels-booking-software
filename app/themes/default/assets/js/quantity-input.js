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

    var qtyInputField = document.getElementsByClassName('qtyInput_tours');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))
            totalNumber += parseInt(qtyInputField[i].value);
    }

    var cardQty = document.querySelector(".guest_tours");
    if (cardQty) { cardQty.innerHTML = totalNumber; }

    var qtyInputField = document.getElementsByClassName('qtyInput_cars');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))
            totalNumber += parseInt(qtyInputField[i].value);
    }

    var cardQty = document.querySelector(".guest_cars");
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

$(".qtyDec, .qtyInc").on("click", function() {

    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

    if ($button.hasClass('qtyInc')) {
        var newVal = parseFloat(oldValue) + 1;

        /*var adult_value  = $('.adult input' ).val() ++; // to get value of input
        var child_value  = $('.child input' ).val(); // to get value of input
        var infant_value = $('.infant input').val(); // to get value of input

        var adult  = parseFloat(adult_value ); // arrurate value
        var child  = parseFloat(child_value ); // arrurate value
        var infant = parseFloat(infant_value); // arrurate value

        console.log('adult value ' + adult_price + ' adult value ' + adult + ' cost ' + adult_price * adult )
        console.log('child value ' + child_price + ' child value ' + child + ' cost ' + child_price * child )
        console.log('infant value' + infant_price+ ' infant value' + infant+ ' cost ' + infant_price *infant)

        var adult_cost = adult_price * adult ;
        var child_cost = child_price * child ;
        var infant_cost = infant_price * infant ;

        var cost = adult_cost + child_cost + infant_cost;

        $(".total").html(cost);*/

    } else {
        // don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;

        } else {
            newVal = 0;
        }
    }

    $button.parent().find("input").val(newVal);
    qtySumary();
});


var AGES = {};
function show_values(id){
    // console.log($("#ages" + id).val());
    let value = $("#ages" + id).val();
    let index = 'age'+id;
    AGES[index] = value;
    console.log(AGES);    
    $.ajax({
        url: root + '/child_ages',
        method: "POST",
        data: AGES,
        beforeSend: () => {
            console.log('Posting Ages...');
        },
        success: function (response) {
            console.log("Response --> " + response);
        } 
    });
}

var counter_ages = 1;
$(".child_ages .qtyInc").click(function(){
    
    var element = `<li class="col px-2" id="child_ages"><div class="dropdown-item p-2" style="margin-top:-36px"> <p style="color:#000"><small> <strong class="px-2">` + child_age + `</strong></small></p> <div class="form-group"> <span class="la la-child select form-icon"></span> <div class="input-items"> <select onchange="show_values(` + counter_ages + `);" class="form-select" id="ages` + counter_ages +`" name="ages[` + counter_ages + `]"> <option value="0" selected disabled>0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10</option> <option value="11">11</option> <option value="12">12</option> <option value="13">13</option> <option value="14">14</option> <option value="15">15</option> <option value="16">16</option> </select> </div> </div> </div></li>`;

    $("#append").append(element);
    counter_ages = counter_ages + 1;
    
});


$(".child_ages .qtyDec").click(function(){
$("#append #child_ages:last").remove();
});

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