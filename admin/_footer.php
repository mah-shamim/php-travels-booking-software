</section>
</main>
</body>

</html>

<?php 

if ($url_name != "profile" && $url_name != "flights" ){ ?>
<script src="<?=root?>assets/js/datepicker.js"></script>
<?php } ?>
<script src="<?=root?>assets/js/toast.js"></script>
<script src="<?=root?>assets/js/toast-alerts.js"></script>
<script src="<?=root?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?=root?>assets/js/bootstrap-select.js"></script>

<script>

Pusher.logToConsole = true;
var pusher = new Pusher('be4840bf63594e1468bb', { cluster: 'us2' });
var channel = pusher.subscribe('<?=$_SERVER['SERVER_NAME']?>');
channel.bind('event', function(data) {
// alert(JSON.stringify(data));
// console.log(JSON.stringify(data.message1))

// SHOW NOTIFICATION
vt.success(data.message2, {
    title: data.message1,
    position: "bottom-center",
    duration: 100,
    callback: function() {
    }
})

// SEND NOTIFICATION TO DATABASE
var form = new FormData();
form.append("notification", "");
form.append("name", data.message1+' '+data.message2);

var settings = {
  "url": "./_post.php",
  "method": "POST",
  "timeout": 0,
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};

$.ajax(settings).done(function (response) { console.log(response); 
    
var form = new FormData();
form.append("notification_get", "");
form.append("id", name);
var settings = {
"url": "./_post.php",
"method": "POST",
"timeout": 0,
"processData": false,
"mimeType": "multipart/form-data",
"contentType": false,
"data": form
};
$.ajax(settings).done(function (id) { 
    var count = jQuery.parseJSON(id);

    // ADD NOTIFICATION 
    $(".drapdown").prepend(`<li><a class="dropdown-item notification_`+count+`" href="#">
    <button style="border-radius: 5px !important;" class="btn btn-warning btn-sm p-3 py-0" onclick="notification(`+count+`)">
    <svg class="m-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
    </button>
    <span class="px-2">`+data.message1+` `+data.message2+`</span></a></li>`);
});

// INCREASE NUMBER OF NOTIFICATIONS
$('.notificaition_count_number').html(parseInt($('.notificaition_count_number').html(), 10)+1) });

});


</script>

<script>
    $(".module button").click(function(){
    var i = $(this).val();
    var mod_name = i.toLowerCase();
    jQuery('#module_type').modal('hide');
    window.location.replace('./listings.php?listing=' + mod_name);
    });
</script>

<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

var hash = window.location.hash.substr(1);
if (hash == "updated") {
    vt.success("Information Updated Successfully", {
        title: "Details Udpated",
        position: "bottom-center",
        callback: function() { //
        }
    })
}

</script>

<script>
// UPDATE STATUS ONCLICK
$('.updated_status').on('click', function() {

    var status = $(this).data("status");
    var id = $(this).data("value");
    var item = $(this).data("item");

    console.log(id);

    var isChecked = this.checked;

    // CONDITION TO CHECK THE STATUS
    if (isChecked == true) {
        var checks = 1
    } else {
        var checks = 0
    }

    var form = new FormData();
    form.append("id", id);
    form.append("status", checks);
    form.append("table_name", "<?=basename($_SERVER['PHP_SELF'],".php")?>");

    var settings = {
        "url": "./_post.php",
        "method": "POST",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };

    $.ajax(settings).done(function(response) {
        console.log(response);

        // ALERT POPUP MESSAGE
        vt.success("Information updated successfully", {
            title: "Info Updated",
            position: "top-center",
            callback: function() { //
            }
        })

    });

});

