

<form id="visa-submit" method="post">
    <div class="main_search contact-form-action">
        <div class="row g-1">
            <div class="col-md-4">
                <div class="input-wrapper">
                    <span class="input-label"><?=T::fromcountry?></span>
                    <div class="form-group">
                        <span class="la la-flag form-icon"></span>
                        <div class="input-items">
                        <select id="from_country" name="city" class="select_ form-control" required>
                            <option value=""><?=T::selectcountry?></option>
                            <?php countries(); ?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-wrapper">
                    <span class="input-label"><?=T::tocountry?></span>
                    <div class="form-group">
                        <span class="la la-flag form-icon"></span>
                        <div class="input-items">
                        <select id="to_country" name="city" class="select_ form-control" required>
                            <option value=""><?=T::selectcountry?></option>
                            <?php countries(); ?>
                        </select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <span class="input-label"><?=T::date?></span>
                <div class="form-group">
                <span class="la la-calendar form-icon"></span>
                <input name="checkin" class="dp form-control form-control-lg" id="date" type="text" placeholder="" value="<?php $d=strtotime("+10 Days"); echo date("d-m-Y", $d);?>" readonly="readonly"/>
                </div>
            </div>
            <div class="col-md-2">
             <div class="btn-search text-center">
              <button type="submit" id="submit" class="effect" data-style="zoom-in"><i class="mdi mdi-search"></i> <?=T::submit?></button>
             </div>
            </div>
        </div>
    </div>
</form>

<script>
// visa submit
$("#visa-submit").submit(function() {
event.preventDefault();
var from_co = $('#from_country').val().toLowerCase();
var to_co = $('#to_country').val().toLowerCase();
var date = $('#date').val();
var from_c = from_co.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var to_c = to_co.split(',').slice(0, 1).join(' ').split(' ').join('-').replace('%40', '@');
var finelURL = '<?=visa?>'+'/'+'submit'+'/'+from_c+'/'+ to_c+'/'+date;
// alert(finelURL);
window.location.href = '<?=root?>'+finelURL; });
</script>