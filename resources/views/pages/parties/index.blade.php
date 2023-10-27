@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <ul class="d-flex align-items-center">
            <li class="text-center">
                <img src="{{asset('assets/images/icons/voting_booths.png')}}" alt="" class="w-75">
            </li>
            <li class="h3 bold">Modulo de partidos</li>
        </ul>
    </div>
    <div class="row mb-2">
        <div class="col text-right">
            <a class="btn btn-success" href="{{ route('parties.create')}}">Añadir nuevo</a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white h5">
            Partidos
        </div>
        <div class="card-body">
            <div class="table-responsive-md">
                <table id="table_parties" class="table table-borderless table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad de candidatos</th>
                        <th scope="col">Fecha de creación</th>
                        <th scope="col">Fecha de actualización</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            </p>
        </div>
    </div>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('page-js')
    <script defer src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script defer src="{{asset('assets/js/vendor/datatables.responsive.min.js')}}"></script>
@endsection

@section('bottom-js')
    <script type="text/javascript">
        'use strict'

        var table;

        $(document).ready(() => {
            table = $('#table_parties').DataTable({
                dom: 'Bfrtlip',
                buttons: [],
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json'
                },
                ajax: "{{ url('api/parties') }}",
                columns: [{
                    data: 'id',
                    render(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'number_candidates',
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'user.name'
                    },
                    {
                        data: 'id',
                        render(data) {
                            return `
                    <a href="{{ url('parties') }}/${data}/edit" class="text-success mr-2">
                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                    </a>
                    <a href="javascript:void(0)" class="text-danger mr-2" onclick="deleteElement(${data})">
                        <i class="nav-icon i-Close font-weight-bold"></i>
                    </a>
                    `;
                        }
                    }
                ]
            });
        });

        function deleteElement(id) {
            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrarlo!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete("{{ url('api/parties') }}/" + id, null)
                        .then((res) => {
                            Swal.fire(
                                '¡Eliminado!',
                                'Registro borrado exitosamente ',
                                'success'
                            );
                            table.ajax.reload();
                        })
                        .catch((error) => {
                            if (error) {
                                Swal.fire(
                                    'Cancelado',
                                    'Este registro no puede ser eliminado :(',
                                    'error'
                                )
                            }
                        })
                }
            })
        }
    </script>
@endsection

