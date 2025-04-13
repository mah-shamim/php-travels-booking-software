<?php echo $errormsg;?>
<div class="panel panel-default">
    <div class="panel-heading">Flights Prices</div>
    <div class="panel-body">
        <form action="" method="POST" autocomplete="off">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="required">From Date</label>
                    <input type="text" placeholder="From" name="fromdate" class="form-control input-sm dpd1" value="<?php echo set_value('fromdate'); ?>"/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="required">To Date</label>
                    <input type="text" placeholder="To" name="todate" class="form-control input-sm dpd2" value="<?php echo set_value('todate'); ?>"/>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="well well-sm">
                <div class="col-md-2">
                    <label class="required"><strong>Adults</strong> Price</label>
                    <div class="input-group" >
                     <input type="number" step="any" name="adults" id="new_adults" class="form-control input-sm" placeholder="<?php echo $appSettings->currencysign;?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="required"><strong>Children</strong> Price</label>
                        <input type="number" step="any" id="new_childs" name="childs" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="required"><strong>Infants</strong> Price</label>
                        <input type="number" step="any" id="new_infants" name="infants" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <div>&nbsp;</div>
                        <input type="hidden" name="action" value="add" />
                        <input type="hidden" name="flightid" value="<?php echo $flightid;?>" />
                        <input type="hidden" name="dateformat" value="<?php echo $appSettings->dateFormat;?>" />
                        <button class="btn btn-primary btn-lg" style="font-size:14px;margin-top:6px" type="submit">Add</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
        <div class="clearfix"></div>
        <hr>
        <form action="" method="POST">
            <table class="table table-striped form-horizontal">
                <thead>
                <tr>
                    <th>Date From - To</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Infants</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($prices as $p): ?>
                    <tr id="tr_<?php echo $p->id;?>">
                        <th><?php echo formatFullDate($p->date_from, $appSettings->dateFormat); ?> - <?php echo formatFullDate($p->date_to, $appSettings->dateFormat); ?></th>
                        <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][adults]"; ?>' id="<?php echo $p->id;?>_adults" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->adults;?>" /></td>
                        <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][childs]"; ?>' id="<?php echo $p->id;?>_childs" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->childs;?>" /></td>
                        <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][infants]"; ?>' id="<?php echo $p->id;?>_infants" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->infants;?>" /></td>
                        <td><span class="btn btn-sm btn-danger delete" id="<?php echo $p->id;?>"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <div class="panel-footer">
        <input type="hidden" name="action" value="update" />
        <button class="btn btn-primary" type="submit"> Update </button>
    </div>
    </form>
</div>
<style>.input{width:100px}</style>
<script type="text/javascript">
    $(function(){
        $(".delete").click(function(){
            var id =  $(this).attr('id');
            $.alert.open('confirm', 'Are you sure you want to delete', function(answer) {
                if (answer == 'yes'){
                    $.post("<?php echo $delurl;?>", { id: id }, function(theResponse){
                        $("#tr_"+id).fadeOut('slow');
                    });
                }
            });
        });
    });
</script>