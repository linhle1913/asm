@extends('client.layout.master')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <div class="py-4"></div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-lg-9   mb-5 mb-lg-0">
                    <article>
                        <div class="post-slider mb-4">
                            <img src="/uploads/post/{{ $post->thumbnail }}" class="card-img" alt="post-thumb">
                        </div>

                        <h1 class="h2">{{ $post->title }} </h1>
                        <ul class="card-meta my-3 list-inline">
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
                                    @if ($tag->is_active == 1)
                                    <li class="list-inline-item"><a href="{{ route('list',$tag->id) }}">{{ $tag->name }}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        <div class="content">
                            {!! nl2br($post->content) !!}
                        </div>
                    </article>

                </div>

                <div class="col-lg-9 col-md-12">
                    <div class="mb-5 border-top mt-4 pt-5">
                        <h3 class="mb-4">Bình luận</h3>

                        @foreach ($comments as $comment)
                        <div class="media d-block d-sm-flex mb-4 pb-4">
                            <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                                <img src="/uploads/avatar/{{ $comment->user->image }}" style="width: 50px" class="mr-3 rounded-circle" alt="">
                            </a>
                            <div class="media-body">
                                <a href="#!" class="h4 d-inline-block mb-3">{{ $comment->user->name }}</a>

                                <p>{{ $comment->comment }}</p>

                                <span class="text-black-800 mr-3 font-weight-600">{{ $comment->created_at->format('d-m-Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ $comments->links() }}
                    <div>
                        <h3 class="mb-4">Để lại bình luận</h3>
                        <form method="POST" action="{{ route('comment',$post->id) }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control shadow-none" name="comment" rows="7" required></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control shadow-none" type="text" placeholder="Name" value="{{ Auth::user()->name }}" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <input class="form-control shadow-none" type="email" placeholder="Email" value="{{ Auth::user()->email }}" disabled>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Bình luận ngay</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
