<div class="<?php echo body;?>">
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-suitcase"></i> Tours Management</span>
      <div class="pull-right">
        <?php if($adminsegment != 'supplier'){ ?> <a data-toggle="modal" href="<?php echo base_url().$adminsegment;?>/tours/add/"><?php echo PT_ADD; ?></a><?php } ?>
        <span class="del_selected">   <?php echo PT_DEL_SELECTED; ?></span>
        <span class="disable_selected">   <?php echo PT_DIS_SELECTED; ?></span>
        <span class="enable_selected">   <?php echo PT_ENA_SELECTED; ?></span>
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <div id="ajax-data">
        <div  class="dataTables_wrapper form-inline" role="grid">
          <div class="row">
            <div class="col-sm-12">
              <div class="pull-left">
                <div class="dataTables_filter"><label><input type="text" aria-controls="DataTables_Table_0" placeholder="Search" class="form-control input-sm searchdata" value="<?php echo @$searchterm;?>"></label></div>
              </div>
              <div class="pull-right">
                <div >
                  <label>
                    Show
                    <select size="1" name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control input-sm" id="perpage" onchange="changePerpage(this.options[this.selectedIndex].value);">
                      <!--         <option value="10" <?php if($perpage == 10){ echo "selected"; } ?> >10</option>
                        <option value="25" <?php if($perpage == 25){ echo "selected"; } ?>>25</option>
                        <option value="50" <?php if($perpage == 50){ echo "selected"; } ?>>50</option>
                        <option value="100" <?php if($perpage == 100){ echo "selected"; } ?>>100</option>-->
                    </select>
                    Rows
                  </label>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="matrialprogress"  style="display:none"><div class="indeterminate"></div></div>
          <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered dataTable" >
            <thead>
              <tr role="row">
                <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
                <th class="width25"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top"  title="Select All" id="select_all" /></th>
                <th class="width25"><i class="fa fa-laptop" data-toggle="tooltip" data-placement="top" title="Featured">&nbsp;</i></th>
                <th><span class="fa fa-picture-o" data-toggle="tooltip" data-placement="top" title="Image"></span> </th>
                <th>Name</th>
                <th>Category </th>
                <th>Date</th>
                <th>Owned by</th>
                <th class="width25">Order </th>
                <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
              <tr class="">
                <td>1</td>
                <td><input type="checkbox" name="hotel_ids[]" value="" class="selectedId"  /></td>
                <td>
                  <span class="fa fa-star featured-star" id="" data-toggle="tooltip" data-placement="right" title="Featured "></span>
                  <a class='inline' href="#"  ><span class="featured-star"><i class="fa fa-star-o" id="" data-toggle="tooltip" data-placement="right" title="Not Featured"></i></span></a>
                </td>
                <td class="zoom_img">
                  <img src="http://home/v2/uploads/global/default/hotel.png" />
                </td>
                <td><a href="#">A Memorable Honeymoon Trip to India</a></td>
                <td><a href="#">Adventures</a></td>
                <td><a href="#">02/02/06</a></td>
                <td><a href="#">Admin Hussain</a></td>
                <td>
                  <input style="width:65px" class="form-control input-sm" type="number" id="order" />
                </td>
                <td>
                  <?php echo PT_ENABLED; ?>
                  <?php echo PT_DISABLED; ?>
                </td>
                <td align="center">
                  <?php echo PT_DEL; ?>
                  <?php echo PT_EDIT; ?>
              </tr>
            </tbody>
          </table>
          <div class="col-xs-12">
            <div class="pull-left">
              <div class="dataTables_info" >
                Total Records: <!--<?php echo $h_data_nums['nums'];?>,-->
                Showing<!-- <?php echo $p_fro;?> of <?php echo $paginationCount['total'];?>   -->
              </div>
            </div>
            <div class="pull-right">
              <ul class="pagination" style="margin: 0">
                <!--       <?php echo $paginationCount['pages'];  ?>     -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!------Featured Box ---->
    <div style='display:none'>
      <?php
        foreach($h_data['all'] as $hfdata){
        ?>
      <div id="Featured_Inline_<?php echo $hfdata->hotel_id;?>" style='padding:30px; background:#fff;'>
        <form method="POST" action="<?php echo base_url().$adminsegment;?>/hotelajaxcalls/update_featured" class="form-horizontal my-form">
          <div class="form-group">
            <label class="col-md-3 control-label">Featured </label>
            <div class="col-md-3">
              <select data-placeholder="Yes" id="isfeatured_<?php echo $hfdata->hotel_id;?>" class="form-control" name="isfeatured" onchange="foreverOpt(this.options[this.selectedIndex].value,<?php echo $hfdata->hotel_id;?>)" >
                <option value="1" <?php if($hfdata->hotel_is_featured == "1"){echo "selected";}?> >Yes</option>
                <option value="0" <?php if($hfdata->hotel_is_featured == "0"){echo "selected";}?>  >No</option>
              </select>
            </div>
            <!---- <div id="featuredf_<?php echo $hfdata->hotel_id;?>" class=""> --->
            <div class="form-group">
              <label class="col-md-1 control-label">From </label>
              <div class="col-md-3">
                <input class="form-control dpd1" type="text" id="dfrom_<?php echo $hfdata->hotel_id;?>" placeholder="From" value="<?php if(empty($hfdata->hotel_featured_forever)){ echo pt_show_date_php($hfdata->hotel_featured_from);}?>" name="ffrom" <?php if(!empty($hfdata->hotel_featured_forever)){echo "disabled";}?>>
              </div>
            </div>
            <!--------</div>----->
          </div>
          <!---- <div id="when_<?php echo $hfdata->hotel_id;?>" style=<?php if($hfdata->hotel_is_featured == '0'){echo "display:none;";}?> > -------->
          <div class="form-group">
            <label class="col-md-3 control-label">When</label>
            <div class="col-md-3">
              <select data-placeholder="Forever" class="form-control" id="whendata_<?php echo $hfdata->hotel_id;?>" name="foreverfeatured" onchange="fdateOpt(this.options[this.selectedIndex].value,<?php echo $hfdata->hotel_id;?>)" <?php if($hfdata->hotel_is_featured == '0'){echo "disabled";}?>>
                <option value="forever" <?php if(!empty($hfdata->hotel_featured_forever)){echo "selected";}?> >Forever</option>
                <option value="bydate" <?php if(empty($hfdata->hotel_featured_forever)){echo "selected";}?> >By Date</option>
              </select>
            </div>
            <!----- <div id="featuredt_<?php echo $hfdata->hotel_id;?>" class="<?php if(empty($hfdata->hotel_featured_from)){echo "hide-it";}?>"> --------->
            <div class="form-group">
              <label class="col-md-1 control-label">To</label>
              <div class="col-md-3">
                <input class="form-control dpd2" id="dto_<?php echo $hfdata->hotel_id;?>" type="text" placeholder="To" value="<?php if(empty($hfdata->hotel_featured_forever)){echo pt_show_date_php($hfdata->hotel_featured_to);}?>" name="fto"  <?php if(!empty($hfdata->hotel_featured_forever)){echo "disabled";}?> >
              </div>
            </div>
            <!------  </div>----->
          </div>
          <!----</div> --->
          <input type="hidden" name="hotelid" value="<?php echo $hfdata->hotel_id;?>" />
          <button type="submit" id="<?php echo $hfdata->hotel_id;?>" class="btn btn-primary btn-block btn-lg updatefeatured"> Done </button>
        </form>
      </div>
      <?php
        }

        ?>
    </div>
    <!------Featured Box ---->
  </div>
  <!------Featured Box ---->
</div>