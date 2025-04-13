<!-- <form action="<?php echo site_url('Gateways/vtweb/vtweb_checkout'); ?>" method="POST" id="payment-form">
	<input type="hidden" name="payload" value="<?php echo base64_encode(json_encode($params)); ?>"/>
	<button class="submit-button" type="submit">Pay Now</button>
</form> -->


<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript"
            src="<?= trim($params['apiUrl'], '/') ?>/snap/snap.js"
            data-client-key="<?=$params['clientKey']?>"></script>
  </head>
  <body>
    <button id="pay-button">Pay!</button>
    <script type="text/javascript">
		var payButton = document.getElementById('pay-button');
		payButton.addEventListener('click', function () {
			setTimeout(function() {
				$('#paynow').modal('hide');	
			}, 3000);
			
			snap.pay('<?=$response->token?>', {
				onSuccess: function(result){console.log('success');console.log(result);},
				onPending: function(result){console.log('pending');console.log(result);},
				onError: function(result){console.log('error');console.log(result);},
				onClose: function(){console.log('customer closed the popup without finishing the payment');}
			});
		});
    </script>
  </body>
</html>
