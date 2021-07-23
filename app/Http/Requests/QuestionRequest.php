<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;


class QuestionRequest extends FormRequest
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
            if ($this->question) {
                if (!$this->checkQuestion()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }
        });
    }

    public function checkQuestion()
    {
        $checkQuestion = Queue::find($this->question);

        if (empty($checkQuestion)) {
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
        // dd($this->all());
        $this->request->add([
            'trueContent' => $this->input('name'),
            'content' => Str::slug($this->input('name')),
            'slug' => Str::slug($this->input('name')),
        ]);

        if ($this->question) {
            return [
                'content' => 'required|unique:questions,slug,' . $this->question,
                'code' => 'required|unique:questions,code,' . $this->question,
            ];
        }

        return [
            'code' => 'bail|required|unique:questions,code',
            'content' => 'bail|required|unique:questions,slug',
            'is_active' => 'bail|integer|boolean',
            'answers' => 'bail|required|array|size:4',

            'answers.*.value' => [
                'bail',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value == '') {
                        return $this->mess = ("Thêm bản ghi lỗi, yêu cầu không bỏ trống câu trả lời");
                    }
                }, 'required',
            ],
            'answers.*.point' => [
                'bail',
                'string',
                function ($attribute, $value, $fail) {
                    $arrVal = ['100', '66.66', '33.33', '0'];
                    if (!in_array($value, $arrVal)) {
                        return $this->mess = ("Thêm bản ghi lỗi, dữ liệu của câu trả lời không phù hợp");
                    }
                }, 'required',
            ],
            'answers' => [
                function ($attribute, $value, $fail) {
                    foreach ($value as $item) {
                        $point[] = $item['point'];
                        $content[] = $item['value'];
                    }

                    if (count($content) !== count(array_unique($content)))
                        return $this->mess = ("Thêm bản ghi lỗi, câu trả lời trùng");
                    if (count($point) !== count(array_unique($point)))
                        return $this->mess = ("Thêm bản ghi lỗi, dữ liệu của câu trả lời không phù hợp");
                },
            ],
        ];
    }

    public function messages()
    {
        if ($this->question) {
            return [
                'content.required' => 'Yêu cầu không để trống',
                'content.unique' => 'Dữ liệu bị trùng',
                'code.required' => 'Yêu cầu không để trống',
                'code.unique' => 'Dữ liệu bị trùng',
            ];
        }

        return [
            'content.required' => 'Yêu cầu không để trống',
            'code.required' => 'Yêu cầu không để trống',
            'code.unique' => 'Dữ liệu bị trùng',
            'content.unique' => 'Dữ liệu bị trùng',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
            'answers.required' => 'Yêu cầu không để trống',
            'answers.size' => 'Yêu cầu có đủ 4 câu trả lời',
            'answers.array' => 'Sai kiểu dữ liệu',
        ];
    }
}
