<?php

namespace App\Http\Requests;

use App\Course;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Str;


class CourseRequest extends FormRequest
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
            if ($this->user) {
                if (!$this->checkCourse()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'User không tồn tại');
                }
            }  
        });

    }

    public function checkCourse () 
    {
        $checkCourse = Course::find($this->user);

        if (empty($checkCourse)) {
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
        $this->request->add([
            'trueName' => $this->input('name'),
            'name' => Str::slug($this->input('name')),
            'slug' => Str::slug($this->input('name')),
        ]);

        if ($this->course) {
            return [
                'name' => 'required|unique:courses,slug,'.$this->course,
                'code' => 'required|unique:courses,code,'.$this->course,
                'subject_id' => 'required|exists:subjects,id',
                'total_lesson' => 'required|integer|min:1"',
                'is_active' => 'integer|boolean',
            ];
        }

        return [
            'name' => 'required|unique:courses,slug',
            'code' => 'required|unique:courses,code',
            'subject_id' => 'required|exists:subjects,id',
            'total_lesson' => 'required|integer|min:1"',
            'is_active' => 'integer|boolean',
        ];
    }

    public function messages () 
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu bị trùng',
            'subject.required' => 'Yêu cầu không để trống',
            'subject.unique' => 'Dữ liệu bị trùng',
            'total_lesson.required' => 'Yêu cầu không để trống',
            'total_lesson.integer' => 'Sai kiểu dữ liệu',
            'total_lesson.min' => 'Dữ liệu phải lớn hơn 0',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
        ];
    }
}
