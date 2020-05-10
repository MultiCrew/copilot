@extends('layouts.base')

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <div class="float-right">
            @if(url()->previous() == env('APP_URL').'/dispatch')
                <a href="{{ route('flights.show', [$flight->id]) }}" class="btn btn-info">
                    Flight Details<i class="fas fa-fw ml-2 fa-search"></i>
                </a>
            @endif

            <a class="btn btn-secondary" href="{{ url()->previous() }}">
                <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
            </a>
        </div>

        <h3 class="card-title">Flight Plan @unless($plan->isApproved()) Review @endunless</h3>
        <p class="lead text-muted">
            Flight {{ $fpl['general']['icao_airline'].$fpl['general']['flight_number'] }}
            from {{ $fpl['origin']['iata_code'] }} ({{ $fpl['origin']['name'] }})
            to {{ $fpl['destination']['iata_code'] }} ({{ $fpl['destination']['name'] }})
        </p>
        <p class="card-text">
            @if($plan->isApproved())
                Your OFP is ready to use! Enjoy your flight.
            @else
                Your draft OFP has been generated. Both pilots are required to review and
                accept the flight plan before cockpit preparation can begin.
            @endif
        </p>
    </div>
</div>

@if(!$plan->isApproved())
    <div class="alert alert-danger mb-4">
        <strong>Do not operate with this flight plan!</strong>
        Both pilots must review the plan before proceeding.
    </div>
@endif

