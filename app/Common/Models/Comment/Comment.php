<?php

namespace App\Common\Models\Comment;

use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\User;
use App\Common\Models\User\UserGuest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property string $resource
 * @property int $resource_id
 * @property string $person
 * @property int $person_id
 * @property int|null $comment_id
 * @property int|null $status
 * @property int|null $is_viewed
 * @property string $text
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int $level
 * @property string|null $path
 *
 * @property Comment $comment
 * @property Collection<Comment> $comments
 */
class Comment extends BaseModel
{
    use HasHistory;

    protected $table = 'ax_comment';
    protected $fillable = [
        'resource',
        'resource_id',
        'person',
        'person_id',
        'text',
        'comment_id',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [
                'resource' => 'required|string',
                'resource_id' => 'required|integer',
                'person' => 'nullable|string|in:' . User::table() . ',' . UserGuest::table(),
                'person_id' => 'nullable|integer',
                'email' => 'required|email',
                'text' => 'required|string',
                'comment_id' => 'nullable|integer',
            ],
            'delete' => [],
        ][$type] ?? [];
    }

    public static function create(array $post): self
    {
        $model = new self();
        $model->loadModel($post);
        return $model->safe();
    }

    public static function getChildrenCommentArray(int $id): string
    {
        $comment = self::query()->where('id', $id)->first();
        /** @var $comment self */
        if ($comment) {
            $items = self::query() # TODO: make a method!!!
                         ->select([
                self::table('*'),
                User::table('first_name') . ' as user_name',
                UserGuest::table('name') . ' as user_guest_name',
            ])
                         ->leftJoin(User::table(), static function ($join) {
                             $join->on(Comment::table('person_id'), '=', User::table('id'))
                                  ->where(Comment::table('person'), '=', User::table());
                         })
                         ->leftJoin(UserGuest::table(), static function ($join) {
                             $join->on(Comment::table('person_id'), '=', UserGuest::table('id'))
                                  ->where(Comment::table('person'), '=', UserGuest::table());
                         })
                         ->where('path', 'like', $comment->path . '.' . $comment->id . '%')
                         ->orderBy('created_at')
                         ->get()
                         ->toArray();
            $itemsArray = self::convertToArray($items);
        }
        return self::getCommentsHtml($itemsArray ?? [], true);
    }

    public static function convertToArray(array $collection): array
    {
        $array = [];
        foreach ($collection as $value) {
            $array[$value['id']] = $value;
        }
        foreach ($array as $key => &$value) {
            $value['children'] = static::setChildren($array, $key);
        }
        return $array;
    }

    public static function setChildren(&$result, $key): array
    {
        $ch = [];
        if ($ch = static::searchChildren($result, $key)) {
            foreach ($ch as $id => &$value) {
                unset($result[$id]);
                $value['children'] = static::setChildren($result, $id);
            }
        }
        return $ch;
    }

    public static function searchChildren($array, $id): array
    {
        $res = [];
        foreach ($array as $key => $value) {
            if ($value['comment_id'] == $id) {
                $res[$key] = $value;
            }
        }
        return $res;
    }

    public static function getCommentsHtml($array, $all = false): string
    {
        $html = '';
        $level = 0;
        foreach ($array as $item) {
            $children = '';
            if (!empty($item['children'])) {
                $level = (int)$item['level'];
                if ($level <= 3 && !$all) {
                    $children .= self::getCommentsHtml($item['children']);
                } else if ($all) {
                    $children .= self::getCommentsHtml($item['children'], $all);
                }
            }
            $html .= '<div id="comment-' . $item['id'] . '" class="comment ">';
            $html .= '<div class="comment-body">
                    <div class="comment-header d-flex flex-wrap justify-content-between">
                    <h4 class="comment-title">
                    <span class="review-name" id="review-name-' . $item['id'] . '">';
            $html .= $item['user_name'] ?? $item['user_guest_name'] ?? null;
            if ($item['comment_id']) {
                $html .= '<span class="answer-name"> отвечает </span><a href="#comment-' . $item['comment_id'] . '">' . $item['comment_id'] . '</a>';
            }
            $html .= '</span>';
            $html .= '<span class="review-date">';
            $html .= '<i class="fa fa-calendar" aria-hidden="true"></i>';
            $html .= _unix_to_string_moscow($item['created_at']);
            $html .= '</span>';
            $html .= '<a href="javascript:void(0)" class="js-review-id" data-review-id="';
            $html .= $item['id'];
            $html .= '">Ответить</a>';
            $html .= '</h4>';
            $html .= '</div>';
            $html .= '<p class="comment-text">';
            $html .= $item['text'];
            $html .= '</p>';
            $html .= '</div>';
            if ($children) {
                $html .= $children;
                if ($level && $level === 2 && !$all) {
                    $html .= '<a href="javascript:void(0)" class="btn btn-outline-secondary btn-sm open-button" data-open-id="' . $item['id'] + 1 . '">Открыть' . $item['id'] . '</a>';
                }
            }

            $html .= '</div>';
        }
        return $html;
    }

    public function setCommentId(?int $id): self
    {
        /* @var $comment self */
        if ($id && $comment = self::query()->where('id', $id)->first()) {
            if ($comment->path) {
                $this->path = $comment->path . '.' . $comment->id;
            } else {
                $this->path = $comment->id;
            }
            $this->level = ++$comment->level;
            $this->comment_id = $comment->id;
        }
        return $this;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(__CLASS__, 'comment_id', 'id');
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'comment_id', 'id');
    }

    public function changeStatus(int $status): static
    {
        $this->status = $status;
        return $this->safe();
    }

    public function getDate(): string
    {
        return _unix_to_string_moscow($this->created_at);
    }

    public function getAuthor(): ?string
    {
        /** @var $class BaseModel */
        if (($class = BaseModel::className($this->person)) && ($user = $class::query()
                                                                             ->where('id', $this->person_id)
                                                                             ->first())) {
            if ($user instanceof User) {
                return $user->first_name;
            }
            if ($user instanceof UserGuest) {
                return $user->name;
            }
        }
        return null;
    }
}
