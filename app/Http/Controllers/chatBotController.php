<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\modelChatBot;

class chatBotController extends Controller
{

    private $verifyToken;
    private $my_number_phone;
    private $access_token;
    private $token_API_IA;


    private $prompt_IA = "Eres Tiburonsin 🤖🦈, el asistente virtual del ECO HOTEL PARADOR DE RAPI.  
Tu tarea es atender a los clientes como un asesor amable, claro y breve, dando información sobre hospedajes, piscina, alimentos y bebidas.

🎯 Reglas:
1. Responde SIEMPRE en español.  
2. Mantén un tono cordial, cercano y profesional, como un recepcionista.  
3. Devuelve SOLO TEXTO. No inventes ni generes imágenes, videos ni enlaces.  
4. Si el cliente solicita FOTOS o VIDEOS, responde con un texto corto y además incluye una palabra clave en mayúsculas en el campo 'action' para que el backend sepa qué adjuntar. Ejemplo:
   - 'Aquí tienes las fotos del Paquete Oro 🥇'  
   - action: FOTOS_PAQUETE_ORO
5. Si el cliente solicita reservar, coloca 'action: RESERVAR'.  
6. Si el cliente pregunta por comida, bebidas o licores si se vende en la tienda y restaurante, coloca 'action: FOTOS_CARTA'.  
7. Sé breve y no repitas información innecesaria. Usa íconos cuando aporte claridad.
8. Si el cliente desea realizar una reservacion debes remitirlo a un asesor y se lo comunicarás 'Te estamos comunicando con un asesor para realizar tu reserva...'.
9. si el cliente pregunta algo de lo que no tienes conocimiento, remitelo al asesor 'action: ASESOR'.
10. si el cliente pregunta que envies mapa o ubicacion 'action: UBICACION'. 
📷 Ejemplos de acciones (palabras clave que debe devolver en 'action'):
- FOTOS_PAQUETE_ORO
- FOTOS_PAQUETE_ORO_ROMANTICO
- FOTOS_PAQUETE_PLATA
- FOTOS_PISCINA
- FOTOS_CARTA
- VIDEOS_LUGAR
- RESERVAR 
- ASESOR
- UBICACION
- NONE  (usar cuando no corresponda adjuntar nada)

📌 Información clave (resumida):
- Piscina: agua caliente a 35°C.  
  Horarios: **Lunes a Sábado: 4:00 PM - 11:30 PM. Domingos y festivos: 10:00 AM - 11:30 PM.**  
  Precios: **Adultos: 💲20.000 — Niños: 💲15.000.**

- Paquete Noche Oro 🥇: Pareja — habitación con tina, piscina caliente, desayuno (8AM–10AM), hospedaje 23h (4PM–3PM), sapo, senderos ecológicos, agua caliente, baño con tina, TV, ventilador, Wi-Fi.  
  Precio: **💲125.000** (entre semana) / **💲140.000** (fin de semana).

- Paquete Noche Plata 🥈: Pareja — habitación estándar con ducha, piscina, desayuno (8AM–10AM), hospedaje 23h, senderos, agua caliente, TV, ventilador, Wi-Fi.  
  Precio: **💲100.000** (entre semana) / **💲120.000** (fin de semana).

- Paquete Eco Romántico Oro: Pareja — incluye cena romántica, vino, decoración plus, tina y todos los beneficios del Oro.  
  Precio: **💲310.000**.

- Paquete Descanso 4h Oro: Pareja — 4 horas, habitación con tina, piscina, TV, ventilador, Wi-Fi, baño privado, sendero. Precio: **💲80.000**.

- Paquete Descanso 4h Plata: Pareja — 4 horas, habitación con baño sencillo, piscina, TV, ventilador, Wi-Fi, baño privado, sendero. Precio: **💲60.000**.

⏰ Horarios y check:
- Check-in: **4:00 PM**.  
- Check-out: **3:00 PM** (día siguiente).  
- Desayunos: **8:00 AM – 10:00 AM**.

RESPONDE siempre como un asesor natural y simpático.
- Cuando te pidan los paquetes coloca los emojis correspondientes a cada paquete.  
- Cuando se deba adjuntar fotos o videos, coloca la palabra clave exacta en 'action'.  
- Si el cliente pide reservar, coloca 'action: RESERVAR'.  
- Si el cliente menciona comida, bebidas o licores, coloca 'action: FOTOS_CARTA'.  
- Si no corresponde, devuelve 'action: NONE'.";


