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
                <dl class="row card-text">
                    <dt class="col-lg-3 card-text">Departure</dt>
                    <dd class="col-lg-9 card-text">
                        {{ is_array($flight->departure) ? implode('/', $flight->departure) : 'Not set' }}
                    </dd>

                    <dt class="col-lg-3 card-text">Arrival</dt>
                    <dd class="col-lg-9 card-text">
                        {{ is_array($flight->arrival) ? implode('/', $flight->arrival) : 'Not set' }}
                    </dd>

                    <dt class="col-lg-3 card-text">Aircraft</dt>
                    <dd class="col-lg-9 card-text">{{ $flight->aircraft }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                @if($type === 'FlightRequest')
                    <dl class="row card-text">
                        <dt class="col-lg-3 align-middle card-text">Copilot</dt>
                        <dd class="col-lg-9 align-middle card-text">
                            @if($otherUser = $flight->otherUser())
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                    {{ $otherUser->username }}
                                </a>
                            @else
                                No one, yet!
                            @endif
                        </dd>

                        <dt class="col-lg-3 align-middle card-text">Flight Plan</dt>
                        <dd class="col-lg-9 align-middle card-text">
                            @if($flight->isPlanned())
                                <a href="{{ route('dispatch.show', $flight->plan_id) }}" class="btn btn-sm btn-info m-0">
                                    View<i class="fas fa-fw ml-1 fa-angle-double-right"></i>
                                </a>
                            @elseif($flight->isAccepted())
                                <button
                                type="button"
                                class="btn btn-sm btn-success"
                                data-toggle="modal"
                                data-target="#dispatchModal">
                                    Create Plan<i class="fas fa-fw ml-2 fa-angle-double-right"></i>
                                </button>
                            @else
                                You need a copilot before you can dispatch this flight!
                            @endif
                        </dd>

                        <dt class="col-lg-3 align-middle card-text">Status</dt>
                        <dd class="col-lg-9 align-middle card-text">
                            @if($flight->planAccepted())
                                <form method="post" action="{{ route('flights.archive', ['flight' => $flight]) }}">
                                    @csrf

                                    <input type="hidden" name="flight" value="{{ $flight->id }}">
                                    <button type="submit" class="btn btn-sm btn-success">
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
            <form method="post" action="{{ route('flights.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="editRequestModalLabel">Create Request</h5>
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
                        <input
                        type="text"
                        name="aircraft"
                        id="aircraft"
                        class="form-control {{ $errors->has('aircraft') ? 'border-danger' : '' }}"
                        value="{{ is_null(old('aircraft')) ? '' : old('aircraft') }}"
                        required>
                        @if($errors->has('aircraft'))
                            <p class="help text-danger">
                                {{ $errors->first('aircraft') }}
                            </p>
                        @endif
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

@endsection

@push('append-scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/ajax-bootstrap-select/1.4.5/js/ajax-bootstrap-select.min.js">
</script>

<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
crossorigin></script>

<script type="text/javascript">
    // get data for selectpickers (airports)
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
    $('.selectpicker').selectpicker('refresh');

    // event listener to dis/en/able input based on radio
    $('input[name="departureRadio"]').click(function() {
        if ($('#departureRadio2').is(":checked")) {
            $('#departure').prop('disabled', false);
            $('.selectpicker').selectpicker('refresh');
        } else {
            $('#departure').prop('disabled',true);
            $('.selectpicker').selectpicker('refresh');
        }
    });

    // event listener to dis/en/able input based on radio
    $('input[name="arrivalRadio"]').click(function() {
        if ($('#arrivalRadio2').is(":checked")) {
            $('#arrival').prop('disabled', false);
            $('.selectpicker').selectpicker('refresh');
        } else {
            $('#arrival').prop('disabled',true);
            $('.selectpicker').selectpicker('refresh');
        }
    });

    // script to copy join code to clipboard
    function copyLink() {
        const link = document.getElementById('privateCode');
        link.select();
        document.execCommand('copy');
    }

    /**
    * Calculate the center/average of multiple GeoLocation coordinates
    * Expects an array of objects with .latitude and .longitude properties
    *
    * @url http://stackoverflow.com/a/14231286/538646
    */
    function averageGeolocation(coords) {
        if (coords.length === 1) {
            return coords[0];
        }

        let x = 0.0;
        let y = 0.0;
        let z = 0.0;

        for (let coord of coords) {
            let latitude = coord.latitude * Math.PI / 180;
            let longitude = coord.longitude * Math.PI / 180;

            x += Math.cos(latitude) * Math.cos(longitude);
            y += Math.cos(latitude) * Math.sin(longitude);
            z += Math.sin(latitude);
        }

        let total = coords.length;

        x = x / total;
        y = y / total;
        z = z / total;

        let centralLongitude = Math.atan2(y, x);
        let centralSquareRoot = Math.sqrt(x * x + y * y);
        let centralLatitude = Math.atan2(z, centralSquareRoot);

        return {
            latitude: centralLatitude * 180 / Math.PI,
            longitude: centralLongitude * 180 / Math.PI
        };
    }

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

    // get airport objects
    var departureAirports = {!! $departureAirports !!};
    var arrivalAirports = {!! $arrivalAirports !!};
    var allPoints = departureAirports.concat(arrivalAirports);

    // initialise map
    var mymap = L.map('map', {
        zoomControl: false
    });

    // add map tiles
    L.tileLayer('https://api.mapbox.com/styles/v1/{style}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: '&copy; <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        style: 'mapbox/dark-v10',
        accessToken: "{{ env('MAPBOX_TOKEN') }}"
    }).addTo(mymap);

    // add markers
    var markers = addMarkers(allPoints);

    // fit markers within map
    mymap.fitBounds(new L.featureGroup(markers).getBounds());
</script>

@endpush
