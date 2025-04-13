 var grandtotal = 0;
 var currentUrl = $("#currenturl").val();
 var baseURL = $("#baseurl").val();
 var currency = $("#currencysign").val();
  var apptax = $("#apptax").val();

$(function(){
  $("#guestacc").hide();
   $("#email").prop("required",false);
  $("#fname").prop("required",false);
  $("#lname").prop("required",false);

  if(apptax == "yes"){
    $(".taxesvat").show();
  }else{
      $(".taxesvat").hide();
  }

$("#selusertype").change(function(){
 var utype = $(this).val();

if(utype == "guest"){
    $("#regcust").hide();
  $("#guestacc").fadeIn("slow");
  $("#email").prop("required",true);
  $("#fname").prop("required",true);
  $("#lname").prop("required",true);

}else{
  $("#guestacc").hide();
  $("#regcust").fadeIn("slow");
  $("#email").prop("required",false);
  $("#fname").prop("required",false);
  $("#lname").prop("required",false);
}


})

$("#servicetype").change(function(){
 var item = $(this).val();
 var apply = $("#apply").val();
 $.post(baseURL+"/quickbooking/applytax", {apply: apply}, function(theResponse){

 window.location.replace(currentUrl+"?service="+item);
 })


})

$(".hotels").change(function(){
 var item = $(this).val();
   $('.sidesups').remove();
   $('.selected_room').remove();
    $("#displaytax").html(currency+0);
    $("#topaytotal").html(currency+0);
    $("#grandtotal").html(currency+0);
    $("#pmethod").html(currency+0);
      $("#summaryroomtotal").html(0);
      $("#alltotals").val(0);

  getSupps(item, "hotels");
$.post(baseURL+"/quickbooking/hoteldetails", {item: item}, function(theResponse){
      var response = jQuery.parseJSON(theResponse);

      $("#itemid").val(response.id);
      $("#itemtitle").val(response.title);
      $("#itemtitlesum").text(response.title);
      $("#btype").val(response.btype);
      $("#b2c_markup").val(response.b2c_markup);
      $("#taxhotel").val(response.tax_val);
      $("#commission").val(response.comm_val);
      $("#commission").removeClass();
      $("#commission").addClass(response.comm_type);
      $("#comtype").val(response.comm_type);
      if(apptax == "yes"){
      $("#tax").val(response.tax_val);
      $("#tax").removeClass();
      $("#tax").addClass(response.tax_type);
      }



       $(".roomquantity").html("");
       $("#roomtotal").val(0);
       $("#totalroomprice").val(0);
       $("#totalsupamount").val(0);
 });

})


$(".hrooms").change(function(){
  hroomprice($(this).val());
  $("#totalsupamount").val("0");
 $("[type=checkbox]" ).prop("checked",false);
 $(".sidesups").remove();


})


$(".dpd1").blur(function(){
  var service = $(this).prop("id");
  setTimeout(function () {
    $("#cin").val($(".dpd1").val());
  if(service == "hotels"){

   var id = $( ".hrooms option:selected" ).val();
   hroomprice(id);

  }else if(service == "cars"){

   var id = $( ".cars option:selected" ).val();
   carsprice(id);

  }
  totalnights();
   }, 500);


});


$(".dpd2").on("blur",function(){
  var service = $(this).prop("id");

setTimeout(function () {
  $("#cout").val($(".dpd2").val());

  totalnights();
  if(service == "hotels"){


   var id = $( ".hrooms option:selected" ).val();
   hroomprice(id);

  }else if(service == "cars"){


   var id = $( ".cars option:selected" ).val();
     carsprice(id);

  }

   }, 500);

});

$("#roomtotal").change(function(){
var rquantity = $(".roomquantity").val();
var stay = $("#stay").val();
var price = $(this).val();
 var roomtotalprice = stay * price * rquantity;
 $("#totalroomprice").val(roomtotalprice);
 $("#selected_price").text(price);

  roomcalculations();

});


$(".roomquantity").change(function(){
var rquantity = $(this).val();
var stay = $("#stay").val();
var price = $("#roomtotal").val();
 var roomtotalprice = stay * price * rquantity;
 $("#totalroomprice").val(roomtotalprice);
 $("#selected_quantity").text(rquantity);

  roomcalculations();

});

$(".updateTourPrice").change(function(){

$.post(baseURL+"/quickbooking/tourUpdatedPrice", $("#bookingform").serialize(), function(theResponse){

var response = jQuery.parseJSON(theResponse);

$("#totaltouramount").val(response.grandTotal);
  var tourTotal = parseFloat(response.grandTotal) - parseFloat(response.taxAmount);

       $("#displaytax").html(currency+response.taxAmount);
       $("#taxamount").val(response.taxAmount);
      
      $("#topaytotal").html(currency+response.depositAmount);
      $("#totaltopay").val(response.depositAmount); 
      $("#grandtotal").html(currency+response.grandTotal);
      $("#summarytourtotal").html(tourTotal);
      $("#totaltourprice").val(tourTotal);

      $("#alltotals").val(response.grandTotal);


      // $("#subitem").val(response.subitem);
      // $("#cin").val(response.startdate);
      //$("#priceadult").val(response.priceadult);
      //$("#pricechild").val(response.pricechild);
      //$("#priceinfant").val(response.priceinfant);
      // $("#totaltourprice").val(response.mainprice);
        $("#tourtotal").val(response.grandTotal);
     
      $("#commission").val(response.depositAmount);
      if(apptax == "yes"){

      $("#tax").val(response.taxAmount);
    //  $("#tax").removeClass();
     // $("#tax").addClass(response.tax_type);

      }
  console.log(response);

        



 });



});



});

