<?php

namespace App\Common\Http\Requests;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Errors\_Errors;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if(($action = $this->route()?->getName()) && method_exists($this, 'rule' . $action)) {
            return $this->{'rule' . $action}();
        }

        return [];
    }

    public function ruleCreate(): array
    {
        return ['id' => 'required|integer|exists:doc_task_group',];
    }

    public function ruleEdit(): array
    {
        return ['id' => 'required|integer|exists:doc_task_group',];
    }

    public function failedValidation(Validator $validator): void
    {
        $controller = new WebController();
        $controller->setErrors(_Errors::error($validator->errors(), $controller));
        throw new HttpResponseException(response()->json($controller->getDataArray()));
    }

}
