<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('tienda','productos.tienda_id','=','tienda.id')
            ->select('productos.id','productos.sku','productos.tienda_id','productos.nombre','productos.valor','tienda.nombre as nombre_tienda','productos.descripcion','productos.condicion')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('tienda','productos.tienda_id','=','tienda.id')
            ->select('productos.id','productos.sku','productos.tienda_id','productos.sku','productos.nombre','productos.valor','tienda.nombre as nombre_tienda','productos.valor','productos.descripcion','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }

    public function listarProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('tienda','productos.tienda_id','=','tienda.id')
            ->select('productos.id','productos.tienda_id','productos.sku','productos.nombre','tienda.nombre as nombre_tienda','productos.valor','productos.descripcion','productos.condicion')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('tienda','productos.tienda_id','=','tienda.id')
            ->select('productos.id','productos.tienda_id','productos.sku','productos.nombre','tienda.nombre as nombre_nombre','productos.valor','productos.descripcion','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return ['productos' => $productos];
    }
 
    public function listarProductoVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Producto::join('tienda','productos.tienda_id','=','tienda.id')
            ->select('productos.id','productos.tienda_id','productos.sku','productos.nombre','tienda.nombre as nombre_nombre','productos.valor','productos.descripcion','productos.condicion')
   
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else{
            $productos = Producto::join('tienda','productos.tienda_id','=','tienda.id')
            ->select('productos.id','productos.tienda_id','productos.sku','productos.nombre','tienda.nombre as nombre_tienda','productos.valor','productos.descripcion','productos.condicion')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
    
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        

        return ['productos' => $productos];
    }

    public function buscarProducto(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('sku','=', $filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get();

        return ['productos' => $productos];
    }

    public function buscarProductoVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $productos = Producto::where('sku','=', $filtro)
        ->select('id','nombre','valor')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();

        return ['productos' => $productos];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = new Producto();
        $producto->tienda_id = $request->tienda_id;
        $producto->sku = $request->sku;
        $producto->nombre = $request->nombre;
        $producto->valor = $request->valor;      
        $producto->descripcion = $request->descripcion;
        $producto->imagen = $request->imagen;
        $producto->condicion = '1';
        $producto->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->tienda_id = $request->tienda_id;
        $producto->sku = $request->sku;
        $producto->nombre = $request->nombre;
        $producto->valor = $request->valor;
        $producto->descripcion = $request->descripcion;
        $producto->imagen = $request->imagen;
        $producto->condicion = '1';
        $producto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '0';
        $producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        $producto->condicion = '1';
        $producto->save();
    }

}
