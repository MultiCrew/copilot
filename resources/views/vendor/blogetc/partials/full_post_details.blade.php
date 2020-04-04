<div class="d-flex justify-content-between align-items-center">
    <div>
        <h2 class="blog_title">
            {{ $post->title }}
        </h2>

        <p class="mb-1">
            By {{ User::find($post->user_id)->name }}
            &middot;
            {{ $post->posted_at }}
            &middot;

            @forelse($post->categories as $category)
                <a class="badge badge-secondary" href="{{ $category->url() }}">
                    {{ $category->category_name }}
                </a>
            @empty
            @endforelse
        </p>
    </div>

    <div class="text-right">
        @can('blog-etc-admin')
            <p class="mb-1">
                <a href="{{ $post->editUrl() }}" class="btn btn-outline-warning btn-sm">
                    <i class="fas fa-fw mr-2 fa-pencil-alt"></i>Edit Post
                </a>
            </p>
        @endcan
        <p>
            <a href="{{ route('blogetc.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-fw mr-2 fa-angle-double-left"></i>Back
            </a>
        </p>
    </div>
</div>

<hr>

<p class="blog_body_content">
    {!! $post->renderBody() !!}
</p>

<hr>
