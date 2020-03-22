@extends('layouts.base', ['title' => $title, ])

@section('content')

<div class="container">
    <div class="row d-flex justify-content-between align-items-baseline">
        <span class="col-4">&nbsp;</span>
        <h1 class="display-4 text-center col-4">Dev Blog</h1>
        <span class="text-right col-4">
            @can('blog-etc-admin')
                <a href="{{ route('blogetc.admin.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-fw fa-cogs mr-2"></i>Admin Panel
                </a>
            @endcan
        </span>
    </div>

    <nav class="nav d-flex justify-content-between">
        <a
        class="p-2 nav-link @if(Route::currentRouteName() === 'blogetc.index') active @endif"
        href="{{ route('blogetc.index') }}">All</a>
        @foreach($categories as $currentCategory)
            <a
            class="p-2 nav-link @if($category && ($category->slug === $currentCategory->slug)) active @endif"
            href="{{ route('blogetc.view_category', $currentCategory->slug) }}">
                {{ $currentCategory->category_name }}
            </a>
        @endforeach
    </nav>

    <hr class="mt-2 mb-3">

    <div class="row">
        @forelse($featuredPosts as $post)
            <div class="col-md-6">
                <div class="card mb-3 shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img
                            src="https://nyc3.digitaloceanspaces.com/fselite/2019/10/FSLabs-A321-FSELite-1-1600x663.jpg"
                            class="card-img" alt="Placeholder">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;">
                                    <a href="{{ $post->url() }}">{{ $post->title }}</a>
                                </h5>
                                <p class="card-text">{{ $post->subtitle }}</p>
                                <p class="card-text"><small class="text-muted">Posted {{ $post->posted_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>

    <div class="row">
        <div class="col-md-8">
            @forelse($posts as $post)
                @include('blogetc::partials.index_loop')
            @empty
                <div class="alert alert-danger">No posts</div>
            @endforelse

            <div class="text-center col-sm-4 mx-auto">
                {{ $posts->appends( [] )->links()}}
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 mb-3 bg-light rounded">
                <h4 class="font-italic" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;">About</h4>
                <p class="mb-0">
                    The MultiCrew blog is where you'll find all news, updates
                    and announcements from the MultiCrew team. We update this
                    blog at least once a month so please check back regularly!
                </p>
            </div>

            @include('blogetc::sitewide.search_form')
        </div>
    </div>
</div>

@endsection