//tour sub items
function toursubitems(){
var aquantity = $("#maxadults").val();
var cquantity = $("#maxchild").val();
var iquantity = $("#maxinfants").val();
var ttype = $("#tourtype").val();
var adultprice = parseFloat($("#priceadult").val());
var childprice = parseFloat($("#pricechild").val()) || 0;
var infantprice = parseFloat($("#priceinfant").val()) || 0;
var adult = adultprice * aquantity;
var child = childprice * cquantity;
var infant = infantprice * iquantity;
var astr = "";
var cstr = "";
var istr = "";
var subitem = "";
if(aquantity > 0){
  astr = "Adults_"+adult+"_"+aquantity+",";
}

if(cquantity > 0){
  cstr = "Child_"+child+"_"+cquantity+",";
}

if(iquantity > 0){
  istr = "Infants_"+infant+"_"+iquantity+",";
}
var combined = astr+cstr+istr;
  $("#subitem").val(combined);
}

function hroomprice(item){

 var chkin = $(".dpd1").val();
 var chkout = $(".dpd2").val();
  if(chkin == ""){
    $(".dpd1").focus();

  }else if(chkout == ""){
    $(".dpd2").focus();

  }else{

$.post(baseURL+"/quickbooking/hroomdetails", {roomid: item,checkin: chkin,checkout: chkout}, function(theResponse){

var response = jQuery.parseJSON(theResponse);
console.log(response);
     if(response.stay < 1){
         $(".bookrslt").addClass("alert-danger");
       $(".bookrslt").html("Invalid Dates Selected");
     }else{

      if(response.price > 0 && response.avail_rooms > 0){
        var hotelid =  $( ".hotels option:selected" ).val();
        getSupps(hotelid, 'hotels')

       //$(".rprice").fadeIn("slow");


          if(response.price_type == 0){
              $("#priceadult").hide();
              $("#pricechild").hide();
              $("#price_type").val('By Fixed');
              $(".adults").html(response.adulttxt);
              $(".child").html(response.chlidtxt);
              $("#roomtotal").val(response.price);


              $("#stay").val(response.stay);
              $(".roomquantity").html(response.quantity);
              $(".bookrslt").removeClass("alert-danger");
              $(".bookrslt").html("");
              var rquantity = $(".roomquantity").val();
              var b2c = $("#b2c_markup").val();
              var taxhotel = $("#taxhotel").val();
              var roomtotal = response.stay * response.price * rquantity;
              var b2c_p = ((roomtotal /100) * b2c);
              var taxhotel_p = ((roomtotal /100) * taxhotel);
              var roomtotalprice = (roomtotal + b2c_p + taxhotel_p);
              $("#totalroomprice").val(roomtotalprice);

              add_to_right_div(response.roomtitle,response.price,response.currency);
          }else {
              $("#priceadult").show();
              $("#pricechild").show();
              $("#adultprice").val(response.room_adult_price);
              $("#childprice").val(response.room_child_price);
              $("#price_type").val('By Travellers');
              $(".adults").html(response.adulttxt);
              $(".child").html(response.chlidtxt);

              $("#stay").val(response.stay);
              $(".roomquantity").html(response.quantity);
              $(".bookrslt").removeClass("alert-danger");
              $(".bookrslt").html("");
              var roomtotalprice = 0;
              $("#totalroomprice").val(roomtotalprice);
              $("#roomtitle").val(response.roomtitle);
              $("#roomcurr").val(response.currency);

              add_to_right_div(response.roomtitle,0,response.currency);
          }
     }else{
       $(".bookrslt").addClass("alert-danger");
       $(".bookrslt").html("Room is Booked");
       $(".roomquantity").html("");
       $("#roomtotal").val(0);
     }
      $("#tr_roomamount").fadeIn("slow");
      $(".paytype").fadeIn("slow");

      roomcalculations();

     }


 });



 }


}


