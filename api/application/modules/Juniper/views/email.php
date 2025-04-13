<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<style type="text/css">
body {
	font-size: 13px !important;
}
.table-email {
	border-collapse: collapse;
	border:1px solid #f1f1f1 !important;
	border-radius: 5px;
	overflow: hidden;
}

.table-email td{
	padding: 5px;
	padding-left: 15px;
	font-size: 13px !important;
	border-bottom: 1px solid #f1f1f1;
}
.border {
	padding: 10px;
	border:1px solid #f1f1f1;
	border-radius: 5px;
	width:auto;
}
</style>
<div class="container">
	<br>
	<div class="border">
		<h3>User Information</h3>
		<hr>
		<p><strong>Name : </strong>&nbsp;<?php echo $email['firstname']; ?>&nbsp;<?php echo $email['lastname']; ?></p>
		<p><strong>Email : </strong>&nbsp;<?php echo $email['email']; ?></p>
		<p><strong>Phone</strong>&nbsp;<?php echo $email['phone']; ?></p>
		<p><strong>Address : </strong>&nbsp<?php echo $email['email']; ?>;</p>
	</div>
	<br>
	<div class="border">
		<h3>Booking Summary</h3>
		<hr>
		<?php
		$count = count($email['carrier_code']);
		for ($i=0; $i < $count ; $i++) { ?>
			<table class="table-email">
				<tbody>
					<tr>
						<td><img class="img-thumbnail" style="max-width: 100px;" src="<?php echo base_url(); ?>uploads/images/flights/airlines/<?php echo $email['carrier_code'][$i]; ?>.png" class="img-responsive" alt="">
						</td>
						<td><?php echo $email['iataCode_departure'][$i]; ?> <i class="fa fa-arrow-right RTL"></i> <?php echo $email['iataCode_arrival'][$i]; ?></td>
					</tr>
					<tr>
						<td>Departure date & time  From <?php echo $email['iataCode_departure'][$i]; ?></td>
						<td><span class="pull-right"><?php echo date("D d-M-Y h:i:s a", strtotime($email['departure_at'][$i])); ?></span></td>
					</tr>
					<tr>
						<td>Arrival date & time at <?php echo $email['iataCode_arrival'][$i]; ?></td>
						<td class="pull-right"><?php echo date("D d-M-Y h:i:s a", strtotime($email['arrival_at'][$i])); ?></td>
					</tr>
					<tr>
						<td>Traveling Duration <?php echo $email['iataCode_arrival'][$i]; ?></td>
						<td class="pull-right">
							<?php 
							$time1 = strtotime($email['departure_at'][$i]);
							$time2 = strtotime($email['arrival_at'][$i]);
							$difference = round(abs($time2 - $time1) / 3600,2);
							echo $difference; 
							?> Hours
						</td>
					</tr>
				</tbody>
			</table>
		<?php }
		?>
	</div>
	<br>
	<div class="border">
		<h3>Passenger Details</h3>
		<hr>
		<?php   if ($email['madult'] > 0) { ?>
			<table class="table-email">
				<tr>
					<td>Adults</td>
					<td style="text-align: right;"><?php echo $email['madult'];  ?></td>
				</tr>
				<tr>
					<td>Price Per Adult</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerAdult']['total']; ?><input type="hidden" name="madult[total]" value="<?php echo $email['pricePerAdult']['total']; ?>"></td>
				</tr>
				<tr>
					<td>Tax Per Adult</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerAdult']['totalTaxes']; ?>
					<input type="hidden" name="madult[totalTaxes]" value="<?php echo $email['pricePerAdult']['totalTaxes']; ?>"></td>
				</tr>
				<tr>
					<td>Total Amount for Adult</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol']; echo ($email['madult']*$email['pricePerAdult']['total']) + ($email['madult']*$email['pricePerAdult']['totalTaxes']);  ?></td>
				</tr>
			</table>
			<br>
		<?php } ?>
		<?php   if ($email['mchildren'] > 0) { ?>
			<table class="table-email">
				<tr>
					<td>Childs</td>
					<td style="text-align: right;"><?php echo $email['mchildren'];  ?></td>
				</tr>
				<tr>
					<td>Price Per Child</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerChild']['total']; ?><input type="hidden" name="mchildren[total]" value="<?php echo $email['pricePerChild']['total']; ?>"></td>
				</tr>
				<tr>
					<td>Tax Per Child</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerChild']['totalTaxes']; ?><input type="hidden" name="mchildren[totalTaxes]" value="<?php echo $email['pricePerChild']['totalTaxes']; ?>"></td>
				</tr>
				<tr>
					<td>Total Amount for Child</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol']; echo ($email['mchildren']*$email['pricePerChild']['total']) + ($email['mchildren']*$email['pricePerChild']['totalTaxes']);  ?></td>
				</tr>
			</table>
			<br>
		<?php } ?>
		<?php   if ($email['minfant'] > 0) { ?>
			<table class="table-email">
				<tr>
					<td>Infants</td>
					<td style="text-align: right;"><?php echo $email['minfant'];  ?></td>
				</tr>
				<tr>
					<td>Price Per Infant</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerInfant']['total']; ?><input type="hidden" name="minfant[total]" value="<?php echo $email['pricePerInfant']['total']; ?>"></td>
				</tr>
				<tr>
					<td>Tax Per Infant</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerInfant']['totalTaxes']; ?><input type="hidden" name="minfant[totalTaxes]" value="<?php echo $email['pricePerInfant']['totalTaxes']; ?>"></td>
				</tr>
				<tr>
					<td>Total Amount for Infants</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol']; echo ($email['minfant']*$email['pricePerInfant']['total']) + ($email['minfant']*$email['pricePerInfant']['totalTaxes']);  ?></td>
				</tr>
			</table>
			<br>
		<?php } ?>
		<?php   if ($email['seniors'] > 0) { ?>
			<table class="table-email">
				<tr>
					<td>Seniors</td>
					<td style="text-align: right;"><?php echo $email['seniors'];  ?></td>
				</tr>
				<tr>
					<td>Price Per Seniors</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerSenior']['total']; ?><input type="hidden" name="seniors[total]" value="<?php echo $email['pricePerSenior']['total']; ?>"></td>
				</tr>
				<tr>
					<td>Tax Per Seniors</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol'].$email['pricePerSenior']['totalTaxes']; ?><input type="hidden" name="seniors[totalTaxes]" value="<?php echo $email['pricePerSenior']['totalTaxes']; ?>"></td>
				</tr>
				<tr>
					<td>Total Amount for Seniors</td>
					<td style="text-align: right;"><?php echo $email['currency']." " .$email['currencysymbol']; echo ($email['minfant']*$email['pricePerSenior']['total']) + ($email['seniors']*$email['pricePerSenior']['totalTaxes']);  ?></td>
				</tr>
			</table>
			<br>
		<?php } ?>
	</div>

	<br>
	<div class="border">
		<h3>Payment Information</h3>
		<hr>
		<div class="total_table">
			<div class="booking-deposit">
			</div>
			<table class="table-email">
				<tbody>
					<tr class="beforeExtraspanel">
						<td>
							Tax                                      
						</td>
						<td class="text-right">
							<?php echo $email['currency']." ".$email['currencysymbol']. number_format($email['totalTaxes'],2); ?> 
						</td>
					</tr>
					<tr>
						<td class="booking-deposit-font">
							<strong>Ticket Amount</strong>
						</td>
						<td class="text-right">
							<?php echo $email['currency']." " .$email['currencysymbol']. number_format($email['total_with_commission'],2); ?>
							<input type="hidden" name="total_with_commission" value="<?php echo $email['total_with_commission']; ?>">
						</td>
					</tr>
					<tr class="tr10">
						<td class="booking-deposit-font">
							<strong>Total Amount</strong>
						</td>
						<td class="text-right">
							<?php echo $email['currency']." " .$email['currencysymbol']; echo " ". number_format($email['total_with_commission']+$email['totalTaxes'],2); ?>
							<input type="hidden" name="total_amount_with_tax" value="<?php echo $email['total_with_commission']+$email['totalTaxes']; ?>">
							<input type="hidden" name="totalPrice" value="<?php echo $email['total']; ?>">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>