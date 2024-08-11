<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FinanceAssetsUpdateRequest extends FormRequest
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
            'id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'recurrence' => 'nullable|string|in:daily,weekly,monthly,yearly',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ];
    }

    /**
     * prepare for validation
     * 
     * @return void
     */
    protected function prepareForValidation()
    {

        if ($this->get('start_date')) {
            // transform format "15/08/2024" to "2024-08-15"
            $this->merge([
                'start_date' => $this->castDate($this->get('start_date'))
            ]);
        }

        if ($this->get('end_date')) {
            $this->merge([
                'end_date' => $this->castDate($this->get('end_date'))
            ]);
        }
    }


    private function castDate($date)
    {
        if (strpos($date, '/') !== false) {
            return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        } else if (strpos($date, '-') !== false) {
            return date('Y-m-d', strtotime($date));
        }
    }
}
