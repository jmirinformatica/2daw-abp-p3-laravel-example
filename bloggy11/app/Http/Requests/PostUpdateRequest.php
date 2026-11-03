<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Handle authorization logic for the request 
        // in another part of your application
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
            'title'     => 'nullable|string|max:255',
            'body'      => 'nullable|string|max:1024',
            'status_id' => 'nullable|integer|exists:statuses,id',
        ];        
    }
}
