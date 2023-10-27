<div>
    <form id="filters">
        <div class="form-row">
            <div class="form-group col-12 col-md-6">
                <label for="voting_booth_id">Puesto de votación</label>
                <select name="voting_booth_id" id="voting_booth_id" class="form-control">
                    <option value="" selected>Seleccionar una opción </option>
                    @foreach($votingBooths as $votingBooth)
                        <option
                            value="{{ $votingBooth->id }}"
                            data-info="{{ $votingBooth->number_tables }}"
                        > {{ $votingBooth->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="number_table">Mesa <span class="text-danger">(*)</span></label>
                <select name="number_table" id="number_table" class="form-control" multiple="multiple" >
                </select>
            </div>
        </div>

        <div class="form-row d-flex justify-content-end">
            <div class="form-group col-12 col-md-2">
                <button id='apply_filter' type="submit" class="btn btn-primary btn-block">Aplicar filtro</button>
            </div>
        </div>
    </form>
</div>

@once
    @push('stack-script')

        <script type="text/javascript" defer>
            'use strict';

            $(document).ready(function () {

                $("#number_table").select2({
                    placeholder: "Seleccionar una opción"
                });

                const votingBoothId = $('#voting_booth_id');
                const numberTable = $('#number_table');

                votingBoothId.on('change', function () {
                    let numberTables = $(this).find(':selected').data('info');
                    numberTable.empty();
                    for (let i = 1; i < numberTables + 1; i++) {
                        numberTable.append(`<option value="${i}">${'Mesa ' + i}</option>`);
                    }
                });

                const callback = eval(' {{ $callback }}');
                $('#filters').on('submit', function (event) {
                    event.preventDefault();
                    console.log(votingBoothId.val())
                    let params =  {
                        voting_booth_id: votingBoothId.val() !== '' ? votingBoothId.val() : undefined,
                        number_table: numberTable.val()
                    };

                    callback(params);
                });

            });
        </script>
    @endpush
@endonce



