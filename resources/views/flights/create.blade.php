<div
class="modal fade"
id="createRequestModal"
tabindex="-1"
role="dialog"
aria-labelledby="createRequestModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('flights.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createRequestModalLabel">Create Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <h5 class="mb-2"><label>Departure</label></h5>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input
                            type="radio"
                            id="departureRadio1"
                            name="departureRadio"
                            class="custom-control-input"
                            value="NONE"
                            checked>
                            <label class="custom-control-label" for="departureRadio1">No preference</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input
                            type="radio"
                            id="departureRadio2"
                            name="departureRadio"
                            class="custom-control-input"
                            value="select">
                            <label class="custom-control-label" for="departureRadio2">The following airport(s):</label>
                        </div>

                        <select
                        name="departure[]"
                        id="departure"
                        class="selectpicker mt-1 mb-3 form-control {{ $errors->has('departure') ? 'border-danger' : '' }}"
                        data-live-search="true"
                        multiple></select>

                        @if($errors->has('departure'))
                            <p class="help text-danger">
                                {{ $errors->first('departure') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2"><label>Arrival</label></h5>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input
                            type="radio"
                            id="arrivalRadio1"
                            name="arrivalRadio"
                            class="custom-control-input"
                            value="NONE"
                            checked>
                            <label class="custom-control-label" for="arrivalRadio1">No preference</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input
                            type="radio"
                            id="arrivalRadio2"
                            name="arrivalRadio"
                            class="custom-control-input"
                            value="select">
                            <label class="custom-control-label" for="arrivalRadio2">The following airport(s):</label>
                        </div>

                        <select
                        name="arrival[]"
                        id="arrival"
                        class="selectpicker mt-1 mb-3 form-control {{ $errors->has('arrival') ? 'border-danger' : '' }}"
                        data-live-search="true"
                        multiple></select>

                        @if($errors->has('arrival'))
                            <p class="help text-danger">
                                {{ $errors->first('arrival') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2"><label>Aircraft</label></h5>

                        <select
                        name="aircraft"
                        id="aircraft"
                        class="aircraftpicker mt-1 mb-3 form-control {{ $errors->has('aircraft') ? 'border-danger' : '' }}"
                        data-live-search="true"
                        multiple></select>

                        @if($errors->has('aircraft'))
                            <p class="help text-danger">
                                {{ $errors->first('aircraft') }}
                            </p>
                        @endif
                    </div>

                    <div class="form-group">
                        <h5 class="mb-2"><label>Request expires in...</label></h5>

                        <div class="input-group">
                            <input type="number" class="form-control" name="time_number">
                            <select class="custom-select" required name="time_units">
                                <option value="hours" selected>hours(s)</option>
                                <option value="days">day(s)</option>
                                <option value="weeks">week(s)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="public" name="public" checked>
                            <label class="custom-control-label" for="public">Public flight</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        Submit <i class="fas fa-angle-double-right fa-fw ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('append-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.5/js/ajax-bootstrap-select.min.js"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: '{{ route('search.airport') }}',
            method: 'GET',
            data: {
                q: '@{{{q}}}'
            }
        },
        locale: {
            emptyTitle: 'Start typing to search...',
            statusInitialized: '',
        },
        preprocessData: function(data){
            var airports = [];
            let count;
            if(data.length > 0){
                if(data.length >= 10) {
                    count = 10;
                } else {
                    count = data.length;
                }
                for(var i = 0; i < count; i++){
                    var curr = data[i];
                    airports.push(
                        {
                            'value': curr.icao,
                            'text': curr.icao + ' - ' + curr.name,
                            'disabled': false
                        }
                    );
                }
            }
            return airports;
        },
        preserveSelected: true
    });
    $('.selectpicker').prop('disabled', true);
    $('.selectpicker').selectpicker('refresh');

    $('.aircraftpicker').selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: '{{ route('search.approved_aircraft') }}',
            method: 'GET',
            data: {
                q: '@{{{q}}}'
            }
        },
        locale: {
            emptyTitle: 'Start typing to search...',
            statusInitialized: '',
        },
        preprocessData: function(data){
            var aircraft = [];
            let count;
            if(data.length > 0){
                if(data.length >= 10) {
                    count = 10;
                } else {
                    count = data.length;
                }
                for(var i = 0; i < count; i++){
                    var curr = data[i];
                    aircraft.push(
                        {
                            'value': curr.id,
                            'text': curr.icao + ' - ' + curr.name + ' (' + curr.sim + ')',
                            'disabled': false
                        }
                    );
                }
            }
            return aircraft;
        },
        preserveSelected: true
    });

    $('input[name="departureRadio"]').click(function() {
        if ($('#departureRadio2').is(":checked")) {
            $('#departure').prop('disabled', false);
            $('.selectpicker').selectpicker('refresh');
        } else {
            $('#departure').prop('disabled',true);
            $('.selectpicker').selectpicker('refresh');
        }
    });

    $('input[name="arrivalRadio"]').click(function() {
        if ($('#arrivalRadio2').is(":checked")) {
            $('#arrival').prop('disabled', false);
            $('.selectpicker').selectpicker('refresh');
        } else {
            $('#arrival').prop('disabled',true);
            $('.selectpicker').selectpicker('refresh');
        }
    });
</script>

@endpush
