<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class Index extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'page' => 'required|integer|min:1',
            'rowsPerPage' => 'required|integer|min:5',
            'search' => 'sometimes|array',
            'sortBy' => 'sometimes|nullable|in:id,title,author,genre,isbn,published_on,publisher',
            'sortType' => 'sometimes|nullable|in:asc,desc'
        ];
    }
}
