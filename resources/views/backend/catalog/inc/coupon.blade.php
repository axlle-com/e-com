<?php

use App\Common\Models\Catalog\Property\CatalogProperty;use App\Common\Models\Catalog\Property\CatalogPropertyUnit;

/* @var $coupons CatalogC[]
 * @var $property CatalogProperty
 * @var $units CatalogPropertyUnit[]
 * @var $properties CatalogProperty[]
 * @var
 */
?>
<?php if(isset($coupons) && count($coupons)){ ?>
    <li class="coupon-item">
        <div class="row coupon-item-block">
            <div class="col-md-3">
                <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                    <input type="checkbox" class="custom-control-input" id="inbox-2">
                    <label for="inbox-2" class="custom-control-label"></label>
                </div>
                <div class="coupon-item-block-number">Facebook</div>
            </div>
            <div class="col-md-5 coupon-item-block-user">Пользователь</div>
            <div class="col-md-2 coupon-item-block-status"><span>Новый</span></div>
            <div class="col-md-2 coupon-item-block-time">21.21.2121</div>
        </div>
    </li>
<?php } ?>

