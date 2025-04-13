<div class="dashboard-bread dashboard--bread">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="breadcrumb-content">
          <div class="section-heading">
            <h2 class="sec__titles font-size-30 cw"><?php echo trans('074');?></h2>
          </div>
          </div><!-- end breadcrumb-content -->
          </div><!-- end col-lg-6 -->
              </div><!-- end row -->
            </div>
          </div>
          <!-- end dashboard-bread -->
          <!-- CONTENT -->
          <div class="dashboard-main-content">
            <div class="clearfix"></div>
            <div class="container-fluid">
              <!-- CONTENT -->
              <div class="row">
                <!-- LEFT MENU -->
                <div class="col-lg-12">
                  <div class="form-box">
                    <div class="clearfix"></div>

<?php if(!empty($wishlist)){ ?>
<div class="form-content">
    <div class="table-form table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><?=trans('0662');?></th>
                    <th scope="col"><?=trans('089');?></th>
                    <th scope="col"><?=trans('08');?></th>
                    <th scope="col"><?php echo trans('0109');?></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 0; foreach($wishlist as $wl){ $count++;  ?>
                <tr>
                    <th scope="row"><img alt="" class="go-right img-responsive" style="max-width:96px" src="<?php echo $wl->thumbnail;?>"></th>
                    <td>
                        <div class="table-content">
                            <h3 class="title"><span class="stars"><?php echo $wl->stars;?></span><br><?php echo $wl->title;?></h3>
                        </div>
                    </td>
                    <td><?php echo $wl->date;?></td>
                    <td><a class="btn btn-sm btn-primary btn-block" href="<?php echo $wl->slug;?>" target="_blank">
                        <?php echo trans('0109');?>
                    </a></td>
                    <td><span class="btn btn-sm btn-block btn-danger removewish remove_btn" id="<?php echo $wl->wishid;?>"><?php echo trans('0108');?></span></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php }else{  ?>
<h4><?php echo trans('0110');?></h4>
<?php } ?>

</div>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>