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
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Plan Flight</h5>
            <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-secondary mb-3">
                <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
            </a>
        </div>

        <div class="row">
            <div class="col-md-9">
                <p class="card-text text-justify">
                    The following form makes use of the SimBrief API to generate a draft flight plan which both
                    pilots must review. A SimBrief account is <strong>required</strong>, and upon generating the
                    plan you will be prompted to sign in to or create your SimBrief account.
                </p>
            </div>

            <div class="col-md-3">
                <p class="card-text text-right mt-3 lead">
                    Current UTC Time: &nbsp;<strong><span id="time" class="border rounded p-2 text-"></span></strong>
                </p>
            </div>
        </div>
    </div>
</div>

<form id="sbapiform">
    <!-- flight options / ofp options -->
    <div class="card-deck mb-4">
        <!-- flight options -->
        <div class="card">
            <div class="card-body">
                <div class="card-text">
                    <!-- acft/arpts -->
                    <div class="form-row">
                        <div class="col-sm-3 form-group">
                            <label>Aircraft Type</label>
                            <input
                            type="text"
                            name="type"
                            class="form-control form-control-sm"
                            readonly
                            value="{{ $flight->aircraft }}">
                        </div>

                        <div class="col-sm-3 form-group">
                            <label>Departure</label>
                            <input
                            type="text"
                            name="orig"
                            class="form-control form-control-sm"
                            maxlength="4"
                            readonly
                            value="{{ $flight->departure }}">
                        </div>

                        <div class="col-sm-3 form-group">
                            <label>Arrival</label>
                            <input
                            type="text"
                            name="dest"
                            class="form-control form-control-sm"
                            maxlength="4"
                            readonly
                            value="{{ $flight->arrival }}">
                        </div>

                        <div class="col-sm-3 form-group">
                            <label>Alternate</label>
                            <input type="text" name="altn" class="form-control form-control-sm" maxlength="4" required>
                        </div>
                    </div>

                    <!-- date/time -->
                    <div class="form-row">
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
                        $date = strtotime("+30 minutes");
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

                    <!-- callsign options -->
                    <div class="form-row">
                        <div class="col-sm-3 form-group mb-0">
                            <label>Flight Number</label>
                            <input type="hidden" name="airline" value="MC">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">MC</span>
                                </div>
                                <input type="text" name="fltnum" class="form-control" required placeholder="1234">
                            </div>
                        </div>

                        <div class="col-sm-3 form-group  mb-0">
                            <label>Callsign</label>
                            <input type="text" name="callsign" class="form-control form-control-sm" placeholder="MTC12AB" required>
                        </div>

                        <div class="col-sm-3 form-group  mb-0">
                            <label>Aircraft Reg</label>
                            <input type="text" name="reg" class="form-control form-control-sm" placeholder="G-MTXX" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ofp options -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">OFP Options</h5>
                <div class="form-group row card-text mb-1">
                    <label class="col-sm-7 col-form-label card-text">Plan Format</label>
                    <div class="col-sm-5">
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
                            <option value="ual f:wz">UAL '14</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row card-text">
                    <label class="col-sm-7 col-form-label card-text">Units</label>
                    <div class="col-sm-5">
                        <select name="units" class="custom-select custom-select-sm card-text" required>
                            <option value="KGS" selected>KGS</option>
                            <option value="LBS">LBS</option>
                        </select>
                    </div>
                </div>

                <h5 class="card-title">Fuel Options</h5>
                <div class="form-group row card-text mb-1">
                    <label class="col-sm-7 col-form-label card-text">Contingency</label>
                    <div class="col-sm-5">
                        <select name="contpct" class="custom-select custom-select-sm card-text" required>
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
                </div>

                <div class="form-group row card-text mb-0">
                    <label class="col-sm-7 col-form-label card-text">Reserve</label>
                    <div class="col-sm-5">
                        <select name="resvrule" class="custom-select custom-select-sm card-text" required>
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

                <input type="hidden" name="etops" value="0">
                <input type="hidden" name="stepclimbs" value="0">
                <input type="hidden" name="tlr" value="0">
                <input type="hidden" name="notams" value="0">
                <input type="hidden" name="firnot" value="0">
            </div>
        </div>
    </div>

    <!-- route -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-text">
                <div class="form-group">
                    <label>Custom Route</label>
                    <textarea
                    name="route"
                    class="form-control form-control-sm"
                    placeholder="LEAVE BLANK TO GENERATE AUTOMATICALLY"
                    rows="3"></textarea>
                </div>

                <input type="hidden" name="reqid" value="">
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-danger">
                        Reset <i class="fas fa-fw ml-2 fa-undo"></i>
                    </button>
                    <button
                    type="button"
                    id="submitButton"
                    class="btn btn-success">
                        Create Plan &raquo;
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')

<script>
    function addZeros(i) {
        if (i < 10) {
            return "0" + i;  // add zero in front of numbers < 10
        } else {
            return i;
        }
    }

    function updateTime() {
        var time = new Date($.now());
        var h = addZeros(time.getHours());
        var m = addZeros(time.getMinutes());
        $('#time').text(h + ":" + m + " Z");
    }

    $(document).ready(function() {
        setInterval(updateTime, 1000);

        $('#submitButton').click(function() {
            $('#loading-overlay').show();
            simbriefsubmit('{{ route('dispatch.store', ['flight' => $flight]) }}');
        });
    });
</script>
<script type="text/javascript" src="{{ asset('simbrief/simbrief.apiv1.js') }}"></script>

@endsection
