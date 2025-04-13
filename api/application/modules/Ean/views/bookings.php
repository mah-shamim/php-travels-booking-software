<script type="text/javascript">
  $(function(){

        slideout();
$(".advsearch").on("click",function() {
var invoiceno = $("#invoiceno").val();
var invoicefdate = $("#invoicefromdate").val();
var invoicetdate = $("#invoicetodate").val();
var status = $("#status").val();
var customername = $("#customername").val();
var module = $("#module").val();

    var perpage = $("#perpage").val();

     $(".loadbg").css("display","block");

     var dataString = 'advsearch=1&module='+module+'&perpage='+perpage+'&customername='+customername+'&status='+status+'&invoicefromdate='+invoicefdate+'&invoicetodate='+invoicetdate+'&invoiceno='+invoiceno;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>/integrations/ean/eanback/booking_ajax/",
           data: dataString,
           cache: false,
           success: function(result){

               $(".loadbg").css("display","none");
                 $("#ajax-data").html(result);
                  $("#li_1").addClass("active");
           }
      });

});

$(".searchdata").keypress(function(e) {
    if(e.which == 13) {
    var sterm = $(this).val();
    var perpage = $("#perpage").val();
  if($.trim(sterm).length < 1){

  }else{
     $(".loadbg").css("display","block");

     var dataString = 'search=1&searchdata='+sterm+'&perpage='+perpage;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>/integrations/ean/eanback/booking_ajax/",
           data: dataString,
           cache: false,
           success: function(result){

               $(".loadbg").css("display","none");
                 $("#ajax-data").html(result);
                  $("#li_1").addClass("active");
           }
      });
     }
   }
});


        $('.del_selected').click(function(){
        var booklist = new Array();
        $("input:checked").each(function() {
             booklist.push($(this).val());
          });
        var count_checked = $("[name='booking_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select a Booking to Delete.');
          return false;}
  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
          if (answer == 'yes')
    $.post("<?php echo base_url();?>admin/bookings/del_multiple_bookings", { booklist: booklist }, function(resp){
    location.reload();
    });
          });});

        // delete single booking
      $(".del_single").click(function(){
     var id = $(this).attr('id');
  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
      if (answer == 'yes')
       $.post("<?php echo base_url();?>admin/bookings/del_single_booking", { id: id }, function(theResponse){
       location.reload();
       });});});

       });



function changePagination(pageId,liId){


   $(".loadbg").css("display","block");

   var perpage = $("#perpage").val();
    var last = $(".last").prop('id');
    var prev = pageId - 1;
    var next =  parseFloat(liId) + 1;
     var dataString = 'perpage='+ perpage;
     $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>/integrations/ean/eanback/booking_ajax/"+pageId,
           data: dataString,
           cache: false,
           success: function(result){
             $(".loadbg").css("display","none");

                 $("#ajax-data").html(result);
                if(liId != '1'){
                 $(".first").after("<li class='previous'><a href='javascript:void(0)' onclick=changePagination('"+prev+"','"+prev+"') >Previous</a></li>");
                 }

                $(".litem").removeClass("active");
                $("#li_"+liId).css("display","block");
                $("#li_"+liId).addClass("active");

           }
      });
}

function changePerpage(perpage){
       $(".loadbg").css("display","block");

     var dataString = 'perpage='+ perpage;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>/integrations/ean/eanback/booking_ajax/1",
           data: dataString,
           cache: false,
           success: function(result){
             $(".loadbg").css("display","none");
             $("#ajax-data").html(result);
             $("#li_1").addClass("active");
           }
      });
}



</script>
 <?php echo LOAD_BG;?>
<?php if(empty($ajaxreq)){ ?>
 <div class="<?php echo body;?>">

   <div class="panel panel-primary table-bg">
      <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-gavel"></i> Expedia Bookings </span>
      <div class="clearfix"></div>
    </div>  <?php } ?>
    <div class="panel-body">

      <div id="ajax-data">

<div class="matrialprogress"  style="display:none"><div class="indeterminate"></div></div>


           <!-- PHPTRAVELS table starting -->


         <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" >
              <thead>
          <tr>
            <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Itinerary ID">&nbsp;</i></th>
            <th><span class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Costumer Name"></span> Customer Name </th>
            <th><span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Name of Section or Item"></span> Hotel Name </th>
            <th><span class="fa fa-dollar" data-toggle="tooltip" data-placement="top" title="Total Amount"></span> Total </th>
            <th><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" title="Created On Date"></i> Date</th>
          </tr>
        </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">

             <?php
          if(!empty($bookings)){

            foreach($bookings['all'] as $book){

            ?>
          <tr>
            <td><?php echo $book->book_itineraryid;?></td>
            <td><?php echo $book->ai_first_name." ".$book->ai_last_name;?></td>
            <td><?php echo $book->book_hotel;?></td>
            <td class="center"><?php echo $book->book_total;?></td>
            <td class="center"><?php echo pt_show_date_php($book->book_date);?></td>
          </tr>
          <?php  } } ?>

           </tbody>
          </table>


                 <?php include 'application/modules/admin/views/includes/table-foot.php'; ?>


               </div>

      </div>
      <!-- PHPTRAVELS table ending -->
    </div>
  </div>