    public function __construct() {
    $this->verifyToken = env('VERIFY_TOKEN');
    $this->my_number_phone = env('MY_NUMBER_PHONE');
    $this->access_token = env('ACCESS_TOKEN');
    $this->token_API_IA = env('OPENAI_API_KEY');


}
    public function chatBot(Request $request)
    {

        if ($request->isMethod('get')) {

            if ( $request->query('hub.mode') === 'subscribe' && $request->query('hub.verify_token') === $this->verifyToken) {
                return response($request->query('hub.challenge'), 200);
            }

            $hola = "";
            $prueba = $request->query('hub.mode');
            if($request->query('hub.verify_token') === $this->verifyToken) $hola = "se verifican satisfactoriamente";
            else $hola = "ni mergas";

            return response("Error de verificación ".$this->verifyToken." ".$hola." ademas esto es asi: ".$prueba, 403);
        }

        // --- Recepción de mensajes (POST) ---
        if ($request->isMethod('post')) {


            $messages = $request->input('entry.0.changes.0.value.messages', []);

            if (empty($messages)) {
                return response()->json(['status' => 'ok', 'message' => 'No hay mensajes']);
            }

            $from = $messages[0]['from']; // Número del usuario
            $text = strtolower($messages[0]['text']['body'] ?? '');
            $contact = $request->input('entry.0.changes.0.value.contacts', []);
            $name = $contact[0]['profile']['name'] ?? '';


            $exists = modelChatBot::verifyExists($from);

            if (!$exists) self::saveChatBot($from, $text);
            else {

                $update_ultimate_message = modelChatBot::updateChat($from,$text);

                if(!$update_ultimate_message) return response()->json(["message" => "no pudo ser guardado el ususario en base de datos"]);
                $reply = '';



                if ($text !== "") {

                    $response_IA = Http::withHeaders([
                        'Authorization' => "Bearer {$this->token_API_IA}",
                        'Content-Type' => 'application/json',
                    ])->post('https://api.openai.com/v1/responses', [
                        "model" => "gpt-5-nano",
                        "input" => [
                            [
                                "role" => "system",
                                "content" => [
                                    [
                                        "type" => "input_text",
                                        "text" => $this->prompt_IA
                                    ]
                                ]
                            ],
                            [
                                "role" => "user",
                                "content" => [
                                    [
                                        "type" => "input_text",
                                        "text" => $text


                                    ]
                                ]
                            ]
                        ]
                    ]);

                    $data = $response_IA->json();

                    $reply3 = "";

                    if (isset($data['output'][1]['content'][0]['text'])) {
                        $reply = $data['output'][1]['content'][0]['text'];
                        $reply = is_array($reply) ? json_encode($reply) : (string)$reply;
                        $reply2 = explode("\n", $reply);

                        $lastLine = trim(end($reply2));

                        if (str_starts_with(strtolower($lastLine), 'action:')) {
                            array_pop($reply2); // quitar la línea action
                        }

                        $reply3 = implode("\n", array_map('trim', $reply2));
                        $action = str_replace('action: ', '', $lastLine) ?: 'NONE';
                    } else {
                        $reply = ''; // fallback si no hay texto
                    }
                }

                /// aca deberia guardar los estados

                // Enviar mensaje real usando Http::post()

                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$this->access_token}",
                    'Content-Type' => 'application/json'
                ])->post("https://graph.facebook.com/v22.0/{$this->my_number_phone}/messages", [
                    "messaging_product" => "whatsapp",
                    "to" => $from,
                    "type" => "text",
                    "text" => ["body" => $reply3]
                ]);