// UPDATE STATUS ONCLICK
$('.makeDefault').on('click', function() {

    var status = $(this).data("status");
    var id = $(this).data("value");
    var item = $(this).data("item");

    console.log(id);

    var isChecked = this.checked;

    // CONDITION TO CHECK THE STATUS
    if (isChecked == true) {
        var checks = 1
    } else {
        var checks = 0
    }

    var form = new FormData();
    form.append("id", id);
    form.append("default_status", checks);
    form.append("table_name", "<?=basename($_SERVER['PHP_SELF'],".php")?>");

    var settings = {
        "url": "./_post.php",
        "method": "POST",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };

    $.ajax(settings).done(function(response) {
        console.log(response);

        location.reload();

    });

});
// UPDATE STATUS ONCLICK
$('.makeFeatured').on('click', function() {

var status = $(this).data("status");
var id = $(this).data("value");
var item = $(this).data("item");

console.log(id);

var isChecked = this.checked;

// CONDITION TO CHECK THE STATUS
if (isChecked == true) {
    var checks = 1
} else {
    var checks = 0
}

var form = new FormData();
form.append("id", id);
form.append("feature_status", checks);
form.append("table_name", "<?=basename($_SERVER['PHP_SELF'],".php")?>");

var settings = {
    "url": "./_post.php",
    "method": "POST",
    "timeout": 0,
    "processData": false,
    "mimeType": "multipart/form-data",
    "contentType": false,
    "data": form
};

$.ajax(settings).done(function(response) {
    console.log(response);

    // ALERT POPUP MESSAGE
    vt.success("Information updated successfully", {
        title: "Info Updated",
        position: "top-center",
        callback: function() { //
        }
    })

});

});
</script>

<script>
// DELETE MULTIPLE ITEMS
$('<button id="deleteAll" class="delete_button btn btn-danger btn-sm" style="margin-top: -54px; margin-left: -22px; position: absolute; z-index: 10;"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>')
    .insertAfter('#select_all').hide();

$(".checkboxcls").click(function() {

    if ($(this).prop("checked")) {
        $("#deleteAll").show()
    } else {
        $(".delete_button").hide();
    }

})

$("#select_all").click(function() {

    $("#deleteAll").show()
    if ($(this).prop("checked")) {
        $(".checkboxcls").prop("checked", true);
    } else {
        $(".checkboxcls").prop("checked", false);
        $(".delete_button").hide();
    }
});

$("#deleteAll").click(function() {

    var checkboxes = $(".checkboxcls:checked");
    var table_name = "<?=basename($_SERVER['PHP_SELF'],".php")?>";
    var all_data = [];
    $.each(checkboxes, function(index, object, container) {
        all_data.push($(object).val())
    });
    if (all_data.length != 0) {

        console.log(all_data.length)
        var answer = confirm("Are you sure you want to delete?");
        if (answer) {
            $.post("./_post.php", {
                items: all_data,
                table_name: table_name
            }, function(theResponse) {
                console.log(theResponse);
                location.reload();
            });

        } else {
            location.reload();
            return false;
        }
    } else {
        alert("Please at least select one item.")
    }
});
</script>

<!-- SELECT2  -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
$(document).on("xcrudbeforerequest", function(event, container) {
    if (container) {
        $(container).find("select").select2('destroy');
    } else {
        $(".xcrud").find("select").select2('destroy');
    }
});
$(document).on("ready xcrudafterrequest", function(event, container)
 {
    if (container) {
        $(container).find("select").select2();
    } else {
        $(".xcrud").find("select").select2();
    }
});
$(document).on("xcrudbeforedepend", function(event, container, data) {
    console.log(data.name);
    //if (container) {
        console.log(!$.isEmptyObject($(container).find('select[name="' + data.name + '"]')));
        console.log(data.name);
        //if(!$.isEmptyObject($(container).find('select[name="' + data.name + '"]'))){
             if ($(container).find('select[name="' + data.name + '"]').data('select2')) {
                  console.log("select2 item");
                  $(container).find('select[name="' + data.name + '"]').select2('destroy');
             }  else {
                  console.log("Not a select2 ");
             }              
        //}
   // }
    
});
$(document).on("xcrudafterdepend", function(event, container, data) {
    jQuery(container).find('select[name="' + data.name + '"]').select2();
});
</script>