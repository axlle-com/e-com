<?php

use App\Common\Assets\MainAsset;
use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var string $title
 * @var \App\Common\Models\Blog\Post $posts
 * @var \App\Common\Models\Blog\PostCategory $category
 */

?>

<?php foreach($posts ?? [] as $post){ ?>
<div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms"
     data-wow-duration="1500ms">
    <div class="inner-box">
        <div class="image-box">
            <a href="<?= $post->getUrl() ?>">
                <img src="<?= $post->getImage() ?: '/frontend/linoor/assets/img/resource/news-1.jpg' ?>" alt=""></a>
        </div>
        <div class="lower-box">
            <div class="post-meta">
                <ul class="clearfix">
                    <li><span class="far fa-clock"></span><?= $post->getCreatedAtShot() ?></li>
                    <li><span class="far fa-user-circle"></span> Admin</li>
                    <li><span class="far fa-comments"></span> 2 Comments</li>
                </ul>
            </div>
            <h5><a href="<?= $post->url ?>"><?= $post->title_short ?? $post->title ?></a></h5>
            <div class="text"></div>
            <div class="link-box">
                <a class="theme-btn" href="<?= $post->url ?>"><span class="flaticon-next-1"></span></a>
            </div>
        </div>
    </div>
</div>
<?php } ?>

