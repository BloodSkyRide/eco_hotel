<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class requestFood implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nombre_producto;
    public $cantidad;
    public $hora;
    public $image_product;


    public function __construct($nombre,$cantidad,$hora)
    {
        $this->nombre_producto = $nombre;
        $this->cantidad = $cantidad;
        $this->$hora = $hora;

    }

    public function broadcastOn(): Channel
    {
        return new Channel('realtime-channel');  // Aquí defines el canal
    }

    // Opcional: cambiar el nombre que se usa en JS para escuchar el evento
    public function broadcastAs()
    {
        return 'requestFood';
    }

        public function broadcastWith()
    {   // aqui definimos los datos que seran enviados al frontend
        
        return [
            
            'name_product' => $this->nombre_producto,
            'amount' => $this->cantidad,
            'hora' => $this->hora,
            'tipo' => "recibido"
        ];
    }
}