<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Tetap true karena pengecekan "siapa yang punya barang" 
        // sudah kita tangani di Policy/Controller.
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'qty.required' => 'Jumlah (kuantitas) produk wajib diisi.',
            'qty.integer' => 'Jumlah produk harus berupa angka bulat.',
            'qty.min' => 'Jumlah produk tidak boleh kurang dari 0.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka yang valid.',
            'price.min' => 'Harga produk tidak boleh kurang dari 0.',
        ];
    }
}