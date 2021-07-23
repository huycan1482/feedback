<?php

namespace App\Http\Requests;

use App\Lesson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CheckInRequest extends FormRequest
{
    protected $mess = 'Thêm bản ghi lỗi';

    protected function failedValidation(Validator $validator) 
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'errors' => $errors,
                'status_code' => 422,
                'mess' => $this->mess,
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
            if ($this->checkIn) {
                if (!$this->checkLesson()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }        
            
        });

    }

    public function checkLesson ()
    {
        $checkLesson = Lesson::find($this->id);

        if (!empty($checkLesson)) {
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
        return [
            'checkIn' => 'required|array',
            'checkIn.*.val' => 'required|numeric|min:1|max:3',
            'checkIn.*.user_id' => 'required|exists:users,id'
        ];
    }

    public function messages ()
    {
        return [
            'checkIn.required' => 'Yêu cầu không để trống',
            'checkIn.array' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.numeric' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.min' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.max' => 'Sai kiểu dữ liệu',
            'checkIn.*.val.required' => 'Yêu cầu không để trống', 
            'checkIn.*.user_id.required' => 'Yêu cầu không để trống',
            'checkIn.*.user_id.exists' => 'Dữ liệu không tồn tại'
        ];
    }
}
