<div class="container">
<div class="row">
  <div class="col-md-7 go-right">
    <h2 class="go-right"><strong><?php echo character_limiter($offer->title, 28);?></strong></h2>
    <div class="clearfix"></div>
  </div>
  <div class="col-md-5">
    <div class="row">
      <div class="visible-lg visible-md col-md-6 go-right" style="margin-top:10px">
        <h3><span class="go-text-right"><?php echo trans('070');?></span> <?php echo $offer->currSymbol; ?><strong><?php echo $offer->price;?></strong></h3>
      </div>
      <div class="col-md-6 go-left" style="margin-top:20px">
        <a class="btn btn-primary pull-right btn-block" data-toggle="modal" href="#call" ><?php echo trans('0438');?></a>
      </div>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="call" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo trans('0438');?></h4>
      </div>
      <div class="modal-body">

      <div class="form-group">
                <div class="col-md-12">
                <h3 class="text-danger text-center"><i class="fa fa-phone"></i> <?php echo $offer->phone;?></h3>
                 </div>
              </div>
            <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans('0234');?></button>
      </div>
    </div>
  </div>
</div>