<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_id' =>'required|integer'
        ];
    }

    protected function prepareForValidation()
    {
        $roomId = $this->route('room_id');
        if ($roomId) {
            $this->merge([
                'room_id' => intval($roomId),
            ]);
        }
    }
}
