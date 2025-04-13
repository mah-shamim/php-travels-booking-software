<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1><strong style="font-size:100px">Oops!</strong></h1>
                <h3><strong><?php echo trans('0267');?></strong> </h3>
                <div class="error-details">
                   <?php echo trans('0268');?>
                </div>
                <div class="error-actions">
                <div class="col-md-6">
                <div class="pull-right">
                    <form action="<?php echo base_url(); ?>" method="post"><button type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-home"></span> <?php echo trans('0269');?></button></form>
                </div>
                </div>
                <div class="col-md-6">
                <div class="pull-left">
                    <form action="<?php echo base_url().'contact-us';?>" method="post"><button type="submit" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> <?php echo trans('0270');?></button></form>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.error-template {padding: 40px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
</style>