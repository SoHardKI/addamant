@extends('layouts.app')

@section('content')
    {!! Form::open(array('route' => ['tire-models.update', $tire_model->id],'method'=>'PATCH')) !!}
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4 class="float-left mr-3">{{ 'Редактировать производителя' }}</h4>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tire-models.index') }}"> {{ 'Назад' }}</a>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('name', 'Имя') !!}
                {!! Form::text('name', $tire_model->name, ['placeholder' => 'Имя','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12 text-left">
            {!! Form::button('Подвтердить', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
