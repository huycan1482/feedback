<?php

namespace App\Http\Requests;

use App\FeedbackQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FeedbackQuestionRequest extends FormRequest
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
            if ($this->feedbackQuestion) {
                if (!$this->checkFeedbackQuestion()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'User không tồn tại');
                }
            }         
            
        });

    }


    public function checkFeedbackQuestion ()
    {
        $checkFeedbackQuestion = FeedbackQuestion::find($this->user);

        if (empty($checkFeedbackQuestion)) {
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
        // if ($this->feedbackQuestion) {   
        //     return [

        //     ];
        // }


        return [
            'question_id' => 'required|exists:questions,id',
            'feedback_id' => 'required|exists:feedbacks,id',
        ];
    }

    public function messages () 
    {
        // if ($this->feedbackQuestion) {
        //     return [

        //     ];
        // }

        return [
            'question_id.required' => 'Yêu cầu không để trống',
            'question_id.exists' => 'Bản ghi không tồn tại',
            'feedback_id.required' => 'Yêu cầu không để trống',
            'feedback_id.exists' => 'Bản ghi không tồn tại',
        ];
    }
}
