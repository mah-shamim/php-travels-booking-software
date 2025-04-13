 <?php  if(pt_main_module_available('ean')){ ?>

<script type="text/javascript">
  $(function(){
    $(".childcountDetailsPage").on("change",function(){
      var count = $(this).val();
      var ages = [];
alert(count);
      if(count > 0){

        // for(i = 1; i <= count; i++){
        //   ages.push('0');
        // }

        $("#childagesdetails").val(ages);


        $(".ageselect").empty();

        addChildsAgeFieldDetails(count);

       $("#ages").modal('show');
      }else{
        $("#childages").val("");
      }

    })



  })


  function addChildsAgeFieldDetails(children) {

        var childagestxt = '';
        for (child = 1; child <= children; child++) {

            var StringChildAge = '';
            StringChildAge = '\
                        <label for="form-input-popover" class="col-sm-4 control-label">'+child+' Age</label><div class="col-sm-8">\n\
                        <select class="room-child-ageDetails form-control" onchange="updateChildAges();">\n\
                            <option value="0"> Under 1 </option>\n\
                            <option value="1">1</option>\n\
                            <option value="2">2</option>\n\
                            <option value="3">3</option>\n\
                            <option value="4">4</option>\n\
                            <option value="5">5</option>\n\
                            <option value="6">6</option>\n\
                            <option value="7">7</option>\n\
                            <option value="8">8</option>\n\
                            <option value="9">9</option>\n\
                            <option value="10">10</option>\n\
                            <option value="11">11</option>\n\
                            <option value="12">12</option>\n\
                            <option value="13">13</option>\n\
                            <option value="14">14</option>\n\
                            <option value="15">15</option>\n\
                            <option value="16">16</option>\n\
                            <option value="17">17</option>\n\
            </select></div>';

            $(".ageselect").append(StringChildAge);
        }



}

function updateChildAges(){

       var selectedAges = [];
            $('.room-child-ageDetails option:selected').each(function () {
                if($(this).val() > 0){
                selectedAges.push($(this).val());
                alert("ages.php wala");
                }
            });

          $("#childages").val(selectedAges);
}

</script>

<!-- Modal -->
<div class="modal fade" id="ages" tabindex="1" role="dialog" aria-hidden="true" style="margin-top:50px;color: #000;" >
  <div class="modal-dialog modal-sm" style="z-index: 9999;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo trans('011');?></h4>
      </div>
      <div class="modal-body">
       <div class="form-group form-horizontal ageselect" >



    </div>
<div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo trans('0233');?></button>
      </div>
    </div>
  </div>
</div>
  <?php } ?>
