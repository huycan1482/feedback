<?php

namespace App\Http\Requests;

use App\ClassRoom;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Str;


class ClassRequest extends FormRequest
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
            if ($this->class) {
                if (!$this->checkClass()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'bản ghi không tồn tại');
                }
            }    
            
        });

    }

    public function checkClass () 
    {
        $classRoom = ClassRoom::find($this->class);

        if (empty($classRoom)) {    
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


        if ($this->class) {
            return [
                'name' => 'required|unique:classes,slug,' . $this->class,
                'code' => 'required|unique:classes,code,' . $this->class,
                'course_id' => 'required|exists:courses,id',
                'teacher_id' => 'required|exists:users,id',
                'total_number' => 'required|integer|min:1',
                'feedback_id' => 'nullable|array',
                'feedback_id.*' => 'exists:feedbacks,id',
                'is_active' => 'integer|boolean',
                'time_limit' => 'nullable|integer|min:1',
            ];
        }

        return [
            'name' => 'required|unique:classes,slug',
            'code' => 'required|unique:classes,code',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
            'total_number' => 'required|integer|min:1',
            'feedback_id' => 'nullable|array',
            'feedback_id.*' => 'exists:feedbacks,id',
            'is_active' => 'integer|boolean',
            'lessons' => 'required|array|min:1',
            'lessons.*' => 'required|date_format:"Y-m-d H:i:s"',
            'time_limit' => 'required|integer|min:1',
        ];
    }

    public function messages ()
    {
        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu trùng',
            'course_id.required' => 'Yêu cầu không để trống',
            'course_id.exists' => 'Dữ liệu không tồn tại',
            'feedback_id.array' => 'Dữ liệu không tồn tại',
            'teacher_id.required' => 'Yêu cầu không để trống',
            'teacher_id.unique' => 'Dữ liệu bị trùng',
            'total_number.required' => 'Yêu cầu không để trống',
            'total_number.integer' => 'Sai kiểu dữ liệu',
            'total_number.min' => 'Dữ liệu phải lớn hơn 0',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
            'lessons.required' => 'Yêu cầu không để trống',
            'lessons.min' => 'Yêu cầu phải có từ 1 ngày học lời trở lên',
            'lessons.array' => 'Sai kiểu dữ liệu',
            'time_limit.required' => 'Yêu cầu không để trống',
            'time_limit.integer' => 'Sai kiểu dữ liệu',
            'time_limit.min' => 'Dữ liệu phải lớn hơn 0',
        ];
    }
}