function bytravellers(valueSelected,price){
    var b2c = $("#b2c_markup").val();
    var taxhotel = $("#taxhotel").val();
    var stay = $("#stay").val();
    var adultprice = price;
    var rquantity = $(".roomquantity").val();
    var roomtotal = stay * adultprice * rquantity * valueSelected;
    var b2c_p = ((roomtotal / 100) * b2c);
    var taxhotel_p = ((roomtotal / 100) * taxhotel);
    var roomtotalprice = (roomtotal + b2c_p + taxhotel_p);
    $("#totalroomprice").val(roomtotalprice);
    $("#totaltopay").val(parseFloat(roomtotalprice));
    var roomtitle = $("#roomtitle").val();
    var roomcurr = $("#roomcurr").val();
    var calclilds = $("#childpricecal").val();
    var calclild = parseInt(calclilds);
    var totalprice = (roomtotalprice+calclild);
    add_to_right_div(roomtitle,roomtotalprice,roomcurr);
    $("#topaytotal").html(roomcurr+totalprice);
    $("#totaltopay").val(parseFloat(totalprice));
    $("#grandtotal").html(roomcurr+totalprice);
    $("#summaryroomtotal").html(roomtotalprice);
    $("#adultpricecal").val(roomtotalprice);

}

 function bytravellerschlid(valueSelected,price){
     var b2c = $("#b2c_markup").val();
     var taxhotel = $("#taxhotel").val();
     var stay = $("#stay").val();
     var adultprice = price;
     var rquantity = $(".roomquantity").val();
     var roomtotal = stay * adultprice * rquantity * valueSelected;
     var b2c_p = ((roomtotal / 100) * b2c);
     var taxhotel_p = ((roomtotal / 100) * taxhotel);
     var roomtotalprice = (roomtotal + b2c_p + taxhotel_p);
     $("#totalroomprice").val(roomtotalprice);
     $("#totaltopay").val(parseFloat(roomtotalprice));
     var roomtitle = $("#roomtitle").val();
     var roomcurr = $("#roomcurr").val();
     var caladults = $("#adultpricecal").val();
     var calclild = parseInt(caladults);
     var totalprice = (roomtotalprice+calclild);
     add_to_right_div(roomtitle,roomtotalprice,roomcurr);
     $("#topaytotal").html(roomcurr+totalprice);
     $("#totaltopay").val(parseFloat(totalprice));
     $("#grandtotal").html(roomcurr+totalprice);
     $("#summaryroomtotal").html(roomtotalprice);
     $("#childpricecal").val(roomtotalprice);

 }
//Adults Travellers show
 $('#adultscount').change(function () {
     $(".traveller").remove();
     var valueSelected = this.value;

     //By Travellers Price Set
     var pricetyep = $("#price_type").val();
     if(pricetyep == "By Travellers") {
         var adultprice = $("#adultprice").val();
         bytravellers(valueSelected,adultprice);
     }
     if (valueSelected != 0) {
        for (var n = 0; n < valueSelected; n++) {
        // APEND ELEMENT
        var element = '<div class="form-group traveller"> <label class="col-md-3 control-label">Guest_'+n+'</span></label> <div class="col-md-9"> <div class="row"> <div class="col-md-2"> <select class="form-control" name="user_type_'+n+'"><option value="Adult">Adult</option></select> </div> <div class="col-md-2"><select class="form-control" name="adult_type_'+n+'"> <option value="mr">Mr</option><option value="miss">Miss</option><option value="mrs">Mrs</option></select></div><div class="col-md-4"> <input placeholder="First Name" class="form-control" name="first_name_traveller_'+n+'"></div><div class="col-md-4"><input placeholder="Last Name" class="form-control" name="last_name_traveller_'+n+'"></div></div></div></div>';
        $(".append").append(element);
     }
 }else{
         $(".traveller").remove();
     }
 });
 //Children Travellers show
 $('#childcount').change(function () {
     $(".travellerchild").remove();
     var valueSelected = this.value;
     //By Travellers Price Set
     var pricetyep = $("#price_type").val();
     if(pricetyep == "By Travellers") {
         var childprice = $("#childprice").val();
         bytravellerschlid(valueSelected,childprice);
     }
     if (valueSelected != 0) {
         for (var n = 0; n < valueSelected; n++) {
             // APEND ELEMENT
             var chlidelement ='<div class="form-group travellerchild"><label class="col-md-3 control-label">Chlid_'+n+'</label><div class="col-md-9"><div class="row"> <div class="col-md-2"> <select class="form-control" name="user_type_chlid_'+n+'"><option value="mr">Child</option></select></div><div class="col-md-2"> <input placeholder="Age" class="form-control" name="child_age_'+n+'"> </div> <div class="col-md-4"><input placeholder="First Name" class="form-control" name="first_name_traveller_chlid_'+n+'"></div> <div class="col-md-4"><input placeholder="Last Name" class="form-control" name="last_name_traveller_chlid_'+n+'"></div></div></div></div>';
             $(".append").append(chlidelement);
         }
     }else{
         $(".travellerchild").remove();
     }
 });
