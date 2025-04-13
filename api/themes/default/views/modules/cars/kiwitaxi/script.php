<?php
//if($searchForm['searchForm']['home']!= '1') {
//    $loactionfrom = $searchForm['searchForm'];
//    $loactionto = $searchForm['searchTo'];
//
//}else{
//    $loactionfrom = $searchForm['searchForm']['searchForm'];
//    $loactionto = $searchForm['searchForm']['searchTo'];
//}

$ci = get_instance();

$loactionfrom = $ci->session->userdata('ktaxilaoctform');
$loactionto = $ci->session->userdata('ktaxilaoctto');

?>
<script>
$("#kiwitaxi").submit(function(e){
e.preventDefault();
var origin_from1 = $("#origin_from").val();
var origin_from = origin_from1.replace(/\s+/g, '-');
var origin_to1 = $("#origin_to").val();
var origin_to = origin_to1.replace(/\s+/g, '-');
var endpoint = $(this).attr("action");
var new_url = endpoint+"/"+origin_from+"/"+origin_to;
window.location.href = new_url;
});

$(".kiwifrom_select2").select2({
minimumInputLength: 3,
width: '100%',
maximumSelectionSize: 1,
ajax: {
url: '<?php echo base_url('kiwitaxi/kawitaxiloaction'); ?>',
dataType: 'json',
data: function (term, page) {
return {query: term}
},
results: function (data, page) {
return {results: data}
}
},
initSelection: function (element, callback) {
callback({id: 1, text: '<?=(!empty($loactionfrom))? $loactionfrom :lang('0618'); ?>'})
}
});
$(".kiwito_select2").select2({
minimumInputLength: 3,
width: '100%',
maximumSelectionSize: 1,
ajax: {
url: '<?php echo base_url('kiwitaxi/kawitaxiloaction'); ?>',
dataType: 'json',
data: function (term, page) {
return {query: term}
},
results: function (data, page) {
return {results: data}
}
},
initSelection: function (element, callback) {
callback({id: 1, text: '<?=(!empty($loactionto))? $loactionto :lang('0618'); ?>'})
}
});
</script>