<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class UserClassRequest extends FormRequest
{

    protected $mess = 'Thêm bản ghi lỗi';

    protected function failedValidation(Validator $validator) 
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'errors' => $errors,
                'status_code' => 422,
                'mess' => $this->mess
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }


    /**
    * @param  \Illuminate\Validation\Validator  $validator
    * @return void
    */
    public function withValidator (Validator $validator)
    {
        $validator->after(function($validator)
        {   
            if ($this->userClass) {
                if (!$this->checkUserClass()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }         
            
        });

    }


    public function checkUserClass ()
    {
        $checkUserClass = \App\UserClass::find($this->user);

        if (empty($checkUserClass)) {
            return false;
        } else {
            return true;
        }
    }

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
    public function rules()
    {
        if ($this->userClass) {
            return [
                'classRoom_id' => 'required|exists:classes,id',
                'is_active' => 'integer|boolean',
            ];
        }   

        return [
            'classRoom_id' => 'required|exists:classes,id',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages ()
    {
        if ($this->userClass) {
            return [
                'classRoom_id.required' => 'Yêu cầu không để trống',
                'classRoom_id.exists' => 'Dữ liệu không tồn tại',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ];
        }   

        return [
            'classRoom_id.required' => 'Yêu cầu không để trống',
            'classRoom_id.exists' => 'Dữ liệu không tồn tại',
            'course_id.required' => 'Yêu cầu không để trống',
            'course_id.exists' => 'Dữ liệu không tồn tại',
            'user_id.required' => 'Yêu cầu không để trống',
            'user_id.exists' => 'Dữ liệu không tồn tại',
        ];
    }
}
