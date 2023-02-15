<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CounterRequest extends FormRequest
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
                'name' => 'required|unique:counters,name,'.$this->id,
                'counter_number' => 'required',
            ];
        }else{
            return [
                'name' => 'required|unique:counters,name',
                'counter_number' => 'required',
            ];
        }
    }

    public function messages(){
        return [
            'name.required' => 'Please enter name',
            'name.unique' => 'This name already exist in our system',
            'counter_number.required' => 'Please enter Count',
        ];
    }
}
