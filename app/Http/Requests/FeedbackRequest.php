<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['title' => "string", 'description' => "string", 'category' => "string"])]
    public function rules(): array
    {
        return [
            'title'         => 'required|max:100',
            'description'   => 'required',
            'category'      => 'required'
        ];
    }
}
