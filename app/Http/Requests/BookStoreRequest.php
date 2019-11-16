<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookStoreRequest extends FormRequest
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
            'name' => 'required|string|min:2',
            'isbn' => 'required|unique:books|min:8',
            'authors' => 'required|min:2',
            'number_of_pages' => 'required|numeric',
            'publisher' =>  'required|string|min:2',
            'country' =>  'required|string|min:2',
            'release_date' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name field is required',
            'name.string' => 'name must be a string',
            'name.min' => 'name must be a miniumu of two string',
            'isbn.required' => 'isbn field is required',
            'isbn.unique' => 'isbn must be unique',
            'isbn.min' => 'isbn must be more than 8 characters',
            'authors.required' => 'authors field is required',
            'authors.min' => 'authors must be a miniumu of two string',
            'number_of_pages.required' => 'number of pages field is required',
            'number_of_pages.numeric' => 'number of pages field must be a number',
            'publisher.required' => 'publisher field is required',
            'publisher.string' => 'publisher must be a string',
            'country.required' => 'publisher field is required',
            'country.string' => 'publisher must be a string',
            'release_date.required' => 'release_date field is required',
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
