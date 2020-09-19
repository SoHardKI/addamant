@extends('layouts.app')

@section('content')
    {!! Form::open(array('route' => ['tires.update', $tire->id],'method'=>'PATCh')) !!}
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4 class="float-left mr-3">{{ 'Редактировать шину' }}</h4>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('tires.index') }}"> {{ 'Назад' }}</a>
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
                {!! Form::label('width', 'Ширина') !!}
                {!! Form::text('width', $tire->width, ['placeholder' => 'Ширина','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('profile', 'Профиль') !!}
                {!! Form::text('profile', $tire->profile, ['placeholder' => 'Профиль','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('diameter', 'Диаметр') !!}
                {!! Form::text('diameter', $tire->diameter, ['placeholder' => 'Диаметр','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('load_index', 'Индекс нагрузки') !!}
                {!! Form::text('load_index', $tire->load_index, ['placeholder' => 'Индекс нагрузки','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('speed_index', 'Индекс скорости') !!}
                {!! Form::text('speed_index', $tire->speed_index, ['placeholder' => 'Индекс скорости','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        {{ Form::hidden('manual_distribution', 0) }}
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                {!! Form::label('manufacturer_id', 'Производитель') !!}
                {!! Form::select('manufacturer_id', \App\Manufacturer::pluck('name', 'id'), $tire->manufacturer()->pluck('id'), ['class' => 'form-control selectpicker']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                {!! Form::label('tire_model_id', 'Модель') !!}
                {!! Form::select('tire_model_id', \App\TireModel::pluck('name', 'id'), $tire->tireModel()->pluck('id'), ['class' => 'form-control selectpicker']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('count', 'Количество') !!}
                {!! Form::text('count', $tire->count, ['placeholder' => 'Количество','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {!! Form::label('price', 'Цена') !!}
                {!! Form::text('price', $tire->price, ['placeholder' => 'Цена','class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="col-12 text-left">
            {!! Form::button('Подвтердить', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
