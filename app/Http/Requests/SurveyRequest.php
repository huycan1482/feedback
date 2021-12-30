<?php

namespace App\Http\Requests;

use App\FeedBack;
use App\Survey;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Str;

class SurveyRequest extends FormRequest
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
            if ($this->survey) {
                if (!$this->checkSurvey()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }
        });
    }

    public function checkSurvey()
    {
        $checkSurvey = Survey::find($this->survey);

        if (empty($checkSurvey)) {
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
            'feedback_id' => 'required|exists:feedbacks,id',
            'start_at' => 'required|date_format:"Y/m/d"',
            'end_at' => 'required|date_format:"Y/m/d"|after:start_at',
            'is_active' => 'required|integer|boolean',
        ];
    }

    public function messages ()
    {
        return [
            'feedback_id.required' => 'Yêu cầu không để trống',
            'feedback_id.exists' => 'Dữ liệu không tồn tại',
            'start_at.required' => 'Yêu cầu không để trống',
            'start_at.date_format' => 'Sai định dạng',
            'end_at.required' => 'Yêu cầu không để trống',
            'end_at.date_format' => 'Sai định dạng',
            'end_at.after' => 'Ngày kết thúc p sau ngày bắt đầu',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
            'is_active.required' => 'Yêu cầu không để trống',
        ];
    }
}
