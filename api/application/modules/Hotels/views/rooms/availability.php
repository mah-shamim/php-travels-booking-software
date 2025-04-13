 <div class="panel panel-default">
  <div class="panel-heading">Room Availability</div>
      	<form action="" id="frmRoomAvailability" method="post">
   <div class="panel-body">
   	<span class="gray">Define a maximum number of rooms available for booking for a specified day or date range (maximum availability <?php echo $room_count; ?> rooms)<br>To edit room availability simply change the value in a day cell and then click 'Submit' button</span>

              <?php echo $calendar; ?>

   </div>

 <div class="panel-footer">
 <input type="hidden" name="updateavail" value="1" />
<button class="btn btn-primary" type="submit">Submit</button>
</div>
</form>
</div>

<style>
INPUT.dc_all, DIV.dc_all {
  border: 1px solid #a6e8a6;
  background-color: #bbffbb;
  margin: 0px;
  margin-right: 1px;
}

INPUT.day_a {
  width: 23px;
  height: 19px;
  font-size: 12px;
  padding: 1px 1px 1px 1px;
  text-align: center;
}

TABLE {
  font-size: 12px;
  color: #222222;
}

TD.day_td_w {
  background-color: #FFBE5C;
  padding: 0px;
}

LABEL.l_day {
  font-size: 9px;
  line-height: 10px;
  color: #555555;
}

TR.m_current {
  background-color: #ffdf7f;
}

INPUT.dc_part, DIV.dc_part {
  border: 1px solid #d8d863;
  background-color: #efef76;
  margin: 0px;
  margin-right: 1px;
}

INPUT.dc_none, DIV.dc_none {
  border: 1px solid #df6666;
  background-color: #ef7676;
  margin: 0px;
  margin-right: 1px;
}

</style>

<script type="text/javascript">
        $(function(){
        $(".pointer").on("click",function(){
        var rid = $(this).prop("id");
        $(this).toggleClass("clked");
         var room_count = "<?php echo $room_count;?>";
         for(i=1; i<=31; i++){
					if(document.getElementById("aval_"+rid+"_"+i))
					   document.getElementById("aval_"+rid+"_"+i).value = $(this).hasClass("clked") ? "0" : room_count;
				}

        });
        //change year
        $(".changeyear").change(function(){
          var year = $(this).val();
          var url = $(this).prop("id");
          window.location.href = url+'?&year='+year;
        });
        //end change year

        //check change maximum room count
        $(".txtval").blur(function(){
            var current = $(this).data('current');
            var max = $(this).data('max');
            var newval = $(this).val();
            if(newval > max){
              $.alert.open('info', "Maximum number of rooms availability is "+max);
              $(this).val(current);
            }

        });
        //end check change maximum room count

        })
</script>