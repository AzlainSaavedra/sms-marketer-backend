@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Carros
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($carros, ['route' => ['carros.update', $carros->id], 'method' => 'patch']) !!}

                        @include('carros.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection