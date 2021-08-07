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
                'errors' => $errors,
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
        // dd($this->all());
        return [
            'id' => 'required|exists:lessons,id',
            'checkIn' => 'required|array',
            'checkIn.*.val' =>'required|integer|min:1|max:3',
            'checkIn.*.id' => 'required|exists:users,id',
            'start_at' => 'required|date_format:H:i:s'
        ];
    }

    public function messages ()
    {
        return [
            'id.required' => 'Yêu cầu không để trống',
            'id.exists' => 'Dữ liệu không tồn tại',
            'checkIn.array' => 'Sai kiểu dữ liệu',
            'checkIn.required' => 'Yêu cầu không để trống',
            'start_at.required' => 'Yêu cầu không để trống',
            'start_at.date_format' => 'Sai định dạng'
        ];

    }

    
}
