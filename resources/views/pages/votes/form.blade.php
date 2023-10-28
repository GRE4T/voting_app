<div class="card-body">
    @csrf
    <div class="form-row">
        <div class="form-group col-12 col-md-6">
            <label for="voting_booth_id">Puesto de votación <span class="text-danger">(*)</span></label>
            <select name="voting_booth_id" id="voting_booth_id" class="form-control @error('voting_booth_id') is-invalid @enderror" required>
                <option value="" selected disabled>Seleccionar una opción </option>
                @foreach($votingBooths as $votingBooth)
                    <option value="{{ $votingBooth->id }}"
                            @if( old('voting_booth_id') && old('voting_booth_id') == $votingBooth->id) selected
                            @elseif($votingBooth->id == $record->voting_booth_id) selected @endif
                        data-info="{{ $votingBooth->number_tables }}"
                    >{{ $votingBooth->name }}</option>
                @endforeach
            </select>
            @error('voting_booth_id')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="number_table">Mesa <span class="text-danger">(*)</span></label>
            <select name="number_table" id="number_table" class="form-control @error('number_table') is-invalid @enderror" required>
                <option value="" selected disabled>Seleccionar una opción </option>
                @if(isset($record->id))
                    @for($i = 1; $i < $record->votingBooth->number_tables + 1; $i++)
                        <option value="{{ $i }}"
                                @if( old('number_table') && old('number_table') == $i) selected
                                @elseif($i == $record->number_table) selected @endif
                        >{{ 'Mesa '. $i  }}</option>
                    @endfor
                @endif
            </select>
            @error('number_table')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
        <div class="form-group col-12">
            <label class="" for="image"><i class="i-File-Text--Image text-16 mr-1"></i>Imagen</label>
            <div class="p-0 border">
                <div style="height: 230px;" class="d-flex justify-content-center my-2">
                    <img id="image" class="border img-fluid @if(!$record->image) w-20 @endif"  src="{{ asset($record->image) }}" alt="image" />
                </div>
                <label class="btn border btn-block mb-0 text-30 text-primary">
                    <input id="image" name="image" data-info="image" type="file"  onchange="readImage(event)" >
                </label>
            </div>
            @error('image')
            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>
    </div>

    @foreach($parties as $party)
            <div class="form-row">
                <div class="col-12 py-3">
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered mb-0 table-votes">
                            <tr>
                                <th rowspan="2" scope="col">
                                    <span class="mb-1 d-block">{{ $party->name  }}</span>
                                    <img src="{{ asset($party->image) }}" alt="" class="img-fluid party-image">
                                </th>
                                <th scope="row">Candidato</th>
                                @for($i = 1;  $i < ($party->number_candidates + 1); $i++)
                                    <th scope="col" class="vote-column"> {{ $i }}</th>
                                @endfor
                            </tr>
                            <tr>
                                <th scope="row">Votos</th>
                                @for($i = 1;  $i < ($party->number_candidates + 1); $i++)
                                    <td>
                                        @php
                                            $name = "votes[$party->id][$i]";
                                            $validate = "votes.$party->id.$i";
                                            $data = $record->votes_cast->isEmpty() || !isset($record->votes_cast[$party->id]) ? [] : $record->votes_cast[$party->id]->pluck('votes', 'number_candidate')->toArray();
                                        @endphp
                                        <input type="number" name="{{ $name }}" class="form-control" required placeholder="Ingresar cantidad de votos" min="0" step="1"
                                        @if(old($validate)) value="{{ old($validate) }}" @else value="{{ $data[$i] ?? 0 }}" @endif>
                                        @error($validate)
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
    @endforeach

</div>
@once
    @push('stack-script')
        <script type="text/javascript">
            'use strict';

            $(document).ready(() => {
                const votingBoothId = $('#voting_booth_id');
                const numberTable = $('#number_table');

                votingBoothId.on('change', function () {
                    let numberTables = $(this).find(':selected').data('info');
                    numberTable.empty();
                    numberTable.append(`<option value="" selected disabled>Seleccionar una opción </option>`);
                    for (let i = 1; i < numberTables + 1; i++) {
                        numberTable.append(`<option value="${i}">${'Mesa ' + i}</option>`);
                    }
                });
            });

            function readImage(event) {
                let input = event.target;
                let id = $(input).data("info");
                let element = $(`#${id}`);
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        element.attr("src", e.target.result);
                        element.removeClass("w-20");
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

        </script>

    @endpush
@endonce
