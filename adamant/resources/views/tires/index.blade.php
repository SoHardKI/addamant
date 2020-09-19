@extends('layouts.app')

@section('content')
    <script>
        $(document).on('click', ".updateBetSizeBtn", function (e) {
            e.preventDefault();
            let id = $(this).parents('tr').attr('data-id');
            $("#updateBetSizeForm").modal("show");
        });
    </script>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4 class="d-inline">{{ 'Управление шинами' }}</h4>
            </div>

            <div class="pull-right">
                <a class="btn btn-sm btn-success" href="{{ route('tires.create') }}"> {{ 'Создать модель шины' }}</a>

                <button class="updateBetSizeBtn btn btn-sm btn-success">Загрузить из файла</button>

                <div class="modal fade" id="updateBetSizeForm" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Загрузить файл</h4>
                                <div type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </div>
                            </div>
                            <div class="modal-body mx-3">
                                <form id="file_form" method="post" action="{{ route('tires.upload.from.file') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" name="file" id="file">
                                        </div>
                                        <div class="col-md-3" style="margin-left: 100px">
                                            <input type="submit" name="upload" value="Upload" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0"
                                         aria-valuemax="100" style="width: 0%">
                                        0%
                                    </div>
                                </div>
                                <br>
                                <div id="success">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a class="btn btn-sm btn-primary"
                   href="{{ route('manufacturers.index') }}"> {{ 'Производители' }}</a>
                <a class="btn btn-sm btn-primary"
                   href="{{ route('tire-models.index') }}"> {{ 'Модели шин' }}</a>
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
    <h4>{{ 'Таблица корректных шин' }}</h4>
    <table class="table table-light table--responsive table-sm table-bordered table-striped small-1 order-table">
        <thead class="thead-light">
        <tr>
            <th class="text-nowrap">{{ 'Наименование' }}</th>
            <th class="text-nowrap">{{ 'Ширина' }}</th>
            <th class="text-nowrap">{{ 'Профиль' }}</th>
            <th class="text-nowrap">{{ 'Диаметр' }}</th>
            <th class="text-nowrap">{{ 'Индекс нагрузки' }}</th>
            <th class="text-nowrap">{{ 'Индекс скорости' }}</th>
            <th class="text-nowrap">{{ 'Производитель' }}</th>
            <th class="text-nowrap">{{ 'Модель' }}</th>
            <th class="text-nowrap">{{ 'Количество' }}</th>
            <th class="text-nowrap">{{ 'Цена' }}</th>
            <th class="text-nowrap">{{ 'Дата создания' }}</th>
            <th class="text-nowrap">{{ 'Дата изменения' }}</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach($tires as $tire)
            <tr>
                <td>{{ $tire->name }}</td>
                <td>{{ $tire->width }}</td>
                <td>{{ $tire->profile }}</td>
                <td>{{ $tire->diameter }}</td>
                <td>{{ $tire->load_index }}</td>
                <td>{{ $tire->speed_index }}</td>
                <td>{{ $tire->manufacturer->name }}</td>
                <td>{{ $tire->tireModel->name }}</td>
                <td>{{ $tire->count }}</td>
                <td>{{ $tire->price }}</td>
                <td>{{ $tire->created_at }}</td>
                <td>{{ $tire->updated_at }}</td>
                <td class="text-right">
                    <a class="dropdown-item"
                       href="{{ route('tires.edit', $tire->id) }}">{{ 'Редактировать' }}</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['tires.destroy', $tire->id],'style'=>'display:inline']) !!}
                    {!! Form::button('Удалить', ['class' => 'dropdown-item', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h4>{{ 'Таблица шин ручной обработки' }}</h4>
    <table class="table table-light table--responsive table-sm table-bordered table-striped small-1 order-table">
        <thead class="thead-light">
        <tr>
            <th class="text-nowrap">{{ 'Наименование' }}</th>
            <th class="text-nowrap">{{ 'Ширина' }}</th>
            <th class="text-nowrap">{{ 'Профиль' }}</th>
            <th class="text-nowrap">{{ 'Диаметр' }}</th>
            <th class="text-nowrap">{{ 'Индекс нагрузки' }}</th>
            <th class="text-nowrap">{{ 'Индекс скорости' }}</th>
            <th class="text-nowrap">{{ 'Производитель' }}</th>
            <th class="text-nowrap">{{ 'Модель' }}</th>
            <th class="text-nowrap">{{ 'Количество' }}</th>
            <th class="text-nowrap">{{ 'Цена' }}</th>
            <th class="text-nowrap">{{ 'Дата создания' }}</th>
            <th class="text-nowrap">{{ 'Дата изменения' }}</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach($manualDistributionTires as $tire)
            <tr>
                <td>{{ $tire->name }}</td>
                <td>{{ $tire->width }}</td>
                <td>{{ $tire->profile }}</td>
                <td>{{ $tire->diameter }}</td>
                <td>{{ $tire->load_index }}</td>
                <td>{{ $tire->speed_index }}</td>
                <td>{{ $tire->manufacturer ? $tire->manufacturer->name : '' }}</td>
                <td>{{ $tire->tireModel ? $tire->tireModel->name : '' }}</td>
                <td>{{ $tire->count }}</td>
                <td>{{ $tire->price }}</td>
                <td>{{ $tire->created_at }}</td>
                <td>{{ $tire->updated_at }}</td>
                <td class="text-right">
                    <a class="dropdown-item"
                       href="{{ route('tires.edit',$tire->id) }}">{{ 'Редактировать' }}</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['tires.destroy', $tire->id],'style'=>'display:inline']) !!}
                    {!! Form::button('Удалить', ['class' => 'dropdown-item', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
