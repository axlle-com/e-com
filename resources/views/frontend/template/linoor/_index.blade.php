<?php

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;

/**
 * @var string $title
 * @var Post[] $posts
 * @var PostCategory $category
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
            <h5><a href="<?= $post->getUrl() ?>"><?= $post->title_short ?? $post->title ?></a></h5>
            <div class="text"></div>
            <div class="link-box">
                <a class="theme-btn" href="<?= $post->getUrl() ?>"><span class="flaticon-next-1"></span></a>
            </div>
        </div>
    </div>
</div>
<?php } ?>

