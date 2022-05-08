<?php

use App\Common\Models\Catalog\CatalogCoupon;

/* @var $coupons CatalogCoupon[]
 * @var
 */
?>
<?php if(isset($coupons) && count($coupons)){ ?>
<?php foreach ($coupons as $coupon){ ?>
<li class="coupon-item">
    <div class="row coupon-item-block">
        <div class="col-md-3">
            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                <input type="checkbox" class="custom-control-input" id="inbox-2">
                <label for="inbox-2" class="custom-control-label"></label>
            </div>
            <div class="coupon-item-block-number"><?= $coupon->value ?></div>
        </div>
        <div class="col-md-1 coupon-item-block-discount"><?= $coupon->discount ?> %</div>
        <div class="col-md-4 coupon-item-block-user"><?= $coupon->getUser() ?></div>
        <div class="col-md-2 coupon-item-block-status"><span><?= $coupon->getState() ?></span></div>
        <div class="col-md-2 coupon-item-block-time"><?= $coupon->getExpired() ?></div>
    </div>
</li>
<?php } ?>
<?php } ?>

