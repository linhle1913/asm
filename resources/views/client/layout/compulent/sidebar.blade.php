<!-- authors -->
<aside class="col-lg-4 sidebar-home">
<div class="widget widget-author">
    <h4 class="widget-title">Các tác giả</h4>
    @foreach ($authors as $author)
    <div class="media align-items-center">
        <div class="mr-3">
            <img class="widget-author-image" src="/uploads/avatar/{{ $author->image }}">
        </div>
        <div class="media-body">
            <h5 class="mb-1"><a class="post-title" href="author-single.html">{{ $author->name }}</a></h5>
        </div>
    </div>
    @endforeach
</div>

<div class="widget">
    <h4 class="widget-title"><span>Các thẻ</span></h4>
    <ul class="list-inline widget-list-inline widget-card">
        @foreach ($tags as $tag)
        <li class="list-inline-item"><a href="tags.html">{{ $tag->name }}</a></li>
        @endforeach
    </ul>
</div>
</aside>
