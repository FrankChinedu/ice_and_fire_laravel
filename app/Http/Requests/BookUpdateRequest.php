<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookUpdateRequest extends FormRequest
{
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
            'name' => 'string|min:2',
            'isbn' => 'unique:books|min:8',
            'authors' => 'string|min:2',
            'number_of_pages' => 'numeric',
            'publisher' =>  'string|min:2',
            'country' =>  'string|min:2',
            'release_date' => 'date'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'name must be a string',
            'name.min' => 'name must be a miniumu of two string',
            'isbn.unique' => 'isbn must be unique',
            'isbn.min' => 'isbn must be more than 8 characters',
            'authors.min' => 'authors must be a miniumu of two string',
            'country.min' => 'authors must be a miniumu of two string',
            'number_of_pages.numeric' => 'number of pages field must be a number',
            'publisher.string' => 'publisher must be a string',
            'country.string' => 'publisher must be a string',
            'release_date.date' => 'release_date must be date type is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            'errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
