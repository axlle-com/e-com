<?php

use App\Common\Models\Page\Page;
use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var $title string
 * @var $model Page
 */

?>
@extends($template.'layout',['title' => $model->title ?? ''])
@section('content')
    <main class="history__main unselectable">
        <div class="history__wrap">
            <div class="history__item">
                <div class="history__text">
                    <h4 class="history__title">
                        <?= $model->title ?>
                    </h4>
                    <?= $model->description ?>
                </div>
            </div>
        </div>
    </main>
@endsection
