@extends('layouts.base')

@push('prepend-scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
crossorigin>

@endpush

@section('content')

<div class="card">
    <div class="card-body">
        <a
        @if($flight->isInvolved(Auth::user()))
            @if(strpos(url()->previous(), 'dispatch') !== false)
                href="{{ route('dispatch.index') }}"
            @else
                href="{{ route('flights.user-flights') }}"
            @endif
        @else
            href="{{ route('flights.index') }}"
        @endif
        class="btn btn-secondary float-right">
            <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
        </a>

        <h5 class="card-title">Flight Information</h5>

        <div class="row">
            <div class="col-md-6">
                <dl class="row align-items-center card-text">
                    <dt class="col-lg-3 card-text">Departure</dt>
                    <dd class="col-lg-9 card-text">
                        @if($type == 'FlightRequest')
                            {{ is_array($flight->departure) ? implode('/', $flight->departure) : 'Not set' }}
                        @else
                            {{ $flight->departure }}
                        @endif
                    </dd>

                    <dt class="col-lg-3 card-text">Arrival</dt>
                    <dd class="col-lg-9 card-text">
                        @if($type == 'FlightRequest')
                            {{ is_array($flight->arrival) ? implode('/', $flight->arrival) : 'Not set' }}
                        @else
                            {{ $flight->arrival }}
                        @endif
                    </dd>

                    <dt class="col-lg-3 card-text">Aircraft</dt>
                    <dd class="col-lg-9 card-text">{{ $flight->aircraft->name }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                @if($type === 'FlightRequest')
                    <dl class="row align-items-center card-text">
                        <dt class="col-lg-3 card-text">Copilot</dt>
                        <dd class="col-lg-9 card-text">
                            @if($otherUser = $flight->otherUser())
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                    {{ $otherUser->username }}
                                </a>
                            @else
                                No one, yet!
                            @endif
                        </dd>

                        <dt class="col-lg-3 card-text">Flight Plan</dt>
                        <dd class="col-lg-9 card-text">
                            @if($flight->isPlanned())
                                <a href="{{ route('dispatch.show', $flight->plan_id) }}" class="btn btn-sm btn-info m-0">
                                    View<i class="fas fa-fw ml-1 fa-angle-double-right"></i>
                                </a>
                            @elseif($flight->isAccepted())
                                @if($flight->isDispatchable())
                                    <button
                                    type="button"
                                    class="btn btn-sm btn-success"
                                    data-toggle="modal"
                                    data-target="#dispatchModal">
                                        Create Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                    </button>
                                @else
                                    There must be one departure and one arrival airport before you can dispatch this
                                    flight!
                                @endif
                            @else
                                You need a copilot before you can dispatch this flight!
                            @endif
                        </dd>

                        <dt class="col-lg-3 card-text">Status</dt>
                        <dd class="col-lg-9 card-text">
                            @if($flight->planAccepted())
                                <form method="post" action="{{ route('flights.archive', ['flight' => $flight]) }}">
                                    @csrf

                                    <input type="hidden" name="flight" value="{{ $flight->id }}">
                                    <button
                                    type="button"
                                    class="btn btn-sm btn-warning card-text"
                                    data-toggle="modal"
                                    data-target="#completeModal">
                                        <i class="fas fa-check fa-fw mr-2"></i>Mark Complete
                                    </button>
                                </form>
                            @elseif($flight->isPlanned())
                                Plan under review
                            @else
                                Not planned
                            @endif
                        </dd>
                    </dl>
                @elseif($type == 'ArchivedFlight')
                    <dl class="row card-text">
                        <dt class="col-sm-3 card-text">Copilot</dt>
                        <dd class="col-sm-9 card-text">
                            <a href="#" class="text-decoration-none">
                                <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                {{ $flight->otherUser()->username }}
                            </a>
                        </dd>

                        <dt class="col-sm-3 card-text">Date Complete</dt>
                        <dd class="col-sm-9 card-text">
                            {{ \Carbon\Carbon::parse($flight->created_at)
                                ->format('H:i, D j M Y') }}
                        </dd>
                    </dl>
                @endif
            </div>

            @if($flight->isRequestee(Auth::user()))
                <p class="card-text mt-4">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editRequestModal">
                        <i class="fas fa-fw mr-2 fa-edit"></i>Edit
                    </button>
                </p>
            @endif

            @if(!$flight->public && !$flight->acceptee)
                <hr>
                <p class="card-text">
                    As your flight is private, you'll need to share it with someone
                    directly for them to join it. Just send them the link below!
                </p>
                <div class="form-group card-text">
                    <label>Join link</label>
                    <div class="input-group">
                        <input
                        type="text"
                        readonly
                        value="{{ route('flights.accept.private', ['code' => $flight->code]) }}"
                        class="form-control"
                        id="privateCode">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="copyLink()">
                                <i class="fas fa-paste"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-3" id="map" style="height: 360px;"></div>
    </div>
</div>

<div
class="modal fade"
id="dispatchModal"
tabindex="-1"
role="dialog"
aria-labelledby="dispatchModalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dispatchModalLabel">Dispatch Flight</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="lead text-center">Select how you want to dispatch this flight</p>
                <a
                href="{{ route('dispatch.upload', $flight->id) }}"
                class="btn btn-lg btn-block btn-primary"
                id="dispatchUploadButton">
                    <i class="fas fa-file-upload mr-2"></i>Upload PDF Plan
                </a>
                <a
                href="{{ route('dispatch.create', $flight->id) }}"
                class="btn btn-lg btn-block btn-primary"
                id="dispatchSimbriefButton">
                    <i class="fas fa-file-contract mr-2"></i>Create SimBrief Plan
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<div
class="modal fade"
id="editRequestModal"
tabindex="-1"
role="dialog"
aria-labelledby="editRequestModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('flights.update', ['flight' => $flight]) }}">
                @csrf
                @method('patch')

                <div class="modal-header">
                    <h5 class="modal-title" id="editRequestModalLabel">Edit Flight</h5>
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
                        value="{{ is_null(old('departure')) ? '' : old('departure') }}"
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
                        value="{{ is_null(old('arrival')) ? '' : old('arrival') }}"
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
                        multiple>
                            <option selected value="{{ $flight->aircraft->id }}">
                                {{  $flight->aircraft->icao . ' - ' . $flight->aircraft->name . ' (' . $flight->aircraft->sim . ')' }}
                            </option>
                        </select>

                        @if($errors->has('aircraft'))
                            <p class="help text-danger">
                                {{ $errors->first('aircraft') }}
                            </p>
                        @endif
                    </div>

                    @unless(empty($flight->expiry))
                        <div class="form-group">
                            <h5 class="mb-2"><label>Request expires in...</label></h5>
                            <input type="text" class="form-control" readonly
                            value="{{ \Carbon\Carbon::now()
                                    ->diffForHumans(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $flight->expiry), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}">
                        </div>
                    @endunless

                    <div class="form-group">
                        <h5 class="mb-2"><label>New expiry in...</label></h5>

                        <div class="input-group">
                            <input type="number" class="form-control" name="time_number">
                            <select class="custom-select" required name="time_units">
                                <option value="hours" selected>hours(s)</option>
                                <option value="days">day(s)</option>
                                <option value="weeks">week(s)</option>
                            </select>
                        </div>
                        <small class="form-text">
                            New expiry will be the above length of time from <strong>now</strong>.
                        </small>
                    </div>

                    <div class="form-group align-self-center">
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

@if($type === 'FlightRequest')
    @if($flight->planAccepted())
        <div
        class="modal fade"
        id="completeModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="completeModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="completeModalLabel">Complete Flight</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to complete this flight?
                    </div>

                    <div class="modal-footer">
                        <form method="post" action="{{ route('flights.archive', ['flight' => $flight]) }}">
                            @csrf

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-check mr-2"></i>Complete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

@endsection

@push('append-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.5/js/ajax-bootstrap-select.min.js">
</script>

<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
crossorigin></script>

<script type="text/javascript">
    /*
     * AIRPORT SELECT PICKERS
     */
    // initialise airport selectpickers with ajax live search
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

    // disable select pickers by default
    $('.selectpicker').prop('disabled', true);

    // get airport objects
    var departureAirports = {!! json_encode($departureAirports) !!};
    var arrivalAirports = {!! json_encode($arrivalAirports) !!};
    var departureIcaos = [];
    var arrivalIcaos = [];

    /**
     * Hack to stop select picker breaking until search initiated
     *
     * @see https://github.com/truckingsim/Ajax-Bootstrap-Select/issues/177
     */
    $.fn.ajaxSelectPickerRefresh = function(){
        return this.each(function () {
            if(!$(this).data('AjaxBootstrapSelect')) return;
            var picker = $(this).data('AjaxBootstrapSelect');
            var selected = [];
            var selectValues = picker.$element.find('option:selected');
            for(var i=0;i<selectValues.length;i++){
                selected.push({
                    value: selectValues[i].value,
                    text: selectValues[i].text,
                    class: "",
                    data: {},
                    preserved: true,
                    selected: true
                });
            }
            picker.list.selected = selected;
            picker.list.replaceOptions(selected);
        });
    }

    // add preselected options to each selectpicker
    $.each(departureAirports, function (i, item) {
        $('#departure').append($('<option>', {
            value: item.icao,
            text : item.icao + ' - ' + item.name
        }));
        departureIcaos.push(item.icao);
    });
    $('#departure').selectpicker('val', departureIcaos).ajaxSelectPickerRefresh();

    $.each(arrivalAirports, function (i, item) {
        $('#arrival').append($('<option>', {
            value: item.icao,
            text : item.icao + ' - ' + item.name
        }));
        arrivalIcaos.push(item.icao);
    });
    $('#arrival').selectpicker('val', arrivalIcaos).ajaxSelectPickerRefresh();

    // enable/check appropriate selectpickers and radios
    if (departureAirports.length > 0) {
        $('#departure').prop('disabled', false);
        $('#departureRadio1').prop('checked', false);
        $('#departureRadio2').prop('checked', true);
    }
    if (arrivalAirports.length >0 ) {
        $('#arrival').prop('disabled', false);
        $('#arrivalRadio1').prop('checked', false);
        $('#arrivalRadio2').prop('checked', true);
    }
    $('.selectpicker').selectpicker('refresh');

    /*
     * Event listeners for setting select picker disabled state based on radios
     */
    $('input[name="departureRadio"]').click(function() {
        if ($('#departureRadio2').is(":checked")) {
            $('#departure').prop('disabled', false);
        } else {
            $('#departure').prop('disabled',true);
        }
        $('.selectpicker').selectpicker('refresh');
    });
    $('input[name="arrivalRadio"]').click(function() {
        if ($('#arrivalRadio2').is(":checked")) {
            $('#arrival').prop('disabled', false);
        } else {
            $('#arrival').prop('disabled',true);
        }
        $('.selectpicker').selectpicker('refresh');
    });

    /*
     * AIRCRAFT SELECT PICKER
     */
    // initialise aircraft select picker with ajax live search
    $('.aircraftpicker').selectpicker({
        liveSearch: true
    }).ajaxSelectPicker({
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
            if (data.length > 0) {
                if (data.length >= 10) {
                    count = 10;
                } else {
                    count = data.length;
                }
                for (var i = 0; i < count; i++) {
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

    /**
     * Copies join link to clipboard
     *
     * @return void
     */
    function copyLink() {
        const link = document.getElementById('privateCode');
        link.select();
        document.execCommand('copy');
    }

    /*
     * MAPPING STUFF
     */

    /**
     * Adds markers to map with popup, and returns an array of marker objects
     *
     * @param array airportsArray Array of objects with latitude, longitude, name and icao properties
     * @return array Array of marker objects
     */
    function addMarkers(airportsArray) {
        var markerArray = [];

        for (var i = 0; i < airportsArray.length ; i++) {
            var airport = airportsArray[i];

            var marker = L.marker([airport.latitude, airport.longitude]).addTo(mymap);
            marker.bindPopup(airport.name+" ("+airport.icao+")");

            markerArray.push(marker);
        }

        return markerArray;
    }

    // concatenate dep and arr airports into single array for adding markers
    var allPoints = departureAirports.concat(arrivalAirports);

    // initialise map
    var mymap = L.map('map', {
        zoomControl: false
    });

    // add map tiles
    L.tileLayer('https://api.mapbox.com/styles/v1/{style}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: '&copy; <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        style: 'mapbox/dark-v10',
        accessToken: "{{ config('services.mapbox.token') }}"
    }).addTo(mymap);

    // add markers
    var markers = addMarkers(allPoints);

    // fit markers within map
    if (markers.length > 1) {
        mymap.fitBounds(new L.featureGroup(markers).getBounds(), {padding: [50, 50]});
    } else {
        mymap.setView(markers[0].getLatLng(), 4);
    }
</script>

@endpush

@section('help-title', 'Help | Flight Request')

@section('help-content')

<h5>Flight Details</h5>

<p>
    This page shows you the details of your flight, including the departure and
    arrival airport(s), if set, the aircraft and your copilot.
</p>
<p>
    You can also see the status of your flight and, if applicable, dispatch the
    flight or view the flight plan.
</p>

<h5>Dispatch</h5>

<p>
    To dispatch your flight, you need to have <strong>one</strong> departure and
    <strong>one</strong> arrival airport. If you have 'No preference', or more
    than one option, set for either your departure or arrival airport, you and
    your copilot should first decide on a finalised departure and arrival
    airport, and then you can dispatch your flight.
</p>

@endsection
