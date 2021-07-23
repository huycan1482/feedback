<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Str;

class SubjectRequest extends FormRequest
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
            if ($this->subject) {
                if (!$this->checkSubject()) {
                    $this->mess = 'Thêm bản ghi lỗi, bản ghi không tồn tại';
                    $validator->errors()->add('exception', 'Bản ghi không tồn tại');
                }
            }         
            
        });

    }


    public function checkSubject ()
    {
        $checkSubject = \App\Subject::find($this->user);

        if (empty($checkSubject)) {
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

        if ($this->subject) {
            return [
                'name' => 'required|unique:subjects,name,' . $this->subject,
                'code' => 'required',
                'is_active' => 'integer|boolean',
            ];
        }

        return [
            'name' => 'required|unique:subjects,name',
            'code' => 'required',
            'is_active' => 'integer|boolean',
        ];
    }

    public function messages ()
    {
        if ($this->subject) {
            return [
                'name.required' => 'Yêu cầu không để trống',
                'name.unique' => 'Dữ liệu bị trùng',
                'code.required' => 'Yêu cầu không để trống',
                'is_active.integer' => 'Sai kiểu dữ liệu',
                'is_active.boolean' => 'Sai kiểu dữ liệu',
            ];
        }

        return [
            'name.required' => 'Yêu cầu không để trống',
            'name.unique' => 'Dữ liệu bị trùng',
            'code.required' => 'Yêu cầu không để trống',
            'is_active.integer' => 'Sai kiểu dữ liệu',
            'is_active.boolean' => 'Sai kiểu dữ liệu',
        ];
    }
}
