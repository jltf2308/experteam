<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuideRequest extends FormRequest
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
    * Function to get the validation rules that apply to the request.
    * @author José Tovar | jtovar@estrategica.com
    * @created 18-05-2021
    * @param ParticipationSchemePost $request
    * @return array
    *
    */
    public function rules()
    {
        return [
            'guide_number' => 'required|max:10|unique:guides,guide_number,'.$this->route('guide'),
            'shipping_date' => 'required',
            'country_origin' => 'required|max:100',
            'sender_name'=> 'required|max:100',
            'sender_address'=> 'required|max:100',
            'sender_phone'=> 'required|max:50',
            'sender_email'=> 'required|max:50',
            'destination_country'=> 'required|max:100',
            'recipient_name'=> 'required|max:100',
            'recipient_address'=> 'required|max:100',
            'recipient_phone'=> 'required|max:50',
            'recipient_email'=> 'required|max:50',
            'total'=> 'required',
        ];
    }

    /**
    * Function to get messages from the validation rules that apply to the request.
    * @author José Tovar | jtovar@estrategica.com
    * @created 18-05-2021
    * @param ParticipationSchemePost $request
    * @return array
    *
    */
    public function messages()
    {
        return [
            'guide_number.required' => 'El número de guia es requerido.',
            'guide_number.max' => 'El número de guia es debe contener máximo 10 caracteres.',
            'shipping_date.required' => 'La fecha de envio es requerida.',
            'country_origin.required' => 'El país de origen es requerido.',
            'country_origin.max' => 'El país de origen debe contener máximo 100 caracteres.',
            'sender_name.required' => 'El nombre del remitente es requerido.',
            'sender_name.max' => 'El nombre del remitente debe contener máximo 100 caracteres.',
            'sender_address.required' => 'La dirección del remitente es requerida.',
            'sender_address.max' => 'La direccion del remitente debe contener máximo 100 caracteres.',
            'sender_phone.required' => 'El teléfono del remitente es requerido.',
            'sender_phone.max' => 'El teléfono del remitente debe contener máximo 50 caracteres.',
            'sender_email.required' => 'El correo eléctronico del remitente es requerido.',
            'sender_email.max' => 'El correo eléctronico del remitente debe contener máximo 50 caracteres.',
            'destination_country.required'=>'El país de destino es requerido.', 
            'destination_country.max'=>'El país de destino debe contener máximo 100 caracteres.',
            'recipient_name.required'=>'El nombre del destinatario es requerido.',
            'recipient_name.max'=>'El nombre del destinatario debe contener máximo 100 caracteres.',
            'recipient_address.required'=> 'La dirección del destinatario es requerida.',
            'recipient_address.max'=> 'La direccion del destinatario debe contener máximo 100 caracteres.',
            'recipient_phone.required'=> 'El teléfono del destinatario es requerido.',
            'recipient_phone.max'=> 'El teléfono del destinatario debe contener máximo 50 caracteres.',
            'recipient_email.required'=> 'El correo eléctronico del destinatario es requerido.',
            'recipient_email.max'=> 'El correo eléctronico del destinatario debe contener máximo 50 caracteres.',
            'total.required'=> 'El monto total de la guia es requerido'
        ];
    }

    /**
    * Response messages
    * @author José Tovar | jtovar@estrategica.com
    * @created 18-05-2021
    * @param  Validator $validator
    * @throws StrategicScopePost
    */
    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'statusCode' => 422,
            'message'    => 'Unprocessable Entity',
            'errors'     => $validator->errors()
        ], 422);
        throw new HttpResponseException($response);
    }
}
