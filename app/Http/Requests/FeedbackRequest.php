<?php

namespace App\Http\Requests;

use App\FeedBack;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Str;

class FeedbackRequest extends FormRequest
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
            ],
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }

    /**
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if ($this->feedback) {
                if (!$this->checkFeedback()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }
        });
    }

    public function checkFeedback()
    {
        $checkFeedback = FeedBack::find($this->feedback);

        if (empty($checkFeedback)) {
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
        // dd($this->feedback);

        $this->request->add([
            'trueName' => $this->input('name'),
            'name' => Str::slug($this->input('name')),
            'slug' => Str::slug($this->input('name')),
        ]);


        if ($this->feedback) {
            return [
                'name' => 'required|unique:feedbacks,slug,' . $this->feedback,
                'code' => 'required|unique:feedbacks,code,' . $this->feedback,
                'is_active' => 'integer|boolean',
                'is_public' => 'integer|boolean',
                'time' => 'required|min:0|integer',
            ];
        }

        return [
            'name' => 'required|unique:feedbacks,slug',
            'code' => 'required|unique:feedbacks,code',
            'is_active' => 'integer|boolean',
            'is_public' => 'integer|boolean',
            'question_id' => 'required|min:1|array',
            'question_id.*' => 'exists:questions,id',
            'time' => 'required|min:0|integer',
        ];
    }

    public function messages()
    {
        if ($this->feedback) {
            return [
                'name.required' => 'Yêu cầu không để trống',
                'name.unique' => 'Dữ liệu trùng',
                'code.required' => 'Yêu cầu không để trống',
                'code.unique' => 'Dữ liệu trùng',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
                'is_public.integer' => 'Sai kiểu dữ liệu',
                'is_public.boolean' => 'Sai kiểu dữ liệu',
                'time.required' => 'Yêu cầu không để trống',
                'time.min' => 'Thời gian phải lớn hơn 0',
                'time.integer' => 'Sai kiểu dữ liệu',
            ];
        }

        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu trùng',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu trùng',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
            'is_public.integer' => 'Sai kiểu dữ liệu',
            'is_public.boolean' => 'Sai kiểu dữ liệu',
            'question_id.required' => 'Yêu cầu không để trống',
            'question_id.min' => 'Yêu cầu có ít nhất 1 câu hỏi',
            'question_id.array' => 'Sai kiểu định dạng',
            'question_id.*.exists' => 'Dữ liệu không tồn tại',
            'time.required' => 'Yêu cầu không để trống',
            'time.min' => 'Thời gian phải lớn hơn 0',
            'time.integer' => 'Sai kiểu dữ liệu',
        ];
    }
}
