<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\TaskStatus;

class StoreTaskStatusRequest extends FormRequest
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
    public function rules(Request $request, TaskStatus $taskStatus)
    {
        switch ($request->method()) {
            case ('PATCH'):
                return [
                    'name' => ['required',
                        Rule::unique('task_statuses')->ignore($taskStatus->id)
                    ]
                ];
            case ('POST'):
                return [
                    'name' => 'required|unique:task_statuses'
                ];
            default:
                throw new \Exception("This method is not supported");
        }
    }
}