function roomcalculations(){

 var roomscount = $(".roomquantity").val();
 var totalroomprice =  $("#totalroomprice").val();
 var itemid =  $( ".hrooms option:selected" ).val();

 var price =  $("#roomtotal").val();
 $("#totalroomamount").val(totalroomprice);
 $("#subitem").val(itemid+"_"+price+"_"+roomscount);
       var commissiontype = $("#commission").attr('class');
      var commissionvalue = parseFloat($("#commission").val());
      var taxtype = $("#tax").attr('class');
      var taxvalue = parseFloat($("#tax").val());
     var tra = parseFloat($("#totalroomamount").val()) +  parseFloat($("#totalsupamount").val());


      if(taxtype == 'fixed'){
      $("#taxamount").val(taxvalue);
      $("#displaytax").html(currency+taxvalue);
      }else{
      var taxper = parseFloat(tra) * parseFloat(taxvalue)/100;
      $("#taxamount").val(taxper);
      $("#displaytax").html(currency+taxper); }
      var totalaftertax = parseFloat($("#taxamount").val()) + tra;

        var paymetodfee = parseFloat($(".hotelspaymethod option:selected").data('fee')) || 0;
       var payfeeamount = parseFloat(tra) * parseFloat(paymetodfee)/100;
        var totalafterpaytax =  parseFloat(parseFloat(payfeeamount) + totalaftertax).toFixed(2);
      if(commissiontype == 'percentage'){
      var totaldeposit = parseFloat(totalafterpaytax) * parseFloat(commissionvalue)/100;
      $("#topaytotal").html(currency+totaldeposit);
      $("#totaltopay").val(parseFloat(totaldeposit));
      }else{
      $("#topaytotal").html(currency+commissionvalue);
      $("#totaltopay").val(parseFloat(commissionvalue)); }
      $("#grandtotal").html(currency+totalafterpaytax);
      $("#summaryroomtotal").html($("#totalroomprice").val());
       $("#pmethod").html(currency+payfeeamount);
      $("#paymethodfee").val(payfeeamount);
      $("#alltotals").val(totalafterpaytax);

}



// car calculations
function carcalculations(){


 var totalcarprice =  $("#totalcarprice").val();


$("#totalcaramount").val(totalcarprice);
       var commissiontype = $("#commission").attr('class');
      var commissionvalue = parseFloat($("#commission").val());
      var taxtype = $("#tax").attr('class');
      var taxvalue = parseFloat($("#tax").val());
     var tca = parseFloat($("#totalcaramount").val()) +  parseFloat($("#totalsupamount").val());


      if(taxtype == 'fixed'){
      $("#taxamount").val(taxvalue);
      $("#displaytax").html(currency+taxvalue);
      }else{
      var taxper = parseFloat(tca) * parseFloat(taxvalue)/100;
      $("#taxamount").val(taxper);
      $("#displaytax").html(currency+taxper); }
      var totalaftertax = parseFloat($("#taxamount").val()) + tca;

        var paymetodfee = parseFloat($(".tourspaymethod option:selected").data('fee')) || 0;
       var payfeeamount = parseFloat(tca) * parseFloat(paymetodfee)/100;
        var totalafterpaytax =  parseFloat(parseFloat(payfeeamount) + totalaftertax).toFixed(2);
      if(commissiontype == 'percentage'){

      var totaldeposit = parseFloat(totalafterpaytax) * parseFloat(commissionvalue)/100;
      $("#topaytotal").html(currency+totaldeposit);
      $("#totaltopay").val(parseFloat(totaldeposit));

      }else{

      $("#topaytotal").html(currency+commissionvalue);
      $("#totaltopay").val(parseFloat(commissionvalue)); 
    }
      $("#grandtotal").html(currency+totalafterpaytax);
      $("#summarycartotal").html($("#totalcarprice").val());
       $("#pmethod").html(currency+payfeeamount);
      $("#paymethodfee").val(payfeeamount);

      $("#alltotals").val(totalafterpaytax);

}


