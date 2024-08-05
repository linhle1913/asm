@extends('admin.layout.master')

@section('title')
    Bài viết {{ $post->title }}
@endsection

@section('content')
    <div class="card border-0 shadow">
        @if (Session::has('success'))
            <div class="alert alert-success">
                <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
            </div>
        @endif
        <form action="{{ route('admin.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="">Phê duyệt</label>
            <select name="is_active" id="">
                <option value="1" @if ($post->is_active==(1)) selected @endif>Có</option>
                <option value="0" @if ($post->is_active==(0)) selected @endif>Không</option>
            </select>
            <label for="">Biên tập viên lựa trọn</label>
            <select name="is_editors_pick" id="">
                <option value="1" @if ($post->is_editors_pick==(1)) selected @endif>Có</option>
                <option value="0" @if ($post->is_editors_pick==(0)) selected @endif>Không</option>
            </select>
            <label for="">Nổi bật</label>
            <select name="is_trending" id="">
                <option value="1" @if ($post->is_trending==(1)) selected @endif>Có</option>
                <option value="0" @if ($post->is_trending==(0)) selected @endif>Không</option>
            </select>
            <button type="submit" class="btn btn-primary">Thay đổi</button>
        </form>
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
                                    <a href="#" class="card-meta-author">
                                        <img src="/uploads/avatar/{{ $post->author->image }}" style="width: 50px">
                                        <span>{{ $post->author->name }}</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-calendar"></i>{{ $post->created_at->format('d-m-Y') }}
                                </li>
                                <li class="list-inline-item">
                                    <ul class="card-meta-tag list-inline">
                                        @foreach ($post->Tags as $tag)
                                        <li class="list-inline-item"><a href="#">{{ $tag->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            <div class="content">
                                {!! nl2br($post->content) !!}
                            </div>
                        </article>

                    </div>

                    {{-- <div class="col-lg-9 col-md-12">
                        <div class="mb-5 border-top mt-4 pt-5">
                            <h3 class="mb-4">Comments</h3>

                            <div class="media d-block d-sm-flex mb-4 pb-4">
                                <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                                    <img src="images/post/user-01.jpg" class="mr-3 rounded-circle" alt="">
                                </a>
                                <div class="media-body">
                                    <a href="#!" class="h4 d-inline-block mb-3">Alexender Grahambel</a>

                                    <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                                        sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                                        Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in
                                        faucibus.</p>

                                    <span class="text-black-800 mr-3 font-weight-600">April 18, 2020 at 6.25 pm</span>
                                    <a class="text-primary font-weight-600" href="#!">Reply</a>
                                </div>
                            </div>
                            <div class="media d-block d-sm-flex">
                                <div class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                                    <img class="mr-3" src="images/post/arrow.png" alt="">
                                    <a href="#!"><img src="images/post/user-02.jpg" class="mr-3 rounded-circle"
                                            alt=""></a>
                                </div>
                                <div class="media-body">
                                    <a href="#!" class="h4 d-inline-block mb-3">Nadia Sultana Tisa</a>

                                    <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                                        sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                                        Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in
                                        faucibus.</p>

                                    <span class="text-black-800 mr-3 font-weight-600">April 18, 2020 at 6.25 pm</span>
                                    <a class="text-primary font-weight-600" href="#!">Reply</a>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="mb-4">Leave a Reply</h3>
                            <form method="POST">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control shadow-none" name="comment" rows="7" required></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input class="form-control shadow-none" type="text" placeholder="Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input class="form-control shadow-none" type="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input class="form-control shadow-none" type="url" placeholder="Website">
                                        <p class="font-weight-bold valid-feedback">OK! You can skip this field.</p>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Comment Now</button>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
    </div>
@endsection

