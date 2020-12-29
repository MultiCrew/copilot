@extends('layouts.base')

@push('prepend-scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
crossorigin=""/>

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
                    <dt class="col-lg-5 card-text">Departure</dt>
                    <dd class="col-lg-7 card-text">
                        @if($type == 'FlightRequest')
                            {{ is_array($flight->departure) ? implode('/', $flight->departure) : 'Not set' }}
                        @else
                            {{ $flight->departure }}
                        @endif
                    </dd>

                    <dt class="col-lg-5 card-text">Arrival</dt>
                    <dd class="col-lg-7 card-text">
                        @if($type == 'FlightRequest')
                            {{ is_array($flight->arrival) ? implode('/', $flight->arrival) : 'Not set' }}
                        @else
                            {{ $flight->arrival }}
                        @endif
                    </dd>

                    <dt class="col-lg-5 card-text">Aircraft</dt>
                    <dd class="col-lg-7 card-text">{{ $flight->aircraft->name }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                @if($type === 'FlightRequest')
                    <dl class="row align-items-center card-text">
                        <dt class="col-lg-4 card-text">Copilot</dt>
                        <dd class="col-lg-8 card-text">
                            @if($otherUser = $flight->otherUser())
                                <a href="{{ route('profile.show', $otherUser->profile) }}" class="text-decoration-none">
                                    <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                    {{ $otherUser->username }}
                                </a>
                            @else
                                No one, yet!
                            @endif
                        </dd>

                        <dt class="col-lg-4 card-text">Plan</dt>
                        <dd class="col-lg-8 card-text">
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
                                    <span data-toggle="tooltip" data-placement="right"
                                    title="There must be one departure and one arrival airport before you can dispatch this flight!">
                                        None<i class="fas fa-exclamation-circle ml-2"></i>
                                    </span>
                                @endif
                            @else
                                <span data-toggle="tooltip" data-placement="right"
                                  title="You need a copilot before you can dispatch this flight!">
                                    None<i class="fas fa-exclamation-circle ml-2"></i>
                                </span>
                            @endif
                        </dd>

                        <dt class="col-lg-4 card-text">Status</dt>
                        <dd class="col-lg-8 card-text">
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
                            <a href="{{ route('profile.show', $flight->otherUser()->profile) }}" class="text-decoration-none">
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
            <div class="form-group card-text">
                <label>
                    As your flight is private, you'll need to share it with someone
                    directly for them to join it. Just send them the link below!
                </label>
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
                            <h5 class="mb-2"><label>Expires</label></h5>
                            <input type="text" class="form-control" readonly
                            value="{{ empty($flight->expiry) ? 'Never' : \Carbon\Carbon::parse($flight->expiry)->format('H:i, D j M Y') }}">
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

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.geodesic"></script>

<script type="text/javascript">
    // Enable tooltips
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    /**
     * Initialises the live search bootstrap-select pickers
     *
     * @param      string     selectPicker  The select picker element (DOM selector)
     * @param      string     searchRoute   The search route (Laravel route())
     * @param      boolean    hasSim        Indicates if selectable object has sim property
     */
    function initLiveSearch(selectPicker, searchRoute, hasSim)
    {
        $(selectPicker).selectpicker({
            liveSearch: true
        }).ajaxSelectPicker({
            ajax: {
                url: searchRoute,
                method: 'GET',
                data: {
                    q: '@{{{q}}}'
                }
            },
            locale: {
                emptyTitle: 'Start typing to search...',
                statusInitialized: '',
            },
            preprocessData: function(data)
            {
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

                        if (hasSim === true) {
                            var value = curr.id;
                            var optText = curr.icao + ' - ' + curr.name + ' (' + curr.sim + ')';
                        } else {
                            var value = curr.icao
                            var optText = curr.icao + ' - ' + curr.name;
                        }

                        aircraft.push({
                                'value': value,
                                'text': optText,
                                'disabled': false
                            }
                        );
                    }
                }
                return aircraft;
            }, preserveSelected: true
        });
    }
    // Initialise both airport and aircraft boostrap-select pickers
    initLiveSearch('.selectpicker', '{{ route('search.airport') }}', false);
    initLiveSearch('.aircraftpicker', '{{ route('search.approved_aircraft') }}', true);

    /*
     * Hack to stop bootstrap-select picker breaking before search initiated
     *
     * @see https://github.com/truckingsim/Ajax-Bootstrap-Select/issues/177
     */
    $.fn.ajaxSelectPickerRefresh = function()
    {
        return this.each(function ()
        {
            if(!$(this).data('AjaxBootstrapSelect')) {
                return;
            }

            var picker = $(this).data('AjaxBootstrapSelect');
            var selected = [];
            var selectValues = picker.$element.find('option:selected');

            for (var i=0;i<selectValues.length;i++) {
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

    /**
     * Preselect defined options in the airport select pickers
     *
     * @param      string     selectPicker  The select picker element (DOM selector)
     * @param      Object     airports      The airport objects (with icao and name properties)
     *
     * @return     Array                    ICAO codes of selected elements
     */
    function preselectOptions(selectPicker, airports)
    {
        icaos = [];

        $.each(airports, function (i, item)
        {
            $(selectPicker).append($('<option>', {
                value: item.icao,
                text : item.icao + ' - ' + item.name
            }));
            icaos.push(item.icao);
        });

        $(selectPicker).selectpicker('val', icaos).ajaxSelectPickerRefresh();
        return icaos;
    }

    var departureAirports = {!! json_encode($departureAirports) !!};
    var arrivalAirports = {!! json_encode($arrivalAirports) !!};

    // Add preselected options to each selectpicker
    var departureIcaos = preselectOptions('#departure', departureAirports);
    var arrivalIcaos = preselectOptions('#arrival', arrivalAirports);

    // Set initial state of bootstrap-select pickers and radios based on database
    if (departureAirports.length > 0)
    {
        $('#departure').prop('disabled', false);
        $('#departureRadio1').prop('checked', false);
        $('#departureRadio2').prop('checked', true);
    }
    if (arrivalAirports.length > 0)
    {
        $('#arrival').prop('disabled', false);
        $('#arrivalRadio1').prop('checked', false);
        $('#arrivalRadio2').prop('checked', true);
    }
    $('.selectpicker').selectpicker('refresh');

    /*
     * Event listeners for setting select picker disabled state based on radios
     */
    $('input[name="departureRadio"]').click(function()
    {
        if ($('#departureRadio2').is(":checked")) {
            $('#departure').prop('disabled', false);
        } else {
            $('#departure').prop('disabled',true);
        }
        $('.selectpicker').selectpicker('refresh');
    });
    $('input[name="arrivalRadio"]').click(function()
    {
        if ($('#arrivalRadio2').is(":checked")) {
            $('#arrival').prop('disabled', false);
        } else {
            $('#arrival').prop('disabled',true);
        }
        $('.selectpicker').selectpicker('refresh');
    });

    /**
     * Copies join link to clipboard
     *
     * @return void
     */
    function copyLink()
    {
        const link = document.getElementById('privateCode');
        link.select();
        document.execCommand('copy');
    }

    /**
     * Adds markers to map with popup, and returns an array of marker objects
     *
     * @param array airportsArray Array of objects with latitude, longitude, name and icao properties
     *
     * @return array Array of marker objects
     */
    function addMarkers(airportsArray)
    {
        var markerArray = [];

        for (var i = 0; i < airportsArray.length ; i++) {
            var airport = airportsArray[i];

            var marker = L.marker([airport.latitude, airport.longitude]).addTo(flightMap);
            marker.bindPopup(airport.name+" ("+airport.icao+")");

            markerArray.push(marker);
        }

        return markerArray;
    }

    // Initialise Leaflet.js map
    var flightMap = L.map('map', {
        zoomControl: false
    });

    // Add map tiles
    L.tileLayer('https://api.mapbox.com/styles/v1/{style}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: '&copy; <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        style: 'mapbox/dark-v10',
        accessToken: "{{ config('services.mapbox.token') }}"
    }).addTo(flightMap);

    // Add markers from departure and arrival airport arrays
    var markers = addMarkers(departureAirports.concat(arrivalAirports));

    // Fit markers within map
    if (markers.length > 1) {
        flightMap.fitBounds(new L.featureGroup(markers).getBounds(), {padding: [50, 50]});
    } else {
        flightMap.setView(markers[0].getLatLng(), 4);
    }
</script>

@if($type === 'FlightRequest' || empty($flight->route))
    <!-- Draws great circle line for all flight requests, and archived flights with no route -->
    <script type="text/javascript">

        /**
         * Get the coordinates of the centre of an array of airports
         * Returns the middle of several airports, or the coordinates of the airport given only one
         *
         * @param      array  airports  Array of airports with .latitude and .longitude properties
         * @return     L.LatLng         LatLng object (containing coords) of middle
         */
        function midCoords(airports)
        {
            // Only one airport so the midpoint is its coords
            if (airports.length <= 1) {
                return L.latLng([airports[0].latitude, airports[0].longitude]);
            }

            // Create an array of LatLng objects for each airport
            var coords = [];
            for (var i = 0; i < airports.length; i++) {
                coords.push(L.latLng(
                    parseFloat(airports[i].latitude), parseFloat(airports[i].longitude)
                ));
            }

            // Use Leaflet.js' getCenter() on a polyline to get the midpoint
            return L.polyline(coords, {opacity: 0.0}).addTo(flightMap).getCenter();
        }

        /**
         * Calculates whether or not to draw a circle encompassing airport(s), and if so, calculates the circle radius
         *
         * @param      array        airports    Array of airports with .latitude and .longitude properties
         * @param      L.LatLng     midpoint    The midpoint coordinates as a LatLng object
         * @return     boolean|float            Radius of circle if airports are closer than 10km, otherwise false
         */
        function calcCircle(airports, midpoint)
        {
            if (airports.length > 1) {
                // Find max distance from midpoint to an airport - will be the circle radius
                let max = 0;
                for (let i = 0; i < airports.length; i++) {
                    let dist = midpoint.distanceTo(L.latLng(airports[i].latitude, airports[i].longitude));
                    if (dist > max) {
                        max = dist;
                    }
                }

                if (max < 1000000) {
                    // Only return max if < 100km (i.e. don't draw the circle otherwise)
                    return max;
                }
            }

            // Not enough airports, or airports too spread out, to draw circle
            return false;
        }

        // Only draw any of this if there's at least one airport for each
        if (departureAirports.length > 0 && arrivalAirports.length > 0) {
            // Get the midpoint of departure and arrival airports
            let depMid = midCoords(departureAirports);
            let arrMid = midCoords(arrivalAirports);

            // Get the radii of any encompassing circles
            let depCircle = calcCircle(departureAirports, depMid);
            let arrCircle = calcCircle(arrivalAirports, arrMid);

            if (arrCircle !== false || depCircle !== false) {
                L.geodesic([depMid, arrMid]).addTo(flightMap);
                // Create circles centred at midpoint and radius calculated above + 50%
                L.circle(depMid, {radius: depCircle*1.5}).addTo(flightMap);
                L.circle(arrMid, {radius: arrCircle*1.5}).addTo(flightMap);
            } else if (departureAirports.length === 1 && arrivalAirports.length === 1) {
                L.geodesic([depMid, arrMid]).addTo(flightMap);
            }
        }
    </script>

@else

    <!-- Draws route for archived flights with a route set -->
    <script type="text/javascript">

        let route = {!! json_encode($flight->route) !!};

        for (let i = 0; i < route.length; i++) {
            let marker = L.marker([route[i].pos_lat, route[i].pos_long]).addTo(flightMap);
            marker.bindPopup(route[i].name);
            if (i > 0) {
                L.polyline([[route[i-1].pos_lat, route[i-1].pos_long], [route[i].pos_lat, route[i].pos_long]]).addTo(flightMap);
            }
        }

    </script>

@endif

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
