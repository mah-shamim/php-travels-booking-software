</div>
</div>
</div>

<?php $settings = $this->Settings_model->get_settings_data(); ?>
<script src="<?php echo base_url(); ?>assets/js/sidebar.js"></script>

<!-- Xcrud multi delete function js -->
<script>
    // Listen for click on toggle checkbox
    $('#select_all').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    function select_all_data(e){
    if ($("#select_all").prop("checked")) {
    $("[class=checkboxcls]").prop("checked", true);
    } else {
    $("[class=checkboxcls]").prop("checked", false);
    }
    }

    /*
    $("#select_all").click(function () {
    if ($("#select_all").prop("checked").prop("checked")) {
    $("[class=checkboxcls]").prop("checked", true);
    } else {
    $("[class=checkboxcls]").prop("checked", false);   }
    });*/

function delete_all() {

    var checkboxes = $("[class=checkboxcls]:checked");
    var table_name = "<?=!empty($table_name) ? $table_name :   ""?>";
    var main_key = "<?=!empty($main_key) ? $main_key :   ""?>";

    var all_data = [];
    $.each(checkboxes, function (index, object, container) {
        all_data.push($(object).val())
    });
    if (all_data.length != 0) {
        var answer = confirm("Are you sure you want to delete?");
        if (answer) {
            $.post("<?=base_url('admin/hotels/DeleteAll')?>", {primery_keys: all_data,table_name : table_name,main_key:main_key}, function (theResponse) {
                location.reload();
            });

        } else {
            location.reload();
            return false;
        }
    } else {
        alert("Please at least select one item.")
    }
}

</script>

<!-- icheck -->
<script src="<?php echo base_url(); ?>assets/include/icheck/icheck.min.js"></script>
<link href="<?php echo base_url(); ?>assets/include/icheck/square/grey.css" rel="stylesheet">
<script>
var cb, optionSet1;

$(function () {
    var checkAll = $('input.all');
    var checkboxes = $('input.checkboxcls');

    $('.tab-pane input').iCheck({
      checkboxClass: "icheckbox_square-grey",
    });

    checkAll.on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });
});

$("radio").iCheck({
checkboxClass: "icheckbox_square-grey",
radioClass: "iradio_square-grey"
});
</script>


<!-- datepicker -->
<script src="<?php echo base_url(); ?>assets/include/datepicker/datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/datepicker/datepicker.css" />

<script>
    var fmt = "<?php echo @$settings[0]->date_f_js;?>";
    if (top.location != location) { top.location.href = document.location.href ; }
    $(function(){ window.prettyPrint && prettyPrint(); $('.dob').datepicker({format: fmt,autoclose: true}).on('changeDate', function (ev) {
        $(this).datepicker('hide'); });
        $('#dp1').datepicker();
        $('#dp2').datepicker();
        $('#dp3').datepicker();
        $('#dp5').datepicker();

// disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var date = $('.dpd3').datepicker({
            format: fmt,
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        })
            .on('changeDate', function(ev) {
                date.hide();
            })
            .data('datepicker');

        var date12 = $('.dpd5').datepicker({
            format: fmt,
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        })
            .on('changeDate', function(ev) {
                date12.hide();
            })
            .data('datepicker');
        var date13 = $('.dpd6').datepicker({
            format: fmt,
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        })
            .on('changeDate', function(ev) {
                date13.hide();
            })
            .data('datepicker');

        var checkin = $('.dpd1').datepicker({
            format: fmt,
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        })
            .on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1); checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            })
            .data('datepicker');
        var checkout = $('.dpd2').datepicker({
            format: fmt,
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        })
            .on('changeDate', function(ev) {
                checkout.hide();
            })
            .data('datepicker');

    });
</script>
<!-- timepicker -->
<script src="<?php echo base_url(); ?>assets/include/timepicker/timepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/timepicker/timepicker.css" />
<script>
$(function(){
$('.timepicker').clockface(); });
</script>

<!-- dronzone -->
<link href="<?php echo base_url(); ?>assets/include/dropzone/dropzone.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/include/dropzone/dropzone.min.js"></script>

