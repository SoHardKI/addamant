@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4 class="d-inline">{{ 'Управление моделями' }}</h4>
            </div>

            <div class="pull-right">
                <a class="btn btn-sm btn-success"
                   href="{{ route('tire-models.create') }}"> {{ 'Создать модель шины' }}</a>
                    <a class="btn btn-primary" href="{{ route('tires.index') }}"> {{ 'Шины' }}</a>
            </div>
        </div>
    </div>
    <h4>{{ 'Таблица моделей шин' }}</h4>
    <table class="table  table-bordered">
        <thead class="thead-light">
        <tr>
            <th class="text-nowrap">{{ 'Имя' }}</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach($tire_models as $tire_model)
            <tr>
                <td>{{ $tire_model->name }}</td>
                <td class="text-right">
                    <a class="dropdown-item"
                       href="{{ route('tire-models.edit',$tire_model->id) }}">{{ 'Редактировать' }}</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['tire-models.destroy', $tire_model->id],'style'=>'display:inline']) !!}
                    {!! Form::button('Удалить', ['class' => 'dropdown-item', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
