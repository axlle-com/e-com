<?php

/**
 * @var $model DocumentOrder
 */

use App\Common\Models\Catalog\Document\DocumentOrder;

$contents = $model->contents ?? [];
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
<body>
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
<table class="table table-bordered table-sm has-checkAll mb-0">
    <thead class="thead-primary">
    <tr>
        <th scope="col" class="width-7">№</th>
        <th scope="col">Продукт</th>
        <th scope="col">Цена</th>
        <th scope="col">Количество</th>
        <th scope="col">Сумма</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;$sum = 0 ?>
    <?php foreach ($contents as $content){ ?>
    <?php $sumCol = 0 ?>
    <tr>
        <?php $sum += ($content->price * $content->quantity) ?>
        <?php $sumCol += ($content->price * $content->quantity) ?>
        <?php $i++; ?>
        <td><?= $i ?></td>
        <td><?= $content->product_title ?></td>
        <td class="text-align-end"><?= _price($content->price) ?></td>
        <td class="text-align-end"><?= $content->quantity ?></td>
        <td class="text-align-end"><?= _price($sumCol) ?></td>
    </tr>
    <?php } ?>
    <tr class="thead-primary">
        <td colspan="4" class="text-align-end">Итого:</td>
        <td colspan="1" class="text-align-end"><?= _price($sum) ?></td>
    </tr>
    </tbody>
</table>
</body>
