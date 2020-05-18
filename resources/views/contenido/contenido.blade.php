    @extends('principal')
    @section('contenido')

    @if(Auth::check())
            @if (Auth::user()->idrol == 1)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>

            <template v-if="menu==1">            
                <tienda :ruta="ruta"></tienda>
            </template>

            <template v-if="menu==2">
                <producto :ruta="ruta"></producto>
            </template>

          

            @endif

    @endif
       
        
    @endsection