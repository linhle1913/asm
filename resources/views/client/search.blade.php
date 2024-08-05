@extends('client.layout.master')

@section('title')
    Tìm kiếm bài viết
@endsection

@section('content')
    <section class="section">
        <div class="py-4"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8  mb-5 mb-lg-0">
                    @if ($posts->isNotEmpty())
                    <h1 class="h2 mb-4">Các bài viết có tiêu đề <mark>{{ $query }}</mark></h1>
                        @foreach ($posts as $post)
                            <article class="card mb-4">
                                <div class="post-slider">
                                    <img src="/uploads/post/{{ $post->thumbnail }}" class="card-img-top" alt="post-thumb">
                                </div>
                                <div class="card-body">
                                    <h3 class="mb-3"><a class="post-title"
                                            href="{{ route('detail',$post->id) }}">{{ $post->title }}</a></h3>
                                    <ul class="card-meta list-inline">
                                        <li class="list-inline-item">
                                            <a href="author-single.html" class="card-meta-author">
                                                <img src="/uploads/avatar/{{ $post->author->image }}">
                                                <span>{{ $post->author->name }}</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="ti-calendar"></i>{{ $post->created_at->format('d-m-Y') }}
                                        </li>
                                        <li class="list-inline-item">
                                            <ul class="card-meta-tag list-inline">
                                                @foreach ($post->Tags as $tag)
                                                    <li class="list-inline-item"><a
                                                            href="{{ route('list', $tag->id) }}">{{ $tag->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                    {!! nl2br(Str::limit($post->content, 350)) !!}
                                    <a href="{{ route('detail', $post->id) }}" class="btn btn-outline-primary">Đọc thêm</a>
                                </div>
                            </article>
                        @endforeach
                    @else
                        <p>Không có bài viết nào chứa tiêu đề này</p>
                    @endif
                </div>

                    @include('client.layout.compulent.sidebar')

            </div>
        </div>
    </section>
@endsection
