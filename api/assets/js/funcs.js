$(function(){
 

  $(".makeDefault").on('click',function(){
  var id = $(this).attr('id');
  var baseurl =  $(this).data('url');
  var answer = confirm("Are you sure you want it Default?");
  if (answer){
     $.post(baseurl, { id: id }, function(theResponse){
          location.reload();
			});
  }

  });




})


function fstar(url,ft,id){
  
   $.post(url, { isfeatured: ft, id: id }, function(theResponse){ 
    if(theResponse == "done"){

      if(ft == "no"){
     $("#"+id).removeClass('fa-star');
     $("#"+id).addClass('fa-star-o');
  }else{
     $("#"+id).removeClass('fa-star-o');
     $("#"+id).addClass('fa-star');
  }

  showNotify();
    }

    });

}

function updateDiscount(order,id,olderval){

    var url = $("#discount_"+id).data('url');
    console.log(url);
    var module_name = $("#discount_"+id).data('module');
    if(order != olderval){
        $.post(url, { order: order,id: id,module:module_name }, function(theResponse){
            if(theResponse == '1'){
                showNotify();
            }else{
                alert('Invalid Discount');
                $("#discount"+id).val(olderval);
            }
        });
    }
}

 function updateOrder(order,id,olderval){
   var url = $("#order_"+id).data('url');   

    if(order != olderval){
     $.post(url, { order: order,id: id }, function(theResponse){
        if(theResponse == '1'){
            showNotify();
        }else{
        alert('Invalid Order');
        $("#order_"+id).val(olderval);
   }

  	});
  }
  }
  
  function updateStatusComission(url,key) {
      var r = confirm("Are you sure you want to mark this transaction paid?");
      if (r == true) {

          $.post(url, { primary_key: key }, function(theResponse){
              if(theResponse == '1'){
                  showNotify();
                  $(this).toggleClass('is-active');
                  location.reload();
              }else{
                  alert('Invalid Discount');
                  $("#discount"+id).val(olderval);
              }
          });
      } else {
          txt = "You pressed Cancel!";
      }

  }

  function showNotify(){
    new PNotify({
    title: 'Changes Saved!',
    type: 'info',
    animation: 'fade',
    });
    }

  function getReviewScore(score){

var sum = 0;
var avg = 0;

$('option:selected').each(function() {
  val = $(this).val(); console.log(val);
  if(val != "No" && val != "Yes"){
sum += parseInt(val);

  }
 //console.log(sum);
});
avg = sum/5;

$("#overall").val(avg);
  }

function delfunc(id,baseurl){

  var answer = confirm("Are you sure you want to delete?");
  if (answer){
     $.post(baseurl, { id: id }, function(theResponse){
                 location.reload();
      });

  }else{
    location.reload();
     return false;
  }
 
  
  }


function multiDelfunc(url,chkclass){
var checkedValues = $('.'+chkclass+':checked').map(function() {
    return this.value;
}).get();

if(checkedValues.length < 1){
  alert("Please select atleast one.");

}else{

   var answer = confirm("Are you sure you want to delete?");
   if (answer){
     $.post(url, { items: checkedValues }, function(theResponse){
      window.location = window.location.href;
      });

  }else{

    window.location = window.location.href;
     return false;
  }
  
}

 
}


function approvefunc(id,baseurl){

  var answer = confirm("Are you sure you want to proceed with this action?");
  if (answer){
     $.post(baseurl, { id: id }, function(theResponse){
                 location.reload();
      });

  }else{
    location.reload();
    return false;
  }
  
  
  }

  function hideBooking(id,baseurl){ 

     $.post(baseurl, { id: id }, function(theResponse){
               
      });
     $("#"+id).fadeOut("slow");

  
  }