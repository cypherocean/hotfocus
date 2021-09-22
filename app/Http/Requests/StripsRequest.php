<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class StripsRequest extends FormRequest{
        public function authorize(){
            return true;
        }

        public function rules(){
            if($this->method() == 'PATCH'){
                return [
                    'name' => 'required|unique:strips,name,'.$this->id
                ];
            }else{
                return [
                    'name' => 'required|unique:strips,name'
                ];
            }
        }

        public function messages(){
            return [
                'name.required' => 'Please enter name',
                'name.unique' => 'Prodcut name is already exists, please use another one',
                'quantity.required' => 'Please enter quantity',
                'unit.required' => 'Please enter unit',
                'color.required' => 'Please enter color',
                'price.required' => 'Please enter price'
            ];
        }
    }
