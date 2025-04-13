<script src="<?php echo $theme_url; ?>assets/js/scripts.js"></script>
<script>
    const cookyDisablePeriodInDays = 100;

    function createCookie(cookieName, cookieValue, daysToExpire) {
        var date = new Date();
        date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
        document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString();
    }

    function accessCookie(cookieName) {
        var name = cookieName + "=";
        var allCookieArray = document.cookie.split(';');
        for (var i = 0; i < allCookieArray.length; i++) {
            var temp = allCookieArray[i].trim();
            if (temp.indexOf(name) == 0)
                return temp.substring(name.length, temp.length);
        }
        return "";
    }

    // If user accept cooky policy by clicking `Got It` button then do not show the button to the user.
    const cookyGotItStatus = accessCookie("cookyGotItButton");
    if (cookyGotItStatus != "" && cookyGotItStatus == "hide") {
        $("#cookyGotItBtnBox").css("display", "none");
    } else {
        setTimeout(function () {
            console.log('show');
            $("#cookyGotItBtnBox").css("display", "flex");
        }, 1000);
    }
    $("#cookyGotItBtn").click(function () {
        createCookie("cookyGotItButton", "hide", cookyDisablePeriodInDays);
        $("#cookyGotItBtnBox").css("display", "none");
    });

    // Travelport flight: start
    // First, checks if it isn't implemented yet.
    if (!String.prototype.format) {
        String.prototype.format = function () {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function (match, number) {
                return typeof args[number] != 'undefined'
                    ? args[number]
                    : match
                    ;
            });
        };
    }
    $(function () {
        var adult = parseInt($("[name='tadult']").val()); // Should be 1
        var children = parseInt($("[name='tchildren']").val());
        var infant = parseInt($("[name='tinfant']").val());
        var totalPassenger = (adult + children + infant);
        var triptype = 'oneway';
        var arrivalDatetimePicker = $("[name='arrival']");
        arrivalDatetimePicker.attr('disabled', 'disabled').css('background', '#d9d9d9');
        $(".trip-check label, .iCheck-helper").on('click', function () {
            triptype = $(this).parent().find("input").val();
            if (triptype == 'oneway') {
                arrivalDatetimePicker.attr('disabled', 'disabled').css('background', '#d9d9d9');
                arrivalDatetimePicker.removeAttr('required');
            } else {
                arrivalDatetimePicker.removeAttr('disabled').css('background', '#F9F9F9');
                arrivalDatetimePicker.attr('required', 'required');
            }
            arrivalDatetimePicker.val('');
        });

        $(".widget-select2").select2({
            placeholder: "Enter Location",
            minimumInputLength: 3,
            width: '100%',
            maximumSelectionSize: 1,
            ajax: {
                url: '<?php echo base_url('Suggestions/airports/tport'); ?>',
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term
                    }
                },
                results: function (data, page) {
                    return {
                        results: data
                    }
                }
            },
            initSelection: function (element, callback) {
                var elementText = $(element).val();
                callback({"text": elementText, "id": elementText});
            }
        });


        //KiwiTaxi Ajax
        $(".ktaxi-select2").select2({
            placeholder: "Enter Taxi Location",
            minimumInputLength: 3,
            width: '100%',
            maximumSelectionSize: 1,
            ajax: {
                url: '<?php echo base_url('ktaxi/kawitaxiloaction'); ?>',
                dataType: 'json',
                data: function (term, page) {
                    return {
                        query: term
                    }
                },
                results: function (data, page) {
                    return {
                        results: data
                    }
                }
            },
            initSelection: function (element, callback) {
                callback({id: 1, text: 'initSelection test'});
            }
        });

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        // Depature time
        var departureTime = $('.departureTime').datepicker({
            format: 'yyyy-mm-dd',
            onRender: function (date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (e) {
            $(this).datepicker('hide');
            if (triptype == 'round' || triptype == 'return') {
                var newDate = new Date(e.date);
                arrivalTime.setValue(newDate.setDate(newDate.getDate() + 1));
                $('.arrivalTime').focus();
            }
        }).data('datepicker');

        //  Arrival time
        var arrivalTime = $('.arrivalTime').datepicker({
            format: 'yyyy-mm-dd',
            onRender: function (date) {
                return date.valueOf() <= departureTime.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function () {
            $(this).datepicker('hide');
        }).data('datepicker');

        // Default fill up date
        if ($('.departureTime').length > 0) {
            if (departureTime.element.val()) {
                departureTime.setValue(departureTime.element.val());
            }
        }
        if ($('.arrivalTime').length > 0) {
            if (arrivalTime.element.val()) {
                arrivalTime.setValue(arrivalTime.element.val());
            }
        }

        $("[name='tadult']").on('change', function () {
            adult = parseInt($("[name='tadult']").val());
        });
        $("[name='tchildren']").on('change', function () {
            children = parseInt($("[name='tchildren']").val());
        });
        $("[name='tinfant']").on('change', function () {
            infant = parseInt($("[name='tinfant']").val());
        });
        $("#tsumPassenger").on('click', function () {
            totalPassenger = (adult + children + infant);
            $("[name='ttotalPassenger']").val(totalPassenger);
        });

        $("form[name='flightSearch']").on('submit', function (e) {
            e.preventDefault();
            var payload = {
                triptype: triptype,
                cabinclass: $('[name="cabinclass"]').val(),
                passenger: {
                    total: totalPassenger,
                    adult: adult,
                    children: children,
                    infant: infant
                },
                origin: $(this).find("[name='origin']").val(),
                destination: $(this).find("[name='destination']").val(),
                departure: $(this).find("[name='departure']").val(),
                arrival: $(this).find("[name='arrival']").val(),
            };

            $('.loader-wrapper').show();
            $.post(base_url + 'flight/getLowFareFlights', payload, function (response) {
                $('.loader-wrapper').hide();
                $('#body-section').html(response.body);
                window.history.pushState("", "", get_path('flight/search', payload));
            });
        });
    });

    function get_path(req, payload) {
        var return_hash = "{0}/{1}/{2}/{3}".format(req, payload.origin, payload.destination, payload.departure);

        if (payload.arrival) {
            return_hash = "{0}/{1}".format(return_hash, payload.arrival)
        }
        if (payload.cabinclass) {
            return_hash = "{0}/{1}".format(return_hash, payload.cabinclass)
        }
        if (payload.passenger.adult) {
            return_hash = "{0}/{1}Adult".format(return_hash, payload.passenger.adult)
        }
        if (payload.passenger.children) {
            return_hash = "{0}/{1}Children".format(return_hash, payload.passenger.children)
        }
        if (payload.passenger.infant) {
            return_hash = "{0}/{1}Infant".format(return_hash, payload.passenger.infant)
        }

        return base_url + return_hash;
    }

    // Travelport flight: end

    if (!String.prototype.format) {
        String.prototype.format = function () {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function (match, number) {
                return typeof args[number] != 'undefined'
                    ? args[number]
                    : match
                    ;
            });
        };
    }

    $(function () {

        var triptype = 'oneway';
        var manualtriptype = $('input[name=triptype]:checked').val();

        var arrivalDatetimePicker = $("[name='arrival']");
        arrivalDatetimePicker.attr('disabled', 'disabled').css('background', '#d9d9d9');
        $(".trip-check label, .iCheck-helper").on('click', function () {
            manualtriptype = $(this).parent().find("input").val();
            if (manualtriptype == 'oneway') {
                arrivalDatetimePicker.attr('disabled', 'disabled').css('background', '#d9d9d9');
                arrivalDatetimePicker.removeAttr('required');
            } else {
                arrivalDatetimePicker.removeAttr('disabled').css('background', '#F9F9F9');
                arrivalDatetimePicker.attr('required', 'required');
            }
            arrivalDatetimePicker.val('');
        });

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        // Depature time
        var departureTime = $('.departureTime').datepicker({
            format: 'yyyy-mm-dd',
            onRender: function (date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (e) {
            $(this).datepicker('hide');
            if (manualtriptype == 'round') {
                var newDate = new Date(e.date);
                arrivalTime.setValue(newDate.setDate(newDate.getDate() + 1));
                $('.arrivalTime').focus();
            }
        }).data('datepicker');

        // Arrival time
        var arrivalTime = $('.arrivalTime').datepicker({
            format: 'yyyy-mm-dd',
            onRender: function (date) {
                return date.valueOf() <= departureTime.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function () {
            $(this).datepicker('hide');
        }).data('datepicker');

        // Default fill up date
        if (departureTime != undefined) {
            if (departureTime.element.val()) {
                departureTime.setValue(departureTime.element.val());
            }
        }
        if (departureTime != undefined) {
            if (arrivalTime.element.val()) {
                arrivalTime.setValue(arrivalTime.element.val());
            }
        }
        var madult = parseInt($("[name='madult']").val()); // Should be 1
        var mchildren = parseInt($("[name='mchildren']").val());
        var minfant = parseInt($("[name='minfant']").val());
        var totalManualPassenger = (madult + mchildren + minfant);
        $("[name='madult']").on('change', function () {
            madult = parseInt($(this).val());
        });
        $("[name='mchildren']").on('change', function () {
            mchildren = parseInt($(this).val());
        });
        $("[name='minfant']").on('change', function () {
            minfant = parseInt($(this).val());
        });
        $("#sumManualPassenger").on('click', function () {
            totalManualPassenger = (madult + mchildren + minfant);
            $("[name='totalManualPassenger']").val(totalManualPassenger);
        });

        // // iati origin
        // $('input[name="iorigin"]').select2('val', 'HEHEHE');
        // $('input[name="idestination"]').select2('val', 'HUHUHUHU');
        var adult = parseInt($("[name='iadult']").val()); // Should be 1
        var children = parseInt($("[name='ichildren']").val());
        var infant = parseInt($("[name='iinfant']").val());
        var xtotalManualPassenger = (adult + children + infant);
        $("[name='iadult']").on('change', function () {
            adult = parseInt($(this).val());
        });
        $("[name='ichildren']").on('change', function () {
            children = parseInt($(this).val());
        });
        $("[name='iinfant']").on('change', function () {
            infant = parseInt($(this).val());
        });
        $("#isumPassenger").on('click', function () {
            var xtotalManualPassenger = (adult + children + infant);
            $("[name='totalPassenger']").val(xtotalManualPassenger);
            // console.log(xtotalManualPassenger);
        });

        <?php
        if (isset($_SESSION['searchManualQuery']) && !empty($_SESSION['searchManualQuery'])) {
            $query = (Object)$_SESSION['searchManualQuery'];
        }
        ?>

        $(document).ready(function () {
            // Safari 3.0+ "[object HTMLElementConstructor]"
            var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 || (function (p) {
                return p.toString() === "[object SafariRemoteNotification]";
            })(!window['safari'] || safari.pushNotification);
            if (isSafari == true) {
                $(".bg-warning").css("padding-bottom", "82px !important");
            }
        });

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

        var fmt = "<?php echo $app_settings[0]->date_f_js;?>";
        var baseURL = "<?php echo base_url(); ?>";

// $(document).ready(function() {

        /* Wish list global function */
        $(".wishlistcheck").on("click", function () {
            var id = $(this).prop('id');
            var module = $(this).data('module');
            var userid = "<?php echo $usersession; ?>";
            var action = "add";
            var thisdiv = $(this);
            if ($(this).hasClass('fav')) {
                action = "remove";
            }


            $.post(baseURL + 'account/wishlist/' + action, {
                module: module,
                itemid: id,
                loggedin: userid
            }, function (resp) {
                var response = $.parseJSON(resp);
                if (response.isloggedIn) {

                    if (action == "remove") {
                        $("." + module + "wishsign" + id).html("+");
                        //$("."+module+"wishtext"+id).html("Add to Wishlist");
                        $("." + module + "wishtext" + id).tooltip('hide').attr('data-original-title', "<?php echo trans('029'); ?>").tooltip('fixTitle').tooltip('show');
                        $("." + module + "wishsign" + id).removeClass("fav");
                        thisdiv.removeClass('fav');

                    } else {

                        thisdiv.addClass('fav');
                        $("." + module + "wishsign" + id).addClass("fav");
                        $("." + module + "wishsign" + id).html("-");
                        //$("."+module+"wishtext"+id).html("Remove From Wishlist");
                        $("." + module + "wishtext" + id).tooltip('hide').attr('data-original-title', "<?php echo trans('028'); ?>").tooltip('fixTitle').tooltip('show');

                    }

                } else {
                    alert("<?php echo trans('0482');?>");
                }

            });

        });
        /* End Wish list global function */


        /* tours ajax categories loader */
        <?php  if(isModuleActive('tours')){ ?>
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
        <?php } ?>

        /* cars ajax types loader */
        <?php  if(isModuleActive('cars')){ ?>
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
                    $("#droplocation").html(response.optionsList).select2({width: '100%', maximumSelectionSize: 1})
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
        }
        <?php } ?>

        /* Datepicker */
        /* disabling dates */
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var checkin = $('.dpd1').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            // if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date);
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
            // }
            checkin.hide();
            $('.dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('.dpd2').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            var newDate = new Date(ev.date);
            checkout.hide();

        }).data('datepicker');

        /* disabling dates for rooms search */
        var nowTemprooms = new Date();
        var nowrooms = new Date(nowTemprooms.getFullYear(), nowTemprooms.getMonth(), nowTemprooms.getDate(), 0, 0, 0, 0);
        var checkinrooms = $('.dpd1rooms').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            // if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDaterooms = new Date(ev.date);
            newDaterooms.setDate(newDaterooms.getDate() + 1);
            checkoutrooms.setValue(newDaterooms);
            // }
            checkinrooms.hide();
            $('.dpd2rooms')[0].focus();
        }).data('datepicker');
        var checkoutrooms = $('.dpd2rooms').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() <= checkinrooms.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            var newDaterooms = new Date(ev.date);
            checkoutrooms.hide();

        }).data('datepicker');

        /* Expedia datepicker */
        <?php  if(isModuleActive('ean')){ echo $module; ?>
        var nowTemp2 = new Date,
            now2 = new Date(nowTemp2.getFullYear(), nowTemp2.getMonth(), nowTemp2.getDate(), 0, 0, 0, 0),
            checkin2 = $(".dpean1").datepicker({
                format: "mm/dd/yyyy", onRender: function (e) {
                    return e.valueOf() < now2.valueOf() ? "disabled" : ""
                }
            }).on("changeDate", function (e) {
                // if(e.date.valueOf()>checkout2.date.valueOf()){
                var a = new Date(e.date);
                a.setDate(a.getDate() + 1);
                a.setDate(a.getDate() + 1), checkout2.setValue(a)
                //}
                checkin2.hide(), $(".dpean2")[0].focus()
            }).data("datepicker"), checkout2 = $(".dpean2").datepicker({
                format: "mm/dd/yyyy", onRender: function (e) {
                    return e.valueOf() <= checkin2.date.valueOf() ? "disabled" : ""
                }
            }).on("changeDate", function (ev) {
                var b = new Date(ev.date);
                checkout2.hide()
            }).data("datepicker");
        <?php } ?>
        /* End Expedia Datepicker*/

        /* Dohop datepicker */
        <?php  if(isModuleActive('flightsdohop')){ ?>
        var nowTemp3 = new Date,
            now3 = new Date(nowTemp3.getFullYear(), nowTemp3.getMonth(), nowTemp3.getDate(), 0, 0, 0, 0),
            checkin3 = $(".dpfd1").datepicker({
                format: "mm/dd/yyyy", onRender: function (e) {
                    return e.valueOf() < now3.valueOf() ? "disabled" : ""
                }
            }).on("changeDate", function (e) {

                //if(e.date.valueOf()>checkout3.date.valueOf()){
                var a = new Date(e.date);

                console.log();
                a.setDate(a.getDate() + 1);
                checkout3.setValue(a);
                // }
                checkin3.hide(), $(".dpfd2")[0].focus()
            }).data("datepicker"), checkout3 = $(".dpfd2").datepicker({
                format: "mm/dd/yyyy", onRender: function (e) {
                    return e.valueOf() <= checkin3.date.valueOf() ? "disabled" : ""
                }
            }).on("changeDate", function (ev) {
                var b = new Date(ev.date);
                checkout3.hide()

            }).data("datepicker");
        <?php } ?>
        /* End Dohop Datepicker*/

        <?php  if(isModuleActive('tours')){ ?>
        // Tours checkin - disabling Single date
        var nowTemp4 = new Date();
        var now4 = new Date(nowTemp4.getFullYear(), nowTemp4.getMonth(), nowTemp4.getDate(), 0, 0, 0, 0);
        var checkin4 = $('.tchkin').datepicker({
            format: fmt, onRender: function (date) {
                return date.valueOf() < now4.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            var tdate = new Date(ev.date);
            $('.tchkin').datepicker('hide');
        });
        <?php } ?>
        <?php  if(isModuleActive('cars')){ ?>
        var nowTemp5 = new Date();
        var now5 = new Date(nowTemp5.getFullYear(), nowTemp5.getMonth(), nowTemp5.getDate(), 0, 0, 0, 0);
        var departcar = $('#departcar').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() < now5.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            //   if (ev.date.valueOf() > returncar.date.valueOf()) {
            var newDate5 = new Date(ev.date)

            newDate5.setDate(newDate5.getDate() + 0);

            returncar.setValue(newDate5);
            //  }
            departcar.hide();
            $('#returncar')[0].focus();
        }).data('datepicker');
        var returncar = $('#returncar').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() <= departcar.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            var cnewDate = new Date(ev.date);
            returncar.hide();

        }).data('datepicker');

        var nowTemp52 = new Date();
        var now52 = new Date(nowTemp52.getFullYear(), nowTemp52.getMonth(), nowTemp52.getDate(), 0, 0, 0, 0);
        var departcar2 = $('#departcar2').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() < now52.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            //   if (ev.date.valueOf() > returncar.date.valueOf()) {
            var newDate52 = new Date(ev.date)

            newDate52.setDate(newDate52.getDate() + 0);

            returncar2.setValue(newDate52);
            //  }
            departcar2.hide();
            $('#returncar2')[0].focus();
        }).data('datepicker');
        var returncar2 = $('#returncar2').datepicker({
            format: fmt,
            onRender: function (date) {
                return date.valueOf() <= departcar2.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function (ev) {
            var cnewDate2 = new Date(ev.date);
            returncar2.hide();

        }).data('datepicker');

        <?php } ?>




        /* Newsletter subscription */
        $(".sub_newsletter").on("click", function () {
            var e = $(".sub_email").val();
            $.post("<?php echo base_url();?>home/subscribe", {email: e}, function (e) {
                $(".subscriberesponse").html(e).fadeIn("slow"), setTimeout(function () {
                    $(".subscriberesponse").fadeOut("slow")
                }, 2000)
            })
        });

        /* dropdown on hover */
        $("ul.nav li.dropdown").hover(function () {
            $(this).find(".dropdown-menu").stop(!0, !0).delay(200).fadeIn(200)
        }, function () {
            $(this).find(".dropdown-menu").stop(!0, !0).delay(200).fadeOut(200)
        });

// }); end: $(function(){});

        /* start change currency functionality */


        /* map iframe modal */
        function showMap(a, o) {
            "modal" == o ? ($("#mapModal").modal("show"), $("#mapModal").on("shown.bs.modal", function () {
                $("#mapModal .mapContent").html('<iframe src="' + a + '" width="100%" height="450" frameborder="0" style="border:0"></iframe>')
            })) : $("#" + o).html('<iframe src="' + a + '" width="100%" height="450" frameborder="0" style="border:0"></iframe>')
        }
</script>
<?php if (isModuleActive('flightsdohop')) { ?>
    <script type="text/javascript">
        /* dohop auto suggest */
        function selectValue(l, h) {
            $("#" + h).val(l), $("#" + h + "resp").html("")
        }

        $(function () {
            $(".sterm").on("keyup", function (l) {
                var h = $(this).val(), e = h.length, i = $(this).prop("id"), t = l.keyCode || l.which;
                if ($.trim(e) > 1 && 38 != t && 40 != t) console.log(t), $("#" + i + "resp").html(""), $.post("<?php echo base_url();?>flightsdohop/getLocationsList", {
                    term: h,
                    inputid: i
                }, function (l) {
                    $("#" + i + "resp").html(l)
                }); else if (38 != t && 40 != t) $("#" + i + "resp").html(""); else {
                    var s, g, n = $("#" + i + "resp ul li.highlight");
                    40 !== t || n.length || $("#" + i + "resp ul li:first").addClass("highlight"), 40 === t && n.length ? (g = n.next("#" + i + "resp ul li"), g.length && (n.removeClass("highlight"), g.addClass("highlight"))) : 38 === t && (s = n.prev("#" + i + "resp ul li"), s.length && (n.removeClass("highlight"), s.addClass("highlight"))), console.log($(".highlight").innerHTML)
                }
            })
        });
    </script>
<?php } ?>
<?php if (isModuleActive('cartrawler')) { ?>
    <script type="text/javascript">
        /* cartrawler auto suggest */
        function selectLocationValue(l, h, locname) {
            $("#" + h).val(locname);
            if (h == 'ct1') {
                $("input[name='pickupLocationId']").val(l);
                $("#ct2").val(locname);
                $("input[name='returnLocationId']").val(l);
            } else if (h == "ct2") {
                $("#returnlocation").val(l);
            }
            ;$("#" + h + "resp").html("")
        }

        $(function () {
            $(".ctlocation").on("keyup", function (l) {
                var h = $(this).val(), e = h.length, i = $(this).prop("id"), t = l.keyCode || l.which;
                if ($.trim(e) > 1 && 38 != t && 40 != t) $("#" + i + "resp").html(""), $.post("<?php echo base_url();?>cartrawler/getLocations", {
                    term: h,
                    inputid: i
                }, function (l) {
                    $("#" + i + "resp").html(l)
                }); else if (38 != t && 40 != t) $("#" + i + "resp").html(""); else {
                    var s, g, n = $("#" + i + "resp ul li.highlight");
                    40 !== t || n.length || $("#" + i + "resp ul li:first").addClass("highlight"), 40 === t && n.length ? (g = n.next("#" + i + "resp ul li"), g.length && (n.removeClass("highlight"), g.addClass("highlight"))) : 38 === t && (s = n.prev("#" + i + "resp ul li"), s.length && (n.removeClass("highlight"), s.addClass("highlight"))), console.log($(".highlight").innerHTML)
                }
            })
        });

    </script>
<?php } ?>

<?php if (isModuleActive('cartrawler')) { ?>
    <script>
        var nowTemp6 = new Date();
        var now6 = new Date(nowTemp6.getFullYear(), nowTemp6.getMonth(), nowTemp6.getDate(), 0, 0, 0, 0);
        var checkin6 = $(".dpcd1").datepicker({
            format: "dd/mm/yyyy",
            onRender: function (e) {
                return e.valueOf() < now6.valueOf() ? "disabled" : "";
            }
        }).on("changeDate", function (e) {
            var a = new Date(e.date);
            a.setDate(a.getDate() + 0);
            checkout6.setValue(a)
            checkin6.hide();
            $(".dpcd2")[0].focus();
        }).data("datepicker");
        var checkout6 = $(".dpcd2").datepicker({
            format: "dd/mm/yyyy",
            onRender: function (e) {
                return e.valueOf() < checkin6.date.valueOf() ? "disabled" : "";
            }
        }).on("changeDate", function (ev) {
            var cnDate = new Date(ev.date);
            checkout6.hide()
        }).data("datepicker");
    </script>
<?php } ?>
<?php if (isModuleActive('Amadeus')) { ?>
    <script type="text/javascript">
        $(".select2").select2();
        $('#location_from_airlines').select2({
            ajax: {
                url: "<?php echo base_url(); ?>admin/ajaxcalls/flightAjex",
                dataType: 'json',
                data: function (term, page) {
                    return {
                        query: term,

                    };
                },
                results: function (data, page) {
                    return {results: data};
                }
            }
        });
    </script>
<?php } ?>

<?php if (isModuleActive('Juniper')) { ?>
    <script>
        $(".juniper_city_search").select2({
            placeholder: "Enter City or Country Name",
            minimumInputLength: 3,
            width: '100%',
            maximumSelectionSize: 1,
            ajax: {
                url: '<?php echo base_url('Suggestions/juniper_cities'); ?>',
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term
                    }
                },
                results: function (data, page) {
                    return {
                        results: data
                    }
                }
            },
            initSelection: function (element, callback) {
                var elementText = $(element).val();
                callback({"text": elementText, "id": elementText});
            }
        }).on('change', function () {

        });


        $(".juniper_nationality").select2({
            placeholder: "Select Your Nationality",
            minimumInputLength: 2,
            width: '100%',
            maximumSelectionSize: 1,
            ajax: {
                url: '<?php echo base_url('Suggestions/juniper_nations'); ?>',
                dataType: 'json',
                data: function (term, page) {
                    return {
                        q: term
                    }
                },
                results: function (data, page) {
                    return {
                        results: data
                    }
                }
            },
            initSelection: function (element, callback) {
                var elementText = $(element).val();
                callback({"text": elementText, "id": elementText});
            }
        }).on('change', function () {

        });


        $(".select2").select2({
            width: '100%'
        });

        function validate_juniper_form() {
            var checkin_date = new Date($('#checkin_date').val());
            var checkout_date = new Date($('#checkout_date').val());
            if (checkout_date <= checkin_date) {
                alert("Checkin Date should be less than Checkout Date");
                return false;
            } else {
                document.getElementById('overlay').style.display = "block";
                return true;
            }
        }


    </script>
    <?php
}
?>