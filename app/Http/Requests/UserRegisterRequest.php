<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required', 'max:255', 'min:6'], // Perbaikan: Hapus tanda kutip ekstra
            'role' => ['required'],
        ];
    }

    /**
     * Menghandle validasi yang gagal
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "errors" => $validator->errors()
        ], 422)); // Perbaikan: Gunakan status 422 untuk validasi yang gagal
    }
}
