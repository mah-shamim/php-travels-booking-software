<?php 
if($_SESSION['provider'] == '1G') {
    $hotelDetailsResp = $hotelDetail->RequestedHotelDetails->HotelRateDetail;
} else {
    $hotelDetailsResp = $hotelDetail->AggregatorHotelDetails->HotelRateDetail;
}
?>
<div class="room-cards">
    <?php if(! empty($hotelDetailsResp) ): ?>
        <?php if( ! is_array($hotelDetailsResp) ) {
            $hotelDetailsResp = [$hotelDetailsResp];
        } ?>
        <?php foreach($hotelDetailsResp as $index => $room): ?>
        <div class="room-card">
            <div class="room-card__container">
                <div class="room-card__body">
                    <div class="room-card__content">
                        <div class="room-card__image-box">
                            <img class="room-card__image" src="<?php echo $theme_url; ?>assets/img/hotel.jpg">
                        </div>
                        <div class="room-card__content--left">
                            <table>
                                <tbody>
                                    <?php $room->RoomRateDescription = (is_array($room->RoomRateDescription))?$room->RoomRateDescription:[$room->RoomRateDescription]; ?>
                                    <?php foreach($room->RoomRateDescription as $roomDescription): ?>
                                        <?php if($roomDescription->Name != 'Supplier Terms and Conditions'): ?>
                                        <tr>
                                            <td class="strong" style="padding-right:15px"><?=$roomDescription->Name?></td>
                                            <td><?=(is_array($roomDescription->Text))?implode(' ', $roomDescription->Text):$roomDescription->Text?></td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <table>
                                <div class="clearfix"></div>
                                <span class="btn btn-warning btn-xs" type="button" data-toggle="collapse" data-target="#roomDetails_<?=$index?>" aria-expanded="false" aria-controls="roomDetails_<?=$index?>">
                                    More Details
                                </span>

                                <div class="collapse" id="roomDetails_<?=$index?>">
                                <?php if($_SESSION['provider'] == '1G'): ?>
                                    <div class="well">
                                        <strong>Cancellation Policy:</strong> <?=($room->CancelInfo->NonRefundableStayIndicator)?'Payment is non-refundable':'Payment is refundable'?><br/>
                                        <strong>Commission:</strong> <?=($room->Commission->Indicator)?"Rate is commissionable":"No Commission"?><br/>
                                        <strong>Commission Percent:</strong> <?=$room->Commission->Percent?><br/>
                                        <strong>Guarantee Type:</strong> <?=$room->GuaranteeInfo->GuaranteeType?><br/>
                                    </div>
                                <?php else: ?>
                                    <div class="well">
                                        <strong>Room Capicity:</strong> <?=$room->RoomCapacity->Capacity?><br/>
                                        <strong>Supplemental Rate Info:</strong> <?=$room->SupplementalRateInfo?><br/>
                                        <strong>Cancellation Policy:</strong> <?=$room->CancelInfo->CancellationPolicy?><br/>
                                        <strong>Commission:</strong> <?=($room->Commission->Indicator)?"Rate is commissionable":"No Commission"?><br/>
                                        <strong>CommissionAmount:</strong> <?=$room->Commission->CommissionAmount?><br/>
                                        <strong>AcceptedPayment:</strong> <?=implode(', ', array_column($room->AcceptedPayment, 'PaymentCode'))?><br/>
                                        <strong>Guarantee Type:</strong> <?=$room->GuaranteeInfo->GuaranteeType?><br/>
                                    </div>
                                <?php endif; ?>
                                </div>
                            </table>
                        </div>
                        <div class="room-card__content--right">
                            <div class="room-price__container">
                                <span class="text-l c-dark-blue"><?=$room->Total?></span>
                            </div>
                            <span class="text-xs-regular c-text-grey">Total price including taxes and fees</span>
                            <form action="<?=base_url('hotelport/checkout')?>" method="post">
                                <input type="hidden" name="RatePlanType" value="<?=$room->RatePlanType?>"/>
                                <input type="hidden" name="GuaranteeType" value="<?=$room->GuaranteeInfo->GuaranteeType?>"/>
                                <input type="hidden" name="checkinDate" value="<?=$checkinDate?>"/>
                                <input type="hidden" name="checkoutDate" value="<?=$checkoutDate?>"/>
                                <input type="hidden" name="adults" value="<?=$adults?>"/>
                                <br>
                                <button class="core-btn-primary room-card__book-now-btn" type="submit">Book now</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="room-card__information">
                    <div class="row top-xs">
                        <div class="col-xs-12 col-sm-6">
                            <div class="box text-s-regular c-text-grey"><strong>1 King Bed</strong><br>431 sq feet (40 sq meters)<br><br><b>Layout</b> - Separate sitting area<br><b>Internet</b> - Free WiFi <br> <b>Entertainment</b> - 32-inch flat-screen TV with premium channels<br><b>Food &amp; Drink</b> - Coffee/tea maker, minibar, electric kettle, and 24-hour room service<br><b>Sleep</b> - Egyptian cotton linens, blackout drapes/curtains, and turndown service <br><b>Bathroom</b> - Private bathroom, bathrobes, and a shower/tub combination with a rainfall showerhead<br><b>Practical</b> - Safe, free newspaper, and phone; rollaway/extra beds and free cribs/infant beds available on request<br><b>Comfort</b> - Air conditioning and daily housekeeping<br>Smoking/Non Smoking, renovated in November 2016<br>Connecting/adjoining rooms can be requested, subject to availability <br>&nbsp;</div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="box">
                                <span class="text-s-medium c-dark-blue">
                                Room Details
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>