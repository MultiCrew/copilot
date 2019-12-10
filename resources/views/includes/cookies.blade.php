@if(!Cookie::get('cookie_consent'))
    <div class="alert alert-warning alert-dismissible fade show border" role="alert"
    style="position: fixed; z-index: 1000; bottom: 10px; text-align: center; width: 92%; left: 4%;">
        MultiCrew uses cookies to ensure you get the best experience. By continuing to browse, you agree to the storage of cookies on your computer.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <a href="{{ route('cookie-consent')}}"><i class="fas fa-times has-text-white"></i></a>
        </button>
    </div>
@endif
