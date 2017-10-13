<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientsRequest extends FormRequest
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
            'first_name'                => 'required',
            'last_name'                 => 'required',
            'gender'                    => 'required',
            'birth_date'                => 'nullable|date_format:'.config('app.date_format'),
            'address'                   => 'required|array|min:1',
            'address.*.address_type_id' => 'required|exists:address_types,id',
        ];
    }
}
