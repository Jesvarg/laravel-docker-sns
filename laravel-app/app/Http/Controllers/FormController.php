<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Aws\Sns\SnsClient;

class FormController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Guardar en base de datos
        DB::table('form_data')->insert($data);

        // Enviar a SNS
        $sns = new SnsClient([
            'version' => 'latest',
            'region' => 'us-east-1'
        ]);

        $sns->publish([
            'TopicArn' => 'arn:aws:sns:us-east-1:039422425289:Practica-microservicios-con-Docker',
            'Message' => json_encode($data)
        ]);

        return response()->json(['message' => 'Formulario enviado correctamente']);
    }
}