$("#cartotal").change(function(){
var rquantity = $(".roomquantity").val();
var stay = $("#stay").val();
var price = $(this).val();
 var cartotalprice = stay * price;
 $("#subitem").val(price);
 $("#totalcarprice").val(cartotalprice);
 $("#summarycartotal").html(cartotalprice);
 $("#itempricesum").html(currency+price);

  carcalculations();

});

function getSupps(id, module){

if(module == "hotels"){
$.post(baseURL+"/quickbooking/hotelsupps", {hotelid: id}, function(theResponse){
      var response = jQuery.parseJSON(theResponse);

      if(response.hassups > 0){
       $(".supdiv").fadeIn();
        $(".suppcontent").html(response.extras);

      }else{

         $(".supdiv").fadeOut("slow");
      }

 });

}else if(module == "tours"){

  $.post(baseURL+"/quickbooking/toursupps", {tourid: id}, function(theResponse){
      var response = jQuery.parseJSON(theResponse);

      if(response.hassups > 0){
        $(".supdiv").fadeIn();
        $(".suppcontent").html(response.extras);

      }else{

         $(".supdiv").fadeOut("slow");
      }

 });

}else if(module == "cars"){

  $.post(baseURL+"/quickbooking/carsupps", {carid: id}, function(theResponse){
      var response = jQuery.parseJSON(theResponse);

      if(response.hassups > 0){
        $(".supdiv").fadeIn();
        $(".suppcontent").html(response.extras);

      }else{

         $(".supdiv").fadeOut("slow");
      }

 });

}

}

      function populateRooms(hotelid){

        $.post(baseURL+"/quickbooking/populateRooms", {hotelid: hotelid}, function(theResponse){


        $("#poprooms").html(theResponse).select2({
        width:'100%',
        maximumSelectionSize: 1
        }); });

        }
      // get cars prices
     function carsprice(item){

      $.post(baseURL+"/quickbooking/carprice", {carid: item}, function(theResponse){

var response = jQuery.parseJSON(theResponse);


      $("#itemtitle").val(response.title);
      $("#subitem").val(response.subitem);
      $("#cin").val(response.startdate);
      $("#cout").val(response.enddate);
      $(".paytype").fadeIn("slow");
      $("#itemid").val(response.id);
      $("#totalcarprice").val(response.mainprice);
      $("#cartotal").val(response.mainprice);
      $("#itemtitlesum").text(response.title);
      $("#btype").val(response.btype);
      $("#commission").val(response.comm_val);
      $("#commission").removeClass();
      $("#commission").addClass(response.comm_type);
      $("#comtype").val(response.comm_type);
      if(apptax == "yes"){

      $("#tax").val(response.tax_val);
      $("#tax").removeClass();
      $("#tax").addClass(response.tax_type);
      }

    $("#tr_caramount").fadeIn("slow");
    getSupps(item, "cars");
    carcalculations();
    $("#totalsupamount").val("0");
 $("[type=checkbox]" ).prop("checked",false);
 $(".sidesups").remove();
 console.log(response);


 });


}



