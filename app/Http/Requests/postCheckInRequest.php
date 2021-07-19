<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;



class postCheckInRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) 
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'error' => $errors,
                'status_code' => 422,
                'mess' => 'Thêm bản ghi lỗi'
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
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
        return [
            'id' => 'required|exists:lessons,id',
            'checkIn' => 'required|array',
        ];
    }

    public function messages ()
    {
        return [
            'id.required' => 'Yêu cầu không để trống',
            'id.exists' => 'Dữ liệu không tồn tại',
            'checkIn.array' => 'Sai kiểu dữ liệu',
            'checkIn.required' => 'Yêu cầu không để trống',
        ];

    }

    
}
