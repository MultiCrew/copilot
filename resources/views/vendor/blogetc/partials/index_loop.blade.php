@php
/**
 * @var \WebDevEtc\BlogEtc\Models\Post $post
 */
@endphp
{{--Used on the index page (so shows a small summary--}}
{{--See the guide on webdevetc.com for how to copy these files to your /resources/views/ directory--}}
{{--https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#guide_to_views--}}

<div>
    <div class="d-flex justify-content-between align-items-end">
        <div>
            <h2 style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;">
                {{ $post->title }}
            </h2>
            <small class="text-muted">
                By {{ $post->user_id }}
                &middot;
                {{ $post->posted_at }}
            </small>
        </div>
        <a href="{{ $post->url() }}" class="btn btn-sm btn-outline-primary">
            Full post<i class="fas fa-angle-double-right fa-fw ml-2"></i>
        </a>
    </div>
    <hr>

    <div class="text-center">
        {{ $post->imageTag('medium', true, '') }}
    </div>
    @if($post->subtitle)
        <h3>{{ $post->subtitle }}</h3>
    @endif

    <p>{{ $post->renderBody() }}</p>
</div>
