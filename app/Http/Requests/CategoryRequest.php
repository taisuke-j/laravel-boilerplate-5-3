<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function __construct()
    {
        // List of models that have categories
        $this->models = [
            'product',
            'post',
            'page',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // Checks if the model name is valid
        $requested_model = $this->route('model');
        $is_valid = false;

        foreach ($this->models as $model) {
            if ($model === $requested_model) {
                $is_valid = true;
                break;
            }
        }

        if (!$is_valid) abort('403');

        return $is_valid;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
