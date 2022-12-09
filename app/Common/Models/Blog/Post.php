<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Gallery\Gallery;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int          $id
 * @property int|null     $render_id
 * @property string|null  $render_title
 * @property int|null     $category_id
 * @property string|null  $category_title
 * @property string|null  $category_title_short
 * @property int|null     $is_published
 * @property int|null     $is_favourites
 * @property int|null     $is_comments
 * @property int|null     $is_image_post
 * @property int|null     $is_image_category
 * @property int|null     $is_watermark
 * @property string|null  $media
 * @property string       $url
 * @property string       $alias
 * @property string       $title
 * @property string|null  $title_short
 * @property string|null  $preview_description
 * @property string|null  $description
 * @property string|null  $title_seo
 * @property string|null  $description_seo
 * @property int|null     $show_date
 * @property int|null     $date_pub
 * @property int|null     $date_end
 * @property int|null     $control_date_pub
 * @property int|null     $control_date_end
 * @property string|null  $image
 * @property int|null     $hits
 * @property int|null     $sort
 * @property float|null   $stars
 * @property int|null     $created_at
 * @property int|null     $updated_at
 * @property int|null     $deleted_at
 *
 * @property PostCategory $category
 * @property Render       $render
 * @property User         $user
 * @property Gallery[]    $manyGalleryWithImages
 * @property Gallery[]    $manyGallery
 */
class Post extends BaseModel
{
    use SeoSetter, HasHistory;

    protected $table = 'ax_post';

    public static function rules(string $type = 'create'): array
    {
        return [
                   'create' => [
                       'id' => 'nullable|integer',
                       'category_id' => 'nullable|integer',
                       'render_id' => 'nullable|integer',
                       'is_published' => 'nullable|string',
                       'is_favourites' => 'nullable|string',
                       'is_watermark' => 'nullable|string',
                       'is_comments' => 'nullable|string',
                       'is_image_post' => 'nullable|string',
                       'is_image_category' => 'nullable|string',
                       'show_date' => 'nullable|string',
                       'control_date_pub' => 'nullable|string',
                       'control_date_end' => 'nullable|string',
                       'show_image' => 'nullable|string',
                       'title' => 'required|string',
                       'title_short' => 'nullable|string',
                       'description' => 'nullable|string',
                       'preview_description' => 'nullable|string',
                       'title_seo' => 'nullable|string',
                       'description_seo' => 'nullable|string',
                       'sort' => 'nullable|integer',
                   ],
               ][$type] ?? [];
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['id']) || !$model = self::query()->where(self::table() . '.id', $post['id'])->first()) {
            $model = new self();
        }
        $model->category_id = $post['category_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_published = empty($post['is_published']) ? 0 : 1;
        $model->is_favourites = empty($post['is_favourites']) ? 0 : 1;
        $model->is_watermark = empty($post['is_watermark']) ? 0 : 1;
        $model->is_comments = empty($post['is_comments']) ? 0 : 1;
        $model->is_image_post = empty($post['is_image_post']) ? 0 : 1;
        $model->is_image_category = empty($post['is_image_category']) ? 0 : 1;
        $model->date_pub = strtotime($post['date_pub']);
        $model->date_end = strtotime($post['date_end']);
        $model->control_date_pub = empty($post['control_date_pub']) ? 0 : 1;
        $model->control_date_end = empty($post['control_date_end']) ? 0 : 1;
        $model->title_short = $post['title_short'] ?? null;
        $model->description = $post['description'] ?? null;
        $model->preview_description = $post['preview_description'] ?? null;
        $model->sort = $post['sort'] ?? null;
        $model->setTitle($post);
        $model->setAlias($post);
        $model->url = $model->alias;
        if ($model->safe()->getErrors()) {
            return $model;
        }
        $post['images_path'] = $model->setImagesPath();
        if (!empty($post['image'])) {
            $model->setImage($post);
        }
        if (!empty($post['galleries'])) {
            $model->setGalleries($post['galleries']);
        }
        $model->setSeo($post['seo'] ?? []);
        return $model->safe();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'category_id', 'id');
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $catalog = PostCategory::query()->where('alias', $alias)->first();
        if ($catalog) {
            return true;
        }
        $catalog = Page::query()->where('alias', $alias)->first();
        if ($catalog) {
            return true;
        }
        $post = self::query()->where('alias', $alias)->when($id, function ($query, $id) {
            $query->where('id', '!=', $id);
        })->first();
        if ($post) {
            return true;
        }
        return false;
    }
}
