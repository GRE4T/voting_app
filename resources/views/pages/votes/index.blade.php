@extends('layouts.master')

@section('main-content')
    <div class="breadcrumb">
        <ul class="d-flex align-items-center">
            <li class="text-center">
                <img src="{{asset('assets/images/icons/votes.png')}}" alt="" class="w-75">
            </li>
            <li class="h3 bold">Modulo de votación</li>
        </ul>
    </div>
    <div class="row mb-2">
        <div class="col text-right">
            <a class="btn btn-success" href="{{ route('records.create')}}">Añadir nuevo</a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white h5">
            Votaciones
        </div>
        <div class="card-body">
            <div class="row justify-content-end">
                <div class="col-12">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body p-1 text-center justify-content-center align-items-center">
                            <i class="i-Financial mr-2 text-primary"></i>
                            <p class="lead text-primary text-24 mb-2"><strong class="font-weight-bold">Total de votos: </strong> <span id="total_value"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                @include('pages.votes.filters', [
                    'votingBooths' => $votingBooths,
                    'callback' => 'callbackFilter'
                ])
            </div>
            <div class="table-responsive-md">
                <table id="table_records" class="table table-borderless table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Puesto de votación</th>
                        <th scope="col">Mesa</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Votación</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.buttons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/select2.min.css')}}" />
@endsection

@section('page-js')
    <script defer src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script defer src="{{asset('assets/js/vendor/datatables.responsive.min.js')}}"></script>
    <script defer src="{{asset('assets/js/vendor/select2.min.js')}}"></script>
@endsection

@section('bottom-js')
    <script type="text/javascript">
        'use strict'

        var table;
        var filters = [];

        $(document).ready(() => {
            table = $('#table_records').DataTable({
                dom: 'Bfrtlip',
                buttons: [],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json'
                },
                ajax: (data, callback, settings) => {
                    $.get('{{ url('api/records') }}', {
                        ...data,
                        filters: filters
                    }, function (response) {
                        $('#total_value').text(response.data.total);
                        callback(response.data.grid.original);
                    });
                },
                columns: [{
                    data: 'id',
                    render(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                    {
                        data: 'voting_booth.name'
                    },
                    {
                        data: 'number_table'
                    },
                    {
                        data: 'image',
                        render(data, type, row, meta) {

                            return data ? `<a href="{{asset('')}}/${data}" download="${row.voting_booth.name}- Mesa ${row.number_table}">Descargar <i class="nav-icon i-Download1 font-weight-bold"></i></a>`: '';
                        }
                    },
                    {
                        data: 'votes_cast',
                        render(data) {
                            let tables = ``;

                            Object.values(data).forEach(values => {
                                let data = Object.values(values);
                                if(data.length > 0){
                                    let party = data[0].party;
                                    let header = `<th>Candidato</th>`;
                                    let body = `<td>Votos</td>`;
                                    data.forEach(value => {
                                        header += `<th>${value.number_candidate}</th>`;
                                        body += `<td>${value.votes}</td>`;
                                    });
                                    tables += `<div class="table-responsive table-scroll">
                                                       <table class="table table-bordered">
                                                            <thead><tr><th colspan="${party.number_candidates + 1}">
                                                                <img src="{{asset('')}}/${party.image}" alt="" class="party-image image-small"> Partido: ${party.name} </th></tr><tr> ${header} </tr> </thead>
                                                            <tbody> <tr> ${body} </tr> </tbody>
                                                       </table>
                                                </div>`;
                                }
                            });
                            return tables;
                        }
                    },
                    {
                        data: 'user.name'
                    },
                    {
                        data: 'id',
                        render(data) {
                            return `
                    <a href="{{ url('records') }}/${data}/report" class="text-success mr-2">
                        <i class="nav-icon i-Eye-Visible font-weight-bold"></i>
                    </a>
                    <a href="{{ url('records') }}/${data}/edit" class="text-success mr-2">
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
                    axios.delete("{{ url('api/records') }}/" + id, null)
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

        function callbackFilter(params = null) {
            filters  = params;
            return table.ajax.reload();
        }

    </script>

    @stack('stack-script')
@endsection
