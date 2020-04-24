@extends('errors::layout')

@section('title', __('Server Error 500'))

@section('content')

    @if(app()->bound('sentry') && app('sentry')->getLastEventId())
        <div class="subtitle">Error ID: {{ app('sentry')->getLastEventId() }}</div>
        <script src="https://browser.sentry-cdn.com/5.15.5/bundle.min.js" integrity="sha384-wF7Jc4ZlWVxe/L8Ji3hOIBeTgo/HwFuaeEfjGmS3EXAG7Y+7Kjjr91gJpJtr+PAT" crossorigin="anonymous"></script>
        <script>
            Sentry.init({ dsn: 'https://5c3cc340ad0d4833a35ac0318269a1b3@o327954.ingest.sentry.io/1840033' });
            Sentry.showReportDialog({
                'eventId': '{{ app('sentry')->getLastEventId() }}',
                'user.email': '{{ Auth::user()->email }}',
                'user.name': '{{ Auth::user()->name }}'
            });
        </script>
    @endif

@endsection
