@php
    use Illuminate\Support\Str;
    use WebDevEtc\BlogEtc\Models\Category;
    use WebDevEtc\BlogEtc\Models\Comment;
    use WebDevEtc\BlogEtc\Models\Post;
    // todo - this needs lots of work
@endphp

<h2 class="mb-3">
    Blog Admin
</h2>

<ul class="nav nav-pills flex-column">
    <h6 class="text-uppercase text-muted">Posts</h6>
    <li class="nav-item">
        <a class="nav-link @if(Request::routeIs('blogetc.admin.index')) active @endif" href="{{ route('blogetc.admin.index') }}">
            <i class="fas fa-table fa-fw mr-2"></i>All Posts
            <span class="badge badge-pill badge-info">{{ $postCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::routeIs('blogetc.admin.create_post')) active @endif" href="{{ route('blogetc.admin.create_post') }}">
            <i class="fas fa-plus fa-fw mr-2"></i>Add Post
        </a>
    </li>

    <h6 class="text-uppercase mt-3 text-muted">Comments</h6>
    <li class="nav-item">
        <a
        class="nav-link @if(Request::routeIs('blogetc.admin.comments.index') && !Request::get('waiting_for_approval')) active @endif"
        href="{{ route('blogetc.admin.comments.index') }}">
            <i class="fas fa-table fa-fw mr-2"></i>All Comments
            <span class="badge badge-pill badge-info">{{ $commentCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link
        @if(Request::routeIs('blogetc.admin.comments.index') && Request::get('waiting_for_approval'))
            active
        @elseif($commentApprovalCount>0)
            list-group-item-warning
        @endif"
        href="{{ route('blogetc.admin.comments.index') }}?waiting_for_approval=true">
            <i class="fas fa-comments fa-fw mr-2"></i>Pending Comments
            <span class="badge badge-pill badge-warning">{{ $commentApprovalCount }}</span>
        </a>
    </li>

    <h6 class="text-uppercase mt-3 text-muted">Categories</h6>
    <li class="nav-item">
        <a
        class="nav-link @if(Request::routeIs( 'blogetc.admin.categories.index')) active @endif"
        href="{{ route('blogetc.admin.categories.index') }}">
            <i class="fas fa-layer-group fa-fw mr-2"></i>All Categories
            <span class="badge badge-pill badge-info">{{ $categoryCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a
        class="nav-link @if(Request::routeIs('blogetc.admin.categories.create_category')) active @endif"
        href="{{ route('blogetc.admin.categories.create_category') }}">
            <i class="fas fa-plus fa-fw mr-2"></i>Add Category
        </a>
    </li>
</ul>
