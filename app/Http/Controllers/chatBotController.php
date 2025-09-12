<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class chatBotController extends Controller
{

    private $verifyToken = 'miverifytoken123';
    private $my_number_phone = "724334417439040";
    private $access_token = "EAANcbiF21WQBPTd47cxdKVZCuwP5J4LLZB3vwPYiLJZCONxbXLEhtitf1X4VB0rile90lDZAtaVFRqGW5Mg7LsbX81a11ilsuZAfPYn76HZB6D1ZBzuSuOukvezHPFOZCy8H8HUDjFJqwmpSB8fedv8YMv0rL8nDFT9KKFh5pKvidB7RsJHZAPKaSHG29965cPSFGjbZAnevI7x6Ltz5H4gT7JWQ0ESqLIJ9jMuMcb5YyI6smG2UFkrfcpwic3Xfk4BgZDZD";
    public function chatBot(Request $request)
    {

        if ($request->isMethod('get')) {

            if (
                $request->input('hub_mode') === 'subscribe' &&
                $request->input('hub_verify_token') === $this->verifyToken
            ) {
                return response($request->input('hub_challenge'), 200);
            }

            return response('Error de verificación', 403);
        }

        // --- Recepción de mensajes (POST) ---
        if ($request->isMethod('post')) {

           $messages = $request->input('entry.0.changes.0.value.messages', []);

        if (empty($messages)) {
            return response()->json(['status' => 'ok', 'message' => 'No hay mensajes']);
        }

        $from = $messages[0]['from']; // Número del usuario
        $text = $messages[0]['text']['body'] ?? '';
        $contact = $request->input('entry.0.changes.0.value.contacts', []);
        $name = $contact[0]['profile']['name'] ?? '';

        // Lógica básica de respuestas
        if (str_contains(strtolower($text), 'hola')) {
            $reply = "¡Hola $name! Soy tu bot tiburonsin !!Huahaha!!🦈🦈, ¿cómo estás?
Selecciona qué tipo de paquete deseas:\n\n1️⃣ Oro (pareja)\n2️⃣ Plata (pareja)\n3️⃣ Familiar (5 o Mas personas)\n4️⃣ Múltiple (7 a 9 personas)

Hola, te recordamos que los horarios son:

PISCINA 🏊🏻‍♂️🏊🏻‍♂️🏊🏻‍♂️: 

4PM - 11:30 PM (LUNES A SABADO)
10 AM - 11:30PM (DOMINGOS Y FESTIVOS)

PRECIOS:

ADULTOS: 💲20.000 (LUNES - DOMINGO)
NIÑOS: 💲 15.000 (LUNES -DOMINGO)";
        } else {
            $reply = "Recibí tu mensaje: $text";
        }

        // Enviar mensaje real usando Http::post()
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->access_token}",
            'Content-Type' => 'application/json'
        ])->post("https://graph.facebook.com/v22.0/{$this->my_number_phone}/messages", [
            "messaging_product" => "whatsapp",
            "to" => $from,
            "type" => "text",
            "text" => ["body" => $reply]
        ]);

        // Retornar respuesta de WhatsApp para debugging
        return response()->json([
            'status' => 'ok',
            'sent_to' => $from,
            'message_sent' => $reply,
            'whatsapp_response' => $response->json()
        ]);
    }

        return response('Método no permitido', 405);
    }
}