<!----Custom functions file---->
<script src="<?php echo base_url(); ?>assets/js/funcs.js"></script>
<!----Custom functions file---->

<!-- pnotify -->
<script src="<?php echo base_url(); ?>assets/include/pnotify/pnotify.custom.min.js"></script>
<link href="<?php echo base_url(); ?>assets/include/pnotify/pnotify.custom.css" rel="stylesheet">

<?php NotifyMsg($this->session->flashdata('flashmsgs')); ?>

<script>
$(function() {
$(document).ready(function() {
    $('.chosen-select').select2( { width:'100%', maximumSelectionSize: 1 } );
    $(".chosen-multi-select").select2( { width:'100%', } ); }); }); function slideout(){ setTimeout(function(){
    $(".alert-success").fadeOut("slow", function () { });
    $(".alert-danger").fadeOut("slow", function () { }); }, 4000);}
</script>

<script>
window.jQuery.ui || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"><\/script>')
</script>
<script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
<script>
/*<![CDATA[*/
$(function() {
$('.main').panels();
});
/*]]>*/

    $("#btnSendSms").click(function() {
        var payload = {
            recepient: $('[name=recepient]').val(),
            message: $('[name=message]').val()
        };
        $.post('<?=base_url("admin/templates/sms_test")?>', payload, function(response) {
            console.log(response);
            if(response.status == 'success') {
                $('#testSmsModalBox #alertBox').html('<div class="alert alert-success">'+response.message+'</div>');
                setTimeout(function() {
                    $('#testSmsModalBox').modal('hide');
                }, 1000);
            } else {
                $('#testSmsModalBox #alertBox').html('<div class="alert alert-danger">'+response.message+'</div>');
            }
        });
    });

    var currentObjElement;
    function editModelBtn(elem) {
        currentObjElement = elem;
        var templateObj = $(elem).data('content');
        $('#modelEdit #modalTitle').text(templateObj.name);
        $('#modelEdit #modalShortCode').text(templateObj.shortcode);
        $('#modelEdit #modalBody').val(templateObj.body);
        $('#modelEdit [name="objectId"]').val(templateObj.id);

        $('#modelEdit #alertBox').empty();
        $('#modelEdit').modal('show');
    }

    function testModelBtn(elem) {
        currentObjElement = elem;
        var templateObj = $(elem).data('content');
        $('#modelTest #modalTitle').text(templateObj.name);
        $('#modelTest #modalBody').val(templateObj.body);

        $('#modelTest #alertBox').empty();
        $('#modelTest').modal('show');
    }

    $('#modelEdit #btnSave').click(function() {
        $.post('<?=base_url("admin/templates/updateSmsTemplate")?>', {
            id: $('#modelEdit [name="objectId"]').val(),
            name: $('#modelEdit #modalTitle').text(),
            shortcode: $('#modelEdit #modalShortCode').text(),
            body: $('#modelEdit #modalBody').val()
        }, function(response) {
            if(response.status == 'success') {
                $(currentObjElement).data('content', response.updatedObject);
                $('#modelEdit #alertBox').html('<div class="alert alert-success">Document updated</div>');
                setTimeout(function() {
                    $('#modelEdit').modal('hide');
                }, 1000);
            } else {
                $('#modelEdit #alertBox').html('<div class="alert alert-danger">Unable to update document</div>');
            }
        });
    });

    $('#modelTest #btnSend').click(function() {
        $.post('<?=base_url("admin/templates/sms_test")?>', {
            recepient: $('#modelTest [name="recepient"]').val(),
            message: $('#modelTest #modalBody').val()
        }, function(response) {
            if(response.status == 'success') {
                $('#modelTest #alertBox').html('<div class="alert alert-success">'+response.message+'</div>');
                setTimeout(function() {
                    $('#modelTest').modal('hide');
                }, 1000);
            } else {
                $('#modelTest #alertBox').html('<div class="alert alert-danger">'+response.message+'</div>');
            }
        });
    });
</script>

<!-- URL for livechat
https://phptravels.com/livechat.php
-->
<?php //echo file_get_contents(""); ?>

</body>
</html>