// Tour calculations
function tourcalculations(){


 var totaltourprice =  $("#totaltourprice").val();

$("#totaltouramount").val(totaltourprice);
 //$("#subitem").val(itemid+"_"+price+"_"+roomscount);
       var commissiontype = $("#commission").attr('class');
      var commissionvalue = parseFloat($("#commission").val());
      var taxtype = $("#tax").attr('class');
      var taxvalue = parseFloat($("#tax").val());
     var tca = parseFloat($("#totaltouramount").val()) +  parseFloat($("#totalsupamount").val());


      if(taxtype == 'fixed'){
      $("#taxamount").val(taxvalue);
      $("#displaytax").html(currency+taxvalue);
      }else{
      var taxper = parseFloat(tca) * parseFloat(taxvalue)/100;
      $("#taxamount").val(taxper);
      $("#displaytax").html(currency+taxper); }
      var totalaftertax = parseFloat($("#taxamount").val()) + tca;

        var paymetodfee = parseFloat($(".tourspaymethod option:selected").data('fee')) || 0;
       var payfeeamount = parseFloat(tca) * parseFloat(paymetodfee)/100;
        var totalafterpaytax =  parseFloat(parseFloat(payfeeamount) + totalaftertax).toFixed(2);
      if(commissiontype == 'percentage'){
      var totaldeposit = parseFloat(totalafterpaytax) * parseFloat(commissionvalue)/100;
      $("#topaytotal").html(currency+totaldeposit);
      $("#totaltopay").val(parseFloat(totaldeposit));
      }else{
      $("#topaytotal").html(currency+commissionvalue);
      $("#totaltopay").val(parseFloat(commissionvalue)); }
      $("#grandtotal").html(currency+totalafterpaytax);
      $("#summarytourtotal").html($("#totaltourprice").val());
       $("#pmethod").html(currency+payfeeamount);
      $("#paymethodfee").val(payfeeamount);

      $("#alltotals").val(totalafterpaytax);

}
 // get tours prices
     function toursprice(item){

$.post(baseURL+"/quickbooking/tourprice", {tourid: item}, function(theResponse){

var response = jQuery.parseJSON(theResponse);


      $("#itemtitle").val(response.title);
      $("#subitem").val(response.subitem);
      $("#cin").val(response.startdate);
      $("#cout").val(response.enddate);
      $("#priceadult").val(response.priceadult);
      $("#pricechild").val(response.pricechild);
      $("#priceinfant").val(response.priceinfant);
      $(".paytype").fadeIn("slow");
      $("#itemid").val(response.id);
      $("#totaltourprice").val(response.mainprice);
      $("#tourtotal").val(response.mainprice);
      $("#itemtitlesum").text(response.title);
      $("#btype").val(response.btype);
      $("#tourtype").val(response.ttype);
      $("#commission").val(response.comm_val);
      $("#commission").removeClass();
      $("#commission").addClass(response.comm_type);
      $("#comtype").val(response.comm_type);
      if(apptax == "yes"){
      $("#tax").val(response.tax_val);
      $("#tax").removeClass();
      $("#tax").addClass(response.tax_type);
      }
        $("#adults").html(response.adultselect);
        $(".adults").fadeIn("slow");

         /*if(response.ttype == "individual"){

          $(".checkinlabel").fadeIn("slow");
          $(".dpd1").prop("required","required");

        }else{
            $(".checkinlabel").fadeOut("fast");
            $(".dpd1").prop("required","");
        }*/

        if(response.maxchild > 0){
          $("#children").html(response.childselect);
          $(".child").fadeIn("slow");
        }
        if(response.maxinfant > 0){
          $("#infants").html(response.infantselect);
          $(".infants").fadeIn("slow");
        }
         $("#tr_touramount").fadeIn("slow");
    getSupps(item, "tours");
    tourcalculations();
    $("#totalsupamount").val("0");
 $("[type=checkbox]" ).prop("checked",false);
 $(".sidesups").remove();


 });



}

        var newsupPrice = parseFloat($("#totalsupamount").val());
