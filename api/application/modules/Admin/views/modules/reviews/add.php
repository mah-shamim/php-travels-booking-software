<script type="text/javascript">
  $(function(){



   var options = {   beforeSend: function()
    {

    },
    uploadProgress: function(event, position, total, percentComplete)
    {

    },
    success: function()
    {

    },
    complete: function(response)
    {

    if($.trim(response.responseText) == "done"){
       $(".output").html('please Wait...');
      window.location.href = "<?php echo base_url().$this->uri->segment(1).'/reviews/'; ?>";
    }
    },
    target: '.output' };
    $('.reviews-form').submit(function() {
        $(this).ajaxSubmit(options);
        $('html, body').animate({
        scrollTop: $('.panel-bg').offset().top
    }, 'slow');
        return false;
    });


    $('.reviewscore').change(function(){
    var sum = 0;
       var avg = 0;
    $('.reviewscore :selected').each(function() {
        sum += Number($(this).val());
    });
     avg = sum/5;
   $("#avgall").html(avg);
     $("#overall").val(avg);
  });



  })



  function showModItems(modtype){
             $('#pt_reload_modal').modal('show');
  $.post("<?php echo base_url().$this->uri->segment(1);?>/ajaxcalls/get_module_items", {modtype: modtype, user: '<?php echo @$issupplier;?>' }, function(theResponse){


  	$("#reviews_for_id").html(theResponse).select2(    {
        width:'100%',

        });
               $('#pt_reload_modal').modal('hide');
  	});

  }

</script>
<form class="form-horizontal reviews-form" method="POST" action="" >
  <div class="container">
    <div class="output"> </div>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <span class="panel-title pull-left"><i class="fa fa-smile-o"></i> Add Review</span>
        <div class="pull-right">
          <?php echo PT_BACK; ?>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body">
        <div class="spacer20px">
          <div class="col-lg-3">
            <div class="well">
              <div class="form-group">
                <label class="col-md-3 control-label">Status</label>
                <div class="col-md-9">
                  <select class="form-control" name="reviewstatus">
                    <option value="1"> Enable</option>
                    <option value="0"> Disable </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Date</label>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-8">
                  <input class="form-control input-sm " id="thingtodo_date" type="text" class="form-control" placeholder="Date" value="<?php echo pt_show_date_php(time());?>" name="reviewsdate">
                </div>
              </div>
              <?php
                if(!empty($modules)){

                ?>
              <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                  <select data-placeholder="Select Module" class="chosen-select" name="reviewmodule" onchange="showModItems(this.options[this.selectedIndex].value)"  >
                    <option value="">Select Module</option>
                    <?php
                      foreach($modules as $mod):
                        $istrue = $this->ptmodules->is_mod_available_enabled($mod);
                        $isintegration = $this->ptmodules->is_integration($mod);
                         if($istrue && !$isintegration && !in_array($mod,$this->ptmodules->notinclude)){
                      ?>
                    <option value="<?php echo $mod;?>" ><?php echo ucfirst($mod);?></option>
                    <?php } endforeach; ?>
                  </select>
                </div>
              </div>
              <?php
                }


                ?>
              <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                  <select data-placeholder="Reviews For"  class="chosen-select"  id="reviews_for_id" name="reviews_for_id">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-5 control-label">Clean</label>
                <div class="col-md-5">
                  <select class="form-control reviewscore" name="reviews_clean">
                    <option value="1"> 1</option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-5 control-label">Comfort</label>
                <div class="col-md-5">
                  <select class="form-control reviewscore" name="reviews_comfort">
                    <option value="1"> 1</option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-5 control-label">Location</label>
                <div class="col-md-5">
                  <select class="form-control reviewscore" name="reviews_location">
                    <option value="1"> 1</option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-5 control-label">Facilities</label>
                <div class="col-md-5">
                  <select class="form-control reviewscore" name="reviews_facilities">
                    <option value="1"> 1</option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-5 control-label">Staff</label>
                <div class="col-md-5">
                  <select class="form-control reviewscore" name="reviews_staff">
                    <option value="1"> 1</option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="col-lg-12 well">
              <div class="form-group form-horizontal">
                <label class="col-md-1 control-label">Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="reviews_name">
                </div>

                <label class="col-md-3 control-label">Overall Points <span class="badge badge-warning"><span id="avgall">1</span> / 10 </span> </label>
                <input type="hidden" name="overall" id="overall" value="1" />
              </div>
            </div>

            <div class="col-lg-12 well">
              <div class="form-group form-horizontal">
               <label class="col-md-1 control-label">Email</label>
               <div class="col-md-8">
                 <input type="text" class="form-control" name="reviews_email" value="">
               </div>
              </div>
            </div>
            <div class="col-lg-12 well">
              <label class="col-md-12 control-label"> Comment </label>
              <textarea class="form-control" placeholder="Add comment here..." rows="10" name="reviews_comments"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="addreview" value="1" />
    <button type="submit" class="btn btn-primary btn-lg pull-right"><i class="fa fa-save"></i> Submit</button>
  </div>
</form>