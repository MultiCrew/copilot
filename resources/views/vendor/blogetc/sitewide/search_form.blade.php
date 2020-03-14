<div class="card">
    <div class="card-body">
        <h4 class="card-title">Search blog</h4>
        <form method="get" action="{{ route('blogetc.search') }}" class="card-text">
            <div class="input-group card-text">
                <input type="text" name="s" class="form-control" value="{{ Request::get('s') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
