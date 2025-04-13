<?php

$res = json_decode($bookingResult);

$pnr = $res->result->pnr;

?>

<div class="container">

<div class="center-block">

<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">

<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>

<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>

</svg>

</div>

<div class="text-center">

<h2 data-wow-duration="0.5s" data-wow-delay="1s" class="wow fadeIn"><strong>Booking Confirmed</strong></h2>

<p data-wow-duration="0.5s" data-wow-delay="1.5s" class="wow fadeInDown">We have reserved your details.</p>

<p data-wow-duration="0.5s" data-wow-delay="1.8s" class="wow fadeInDown">Soon you will receive a confirmation from agency to your email.</p>

<div data-wow-duration="0.5s" data-wow-delay="3s" class="wow fadeIn">

<hr>

<a target="_black" href="<?=$invoice?>" class="btn btn-primary">Check Your Invoice</a>

<hr>

<h4>Booking PNR : <strong><?php echo $bookingResult->result->pnr; ?></strong></h4>

</div>

</div>

</div>

<br><br><br>