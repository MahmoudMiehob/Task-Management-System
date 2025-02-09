<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The task title is required.',
            'title.max' => 'The task title must not exceed 255 characters.',
            'assigned_to.required' => 'You must assign the task to a user.',
            'assigned_to.exists' => 'The selected user does not exist.',
            'status.required' => 'The task status is required.',
            'status.in' => 'The task status must be one of: pending, in_progress, completed.',
        ];
    }
}