                if ($action !== "NONE" && $action !== "ASESOR" && $action !== "RESERVAR") self::sendImageToWhastapp($from, $action);
                else {

                    $from_general = "573108805964";
                    $response = Http::withHeaders([
                        'Authorization' => "Bearer {$this->access_token}",
                        'Content-Type' => 'application/json'
                    ])->post("https://graph.facebook.com/v22.0/{$this->my_number_phone}/messages", [
                        "messaging_product" => "whatsapp",
                        "to" => $from_general,
                        "type" => "text",
                        "text" => ["body" => "Hola, parece que el cliente con numero de whatsapp $from necesita $action \n wa.me/$from"]
                    ]);
                }
                // Retornar respuesta de WhatsApp para debugging
                return response()->json([
                    'status' => 'ok',
                    'sent_to' => $from,
                    'message_sent' => $reply3,
                    'whatsapp_response' => $response->json()
                ]);
            }

            return response('Método no permitido', 405);
        }
    }


    private function sendImageToWhastapp($to, $image)
    {


        $images = [];
        switch ($image) {
            case 'FOTOS_PAQUETE_ORO_ROMANTICO':
                $images = [
                    'https://res.cloudinary.com/dznejj41m/image/upload/Romantico4_nck2p5',
                    'https://res.cloudinary.com/dznejj41m/image/upload/Romantico2_cydxli',
                    'https://res.cloudinary.com/dznejj41m/image/upload/Romantico6_xuovlc',
                    'https://res.cloudinary.com/dznejj41m/image/upload/Romantico1_g2syyb',
                    'https://res.cloudinary.com/dznejj41m/image/upload/Romantico5_unqs1g',
                    'https://res.cloudinary.com/dznejj41m/image/upload/Romantico3_zzqjfe'
                ];
                break;

            case 'FOTOS_CARTA':
                $images = [
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758341286/Carta1_jedsm1.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758341286/Carta2_mj9opz.jpg'
                ];
                break;

            case 'FOTOS_PAQUETE_ORO':
                $images = [
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758341631/Oro3_z8umbo.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758341631/Oro1_sbynnq.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758341631/Oro2_unwqmb.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758341631/Oro4_l2dcgw.jpg'
                ];
                //];
                break;


            case 'FOTOS_PAQUETE_PLATA':

                $images = [
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758342531/Plata3_vyg0hi.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758342531/Plata2_frgc1b.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758342531/Plata1_btqlic.jpg'
                ];
                break;


            case 'FOTOS_PISCINA':

                $images = [
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758342829/Piscina4_nruc0t.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758342830/Piscina2_tngtmk.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758342830/Piscina3_s863yf.jpg',
                    'https://res.cloudinary.com/dznejj41m/image/upload/v1758342830/Piscina1_jphoau.jpg'
                ];
                break;

            case 'VIDEOS_LUGAR':

                $images = [
                    'https://res.cloudinary.com/dznejj41m/video/upload/v1758346698/publicidad-video-7fpnnxcx_FqgxdkJU_compressed_vtvh41.mp4'
                ];
                break;
            default:
                // Aquí va la lógica por defecto
                break;
        }


        if ($image === 'UBICACION') {

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->access_token}",
                'Content-Type'  => 'application/json'
            ])->post("https://graph.facebook.com/v22.0/{$this->my_number_phone}/messages", [
                "messaging_product" => "whatsapp",
                "to"                 => $to, // número del cliente
                "type"               => "location",
                "location"           => [
                    "latitude"  => "4.8571289039336865",
                    "longitude" => "-75.64672035182372",
                    "name"      => "CENTRO RECREACIONAL ECO HOTEL PARADOR DE RAPI",
                    "address"   => "800 metros de la rotonda de la romelia, subiendo a santa rosa de cabal a mano derecha."
                ]
            ]);
        }else{

                    foreach ($images as $item) {

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->access_token}",
                'Content-Type'  => 'application/json'
            ])->post("https://graph.facebook.com/v22.0/{$this->my_number_phone}/messages", [
                "messaging_product" => "whatsapp",
                "to"                => $to, // número del cliente
                "type"              => $image === 'VIDEOS_LUGAR' ? "video" : "image",
                $image === 'VIDEOS_LUGAR' ? "video" : "image" => [
                    "link" => $item // URL directa de la imagen o video
                ]
            ]);

            usleep(500000);
        }

        }

    }
    private function  saveChatBot($numero, $mensaje,)
    {

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $state_conversation = 'inicio';

        $data_insert = [
            "telefono" => $numero,
            "ultimo_mensaje" => $mensaje,
            "estado_conversacion" => $state_conversation,
            "consentimiento" => false,
            "fecha" => $fecha,
            "hora" => $hora
        ];
        $save_session = modelChatBot::insertConversation($data_insert);
    }


    private function verifyStateConversation($numero) {}

}
