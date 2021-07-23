<?php

namespace App\Http\Requests;

use App\Answer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AnswerRequest extends FormRequest
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
    * @param  \Illuminate\Validation\Validator  $validator
    * @return void
    */
    public function withValidator (Validator $validator)
    {
        $validator->after(function($validator)
        {            
            if (!$this->checkAnswer()) {
                $this->mess = 'Thêm bản ghi lỗi, câu trả lời không tồn tại';
                $validator->errors()->add('exception', 'Câu trả lời không tồn tại');
            }
        });

    }

    public function checkAnswer ()
    {
        $checkAnswer = Answer::where([[ 'question_id', '=', $this->input('id')], ['id', '=', $this->answer]])->get()->first();

        if (empty($checkAnswer)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->answer) {
            return [
                // 'answer_content' => 'required|unique:answers,content',
                'content' => 'required|string',
                'answer_is_active' => 'integer|boolean',
            ];
        }

        return [
            'question_id' => 'required|exists:questions,id',
            'add_answer_content' => 'required',
            'add_answer_active' => 'integer|boolean',
        ];
    }

    public function messages()
    {
        if ($this->answer) {
            return [
                'content.string' => 'Sai kiểu dữ liệu',
                'content.required' => 'Yêu cầu không để trống',
                'content.unique' => 'Câu trả lời bị trùng',
                'answer_is_active.integer' => 'Sai kiểu dữ liệu',
                'answer_is_active.boolean' => 'Sai kiểu dữ liệu',
            ];
        }

        return [
            'question_id.required' => 'Yêu cầu không để trống',
            'question_id.exists' => 'Câu hỏi không tồn tại',
            'add_answer_content.required' => 'Yêu cầu không để trống',
            'add_answer_active.integer' => 'Sai kiểu dữ liệu',
            'add_answer_active.boolean' => 'Sai kiểu dữ liệu',
        ];
    }

    
}