<div class="row">
    <div class="col-xl-3">
        <div class="row">
            <div class="col-xl-12 col-lg-6">
                <!-- begin summary box -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Summary</h5>

                        <dl class="card-text row">
                            <dt class="col-sm-5 col-xl-12">AIRAC</dt>
                            <dd class="col-sm-7 col-xl-12 text-right">
                                <samp>{{ $fpl['params']['airac'] }}</samp>
                            </dd>

                            <dt class="col-sm-5 col-xl-12">Planned by</dt>
                            <dd class="col-sm-7 col-xl-12 text-right">
                                <samp>{{ $fpl['crew']['cpt'] }}</samp>
                            </dd>

                            <dt class="col-sm-5 col-xl-12">Callsign</dt>
                            <dd class="col-sm-7 col-xl-12 text-right">
                                <samp>{{ $fpl['atc']['callsign'] }}</samp>
                            </dd>

                            <dt class="col-sm-5 col-xl-12">Departure</dt>
                            <dd class="col-sm-7 col-xl-12 text-right">
                                <samp>{{ $fpl['origin']['icao_code'].' / '.$fpl['origin']['iata_code'] }}</samp>
                            </dd>

                            <dt class="col-sm-5 col-xl-12">Arrival</dt>
                            <dd class="col-sm-7 col-xl-12 text-right">
                                <samp>{{ $fpl['destination']['icao_code'].' / '.$fpl['destination']['iata_code'] }}</samp>
                            </dd>

                            <dt class="col-sm-5 col-xl-12">Prim. Altn.</dt>
                            <dd class="col-sm-7 col-xl-12 text-right">
                                <samp>{{ $fpl['alternate']['icao_code'].' / '.$fpl['alternate']['iata_code'] }}</samp>
                            </dd>

                            <dt class="col-sm-5 col-xl-12">Aircraft</dt>
                            <dd class="col-sm-7 col-xl-12 text-right">
                                <samp>{{ $fpl['aircraft']['icaocode'] }}</samp>
                            </dd>
                        </dl>
                    </div>
                </div>
                <!-- /end summary box -->
            </div>

            <div class="col-xl-12 col-lg-6">

                @unless($plan->isApproved())
                    <button
                    type="button"
                    class="btn btn-info btn-block btn-lg card-text mb-4"
                    data-toggle="modal"
                    data-target="#previewModal">
                        Preview Paperwork<i class="fas fa-external-link-alt ml-2"></i>
                    </button>

                    <!-- begin review box -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Review</h5>

                            @if($plan->hasAccepted())
                                <p>
                                    You have already accepted this flight plan. Your copilot has yet to review the plan, so
                                    sit tight for now.
                                </p>
                            @else
                                <div class="card-text">
                                    <p>
                                        Please select one of the following options to indicate whether you have reviewed,
                                        and are happy to continue with, the <strong>draft</strong> flight plan detailed above.
                                    </p>

                                    <div class="text-center card-text">
                                        <a class="btn btn-success btn-block card-text" href="{{ route('dispatch.accept', [$plan]) }}">
                                            <i class="fas mr-2 fa-check"></i>Accept
                                        </a>
                                        <a class="btn btn-danger btn-block card-text" href="{{ route('dispatch.reject', [$plan]) }}">
                                            <i class="fas mr-2 fa-times"></i>Reject
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /end review box -->
                @endunless
            </div>
        </div>
    </div>

    <!-- begin details accordion -->
    <div class="col-xl-9">
        <div class="accordion" id="detailsAccordion">
            <div class="card">
                <!-- begin route button -->
                <div class="card-header" id="routeHeading">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#routeSection">
                            Route
                        </button>
                    </h5>
                </div>
                <!-- /end route button -->

                <!-- begin route section -->
                <div id="routeSection" class="collapse" data-parent="#detailsAccordion">
                    <div class="card-body">
                        <div class="row mb-4 card-text">
                            <div class="col-md-6">
                                <p class="card-subtitle mb-2">Departure</p>
                                <samp>{{ $fpl['origin']['name'] . ' (' . $fpl['origin']['iata_code'] . ')' }}</samp>
                                <br>
                                <samp>{{ $fpl['origin']['icao_code'] . '/' . $fpl['origin']['plan_rwy'] }}</samp>
                            </div>

                            <div class="col-md-6">
                                <p class="card-subtitle mb-2">Arrival</p>
                                <samp>{{ $fpl['destination']['name'] . ' (' . $fpl['destination']['iata_code'] . ')' }}</samp>
                                <br>
                                <samp>{{ $fpl['destination']['icao_code'] . '/' . $fpl['destination']['plan_rwy'] }}</samp>
                            </div>
                        </div>
                        <div class="form-group card-text mb-4">
                            <label>Route</label>
                            <code>
                                <textarea
                                class="form-control form-control-sm card-text"
                                readonly
                                rows="2"
                                style="resize: none;">{{ $fpl['general']['route_navigraph'] }}</textarea>
                            </code>
                        </div>
                        <div class="row card-text">
                            <div class="col-md-4">
                                <p class="card-subtitle mb-2">Alternate</p>
                                <samp>{{ $fpl['alternate']['name'] . ' (' . $fpl['alternate']['iata_code'] . ')' }}</samp>
                                <br>
                                <samp>{{ $fpl['alternate']['icao_code'] . '/' . $fpl['alternate']['plan_rwy'] }}</samp>
                            </div>
                            <div class="col-md-8">
                                <label>Alternate Route</label>
                                <code>
                                    <textarea
                                    class="form-control form-control-sm card-text"
                                    readonly
                                    rows="2"
                                    style="resize: none;">{{ $fpl['alternate']['route'] }}</textarea>
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /end route section -->
            </div>

            <div class="card">
                <!-- begin schedule button -->
                <div class="card-header" id="scheduleHeading">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#scheduleSection">
                            Schedule
                        </button>
                    </h5>
                </div>
                <!-- /end schedule button -->

                <!-- begin schedule section -->
                <div id="scheduleSection" class="collapse" data-parent="#detailsAccordion">
                    <div class="card-body">
                        <table class="table table-borderless table-sm card-text">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Scheduled</th>
                                    <th>Estimated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><pre class="mb-0">OUT</pre></th>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['sched_out'])->format('Hi') }} Z</pre></td>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['est_out'])->format('Hi') }} Z</pre></td>
                                </tr>
                                <tr>
                                    <th><pre class="mb-0">OFF</pre></th>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['sched_off'])->format('Hi') }} Z</pre></td>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['est_off'])->format('Hi') }} Z</pre></td>
                                </tr>
                                <tr>
                                    <th><pre class="mb-0">TET</pre></th>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['sched_time_enroute'])->format('Hi') }}</pre></td>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['est_time_enroute'])->format('Hi') }}</pre></td>
                                </tr>
                                <tr>
                                    <th><pre class="mb-0">ON</pre></th>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['sched_on'])->format('Hi') }} Z</pre></td>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['est_on'])->format('Hi') }} Z</pre></td>
                                </tr>
                                <tr>
                                    <th><pre class="mb-0">IN</pre></th>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['sched_in'])->format('Hi') }} Z</pre></td>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['est_in'])->format('Hi') }} Z</pre></td>
                                </tr>
                                <tr>
                                    <th><pre class="mb-0">BLOCK</pre></th>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['est_block'])->format('Hi') }}</pre></td>
                                    <td><pre class="mb-0">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['sched_block'])->format('Hi') }}</pre></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /end schedule section -->
            </div>

            <div class="card">
                <!-- begin fuel button -->
                <div class="card-header" id="fuelHeading">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#fuelSection">
                            Fuel & Payload
                        </button>
                    </h5>
                </div>
                <!-- /end fuel button -->

                <!-- begin fuel section -->
                <div id="fuelSection" class="collapse" data-parent="#detailsAccordion">
                    <div class="card-body">
                        <div class="form-row card-text">
                            <div class="form-group mb-4 col-md-5">
                                <label>Aicraft Type</label>
                                <input type="text" readonly class="form-control" value="{{ $fpl['aircraft']['name'] }}">
                            </div>
                            <div class="form-group mb-4  col-md-5">
                                <label>Registration</label>
                                <input type="text" readonly class="form-control" value="{{ $fpl['aircraft']['reg'] }}">
                            </div>
                            <div class="form-group mb-4  col-md-2">
                                <label>Units</label>
                                <input type="text" readonly class="form-control bg-warning" value="{{ strtoupper($fpl['params']['units']) }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-xl-6 col-lg-8 col-md-10 col-xs-12">
                                <table class="table table-borderless table-sm card-text">
                                    <thead>
                                        <tr>
                                            <th colspan="2"><pre class="mb-0">FUEL</pre></th>
                                            <th><pre class="mb-0 text-right">TIME</pre></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td><pre class="mb-0">TRIP</pre></td>
                                            <td><pre class="mb-0 text-right">{{ $fpl['fuel']['enroute_burn'] }}</pre></td>
                                            <td><pre class="mb-0 text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['est_block'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre class="mb-0">CONT</pre></td>
                                            <td><pre class="mb-0 text-right">{{ $fpl['fuel']['contingency'] }}</pre></td>
                                            <td><pre class="mb-0 text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['contfuel_time'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre class="mb-0">ALTN</pre></td>
                                            <td><pre class="mb-0 text-right">{{ $fpl['fuel']['alternate_burn'] }}</pre></td>
                                            <td><pre class="mb-0 text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['alternate']['ete'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre>FINRES</pre></td>
                                            <td><pre class="text-right">{{ $fpl['fuel']['reserve'] }}</pre></td>
                                            <td><pre class="text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['reserve_time'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre>M. T/O</pre></td>
                                            <td><pre class="text-right">{{ $fpl['fuel']['min_takeoff'] }}</pre></td>
                                            <td><pre class="text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['endurance']-$fpl['times']['extrafuel_time'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre>EXTRA</pre></td>
                                            <td><pre class="text-right">{{ $fpl['fuel']['extra'] }}</pre></td>
                                            <td><pre class="text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['extrafuel_time'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre class="mb-0">T/O</pre></td>
                                            <td><pre class="mb-0 text-right">{{ $fpl['fuel']['plan_takeoff'] }}</pre></td>
                                            <td><pre class="mb-0 text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['endurance'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre>TAXI</pre></td>
                                            <td><pre class="text-right">{{ $fpl['fuel']['taxi'] }}</pre></td>
                                            <td><pre class="text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['taxi_out']+$fpl['times']['taxi_in'])->format('Hi') }}</pre></td>
                                        </tr>
                                        <tr>
                                            <td><pre class="mb-0">BLOCK</pre></td>
                                            <td><pre class="mb-0 text-right">{{ $fpl['fuel']['plan_ramp'] }}</pre></td>
                                            <td><pre class="mb-0 text-right">{{ \Carbon\Carbon::createFromTimestamp($fpl['times']['endurance']+$fpl['times']['taxi_out']+$fpl['times']['taxi_in'])->format('Hi') }}</pre></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xl-6 col-lg-4 col-md-2"></div>
                        </div>

                        <div class="alert alert-warning border">
                            For all weights, the left hand value is <strong>estimated</strong>. The right
                            hand value is the aircraft's <strong>maximum</strong>.
                        </div>
                        <div class="form-row card-text">
                            <div class="form-group mb-md-4 mb-lg-0 col-md-3">
                                <label>Passengers</label>
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['weights']['pax_count'] }}">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['aircraft']['max_passengers'] }}">
                                </div>
                            </div>
                            <div class="form-group mb-md-4 mb-lg-0 col-md-3">
                                <label>
                                    <abbr title="Zero Fuel Weight">ZFW</abbr>
                                </label>
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['weights']['est_zfw'] }}">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['weights']['max_zfw'] }}">
                                </div>
                            </div>
                            <div class="form-group mb-md-4 mb-lg-0 col-md-3">
                                <label>
                                    <abbr title="Take-Off Weight">TOW</abbr>
                                </label>
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['weights']['est_tow'] }}">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['weights']['max_tow'] }}">
                                </div>
                            </div>
                            <div class="form-group mb-md-4 mb-lg-0 col-md-3">
                                <label>
                                    <abbr title="Landing Weight">LAW</abbr>
                                </label>
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['weights']['est_ldw'] }}">
                                    <input type="text" readonly class="form-control" value="{{ $fpl['weights']['max_ldw'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /end fuel section -->
            </div>

            <div class="card">
                <!-- begin performance button -->
                <div class="card-header" id="performanceHeading">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#performanceSection">
                            Performance
                        </button>
                    </h5>
                </div>
                <!-- /end performance button -->

                <!-- begin performance section -->
                <div id="performanceSection" class="collapse" data-parent="#detailsAccordion">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label>
                                Select one of the following options to see the impact on various flight factors...
                            </label>
                            <select class="form-control card-text" id="impactSelect">
                                <option selected disabled value>Select one...</option>
                                <optgroup label="Cruise Altitude">
                                    <option value="minus_6000ft">-6000 ft</option>
                                    <option value="minus_4000ft">-4000 ft</option>
                                    <option value="minus_2000ft">-2000 ft</option>
                                    <option value="plus_2000ft">+2000 ft</option>
                                    <option value="plus_4000ft">+4000 ft</option>
                                    <option value="plus_6000ft">+6000 ft</option>
                                </optgroup>
                                <optgroup label="Cost Index">
                                    <option value="lower_ci">Lower</option>
                                    <option value="higher_ci">Higher</option>
                                </optgroup>
                                <optgroup label="Zero Fuel Weight">
                                    <option value="zfw_minus_1000">-1000</option>
                                    <option value="zfw_plus_1000">+1000</option>
                                </optgroup>
                            </select>
                        </div>

                        <p class="mt-3 mb-0" id="noImpact">
                            Unable to show performance figures for this change. Please <strong>do not</strong> operate
                            at the selected change.
                        </p>

                        @foreach($fpl['impacts'] as $key => $impact)
                            @unless(empty($impact))
                                <table id="{{ $key }}" class="table table-borderless table-sm mt-3 mb-0 impacts-table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th><samp>VALUE</samp></th>
                                            <th><samp>DIFF</samp></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="align-middle mb-0">Enroute Time</th>
                                            <td class="align-middle mb-0"><samp>{{ $impact['time_enroute'] }}</samp></td>
                                            <td class="align-middle mb-0"><samp>{{ $impact['time_difference'] }}</samp></td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle mb-0">Enroute Fuel</th>
                                            <td class="align-middle mb-0"><samp>{{ $impact['enroute_burn'] }}</samp></td>
                                            <td class="align-middle mb-0"><samp>{{ $impact['burn_difference'] }}</samp></td>
                                        </tr>
                                        <tr>
                                            <th class="align-middle">Block Fuel</th>
                                            <td colspan="2" class="align-middle"><samp>{{ $impact['ramp_fuel'] }}</samp></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endunless
                        @endforeach
                    </div>
                </div>
                <!-- /end performance section -->
            </div>

            <div class="card">
                <!-- begin weather button -->
                <div class="card-header" id="weatherHeading">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#weatherSection">
                            Weather
                        </button>
                    </h5>
                </div>
                <!-- /end weather button -->

                <!-- begin weather section -->
                <div id="weatherSection" class="collapse" data-parent="#detailsAccordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Departure</h5>
                                <div class="form-group">
                                    <label>METAR</label>
                                    <pre style=" white-space: pre-wrap;">{{ $fpl['weather']['orig_metar'] }}</pre>
                                </div>
                                <div class="form-group">
                                    <label>TAF</label>
                                    <pre style=" white-space: pre-wrap;">{{ $fpl['weather']['orig_taf'] }}</pre>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Arrival</h5>
                                <div class="form-group">
                                    <label>METAR</label>
                                    <pre style=" white-space: pre-wrap;">{{ $fpl['weather']['dest_metar'] }}</pre>
                                </div>
                                <div class="form-group">
                                    <label>TAF</label>
                                    <pre style=" white-space: pre-wrap;">{{ $fpl['weather']['dest_taf'] }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /end weather section -->
            </div>
        </div>
    </div>
    <!-- /end details accordion -->
</div>

@if($plan->isApproved())
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Export Options</h5>

                    <table class="card-text table table-striped border">
                        <tbody>
                            @foreach($fpl['fms_downloads'] as $download)
                                @unless($loop->first)
                                    <tr>
                                        <td class="align-middle">{{ $download['name'] }}</td>
                                        <td class="align-middle text-right">
                                            <a
                                            class="btn btn-success btn-sm m-0"
                                            href="{{ $fpl['fms_downloads']['directory'].$download['link']}}">
                                                <i class="fas fa-fw mr-2 fa-download"></i>Download
                                            </a>
                                        </td>
                                    </tr>
                                @endunless
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Pre-file Flight Plan</h5>

                    <div class="d-inline card-text">
                        <div id="unstyled-buttons">
                            {!! $fpl['vatsim_prefile'] !!}
                            {!! $fpl['ivao_prefile'] !!}
                        </div>

                        <a
                        href="{{ $fpl['pilotedge_prefile'] }}"
                        class="btn btn-primary btn-block"
                        target="_blank">
                            Pre-file on PilotEdge
                        </a>
                        <a
                        href="{{ $fpl['poscon_prefile'] }}"
                        class="btn btn-primary btn-block"
                        target="_blank">
                            Pre-file on POSCON
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Complete Flight</h5>

                    <p class="lead">Done with your flight? Mark it as completed and it will appear in your logbook!</p>
                    <button
                    type="button"
                    class="btn btn-warning btn-block btn-lg card-text"
                    data-toggle="modal"
                    data-target="#completeModal">
                        <i class="fas fa-check fa-fw mr-2"></i>Complete
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                    <h5 class="modal-title" id="completeModalLabel">Complete flight</h5>
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

@else

    <div
    class="modal fade"
    id="previewModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="previewModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Paperwork Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! ($fpl['text']['plan_html']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('#unstyled-buttons form button').addClass('btn btn-primary btn-block mb-2');

        $('.impacts-table').hide();
        $('#noImpact').hide();

        $('#impactSelect').change(function() {
            var impact = '#' + $(this).val();

            $('.impacts-table').hide();
            $('#noImpact').hide();

            if($(impact).length) {
                $(impact).show();
            } else {
                $('#noImpact').show();
            }
        });
    });
</script>

@endsection
