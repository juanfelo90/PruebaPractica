<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tienda;
use App\Producto;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tiendas = Tienda::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $tiendas = Tienda::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $tiendas->total(),
                'current_page' => $tiendas->currentPage(),
                'per_page'     => $tiendas->perPage(),
                'last_page'    => $tiendas->lastPage(),
                'from'         => $tiendas->firstItem(),
                'to'           => $tiendas->lastItem(),
            ],
            'tiendas' => $tiendas
        ];
    }

    public function selectTienda(Request $request){
        if (!$request->ajax()) return redirect('/');
        $tiendas = Tienda::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['tiendas' => $tiendas];
    }
 

    public function servicio()
    {

        $productos = Producto::join('tienda','productos.tienda_id','=','tienda.id')
        ->select('productos.id','productos.tienda_id','productos.sku','productos.nombre','tienda.nombre as nombre_tienda','productos.valor','productos.descripcion','productos.condicion')
        ->orderBy('productos.id', 'desc')->paginate(10);
        return response()->json($productos);
 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tienda = new Tienda();
        $tienda->nombre = $request->nombre;
        $tienda->fecha_apertura = $request->fecha_apertura;
        $tienda->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if (!$request->ajax()) return redirect('/');
        $tienda = Tienda::findOrFail($request->id);
        $tienda->nombre = $request->nombre;
        $tienda->fecha_apertura = $request->fecha_apertura;
        $tienda->condicion = '1';
        $tienda->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tienda = Tienda::findOrFail($request->id);
        $tienda->condicion = '0';
        $tienda->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tienda = Tienda::findOrFail($request->id);
        $tienda->condicion = '1';
        $tienda->save();
    }

    
}
