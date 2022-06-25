<?php

use App\Common\Models\Catalog\Document\DocumentOrder;

/**
 * @var $model DocumentOrder
 * @var
 */
$address = $model['address_index'] . ', ' .
    $model['address_region'] . ', ' .
    $model['address_city'] . ', ' .
    $model['address_street'] . ', ' .
    $model['address_house'] . ', ' .
    $model['address_apartment'];
$address = trim($address, ', ');
$individual = $model->individual_name
    . ' ' . $model->individual_first_name
    . ' ' . $model->individual_patronymic
    . ' Телефон: ' . _pretty_phone($model->individual_phone)
    . ' E-mail: ' . $model->individual_email;
?>
<div class="col-sm-12 mt-2">
    <ul class="list-group list-group-sm list-group-example">
        <li class="list-group-item"><strong>Покупатель: </strong>
            <span class="text-secondary"><?= $individual ?></span>
        </li>
        <li class="list-group-item"><strong>Тип доставки: </strong>
            <span class="text-secondary"><?= $model->delivery_title ?></span>
        </li>
        <li class="list-group-item"><strong>Способ оплаты: </strong>
            <span class="text-secondary"><?= $model->payment_title ?></span>
        </li>
        <li class="list-group-item"><strong>Статус оплаты: </strong>
            <span class="text-secondary"><?= $model->payment_status ?></span>
        </li>
        <li class="list-group-item"><strong>Статус доставки: </strong>
            <span class="text-secondary"><?= $model->delivery_status ?></span>
        </li>
        <?php if(!empty($model->coupon_discount)){ ?>
        <li class="list-group-item"><strong>Скидка: </strong>
            <span class="text-secondary"><?= $model->coupon_discount ?></span>
        </li>
        <?php } ?>
        <li class="list-group-item"><strong>Стоимость доставки: </strong>
            <span class="text-secondary"><?= _price($model->delivery_cost) ?></span>
        </li>
        <li class="list-group-item"><strong>Адрес доставки: </strong>
            <span class="text-secondary"><?= $address ?></span>
        </li>
    </ul>
</div>
