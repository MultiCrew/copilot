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
                    <div class="form-group mr-2">
                        <label class="sr-only" for="departure">Departure</label>
                        <input
                        type="text"
                        name="departure"
                        id="departure"
                        class="form-control {{ $errors->has('departure') ? 'border-danger' : '' }}"
                        placeholder="Departure"
                        value="{{ is_null(old('departure')) ? '' : old('departure') }}"
                        required>
                        @if($errors->has('departure'))
                            <p class="help text-danger">
                                {{ $errors->first('departure') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group mr-2">
                        <label class="sr-only" for="arrival">Arrival</label>
                        <input
                        type="text"
                        name="arrival"
                        id="arrival"
                        class="form-control {{ $errors->has('arrival') ? 'border-danger' : '' }}"
                        placeholder="Arrival"
                        value="{{ is_null(old('arrival')) ? '' : old('arrival') }}"
                        required>
                        @if($errors->has('arrival'))
                            <p class="help text-danger">
                                {{ $errors->first('arrival') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group mr-2">
                        <label class="sr-only" for="aircraft">Aircraft</label>
                        <input
                        type="text"
                        name="aircraft"
                        id="aircraft"
                        class="form-control {{ $errors->has('aircraft') ? 'border-danger' : '' }}"
                        placeholder="Aircraft"
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
