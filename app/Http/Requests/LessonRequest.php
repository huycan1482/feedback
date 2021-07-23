<?php

namespace App\Http\Requests;

use App\Lesson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LessonRequest extends FormRequest
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
            if ($this->lesson) {
                if (!$this->checkLesson()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }         
            
        });

    }


    public function checkLesson ()
    {
        $checkLesson = Lesson::find($this->lesson);

        if (empty($checkLesson)) {
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
        if ($this->lesson) {
            return [
                'start_at' => 'required|date_format:"Y-m-d H:i:s',
            ];
        }

        return [
            'class_id' => 'required|exists:classes,id',
            'start_at' => 'required|date_format:"Y-m-d H:i:s',
            'time_limit' => 'required|integer|min:1'
        ];
    }

    public function messages ()
    {
        if ($this->lesson) {
            return [
                'start_at.required' => 'Yêu cầu không để trống',
                'start_at.date_format' => 'Sai định dạng',
            ];
        }

        return [
            'class_id.required' => 'Yêu cầu không để trống',
            'class_id.exists' => 'Dữ liệu không tồn tại',
            'start_at.required' => 'Yêu cầu không để trống',
            'start_at.date_format' => 'Sai định dạng',
            'time_limit.required' => 'Yêu cầu không để trống',
            'time_limit.integer' => 'Sai kiểu dữ liệu',
            'time_limit.min' => 'Giá trị phải lớn hơn 1',
        ];
    }
}
