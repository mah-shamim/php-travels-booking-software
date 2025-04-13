var grandtotal = 0;
var newsupPrice = 0;
$(function() {
  $("#guesttab").on("click", function() {
    $(".completebook").prop("name", "guest");
  });

  $("#signintab").on("click", function() {
    $(".completebook").prop("name", "login");
  });

  $("#signuptab").on("click", function() {
    $(".completebook").prop("name", "signup");
  });
});
function select_tour_sup(price, title, supid, currency) {
  var commissiontype = $("#commission").attr("class");
  var commissionvalue = parseFloat($("#commission").val());
  var taxtype = $("#tax").attr("class");
  var taxvalue = parseFloat($("#tax").val());

  if (newsupPrice < 0) {
    newsupPrice = 0;
  }
  var countsupp = $("div[id^=supp_" + supid + "]").length;
  if (countsupp < 1) {
    add_sup_to_right_div(supid, title, price, currency);
  }

  if (!$("#supplements_" + supid).prop("checked")) {
    $(".rightpanel")
      .find("#supp_" + supid)
      .remove();
    newsupPrice -= price;
  } else {
    newsupPrice += price;
  }

  $("#totalsupamount").val(newsupPrice);

  var tts =
    parseFloat($("#totaltouramount").val()) +
    parseFloat($("#totalsupamount").val());
  if (taxtype == "fixed") {
    $("#taxamount").val(taxvalue);
    $("#displaytax").html(currency + taxvalue);
  } else {
    var taxper = parseFloat(
      (parseFloat(tts) * parseFloat(taxvalue)) / 100
    ).toFixed(2);

    $("#taxamount").val(taxper);
    $("#displaytax").html(currency + taxper);
  }

  var totalaftertax = parseFloat($("#taxamount").val()) + tts;
  var paymetodfee =
    parseFloat($(".paymethod option:selected").data("fee")) || 0;
  var payfeeamount = (parseFloat(tts) * parseFloat(paymetodfee)) / 100;

  var totalafterpaytax = parseFloat(
    parseFloat(payfeeamount) + totalaftertax
  ).toFixed(2);

  if (commissiontype == "percentage") {
    var totaldeposit =
      (parseFloat(totalafterpaytax) * parseFloat(commissionvalue)) / 100;

    $("#topaytotal").html(currency + parseFloat(totaldeposit).toFixed(2));

    $("#totaltopay").val(parseFloat(totaldeposit).toFixed(2));
  } else {
    commissionvalue = parseFloat($("#commission").val()).toFixed(2);

    $("#topaytotal").html(currency + commissionvalue);

    $("#totaltopay").val(parseFloat(commissionvalue).toFixed(2));
  }

  $("#grandtotal").html(currency + totalafterpaytax);
  $("#paymethodfee").val(payfeeamount);
}

function completebook(url, msg) {
  var formname = $(".completebook").prop("name");

  $("html, body").animate(
    {
      scrollTop: $("body").offset().top - 100
    },
    "slow"
  );
  $(".completebook").fadeOut("fast");
  $("#waiting").html("Please Wait...");

  $.post(
    url + "admin/ajaxcalls/processBooking" + formname,
    $("#bookingdetails, #" + formname + "form").serialize(),
    function(response) {
      var resp = $.parseJSON(response);
      if (resp.error == "yes") {
        $(".result").html(
          "<div class='alert alert-danger'>" + resp.msg + "</div>"
        );
        $("#HotelsLoad").removeClass("load");
        $("#HotelsLoad").addClass("notload");
        $(".completebook").fadeIn("fast");
        $("#waiting").html("");
      } else {
        $("#HotelsLoad").addClass("load");

        $(".bdetails").addClass("complete");
        $(".bdetails").removeClass("active");
        $(".bsuccess").removeClass("disabled");
        $(".bsuccess").addClass("active");
        $(".bsuccess").addClass("complete");
        $(".acc_section").hide();
        $(".extrasection").hide();
        $(".final_section").fadeIn("fast");
        $(".result").html("");

        setTimeout(function() {
          window.location.replace(resp.url);
        }, 2000);
      }
    }
  );
}

function updateBookingData(url) {
  //var formname = $(".completebook").prop('name');
  $.post(url, $("#bookingdetails").serialize(), function(response) {
    var resp = $.parseJSON(response);

    $("#displaytotal").html(resp.grandTotal);
    $("#displaytax").html(resp.taxAmount);
    $("#displaydeposit").html(resp.depositAmount);
    $("#displaypmethod").html(resp.paymethodFee);
    $(".allextras").remove();
    $(".summary-price-list").prepend(resp.extrashtml);
    console.log(resp);
  });
}
