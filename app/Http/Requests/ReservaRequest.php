<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ReservaRequest extends FormRequest
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
            'fecha_inicio' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'fecha_fin' => [
                'required',
                'date',
                'after_or_equal:fecha_inicio',
            ],
            'num_personas' => [
                'required',
                'integer',
                'min:1',
                'max:10',
            ],
            'comentario' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'estado' => [
                'nullable',
                'in:PRE-RESERVA,RESERVADO,NO_DISPONIBLE,cancelada',
            ],
        ];
    }

    /**
     * Get custom messages for validation.
     */
    public function messages(): array
    {
        return [
            'fecha_inicio.required' => 'Debe seleccionar una fecha de inicio.',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a hoy.',
            'fecha_fin.required' => 'Debe seleccionar una fecha de fin.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la de inicio.',
            'num_personas.required' => 'Debe indicar el número de personas.',
            'num_personas.min' => 'Mínimo 1 persona.',
            'num_personas.max' => 'Máximo 10 personas.',
            'comentario.max' => 'El comentario no debe exceder 1000 caracteres.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $inicio = $this->input('fecha_inicio');
            $fin = $this->input('fecha_fin');

            if (!$inicio || !$fin) {
                return;
            }

            $fechaInicio = Carbon::parse($inicio);
            $fechaFin = Carbon::parse($fin);
            $dias = $fechaInicio->diffInDays($fechaFin);

            if ($dias < 6) {
                $validator->errors()->add('fecha_fin', 'La reserva debe ser de minimo 7 dias.');
            }
        });
    }
}
