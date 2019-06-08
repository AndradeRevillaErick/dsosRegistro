@extends('plantilla.plantilla') 

@section('cabeceras')
<script src="{{ asset('assets/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/agregar.js') }}"></script>
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"/> --}}
{{-- {!! Form::hidden('_token',csrf_token()) !!} --}}
@endsection @section('content')

{{-- Esta variable guarda el id del equipo local extraido de la consulta realizada
en el controlador verregitro --}}
<input type="hidden" id="idlocal" value="{{$partidoj->equipo_local}}"/>
{{-- Esta variable guarda el id del equipo visitante extraido de la consulta realizada
en el controlador verregitro --}}
<input type="hidden" id="idvisit" value="{{$partidoj->equipo_visitante}}"/>

<input type="hidden" id="idpartido" value="{{$partidoj->id_partido}}"/>

<div class="container-fluid">

    <div class="row justify-content-center">
        <div>
            <h3>RESULTADO FINAL</h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div>
            <h4>
                 <label >Local: </label>
                 <input type="text" id="totlocal" readonly style="max-width: 60px">
                 <label >  Visitante: </label>
                 <input type="text" id="totvisitante" readonly readonly style="max-width: 60px">
            </h4>
        </div>
    </div>

    <div class="accordion" id="accordionExample">
        <div class="card">

            <!--Registro de goles-->
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <center>
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h3>GOLES</h3>
                        </button>
                    </center>
                 </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <!--Plantilla para agregar goles-->
                        <template id="plantillagoles">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters ">
                                    <div class="col-md-4">
                                        {{-- <img src="..." class="card-img" alt="(Imagen del Jugador)"> --}}
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Gol anotado por</h5>
                                            {{-- <form action=""> --}}
                                                <input type="hidden" name="id_partido[]" id="id_partido" value="{{$partidoj->id_partido}}"/>
                                                <div class="form-group">
                                                    <label for="jugador">Jugador que anoto</label>
                                                    <select class="form-control" name="id_jugador[]" id="goljugador">
                                                      {{-- <option value="">- Seleccione -</option> --}}
                                                    </select>
                                                </div>
                                                
                                                <input type="hidden" name="oculto[]" id="oculto" value=""/>

                                                <div class="form-group">
                                                    <label for="minuto">Gol antotado al minuto</label>
                                                    <input type="text" name="minuto[]" class="form-control" id="golminuto" placeholder="Registra el minuto">
                                                </div>
                                                <div class="form-group">
                                                    <label for="eqcd">Equipo en contra de</label>
                                                    <input type="number" min=99 max=150 name="equipo_en_contra[]" class="form-control" id="contrade" placeholder="En contra de">
                                                </div>
                                                <div class="form-group">
                                                    <label for="efd">Equipo en favor de </label>
                                                    <input type="text" name="equipo_en_favor_de[]" class="form-control" id="favorde" placeholder="A favor de">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tipoa">Tipo de Anotacion </label>
                                                    <input type="text" name="tipo_anotacion[]" class="form-control" id="tipo" placeholder="Tipo de anotacion">
                                                </div>
                                            {{-- </form> --}}
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" style="max-width: 150px;">
                                    Eliminar
                                </button>
                            </div>
                        </template>
                        <!--CONTENIDO IZQUIERDA-->
                        <div class="col-sm border-right border-primary">
                            <form action="insertargl" method="POST">
                            {{-- {!! Form::open(array('route'=>'#','id'=>'reggl','method'=>'post')) !!} --}}
                            {{csrf_field()}}
                            <div id="goleslocal">
                                <input type="hidden" id="tokent" value="'_token',csrf_token()"/>
                                {{-- {!! Form::hidden('_token',csrf_token()) !!} --}}
                                <div class="row justify-content-center">
                                    <div><h3>LOCAL</h3></div>
                                </div>
                            </div>
                            <input type="submit" name="insertar" value="Insertargg" id="registrargoles" class="btn btn-primary"/>
                            </form>
                            {{-- {!! Form::submit('Guardar todo',array('class'=>'btn btn-primary')) !!}
                            
                            {!! Form::close() !!} --}}

                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="agoleslocal">
                                    Agregar
                                </button>
                            </div>
                        </div>

                        <!--CONTENIDO DERECHA-->
                        <div class="col-sm border-left border-primary">
                            
                            <div id="golesvisitante">
                                <div class="row justify-content-center">
                                    <div>
                                        <h3>VISITANTE</h3></div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="agolesvisitante">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Boton para agregar todos los registros  --}}
                {{-- <div class="row justify-content-center">
                    <button class="btn btn-primary" id="registrargoles">
                        Registrar Goles
                    </button>
                </div> --}}
            </div>

            <!--Registro de titulares-->
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <center>
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h3>TITULARES</h3>
                        </button>
                    </center>
                </h2>
            </div>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <!--Plantilla para agregar titulares-->
                        <template id="plantillatitulares">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters ">
                                    <div class="col-md-4">
                                        <img src="..." class="card-img" alt="(Imagen del Jugador)">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Jugador Titular</h5>
                                            <div class="form-group">
                                                <label for="jugador">Jugador</label>
                                                <select class="form-control" id="jugadortit">
                                                  <option selected>- Selecciona el jugador -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" style="max-width: 150px;">
                                    Eliminar
                                </button>
                            </div>
                        </template>
                        <!--CONTENIDO IZQUIERDA-->
                        <div class="col-sm border-right border-primary">
                            <div id="titulareslocal">
                                <div class="row justify-content-center">
                                    <div><h3>LOCAL</h3></div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="atitulareslocal">
                                    Agregar
                                </button>
                            </div>
                        </div>

                        <!--CONTENIDO DERECHA-->
                        <div class="col-sm border-left border-primary">
                            <div id="titularesvisitante">
                                <div class="row justify-content-center">
                                    <div><h3>VISITANTE</h3></div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="atitularesvisitante">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button class="btn btn-primary" id="registrargoles">
                        Registrar Titulares
                    </button>
                </div>
            </div>

            <!--Registro Suplentes-->
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <center>
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <h3>SUPLENTES</h3>
                        </button>
                    </center>
                </h2>
            </div>

            <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <!--Plantilla para agregar suplentes-->
                        <template id="plantillasuplentes">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters ">
                                    <div class="col-md-4">
                                        <img src="..." class="card-img" alt="(Imagen del Jugador)">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title">Jugador Suplente</h5>
                                            <div class="form-group">
                                                    <label for="jugador">Jugador</label>
                                                    <select class="form-control" id="jugadorsup">
                                                    <option selected>- Selecciona el jugador -</option>
                                                    </select>
                                            </div>
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" style="max-width: 150px;">
                                    Eliminar
                                </button>
                            </div>
                        </template>
                        <!--CONTENIDO IZQUIERDA-->
                        <div class="col-sm border-right border-primary">
                            <div id="suplenteslocal">
                                <div class="row justify-content-center">
                                    <div><h3>LOCAL</h3></div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="asuplenteslocal">
                                    Agregar
                                </button>
                            </div>
                        </div>

                        <!--CONTENIDO DERECHA-->
                        <div class="col-sm border-left border-primary">
                            <div id="suplentesvisitante">
                                <div class="row justify-content-center">
                                    <div class="col-4"><h3>VISITANTE</h3></div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="asuplentesvisitante">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button class="btn btn-primary" id="registrargoles">
                        Registrar Suplentes
                    </button>
                </div>
            </div>

            <!--Registro tarjetas-->
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <center>
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseCuatro" aria-expanded="false" aria-controls="collapseCuatro">
                            <h3>TARJETAS</h3>
                        </button>
                    </center>
                </h2>
            </div>

            <div id="collapseCuatro" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="row">
                        <!--Plantilla para agregar tarjetas-->
                        <template id="plantillatarjetas">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters ">
                                    <div class="col-md-4">
                                        <img src="..." class="card-img" alt="(Imagen del Jugador)">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="card-title">Falta</h5>
                                        <form action="">
                                                <input type="hidden" id="idp" value="{{$partidoj->id_partido}}"/>
                                                <div class="form-group">
                                                        <label for="jugador">Jugador</label>
                                                        <select class="form-control" id="jfalta">
                                                        <option selected>- Selecciona el jugador -</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="minuto">Falta al minuto</label>
                                                    <input type="text" name="minuto[]" class="form-control" id="golminuto" placeholder="Registra el minuto">
                                                </div>
                                                <input type="hidden" id="idp" value="{{$partidoj->id_partido}}"/>
                                                <div class="form-group">
                                                        <label for="tipo">Tipo</label>
                                                        <select class="form-control" id="jfalta">
                                                        <option selected>- Selecciona la tarjeta -</option>
                                                        <option value="amarilla">Amarilla</option>
                                                        <option value="roja">Roja</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="minuto">Minuto</label>
                                                    <input type="text" class="form-control" id="faltaminuto" placeholder="Registra el minuto">
                                                </div>
                                        </form>
                                    </div>
                                </div>
                                <button class="btn btn-danger btn-sm" style="max-width: 150px;">
                                    Eliminar
                                </button>
                            </div>
                        </template>
                        <!--CONTENIDO IZQUIERDA-->
                        <div class="col-sm border-right border-primary">
                            <div id="tarjetaslocal">
                                <div class="row justify-content-center">
                                    <div><h3>LOCAL</h3></div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="atarjetaslocal">
                                    Agregar
                                </button>
                            </div>
                        </div>

                        <!--CONTENIDO DERECHA-->
                        <div class="col-sm border-left border-primary">
                            <div id="tarjetasvisitantes">
                                <div class="row justify-content-center">
                                    <div class="col-4"><h3>VISITANTE</h3></div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <button class="btn btn-primary" id="atarjetasvisit">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button class="btn btn-primary" id="registrartarjetas">
                        Registrar Tarjetas
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection