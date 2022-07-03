<?php

$successSession = session('success', []);
$errorSession = session('error', []);
$messageSession = session('message', '');
$messageTitleSession = session('message_title', '');
$arraySession = $errorSession ?: $successSession;
if (!is_array($arraySession) || !is_object($arraySession)) {
    $arraySession = (array)$arraySession;
}
if (empty($arraySession)) {
    return [];
}
session(['success' => []]);
session(['error' => []]);
session(['message' => '']);
session(['message_title' => '']);
$titleSession = $errorSession ? 'Произошла ошибка' : 'Операция прошла успешно';
if ($messageTitleSession) {
    $titleSession = $messageTitleSession;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-accent <?= $errorSession ? 'alert-danger' : 'alert-success' ?>" role="alert">
                <h4 class="alert-heading">
                    <?= $titleSession ?>
                </h4>
                <hr>
                <?php foreach ($arraySession as $error) { ?>
                <div><?= $error ?></div>
                <?php } ?>
                <hr>
                <p class="mb-0"><?= $message ?? ''?></p>
            </div>
        </div>
    </div>
</div>
