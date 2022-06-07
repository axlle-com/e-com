<?php

use App\Common\Models\User\UserWeb;

/**
 * @var $user UserWeb
 */


?>
<body>
<p> Для активации аккаунта пройдите по ссылке
    <a href="<?= trim(env('APP_URL'), '/') . '/user/verification-token?value=' . $user->token->token ?>">Активация</a>
</p>
</body>
