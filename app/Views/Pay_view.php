<!DOCTYPE html>
<html lang="en">
<link rel="shortcut icon" href="<?=root;?>uploads/global/favicon.png">
<head>
<?php 
$payload = json_decode(base64_decode($_POST['payload'])); 
// REDIRECT USERTO HOMEPAGE IF THERE IS ANY ERROR 
// function error_found(){ header("Location: ".root); }
// set_error_handler('error_found');
?>

<title><?=T::pay_with?> <?php echo ucfirst(str_replace('-', ' ', ($_POST['payment_gateway'])));?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta http-equiv="refresh" content="6000; <?=root?>timeout" />
</head>
<body>
<div style="width:526px">

<!-- PAYMENT GATEWAY LOGO -->
<img src="<?=root?>assets/img/gateways/<?=($_POST['payment_gateway'])?>.png" alt="payment gateways" style="max-height: 50px; display: flex; justify-content: center; align-items: center; margin: 0 auto; margin-bottom: 15px; border-radius: 10px;" />

<div class="card">
    <div class="card-header">
      <small><?=T::pay_with?> <strong><?= str_replace('-', ' ', ($_POST['payment_gateway']));?> <small><?=$payload->currency?></small> <?=number_format($payload->price,2)?></strong></small>
    </div>
    <div class="card-body">
      <?=$body?>
    </div>
</div>

<div class="btn">
<div class="btn-back">
    <p><?=T::are_you_sure?></p>
    <a href="<?=$payload->invoice_url?>" class="yes"><?=T::yes?></a>
    <button class="no"><?=T::no?></button>
</div>

<div class="btn-front" style="display:flex">
<svg style="height: 20px; fill: #000; margin: 0 8px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g> <g> <path d="M501.333,245.333H36.417l141.792-141.792c4.167-4.167,4.167-10.917,0-15.083c-4.167-4.167-10.917-4.167-15.083,0l-160,160 c-4.167,4.167-4.167,10.917,0,15.083l160,160c2.083,2.083,4.813,3.125,7.542,3.125c2.729,0,5.458-1.042,7.542-3.125 c4.167-4.167,4.167-10.917,0-15.083L36.417,266.667h464.917c5.896,0,10.667-4.771,10.667-10.667S507.229,245.333,501.333,245.333z "/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
<?=T::back_to_invoice?>
</div>
</div>
</div>

<style>
 html { box-sizing: border-box;}
