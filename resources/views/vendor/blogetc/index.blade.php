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
        <a class="p-2 text-muted" href="#">All</a>
        <a class="p-2 text-muted" href="#">Announcements</a>
        <a class="p-2 text-muted" href="#">Development</a>
        <a class="p-2 text-muted" href="#">Infrastructure</a>
        <a class="p-2 text-muted" href="#">Copilot</a>
        <a class="p-2 text-muted" href="#">Sponsorship</a>
    </nav>

    <hr class="mt-2 mb-3">

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="https://via.placeholder.com/500" class="card-img" alt="Placeholder">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="https://via.placeholder.com/500" class="card-img" alt="Placeholder">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @if(isset($blogetc_category) && $blogetc_category)
                <h2 class="text-center">
                    Viewing Category: {{ $blogetc_category->category_name }}
                </h2>

                @if($blogetc_category->category_description)
                    <p class="text-center">
                        {{ $blogetc_category->category_description }}
                    </p>
                @endif
            @endif

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
