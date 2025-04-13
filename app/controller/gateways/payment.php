<?php $router->post('payment', function() {

// $_POST['payment_gateway'];74
$payload = $_POST['payload'];
$gateway = $_POST['payment_gateway'];

// in case price was sent through post instead payload
if (isset($_POST['price'])) { $price = $_POST['price']; }
else { $price = ""; }

foreach ($_SESSION['app']->payment_gateways as $item){

if ($item->title == $gateway ) {
$c1 = $item->c1;
$c2 = $item->c2;
$c3 = $item->c3;
$c4 = $item->c4;
$c5 = $item->c5;
$dev = $item->dev;

if ($item->dev == false ){
$url = $item->pro_endpoint;
} else {
$url = $item->dev_endpoint;
}; } };

// dd($payload);

echo '
<div class="loader">
<div class="spinner"></div>
<div class="airport-loader"></div>
</div>

<style>
.loader{text-align: center; display: none; height: 90vh; display: flex !important; margin: 0 auto; justify-content: center; align-items: center; background: #fff; margin-left: 50%;}
@media screen and (min-width:600px){.loader{}
}.spinner{margin-left:auto;margin-right:auto;text-align:center;border:4px solid #f2f2f2;border-top:4px solid #ff6259;border-top:4px solid #007cff;border-radius:50%;width:30px;height:30px;-webkit-animation:spin .45s linear infinite;-moz-animation:spin .45s linear infinite;-o-animation:spin .45s linear infinite;animation:spin .45s linear infinite}
@media screen and (min-width:600px){.spinner{width:28px;height:28px}
}.airport-loader{position:relative;margin-top:15px;margin-left:15px;margin-right:15px;width:calc(100% - 30px);text-align:center;background:#fff}
@media screen and (min-width:600px){.airport-loader{margin:0;margin-top:15px;display:inline-block;vertical-align:top}
}/*! CSS Used keyframes */@-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}
100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}
}@-moz-keyframes spin{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}
100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}
}@-o-keyframes spin{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}
100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}
}@keyframes spin{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}
100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}
}</style>

<form id="form" action="'.root.'payment/'.$gateway.'" method="post">
<input type="hidden" name="payload" value="'.$payload.'" />
<input type="hidden" name="payment_gateway" value="'.$gateway.'" />
<input type="hidden" name="url" value="'.$url.'" />
<input type="hidden" name="c1" value="'.$c1.'" />
<input type="hidden" name="c2" value="'.$c2.'" />
<input type="hidden" name="c3" value="'.$c3.'" />
<input type="hidden" name="c4" value="'.$c4.'" />
<input type="hidden" name="c5" value="'.$c5.'" />
<input type="hidden" name="price" value="'.$price.'" />
<input type="hidden" name="dev" value="'.$dev.'" />
</form>

<script>
setInterval(function() { document.getElementById("form").submit(); }, 2000);
</script>
';
});