function select_sup(price,title,supid,currency){

 var commissiontype = $("#commission").attr('class');
      var commissionvalue = parseFloat($("#commission").val());
      var taxtype = $("#tax").attr('class');
      var taxvalue = parseFloat($("#tax").val());

        if(newsupPrice < 0){
          newsupPrice = 0;
        }
     var countsupp=  $('tr[id^=supp_'+supid+']').length;


      if(countsupp < 1){

        add_sup_to_right_div(supid,title,price,currency);
      }

       if(!$("#extras_"+supid).prop('checked')){
      $('.summary').find('#supp_'+supid).remove();
         newsupPrice -= price;
      }else{
          newsupPrice += price;
      }



  $("#totalsupamount").val(newsupPrice);

       var trs =  parseFloat($("#totalroomamount").val()) +  parseFloat($("#totalsupamount").val());
            if(taxtype == 'fixed'){

          $("#taxamount").val(taxvalue);
           $("#displaytax").html(currency+taxvalue);
         }else{
          var taxper = parseFloat(parseFloat(trs) * parseFloat(taxvalue)/100).toFixed(2);

          $("#taxamount").val(taxper);
         $("#displaytax").html(currency+taxper);
         }

    var totalaftertax = parseFloat($("#taxamount").val()) + trs;
        var paymetodfee = parseFloat($(".hotelspaymethod option:selected").data('fee')) || 0;
       var payfeeamount = parseFloat(trs) * parseFloat(paymetodfee)/100;

       var totalafterpaytax =  parseFloat(parseFloat(payfeeamount) + totalaftertax).toFixed(2);

     if(commissiontype == 'percentage'){

        var totaldeposit = parseFloat(totalafterpaytax) * parseFloat(commissionvalue)/100;


      $("#topaytotal").html(currency+parseFloat(totaldeposit).toFixed(2));

      $("#totaltopay").val(parseFloat(totaldeposit).toFixed(2));

        }else{

         commissionvalue = parseFloat($("#commission").val()).toFixed(2);

       $("#topaytotal").html(currency+commissionvalue);

       $("#totaltopay").val(parseFloat(commissionvalue).toFixed(2));

        }


        $("#grandtotal").html(currency+totalafterpaytax);
        $("#pmethod").html(currency+payfeeamount);
      $("#paymethodfee").val(payfeeamount);
       $("#alltotals").val(totalafterpaytax);

}


      $(".hotelspaymethod").on('change',function(){
          var id = $(this).prop('id');
          var sign = $("#currencysign").val();
          var commissionvalue = parseFloat($("#commission").val()).toFixed(2);
          var commissiontype = $("#commission").attr('class');
       var fee = parseFloat($(".hotelspaymethod option:selected").data('fee')) || 0;
       var total =  parseFloat($("#totalroomamount").val()) +  parseFloat($("#totalsupamount").val());
       var totalfee = parseFloat(total) * parseFloat(fee)/100;
          $("#methodname").val($(this).val());


      $("#pmethod").html(sign+totalfee);
      $("#paymethodfee").val(totalfee);
  var paymethodfees =  parseFloat($("#paymethodfee").val());
        var grand = $("#displaytax").text();
        var arr = grand.split(sign);
        var totall = parseFloat(total + totalfee + parseFloat(arr[1])).toFixed(2);

       if(commissiontype == 'percentage'){


            var totaldeposit = totall * parseFloat(commissionvalue)/100;

          $("#topaytotal").html(sign+parseFloat(totaldeposit).toFixed(2));

          $("#totaltopay").val(parseFloat(totaldeposit).toFixed(2));

        }

         $("#grandtotal").html(sign+totall);
           $("#alltotals").val(totall);

     });


     //cars paymethod change
      $(".carspaymethod").on('change',function(){
          var id = $(this).prop('id');
          var sign = $("#currencysign").val();
          var commissionvalue = parseFloat($("#commission").val()).toFixed(2);
          var commissiontype = $("#commission").attr('class');
       var fee = parseFloat($(".carspaymethod option:selected").data('fee')) || 0;
       var total =  parseFloat($("#totalcaramount").val());
       var totalfee = parseFloat(total) * parseFloat(fee)/100;
          $("#methodname").val($(this).val());


      $("#pmethod").html(sign+totalfee);
      $("#paymethodfee").val(totalfee);
  var paymethodfees =  parseFloat($("#paymethodfee").val());
        var grand = $("#displaytax").text();
        var arr = grand.split(sign);
        var totall = parseFloat(total + totalfee + parseFloat(arr[1])).toFixed(2);

       if(commissiontype == 'percentage'){


            var totaldeposit = totall * parseFloat(commissionvalue)/100;

          $("#topaytotal").html(sign+parseFloat(totaldeposit).toFixed(2));

          $("#totaltopay").val(parseFloat(totaldeposit).toFixed(2));

        }

         $("#grandtotal").html(sign+totall);
           $("#alltotals").val(totall);

     });

      //tours paymethod change
      $(".tourspaymethod").on('change',function(){
          var id = $(this).prop('id');
          var sign = $("#currencysign").val();
          var commissionvalue = parseFloat($("#commission").val()).toFixed(2);
          var commissiontype = $("#commission").attr('class');
       var fee = parseFloat($(".tourspaymethod option:selected").data('fee')) || 0;
       var total =  parseFloat($("#totaltouramount").val());
       var totalfee = parseFloat(total) * parseFloat(fee)/100;
          $("#methodname").val($(this).val());


      $("#pmethod").html(sign+totalfee);
      $("#paymethodfee").val(totalfee);
  var paymethodfees =  parseFloat($("#paymethodfee").val());
        var grand = $("#displaytax").text();
        var arr = grand.split(sign);
        var totall = parseFloat(total + totalfee + parseFloat(arr[1])).toFixed(2);

       if(commissiontype == 'percentage'){


            var totaldeposit = totall * parseFloat(commissionvalue)/100;

          $("#topaytotal").html(sign+parseFloat(totaldeposit).toFixed(2));

          $("#totaltopay").val(parseFloat(totaldeposit).toFixed(2));

        }

         $("#grandtotal").html(sign+totall);
           $("#alltotals").val(totall);

     });



function add_to_right_div(title,price,currency,quantity){
   $('.summary').find('.selected_room').remove();
   $(".summary").append("<tr style='background-color:#ffffdf' class='selected_room'><td><b>"+title+"</b></td> <td> <strong>"+currency+"<span id='selected_price'>"+price+"</span></strong> x <span id='selected_quantity'>1</span> </td></tr>");


}

function add_sup_to_right_div(id,title,price,currency){
     var supidd = 'supp_'+id;

  $(".summary").append("<tr style='background-color:#ffffdf' class='sidesups' id="+supidd+"><td><b>"+title+"</b></td> <td> <strong>"+currency+price+"</strong> </td></tr>");


}


