<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Comment\Comment;
use App\Common\Models\Gallery\HasGallery;
use App\Common\Models\Gallery\HasGalleryImage;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Render;
use App\Common\Models\Url\HasUrl;
use App\Common\Models\User\User;
use App\Common\Models\User\UserGuest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $render_id
 * @property string|null $render_title
 * @property int|null $category_id
 * @property string|null $category_title
 * @property string|null $category_title_short
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_comments
 * @property int|null $is_image_post
 * @property int|null $is_image_category
 * @property int|null $is_watermark
 * @property string|null $media
 * @property string $title
 * @property string|null $title_short
 * @property string|null $preview_description
 * @property string|null $description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property int|null $show_date
 * @property int|null $date_pub
 * @property int|null $date_end
 * @property int|null $control_date_pub
 * @property int|null $control_date_end
 * @property string|null $image
 * @property int|null $hits
 * @property int|null $sort
 * @property float|null $stars
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property PostCategory $category
 * @property Render $render
 * @property User $user
 * @property Collection<Comment> $comments
 *
 */
class Post extends BaseModel
{
    use SeoSetter;
    use HasHistory;
    use HasUrl;
    use HasGallery;
    use HasGalleryImage;

    protected $table = 'ax_post';
    protected $fillable = [
        'user_id',
        'render_id',
        'category_id',
        'is_published',
        'is_favourites',
        'is_comments',
        'is_image_post',
        'is_image_category',
        'is_watermark',
        'title',
        'title_short',
        'description',
        'preview_description',
        'show_date',
        'date_pub',
        'date_end',
        'control_date_pub',
        'control_date_end',
        'image',
        'media',
        'hits',
        'sort',
        'stars',
        'deleted_at',
        'galleries',
    ];
    protected $attributes = [
        'render_id' => null,
        'category_id' => null,
        'is_published' => 0,
        'is_favourites' => 0,
        'is_comments' => 0,
        'is_image_post' => 0,
        'is_image_category' => 0,
        'is_watermark' => 0,
        'title_short' => null,
        'description' => null,
        'preview_description' => null,
        'show_date' => 0,
        'control_date_pub' => 0,
        'control_date_end' => 0,
        'image' => null,
        'media' => null,
        'hits' => null,
        'sort' => null,
        'stars' => null,
    ];
    protected static $guardableColumns = [
        'title_seo',
        'description_seo',
        'alias',
        'url',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id', 'id');
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'resource_id', 'id')->select([
            Comment::table('*'),
            User::table('first_name') . ' as user_name',
            UserGuest::table('name') . ' as user_guest_name',
        ])->leftJoin(User::table(), static function ($join) {
            $join->on(Comment::table('person_id'), '=', User::table('id'))
                ->where(Comment::table('person'), '=', User::table());
        })->leftJoin(UserGuest::table(), static function ($join) {
            $join->on(Comment::table('person_id'), '=', UserGuest::table('id'))
                ->where(Comment::table('person'), '=', UserGuest::table());
        })->where('resource', $this->getTable())->where('level', '<', 4);
    }

    public function setDatePub(?string $date): static
    {
        $this->date_pub = strtotime($date);

        return $this;
    }

    public function getDatePub(?string $date): string
    {
        return date('d.m.Y', $this->date_pub);
    }

    public function setDateEnd(?string $date): static
    {
        $this->date_end = strtotime($date);

        return $this;
    }

    public function getDateEnd(?string $date = null): string
    {
        return date('d.m.Y', $date ?? $this->date_end);
    }

    public function getComments(): string
    {
        $html = '';
        if ($comments = Comment::convertToArray($this->comments->toArray())) {
            $html = self::getCommentsHtml($comments);
        }
        return $html;
    }

    public static function getCommentsHtml(array $array, bool $all = false): string
    {
        $html = '';
        $level = 0;
        foreach ($array as $item) {
            $children = '';
            if (!empty($item['children'])) {
                $level = (int)$item['level'];
                if ($level <= 3 && !$all) {
                    $children .= self::getCommentsHtml($item['children']);
                } else {
                    if ($all) {
                        $children .= self::getCommentsHtml($item['children'], $all);
                    }
                }
            }
            $html .= '<div id="comment-' . $item['id'] . '" class="comment ">';
            $html .= '<div class="comment-box">
                    <div class="info">
                    <span class="name" id="review-name-' . $item['id'] . '">';
            $html .= $item['user_name'] ?? $item['user_guest_name'] ?? null;
            if ($item['comment_id']) {
                $html .= '<span class="answer-name"> отвечает </span><a href="#comment-' . $item['comment_id'] . '">' .
                    $item['comment_id'] . '</a>';
            }
            $html .= '</span>';
            $html .= '<span class="review-date">';
            $html .= '<i class="fa fa-calendar" aria-hidden="true"></i>';
            $html .= _unix_to_string_moscow($item['created_at']);
            $html .= '</span>';
            $html .= '<a href="javascript:void(0)" class="js-review-id" data-review-id="';
            $html .= $item['id'];
            $html .= '">Ответить</a>';
            $html .= '</div>';
            $html .= '<p class="comment-text">';
            $html .= $item['text'];
            $html .= '</p>';
            $html .= '</div>';
            if ($children) {
                $html .= $children;
                if ($level && $level === 2 && !$all) {
                    $html .= '<a href="javascript:void(0)" class="btn btn-outline-secondary btn-sm open-button" data-open-id="' .
                        $item['id'] + 1 . '">Открыть' . $item['id'] . '</a>';
                }
            }

            $html .= '</div>';
        }

        return $html;
    }
}
