@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4 class="d-inline">{{ 'Управление производителями' }}</h4>
            </div>

            <div class="pull-right">
                <a class="btn btn-sm btn-success"
                   href="{{ route('manufacturers.create') }}"> {{ 'Создать производителя шины' }}</a>
                    <a class="btn btn-primary" href="{{ route('tires.index') }}"> {{ 'Шины' }}</a>
            </div>
        </div>
    </div>
    <h4>{{ 'Таблица производителей' }}</h4>
    <table class="table  table-bordered">
        <thead class="thead-light">
        <tr>
            <th class="text-nowrap">{{ 'Имя' }}</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach($manufacturers as $manufacturer)
            <tr>
                <td>{{ $manufacturer->name }}</td>
                <td class="text-right">
                    <a class="dropdown-item"
                       href="{{ route('manufacturers.edit',$manufacturer->id) }}">{{ 'Редактировать' }}</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['manufacturers.destroy', $manufacturer->id],'style'=>'display:inline']) !!}
                    {!! Form::button('Удалить', ['class' => 'dropdown-item', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
