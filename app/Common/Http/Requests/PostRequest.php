<?php

namespace App\Common\Http\Requests;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Errors\_Errors;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if(($action = $this->route()
                ?->getName()) && method_exists($this, 'rule' . $action)) {
            return $this->{'rule' . $action}();
        }

        return [];
    }

    public function ruleCreate(): array
    {
        $post = $this->request->all();

        return [
            'id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'render_id' => 'nullable|integer',
            'is_published' => 'nullable|integer',
            'is_favourites' => 'nullable|integer',
            'is_watermark' => 'nullable|integer',
            'is_comments' => 'nullable|integer',
            'is_image_post' => 'nullable|integer',
            'is_image_category' => 'nullable|integer',
            'show_date' => 'nullable|integer',
            'control_date_pub' => 'nullable|integer',
            'control_date_end' => 'nullable|integer',
            'show_image' => 'nullable|integer',
            'title' => 'required|string|unique:' . Post::table() . ',title,' . ($post['id'] ?? null),
            'title_short' => 'nullable|string',
            'description' => 'nullable|string',
            'preview_description' => 'nullable|string',
            'title_seo' => 'nullable|string',
            'description_seo' => 'nullable|string',
            'sort' => 'nullable|integer',
        ];
    }

    public function ruleDelete(): array
    {
        return ['id' => 'required|integer|exists:' . Post::table(),];
    }

    public function failedValidation(Validator $validator): void
    {
        $controller = new WebController($this);
        $controller->setErrors(_Errors::error($validator->errors()
            ->getMessages(), $controller));
        throw new HttpResponseException(response()->json($controller->getDataArray()));
    }

}
