<?php

namespace App\Common\Models\Comment;

use App\Common\Models\Main\BaseComponent;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class CommentService extends BaseComponent
{
    public ?Comment $comment;
    public Collection $comments;

    public function __construct(Collection $comments)
    {
        $this->comments = $comments;
        parent::__construct();
    }

    public function convertToArray(array $collection): array
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

    public function setChildren(&$result, $key): array
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

    public function searchChildren($array, $id): array
    {
        $res = [];
        foreach ($array as $key => $value) {
            if ($value['comment_id'] === $id) {
                $res[$key] = $value;
            }
        }
        return $res;
    }

}