*, *:before, *:after {box-sizing: inherit;}
html,body{width:100%;height:100%;margin:0;/*-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none*/}
body{display:flex;font-family:Roboto,"Helvetica Neue",sans-serif;font-size:18px;perspective:1000px;background-color:#dfe2e6;flex-direction:column;justify-content:center;align-items:center}
.description{margin-top:50px;text-align:center;color:#999;transition:opacity .3s ease}
.description a{color:#4a9df6;text-decoration:none}
.btn.is-open ~ .description{opacity:0}
.btn{display:block;position:relative;width:100%;height:50px;transition:width .8s cubic-bezier(0.23,1,0.32,1),height .8s cubic-bezier(0.23,1,0.32,1),transform .8s cubic-bezier(0.175,0.885,0.32,1.275);transform-style:preserve-3d;transform-origin:50% 50%;text-align:center}
.btn-front{ font-size: 14px; display: flex important; justify-content: center; align-items: center;position:absolute;display:block;width:100%;height:100%;line-height:50px;background-color:#ff4812;border-radius:4px;color:#fff;cursor:pointer;-webkit-backface-visibility:hidden;backface-visibility:hidden;-webkit-tap-highlight-color:rgba(0,0,0,0);transition:background .15s ease,line-height .8s cubic-bezier(0.23,1,0.32,1)}
.btn-front:hover{background-color:#f77066}
.btn.is-open .btn-front{pointer-events:none;line-height:160px}
.btn-back{position: absolute; width: 100%; height: 100%; background-color: #fff; color: #222; transform: translateZ(-2px) rotateX( 180deg ); overflow: hidden; transition: box-shadow .8s ease; border-radius: 5px;}
.btn-back p{margin-top:27px;margin-bottom:25px}
.btn-back a{padding:12px 20px;width:30%;margin:0 5px;background-color:transparent;border:0;border-radius:2px;font-size:1em;cursor:pointer;-webkit-appearance:none;-webkit-tap-highlight-color:rgba(0,0,0,0);transition:background .15s ease}
.btn-back button{padding:12px 20px;width:30%;margin:0 5px;background-color:transparent;border:0;border-radius:2px;font-size:1em;cursor:pointer;-webkit-appearance:none;-webkit-tap-highlight-color:rgba(0,0,0,0);transition:background .15s ease}
.btn-back button:focus{outline:0}
.btn-back a.yes{background-color:#2196f3;color:#fff;text-decoration:none}
.btn-back a.yes:hover{background-color:#51adf6}
.btn-back button.no{color:#2196f3}
.btn-back button.no:hover{background-color:#ddd}
.btn.is-open .btn-back{box-shadow:0px ​10px 16px rgb(0 0 0 / 4%)}
.btn[data-direction=left] .btn-back,.btn[data-direction=right] .btn-back{transform:translateZ(-2px) rotateY(180deg)}
.btn.is-open{100%;height:160px;margin: 0 auto;}
.btn[data-direction=top].is-open{transform:rotateX(180deg)}
.btn[data-direction=right].is-open{transform:rotateY(180deg)}
.btn[data-direction=bottom].is-open{transform:rotateX(-180deg)}
.btn[data-direction=left].is-open{transform:rotateY(-180deg)}
.card { margin-bottom:25px;position: relative; display: flex; flex-direction: column; min-width: 0; word-wrap: break-word; background-color: #fff; background-clip: border-box; border: 1px solid rgba(0,0,0,.125); border-radius: .25rem; }
.card-header { padding: 1rem 1rem; text-transform: capitalize; margin-bottom: 0; background-color: rgba(0,0,0,.03); border-bottom: 1px solid rgba(0,0,0,.125); }
.card-body { display:flex;flex: 1 1 auto; padding: 1rem 1rem; }
 p{margin:8px 0;font-size: 14px}
.pay {text-align:center;display:block;max-height:45px!important;text-decoration:none;border: transparent; width: 100%; padding: 17px; cursor: pointer; border-radius: 5px; color: #fff; font-weight: bold; font-size: 14px;}
.pay:hover{opacity:0.8}
.alert{background: #f6f8fa; border: 1px solid #e5eaf0; border-left: 4px solid #ff0000; font-size: 13px; border-radius: 0px; margin-bottom: 12px; padding: 14px;}
 hr{border: 1px solid #eee}

.rotatingDiv { display: block; margin: 16px auto; height: 30px; width: 30px; -webkit-animation: rotation .9s infinite linear; -moz-animation: rotation .9s infinite linear; -o-animation: rotation .9s infinite linear; animation: rotation .3s infinite linear; border-left: 2px solid rgba(0,0,0,.10); border-right: 2px solid rgba(0,0,0,.10); border-bottom: 2px solid rgba(0,0,0,.10); border-top: 2px solid rgb(0 67 191); border-radius: 100%; } @keyframes rotation { from { transform: rotate(0deg); } to { transform: rotate(359deg); } } @-webkit-keyframes rotation { from { -webkit-transform: rotate(0deg); } to { -webkit-transform: rotate(359deg); } } @-moz-keyframes rotation { from { -moz-transform: rotate(0deg); } to { -moz-transform: rotate(359deg); } } @-o-keyframes rotation { from { -o-transform: rotate(0deg); } to { -o-transform: rotate(359deg); } }
.loading { align-items: center; position: fixed; background: #fff; width: 100%; height: 100%; z-index: 999; display: flex; }

</style>

<script>
var btn=document.querySelector('.btn');var btnFront=btn.querySelector('.btn-front'),btnYes=btn.querySelector('.btn-back .yes'),btnNo=btn.querySelector('.btn-back .no');btnFront.addEventListener('click',function(event){var mx=event.clientX-btn.offsetLeft,my=event.clientY-btn.offsetTop;var w=btn.offsetWidth,h=btn.offsetHeight;var directions=[{id:'top',x:w/2,y:0},{id:'right',x:w,y:h/2},{id:'bottom',x:w/2,y:h},{id:'left',x:0,y:h/2}];directions.sort(function(a,b){return distance(mx,my,a.x,a.y)-distance(mx,my,b.x,b.y)});btn.setAttribute('data-direction',directions.shift().id);btn.classList.add('is-open')});btnYes.addEventListener('click',function(event){btn.classList.remove('is-open')});btnNo.addEventListener('click',function(event){btn.classList.remove('is-open')});function distance(x1,y1,x2,y2){var dx=x1-x2;var dy=y1-y2;return Math.sqrt(dx*dx+dy*dy)}
</script>

<div class="loading" id="loading" style="display:none">
<div class="rotatingDiv"></div>
</div>

</body>
</html>