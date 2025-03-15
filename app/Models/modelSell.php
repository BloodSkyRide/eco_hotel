<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class modelSell extends Model
{
    use HasFactory;
    protected $table = "historial_ventas";
    protected $fillable = [
        "id_producto_venta",
        "nombre_producto_venta",
        "descripcion_producto_venta",
        "unidades_venta",
        "id_user_cajero",
        "nombre_cajero",
        "hora",
        "fecha",
        "total_venta",
        "created_at",
        "updated_at"
    ];

    public static function insertSell($data)
    {

        return self::insert($data);
    }

    public static function getSells($fecha)
    {

        // return self::where("fecha", $fecha)
        //     ->orderby("fecha", "desc")
        //     ->get();

        return self::join('productos_venta', 'historial_ventas.id_producto_venta', '=', 'productos_venta.id_producto') // INNER JOIN con la tabla 'users'
            ->where('historial_ventas.fecha', $fecha)
            ->orderBy('historial_ventas.hora', 'desc')
            ->get();

        // return self::where('historial_ventas.fecha', $fecha)
        //     ->orderBy('historial_ventas.hora', 'desc') 
        //     ->get();
    }


    public static function totalSells($fecha)
    {

        return self::where("fecha", $fecha)
            ->sum('total_venta');
    }


    public static function unitTotalSells($fecha)
    {

        return self::select(
            'historial_ventas.id_producto_venta',
            DB::raw('MAX(productos_venta.url_imagen) AS url_imagen'),
            DB::raw('MAX(historial_ventas.nombre_producto_venta) AS nombre_producto_venta'),
            DB::raw('MAX(historial_ventas.descripcion_producto_venta) AS descripcion_producto_venta'),
            DB::raw('MAX(historial_ventas.id_user_cajero) AS id_user_cajero'),
            DB::raw('MAX(historial_ventas.hora) AS hora'),
            DB::raw('MAX(historial_ventas.fecha) AS fecha'),
            DB::raw('MAX(historial_ventas.nombre_cajero) AS nombre_cajero'),
            DB::raw('SUM(historial_ventas.unidades_venta) AS total_cantidad'),
            DB::raw('SUM(historial_ventas.total_venta) AS total_vendido')
        )
            ->join("productos_venta", "historial_ventas.id_producto_venta", "=", "productos_venta.id_producto")
            ->whereDate('fecha', $fecha)
            ->groupBy('id_producto_venta')
            ->get();
    }



    public static function getTotalForUsers($fecha)
    {


        return self::select(
            "id_user_cajero",
            "nombre_cajero",
            DB::raw('SUM(unidades_venta) AS total_unidades'),
            DB::raw('SUM(total_venta) AS total_venta')
        )
            ->where("fecha", $fecha)
            ->groupBy('id_user_cajero', 'nombre_cajero')
            ->get();
    }

    public static function getContability($month, $year,$today) {


        $startDate = "$year-$month-01"; // Primer día del mes
        $endDate = "$year-$month-$today"; // Día actual dentro del mes
    
        return self::whereBetween("fecha", [$startDate, $endDate])
            ->sum("total_venta");
    }
}
