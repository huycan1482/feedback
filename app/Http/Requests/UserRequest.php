<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class UserRequest extends FormRequest
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
            if ($this->user) {
                if (!$this->checkUser()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }         
            
        });

    }


    public function checkUser ()
    {
        $checkUser = User::find($this->user);

        if (empty($checkUser)) {
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

        if ($this->user) {
            return [
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users,email,'.$this->user,
                'password' => 'nullable|string|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
                'code' => 'required|size:11|unique:users,code,'.$this->user,
                'gender' => 'required|integer|min:1|max:3',
                'date_of_birth' => 'required|date_format:"Y-m-d"',
                'phone' => 'required|size:10',
                'address' => 'required',
                'is_active' => 'integer|boolean',
            ];
        }

        return [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'code' => 'required|unique:users,code|size:11',
            'gender' => 'required|integer|min:1|max:3',
            'date_of_birth' => 'required|date_format:"Y-m-d"',
            'phone' => 'required|size:10',
            'address' => 'required',
            'is_active' => 'integer|boolean',
        ];
    }

    public function messages ()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.string' => 'Sai kiểu dữ liệu',
            'email.required' => 'Yêu cầu không để trống',
            'email.email' => 'Yêu cầu email',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Yêu cầu không để trống',
            'password.min' => 'Độ dài phải lớn hơn 8 kí tự',
            'password.confirmed' => 'Nhập lại mật khẩu không khớp',
            'role_id.required' => 'Yêu cầu không để trống',
            'role_id.exists' => 'Dữ liệu không tồn tại',
            'code.size' => 'Độ dài gồm 11 kí tự',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu bị trùng',
            'gender.required' => 'Yêu cầu không để trống',
            'gender.integer' => 'Sai kiểu dữ liệu',
            'gender.min' => 'Sai kiểu dữ liệu',
            'gender.max' => 'Sai kiểu dữ liệu',
            'date_of_birth.required' => 'Yêu cầu không để trống',
            'date_of_birth.date_format' => 'Sai kiểu dữ liệu',
            'phone.required' => 'Yêu cầu không để trống',
            'phone.size' => 'Độ dài 10 chữ số',
            'address.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
        ];

    }
}
