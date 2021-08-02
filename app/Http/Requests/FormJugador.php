<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormJugador extends FormRequest
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
            'nombre' => 'required',
            'apellido' => 'required',
            'val_media' => 'required|numeric|between:0, 100',
            'pais' => 'required|size:3',
            'edad' => 'required|numeric|between:15, 50',
            'altura' => 'required|digits:3',
        ];
    }

    public function attributes()
    {
        return [
            "val_media" => "valoración media"
        ];
    }

    public function messages()
    {
        return [
            "val_media.required" => "Debe ingresar una valoración media valida"
//            'val_media' => 'required|numeric|between:0, 100',
//            'pais' => 'required|size:3',
//            'edad' => 'required|numeric|between:15, 50',
//            'altura' => 'required|digits:3',
        ];
    }
}
