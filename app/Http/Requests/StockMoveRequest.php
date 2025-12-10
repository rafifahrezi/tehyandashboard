<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockMoveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // PENTING: Kembalikan true jika sudah ada middleware auth
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
            'bahan_id' => 'required|exists:bahans,id',
            'move_type' => 'required|in:in,out',
            'qty' => 'required|numeric|min:0.01',
            'reference_type' => 'nullable|string',
            'reference_id' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'bahan_id.required' => 'Bahan baku wajib dipilih.',
            'move_type.required' => 'Jenis transaksi wajib dipilih.',
            'qty.required'      => 'Jumlah transaksi wajib diisi.',
            'qty.min'           => 'Jumlah transaksi minimal 0.01.',
        ];
    }
}
