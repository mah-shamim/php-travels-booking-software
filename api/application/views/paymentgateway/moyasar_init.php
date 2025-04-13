<style type="text/css">
    .align-left {
        text-align: left;
    }
</style>


<form accept-charset="UTF-8" action="https://api.moyasar.com/v1/payments.html" method="POST">
    <fieldset>
        <div class="row">
            <div class="col-md-6  go-right">
                <div class="form-group align-left">
                    <label class="required go-right">First Name</label>
                    <input type="text" class="form-control" name="source[name]" id="card-holder-firstname" placeholder="Username">
                </div>
            </div>
            <div class="col-md-6  go-left">
                <div class="form-group align-left">
                    <label class="required go-right">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="card-holder-lastname" placeholder="Last Name">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12  go-right">
                <div class="form-group align-left">
                    <label class="required go-right">Card Number</label>
                    <input type="text" class="form-control" name="source[number]" onkeypress="validateNumber(event, 15)" id="card-number" placeholder="Card Number" onkeypress="return isNumeric(event)">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3 go-right">
                <div class="form-group ">
                    <label style="font-size:13px" class="required  go-right">Expiration Date</label>
                    <select class="form-control col-sm-2" name="source[month]" id="expiry-month">
                        <option value="01">Jan (01)</option>
                        <option value="02">Feb (02)</option>
                        <option value="03">Mar (03)</option>
                        <option value="04">Apr (04)</option>
                        <option value="05">May (05)</option>
                        <option value="06">June (06)</option>
                        <option value="07">July (07)</option>
                        <option value="08">Aug (08)</option>
                        <option value="09">Sep (09)</option>
                        <option value="10">Oct (10)</option>
                        <option value="11">Nov (11)</option>
                        <option value="12">Dec (12)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 go-left">
                <div class="form-group">
                    <label class="required go-right">&nbsp;</label>
                    <select class="form-control" name="source[year]" id="expiry-year">
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 go-left">
                <div class="form-group">
                    <label class="required go-right">&nbsp;</label>
                    <input type="text" class="form-control" name="source[cvc]" id="cvv" placeholder="Card CVV" onkeypress="validateNumber(event, 2)">
                </div>
            </div>
            <div class="col-md-3 go-left">
                <label class="required go-right">&nbsp;</label>
                <img src="<?=base_url('assets/img/cc.png')?>" class="img-responsive">
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="form-group">
            <div class="alert alert-danger submitresult" style="display: none;"></div>
            <input type="hidden" name="source[type]" value="creditcard">
            <input type="hidden" name="publishable_api_key" value="pk_test_snd6HipaMgxfLyYV2n4kkTxRbXeQUkD9axHmH1RT">
            <input type="hidden" name="amount" value="<?=($params['amount'] * 100)?>" class="form-conrol">
            <input type="hidden" name="callback_url" value='<?=base_url("Gateways/moyasar/payment_callback/{$params['invoiceid']}")?>' />
            <button type="submit" class="btn btn-success btn-lg paynowbtn pull-left" onclick="return expcheck();">Pay Now</button>
        </div>
    </fieldset>
</form>

<script type="text/javascript">
    function validateNumber(event, maxlength) {
        var key = window.event ? event.keyCode : event.which;
        if (event.keyCode === 8 || event.keyCode === 46) {
            return true;
        } else if ( key < 48 || key > 57 || event.target.value.length > maxlength) {
            event.preventDefault();
        } else {
            return true;
        }
    }
</script>