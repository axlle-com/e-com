<?php

$success = session('success', []);
$error = session('error', []);
$array = $error ?: $success;


?>
<?php if ($error || $success){ ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="<?= $error ? 'alert alert-danger' : 'alert alert-success' ?>" role="alert">
                <?php foreach ($array as $error) { ?>
                <div><?= $error ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
