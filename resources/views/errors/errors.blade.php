<?php

$success = session('success', []);
$error = session('error', []);
$message = session('message', '');
$array = $error ?: $success;
if (!is_array($array) || !is_object($array)) {
    $array = (array)$array;
    session(['success' => []]);
    session(['error' => []]);
    session(['message' => '']);
}

?>
<?php if ($array){ ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-accent <?= $error ? 'alert-danger' : 'alert-success' ?>" role="alert">
                <h4 class="alert-heading">
                    <?= $error ? 'Произошла ошибка' : 'Операция прошла успешно' ?>
                </h4>
                <hr>
                <?php foreach ($array as $error) { ?>
                <div><?= $error ?></div>
                <?php } ?>
                <hr>
                <p class="mb-0"><?= $message ?? ''?></p>
            </div>
        </div>
    </div>
</div>
<?php } ?>