function completebook(url,currency,msg){


   var paymethod = $("#methodname").val();
   var formname = $(".completebook").prop('name');
     var grand = $("#grandtotal").text();
     var arr = grand.split(currency);
    var allsum = parseFloat(arr[1]);
   $("#alltotals").val(allsum);

       if(paymethod == ""){
    $.alert.open('info', msg);
   return false;

   }



     $(".result").html("Please Wait....");
      $(".completebook").hide();
 $.post(url+"admin/ajaxcalls/process_booking_"+formname,$("#bookingdetails, #"+formname+"form").serialize(), function(response){

  if($.trim(response) == ""){
     $(".acc_section").hide();
     $(".sups_section").hide();
     $(".btn_section").hide();
     $(".final_section").fadeIn("slow");
  $(".result").html("");

  setTimeout(function () {
   window.location.replace(url+"invoice");
  }, 4000);


  }else{
   $(".result").html("<div class='alert alert-danger'>"+response+"</div>");
      $(".completebook").show();
  return false;

  }

  });



  }

  function totalnights(){
 var chkin = $(".dpd1").val();
 var chkout = $(".dpd2").val();

$.post(baseURL+"/quickbooking/totalnights", {checkin: chkin,checkout: chkout}, function(theResponse){
var response = jQuery.parseJSON(theResponse);
$("#stay").val(response.stay);

 });



}

$(".editdeposit").blur(function(){
 var deposit = $(this).val();
  $("#topaytotal").html(currency+deposit);

})

function select_TourExtra(price,title,supid,currency){

     var countsupp=  $('tr[id^=supp_'+supid+']').length;


      if(countsupp < 1){

        add_sup_to_right_div(supid,title,price,currency);
      }

       if(!$("#extras_"+supid).prop('checked')){
      $('.summary').find('#supp_'+supid).remove();
        
      }



$.post(baseURL+"/quickbooking/tourUpdatedPrice", $("#bookingform").serialize(), function(theResponse){

var response = jQuery.parseJSON(theResponse);

$("#totaltouramount").val(response.grandTotal);
  var tourTotal = parseFloat(response.grandTotal) - parseFloat(response.taxAmount);

       $("#displaytax").html(currency+response.taxAmount);
       $("#taxamount").val(response.taxAmount);
      
      $("#topaytotal").html(currency+response.depositAmount);
      $("#totaltopay").val(response.depositAmount); 
      $("#grandtotal").html(currency+response.grandTotal);
      $("#summarytourtotal").html(tourTotal);
      $("#totaltourprice").val(tourTotal);

      $("#alltotals").val(response.grandTotal);


      // $("#subitem").val(response.subitem);
      // $("#cin").val(response.startdate);
      //$("#priceadult").val(response.priceadult);
      //$("#pricechild").val(response.pricechild);
      //$("#priceinfant").val(response.priceinfant);
      // $("#totaltourprice").val(response.mainprice);
        $("#tourtotal").val(response.grandTotal);
     
      $("#commission").val(response.depositAmount);
      if(apptax == "yes"){

      $("#tax").val(response.taxAmount);
    //  $("#tax").removeClass();
     // $("#tax").addClass(response.tax_type);

      }
console.log(response);    



 });

 
}


function select_CarExtra(price,title,supid,currency){

     var countsupp=  $('tr[id^=supp_'+supid+']').length;


      if(countsupp < 1){

        add_sup_to_right_div(supid,title,price,currency);
      }

       if(!$("#extras_"+supid).prop('checked')){
      $('.summary').find('#supp_'+supid).remove();
        
      }



$.post(baseURL+"/quickbooking/carUpdatedPrice", $("#bookingform").serialize(), function(theResponse){

var response = jQuery.parseJSON(theResponse);

$("#totalcaramount").val(response.grandTotal);
  var tourTotal = parseFloat(response.grandTotal) - parseFloat(response.taxAmount);

       $("#displaytax").html(currency+response.taxAmount);
       $("#taxamount").val(response.taxAmount);
      
      $("#topaytotal").html(currency+response.depositAmount);
      $("#totaltopay").val(response.depositAmount); 
      $("#grandtotal").html(currency+response.grandTotal);
      $("#summarytourtotal").html(tourTotal);
      $("#totalcarprice").val(tourTotal);

      $("#alltotals").val(response.grandTotal);


      // $("#subitem").val(response.subitem);
      // $("#cin").val(response.startdate);
      //$("#priceadult").val(response.priceadult);
      //$("#pricechild").val(response.pricechild);
      //$("#priceinfant").val(response.priceinfant);
      // $("#totaltourprice").val(response.mainprice);
        $("#tourtotal").val(response.grandTotal);
     
      $("#commission").val(response.depositAmount);
      if(apptax == "yes"){

      $("#tax").val(response.taxAmount);
    //  $("#tax").removeClass();
     // $("#tax").addClass(response.tax_type);

      }
console.log(response);    



 });

 
}