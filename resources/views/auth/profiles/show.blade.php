@extends('layouts.base')

@section('content')

<div class="row">
    <div class="col-md-4">
        <h3 class="mb-3">Your Profile</h1>

                <div class="rounded-circle mx-auto img-thumbnail mb-3"
                style="background: url('{{ !empty($profile->picture) ? Storage::url($profile->picture) : asset('img/icon_sqcirc_lightondark.png') }}'); background-size: cover;
                height: 200px; width: 200px;"></div>

        <form action="{{ route('profile.picture.update', $profile) }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="picture" class="custom-file-input" required>
                        <label class="custom-file-label">New picture</label>
                    </div>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top"
                                title="Upload new image">
                                    <i class="fas fa-upload"></i>
                                </button>
                                <a href="#" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Remove current image"
                                onclick="document.getElementById('removePicture').submit();">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <small class="form-text text-muted">Max. file size 2MB. Recommended 200x200 pixels.</small>
            </div>
        </form>

                <form method="POST" action="{{ route('profile.picture.destroy', $profile) }}" id="removePicture">
                    @csrf
            @method('DELETE')
        </form>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update', $profile) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" readonly value="{{ Auth::user()->username }}">
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" readonly value="{{ Auth::user()->name }}">
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="hidden" name="showName" value="0">
                        <input type="checkbox" class="custom-control-input" id="showName" name="showName" value="1">
                        <label class="custom-control-label" for="showName">Show name on profile</label>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location">
                    </div>

                    <button type="submit" class="btn btn-primary card-text">
                        <i class="fas fa-save mr-2"></i>Save
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <h3 class="mb-3">Your Preferences</h3>

        <div class="card">
            <div class="card-body">
                <p>
                    Setting your preferences here helps prospective copilots picking up your requests know a bit more about
                    your flying style, simulator experience and compatability. Fill it out as much as you like - the more
                    information, the more well-matched your copilots will be!
                </p>

                <form action="{{ route('profile.update', $profile) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top" title="Select the simulators you use most often">
                                Simulators<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" multiple name="sims[]" id="sims"></select>
                        </div>

                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top"
                            title="Select the weather engine(s) you use with your simulator(s)">
                                Weather Engines<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" multiple name="weather[]" id="weather"></select>
                        </div>

                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top"
                            title="If you have a subscription to navigation data, select 'Kept up-to-date'">
                                Navigation Data<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" name="airac">
                                <option value="0" @if($profile->airac === 0) selected @endif>Outdated</option>
                                <option value="1" @if($profile->airac === 1) selected @endif>Kept up-to-date</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top"
                            title="Indicate your experience with shared cockpit. This is only a rough estimate!">
                                Level<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" name="level">
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top"
                            title="Let people know how you usually connect to shared cockpit sessions">
                                Connection Method<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" name="connection">
                                <option value="Tunnelling Engine (e.g. Hamachi)">Tunnelling Engine (e.g. Hamachi)</option>
                                <option value="Port Forwarding">Port Forwarding</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top"
                            title="Select the procedures you like to follow when you fly shared cockpit!">
                                Procedures<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" name="procedures">
                                <option value="No preference">
                                    No preference
                                </option>
                                <option value="Beginner - Looking to learn">
                                    Beginner - Looking to learn
                                </option>
                                <option value="MultiCrew flows - I use flows from the Internet">
                                    MultiCrew flows - I use flows from the Internet
                                </option>
                                <option value="Real World - I follow real-world procedures">
                                    Real World - I follow real-world procedures
                                </option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary card-text">
                        <i class="fas fa-save mr-2"></i>Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('append-scripts')

<script type="text/javascript">
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script type="text/javascript">
    // disable select pickers by default
    //$('.selectpicker').prop('disabled', true);

    // get all simulator options
    var sims = {!! json_encode($sims) !!};
    var selectedSims = {!! json_encode($profile->sims) !!};
    // get all weather engine options
    var wxs = {!! json_encode($wxs) !!};
    var selectedWxs = {!! json_encode($profile->weather) !!};

    // add sims and select preselected ones
    $.each(sims, function (i, item) {
        var newOption = $('<option>', {
            value: item.name,
            text:  item.name
        });

        $('#sims').append(newOption);
    });
    $('#sims').selectpicker('val', selectedSims);

    // add weather enginesand select preselected ones
    $.each(wxs, function (i, item) {
        var newOption = $('<option>', {
            value: item.name,
            text:  item.name
        });

        $('#weather').append(newOption);
    });
    $('#weather').selectpicker('val', selectedWxs);

    // refresh select picker displays
    $('.selectpicker').selectpicker('refresh');

    /*
     * Event listeners for setting select picker disabled state based on radios
     */
    /*$('input[name="departureRadio"]').click(function() {
        if ($('#departureRadio2').is(":checked")) {
            $('#departure').prop('disabled', false);
        } else {
            $('#departure').prop('disabled',true);
        }
        $('.selectpicker').selectpicker('refresh');
    });*/
</script>
@endpush
