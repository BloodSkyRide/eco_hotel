<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificacionCreada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nombre_producto;
    public $cantidad;
    public $cajero;
    public $id_cajero;
    public $description;
    public $hora;
    public $fecha;
    public $image_product;
    public $id_order;
    public $tipo;

    public function __construct($nombre,$cantidad,$hora, $tipo, $id_cajero, $description = '', $cajero = '' ,$fecha = '', $image_product = '', $id_order = '')
    {
        $this->nombre_producto = $nombre;
        $this->cantidad = $cantidad;
        $this->cajero = $cajero;
        $this->id_cajero = $id_cajero;
        $this->description = $description;
        $this->hora = $hora;
        $this->fecha = $fecha;
        $this->image_product = $image_product;
        $this->id_order = $id_order;
        $this->tipo = $tipo;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('realtime-channel');  // Aquí defines el canal
    }

    // Opcional: cambiar el nombre que se usa en JS para escuchar el evento
    public function broadcastAs()
    {
        return 'orderKitchen';
    }

        public function broadcastWith()
    {   // aqui definimos los datos que seran enviados al frontend
        
        return [
            
            'name_product' => $this->nombre_producto,
            'amount' => $this->cantidad,
            'name_shopkeeper' => $this->cajero,
            'id_shopkeeper' => $this->id_cajero,
            'description' => $this->description,
            'hora' => $this->hora,
            'fecha' => $this->fecha,
            'image_product'=> $this->image_product,
            'id_order' => $this->id_order,
            'tipo' => $this->tipo
        ];
    }
}