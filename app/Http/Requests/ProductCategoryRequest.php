<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        if($this->method() == 'PATCH'){
            return [
                'name' => 'required',
            ];
        }else{
            return [
                'name' => 'required',
            ];
        }
    }

    public function messages(){
        return [
            'name.required' => 'Please enter name'
        ];
    }
}
