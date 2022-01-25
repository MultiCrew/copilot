@extends('layouts.base')

@section('content')

<div class="row">
    <div class="col-xl-3">
        <div class="card mb-4 shadow">
            <div class="card-body">
                <h3 class="text-center card-title">{{ $profile->user->name }}</h3>
                <h5 class="text-center card-subtitle mb-3">{{ $profile->user->username }}</h5>

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

                <hr>

                <form method="POST" action="{{ route('profile.update', $profile) }}">
                    @csrf
                    @method('PATCH')

                    <div class="custom-control custom-checkbox mb-3">
                        <input type="hidden" name="showName" value="0">
                        <input type="checkbox" class="custom-control-input" id="showName" name="showName" value="1" @if($profile->show_name != false) checked @endif>
                        <label class="custom-control-label" for="showName">Show name on public profile</label>
                    </div>

                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" value="{{ $profile->location }}">
                    </div>

                    <button type="submit" class="btn btn-primary card-text">
                        <i class="fas fa-save mr-2"></i>Save
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-9">
        <div class="card mb-4 shadow">
            <div class="card-body">
                <h3 class="card-title mb-3">Your Preferences</h3>

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
                                <option value @if(empty($profile->airac)) selected @endif>Nothing selected</option>
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
                                <option value @if(empty($profile->level)) selected @endif>Nothing selected</option>
                                <option @if($profile->level === 'Beginner') selected @endif value="Beginner">Beginner</option>
                                <option @if($profile->level === 'Intermediate') selected @endif value="Intermediate">Intermediate</option>
                                <option @if($profile->level === 'Advanced') selected @endif value="Advanced">Advanced</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top"
                            title="Let people know how you usually connect to shared cockpit sessions">
                                Connection Method<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" name="connection">
                                <option value @if(empty($profile->connection)) selected @endif>Nothing selected</option>

                                <option @if($profile->connection === 'Tunnelling Engine (e.g. Hamachi)') selected @endif value="Tunnelling Engine (e.g. Hamachi)">
                                    Tunnelling Engine (e.g. Hamachi)
                                </option>
                                <option @if($profile->connection === 'Port Forwarding') selected @endif value="Port Forwarding">
                                    Port Forwarding
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label data-toggle="tooltip" data-placement="top"
                            title="Select the procedures you like to follow when you fly shared cockpit!">
                                Procedures<i class="fas fa-question-circle ml-2"></i>
                            </label>
                            <select class="form-control selectpicker" name="procedures">
                                <option value @if(empty($profile->procedures)) selected @endif>Nothing selected</option>

                                <option @if ($profile->procedures === 'No preference') selected @endif value="No preference">
                                    No preference
                                </option>
                                <option @if ($profile->procedures === 'Beginner - Looking to learn') selected @endif value="Beginner - Looking to learn">
                                    Beginner - Looking to learn
                                </option>
                                <option @if ($profile->procedures === 'MultiCrew flows - I use flows from the Internet') selected @endif value="MultiCrew flows - I use flows from the Internet">
                                    MultiCrew flows - I use flows from the Internet
                                </option>
                                <option @if ($profile->procedures === 'Real World - I follow real-world procedures') selected @endif value="Real World - I follow real-world procedures">
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
