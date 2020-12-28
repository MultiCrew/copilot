@extends('layouts.base')

@section('content')

<div id="loading-overlay" class="text-center pt-5" style="position: absolute;
display: none;
top: 0;
left: 0;
right: 0;
bottom: 0;
background-color: rgba(0,0,0,0.5);
z-index: 2;">
      <div class="spinner-border mx-auto mt-5 text-light" style="width: 3rem; height: 3rem;"></div>
      <h4 class="text-light">Loading, please wait...</h4>
      <p class="text-light">SimBrief will open in a new window</p>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="float-right">
            <a class="btn btn-secondary" href="{{ url()->previous() }}">
                <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
            </a>
        </div>
        <h3 class="card-title">Dispatch Flight</h3>

        <p class="card-text text-justify">
            The following form makes use of the SimBrief API to generate a draft flight plan which both
            pilots must review. A SimBrief account is <strong>required</strong>, and upon generating the
            plan you will be prompted to sign in to or create your SimBrief account.
        </p>
        <p class="card-text text-justify">
            If you already have a plan, you may wish to <a href="{{ route('dispatch.upload', $flight) }}">upload
            a PDF plan</a>.
        </p>
    </div>
</div>

<form id="sbapiform">
    <div class="row">
        <div class="col-xl-4">
            <div class="row">
                <div class="col-xl-12 col-lg-6">
                    <!-- begin summary box -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Summary</h5>

                            <div class="form-group row mb-0">
                                <label class="col-6 col-form-label">Flight Number</label>
                                <div class="input-group col-6">
                                    <input
                                    type="test"
                                    name="airline"
                                    class="form-control form-control-sm"
                                    required
                                    placeholder="MC"
                                    value="MC"
                                    maxlength="2">

                                    <input
                                    type="text"
                                    name="fltnum"
                                    class="form-control form-control-sm"
                                    required
                                    placeholder="124"
                                    maxlength="4">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label class="col-6 col-form-label">Callsign</label>
                                <div class="col-6">
                                    <input
                                    type="text"
                                    name="callsign"
                                    class="form-control form-control-sm"
                                    placeholder="MTC124"
                                    required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label class="col-6 col-form-label">Departure</label>
                                <div class="col-6">
                                    <input
                                    type="text"
                                    name="orig"
                                    class="form-control form-control-sm"
                                    maxlength="4"
                                    readonly
                                    value="{{ $flight->departure[0] }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label class="col-6 col-form-label">Arrival</label>
                                <div class="col-6">
                                    <input
                                    type="text"
                                    name="dest"
                                    class="form-control form-control-sm"
                                    maxlength="4"
                                    readonly
                                    value="{{ $flight->arrival[0] }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label class="col-6 col-form-label">Prim. Altn.</label>
                                <div class="col-6">
                                    <input
                                    type="text"
                                    name="altn"
                                    class="form-control form-control-sm"
                                    maxlength="4"
                                    required>
                                </div>
                            </div>

                            <div class="form-group row mb-n1">
                                <label class="col-6 col-form-label">Aircraft Type</label>
                                <div class="col-6">
                                    <input
                                    type="text"
                                    name="type"
                                    class="form-control form-control-sm"
                                    readonly
                                    value="{{ $flight->aircraft->icao }}">
                                </div>
                            </div>

                            <div class="form-group row mb-n1">
                                <label class="col-6 col-form-label">Copilot</label>
                                <div class="col-6 pt-2">
                                    <a href="{{ route('profile.show', $flight->otherUser()->profile) }}" class="text-decoration-none">
                                        <i class="fas fa-fw mr-1 fa-xs fa-user-circle"></i>
                                        {{ $flight->otherUser()->username }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /end summary box -->
                </div>

                <div class="col-xl-12 col-lg-6">
                    <!-- ofp options -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">OFP Options</h5>

                            <div class="form-group row card-text mb-1">
                                <label class="col-6 col-form-label card-text">Plan Format</label>
                                <div class="col-6">
                                    <select name="planformat" class="custom-select custom-select-sm card-text" required>
                                        <option value="lido" selected>LIDO</option>
                                        <option value="aal">AAL</option>
                                        <option value="aca">ACA</option>
                                        <option value="afr">AFR '12</option>
                                        <option value="afr2017">AFR '17</option>
                                        <option value="awe">AWE</option>
                                        <option value="baw">BAW</option>
                                        <option value="ber">BER</option>
                                        <option value="dal">DAL</option>
                                        <option value="dlh">DLH</option>
                                        <option value="ein">EIN</option>
                                        <option value="etd">ETD</option>
                                        <option value="ezy">EZY</option>
                                        <option value="gwi">GWI</option>
                                        <option value="jbu">JBU</option>
                                        <option value="jza">JZA</option>
                                        <option value="klm">KLM</option>
                                        <option value="qfa">QFA</option>
                                        <option value="ryr">RYR</option>
                                        <option value="swa">SWA</option>
                                        <option value="thy">THY</option>
                                        <option value="uae">UAE</option>
                                        <option value="ual">UAL '12</option>
                                        <option value="ual f:wz">UAL '18</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row card-text mb-n1">
                                <label class="col-6 col-form-label">Units</label>
                                <div class="col-6">
                                    <select name="units" class="custom-select custom-select-sm" required>
                                        <option value="KGS" selected>KGS</option>
                                        <option value="LBS">LBS</option>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="etops" value="0">
                            <input type="hidden" name="stepclimbs" value="0">
                            <input type="hidden" name="tlr" value="0">
                            <input type="hidden" name="notams" value="0">
                            <input type="hidden" name="firnot" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="alert alert-warning border">
                Limited dispatch options are available. More options are to be added here, with improved aircraft
                options already in the works. Please submit further reqeuests to
                <a href="https://github.com/MultiCrew/copilot/issues" target="_blank">GitHub</a>.
            </div>

            <!-- begin details accordion -->
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
                            <div class="form-group card-text">
                                <label>Custom Route</label>
                                <textarea
                                name="route"
                                class="form-control form-control-sm card-text"
                                placeholder="LEAVE BLANK TO GENERATE AUTOMATICALLY"
                                rows="3"></textarea>
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
                            <!-- date/time -->
                            <div class="col-md form-group">
                                <label>Date of Flight</label>
                                <select class="custom-select custom-select-sm card-text" name="date" required>
                                    @php
                                    // will default to today
                                    for ($i=0; $i < 7; $i++) {
                                        $date = strtotime('+ '.$i.' day');
                                        echo '<option value="'.$date.'">'.date('d-M-y', $date).'</option>';
                                    }
                                    @endphp
                                </select>
                            </div>

                            @php
                                // calculate departure time as 30 mins from now
                                $date = round(strtotime('+30 minutes') / 300) * 300;
                                $hour = date('H', $date);
                                $minute = date('i', $date);
                            @endphp
                            <div class="col-md form-group">
                                <label>Departure Time (UTC)</label>
                                    <div class="form-inline">
                                    <select class="custom-select custom-select-sm card-text mr-2" name="dephour" required>
                                        @php
                                        // add options for all hours of day
                                        for ($i=0; $i < 24; $i++) {
                                            if ($i==$hour) echo '<option value="'.$i*(60^2).'" selected>'.$i.'</option>';
                                            else echo '<option value="'.$i*(60^2).'">'.$i.'</option>';
                                        }
                                        @endphp
                                    </select> : &nbsp;
                                    <select class="custom-select custom-select-sm card-text" name="depmin" required>
                                        @php
                                        // add options for all minutes of hour
                                        for ($i=0; $i < 60; $i++) {
                                            if ($i==$minute) {
                                                echo '<option value="'.$i*(60).'" selected>'.$i.'</option>';
                                            } else {
                                                echo '<option value="'.$i*(60).'">'.$i.'</option>';
                                            }
                                        }
                                        @endphp
                                    </select>
                                </div>
                            </div>
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
                                <div class="form-group col-md-6">
                                    <label>
                                        Aicraft Type
                                        <i
                                        class="fas fa-info-circle ml-1"
                                        data-toggle="tooltip"
                                        data-placement="right"
                                        title="Enter a SimBrief airframe ID here if you want to use a specific aircraft in your fleet"></i>
                                    </label>
                                    <input type="text" class="form-control" value="{{ $flight->aircraft->icao }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Registration</label>
                                    <input type="text" name="reg" class="form-control" placeholder="G-ABCD">
                                </div>
                            </div>

                            <div class="form-row card-text">
                                <div class="form-group mb-0 col-md-6">
                                    <label>Contingency</label>
                                    <select name="contpct" class="custom-select card-text" required>
                                        <option value="auto" selected>AUTO</option>
                                        <option value="0">NONE</option>
                                        <option value disabled>- - - - - -</option>
                                        <option value="0.05/5">5% or 05 MIN</option>
                                        <option value="0.05/10">5% or 10 MIN</option>
                                        <option value="0.05/15">5% or 15 MIN</option>
                                        <option value="0.05/20">5% or 20 MIN</option>
                                        <option value disabled>- - - - - -</option>
                                        <option value="0.02">2 PCT</option>
                                        <option value="0.03">3 PCT</option>
                                        <option value="0.05">5 PCT</option>
                                        <option value="0.1">10 PCT</option>
                                        <option value="0.15">15 PCT</option>
                                        <option value="0.2">20 PCT</option>
                                        <option value disabled>- - - - - -</option>
                                        <option value="1">01 MIN</option>
                                        <option value="2">02 MIN</option>
                                        <option value="3">03 MIN</option>
                                        <option value="4">04 MIN</option>
                                        <option value="5">05 MIN</option>
                                        <option value="6">06 MIN</option>
                                        <option value="7">07 MIN</option>
                                        <option value="8">08 MIN</option>
                                        <option value="9">09 MIN</option>
                                        <option value="10">10 MIN</option>
                                        <option value="11">11 MIN</option>
                                        <option value="12">12 MIN</option>
                                        <option value="13">13 MIN</option>
                                        <option value="14">14 MIN</option>
                                        <option value="15">15 MIN</option>
                                        <option value="20">20 MIN</option>
                                        <option value="25">25 MIN</option>
                                        <option value="30">30 MIN</option>
                                    </select>
                                </div>

                                <div class="form-group mb-0 col-md-6">
                                    <label>Reserve</label>
                                    <div>
                                        <select name="resvrule" class="custom-select card-text" required>
                                            <option value="auto" selected>AUTO</option>
                                            <option value="0">0 MIN</option>
                                            <option value="15">15 MIN</option>
                                            <option value="30">30 MIN</option>
                                            <option value="35">35 MIN</option>
                                            <option value="40">40 MIN</option>
                                            <option value="45">45 MIN</option>
                                            <option value="60">60 MIN</option>
                                            <option value="75">75 MIN</option>
                                            <option value="90">90 MIN</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /end fuel section -->
                </div>
                <!-- /end details accordion -->
            </div>
        </div>
    </div>

    <input type="hidden" name="reqid" value="">
    <button type="reset" class="btn btn-danger">
        Reset<i class="fas fa-undo ml-2"></i>
    </button>
    <button
    type="button"
    id="submitButton"
    class="btn btn-success">
        Generate Plan<i class="fas fa-angle-double-right ml-2"></i>
    </button>
</form>

@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('#submitButton').click(function() {
            $('#loading-overlay').show();
            simbriefsubmit('{{ route('dispatch.store', ['flight' => $flight]) }}');
        });
    });
</script>
<script type="text/javascript" src="{{ asset('simbrief/simbrief.apiv1.js') }}"></script>

@endsection
