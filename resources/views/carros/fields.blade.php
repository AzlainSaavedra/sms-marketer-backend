<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id', null, ['class' => 'form-control']) !!}
</div>

<!-- Marca Field -->
<div class="form-group col-sm-6">
    {!! Form::label('marca', 'Marca:') !!}
    {!! Form::text('marca', null, ['class' => 'form-control']) !!}
</div>

<!-- Modelo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('modelo', 'Modelo:') !!}
    {!! Form::text('modelo', null, ['class' => 'form-control']) !!}
</div>

<!-- Placa Field -->
<div class="form-group col-sm-6">
    {!! Form::label('placa', 'Placa:') !!}
    {!! Form::text('placa', null, ['class' => 'form-control']) !!}
</div>

<!-- Anio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('anio', 'Anio:') !!}
    {!! Form::number('anio', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('carros.index') !!}" class="btn btn-default">Cancel</a>
</div>
