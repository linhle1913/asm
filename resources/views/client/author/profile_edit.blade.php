@extends('client.author.layout.master')

@section('title')
    Danh sách bài viết
@endsection

@section('content')
    <div class="card border-0 shadow">
        <div class="card-header  text-white">
            Thông tin người dùng
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success">
                <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">
                <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
            </div>
        @endif
        <form action="{{ route('author.processEditProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row gy-3 overflow-hidden">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="name" id="name" placeholder="Tên của bạn" value="{{ $user->name }}">
                        <label for="name" class="form-label">Tên</label>
                        @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('short_des') is-invalid @enderror" name="short_des" id="short_des" value="" placeholder="Mô tả ngắn về bạn" value="{{ $user->short_des }}">
                        <label for="short_des" class="form-label">Mô tả ngắn về bạn</label>
                        @error('short_des')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Image" class="form-label">Ảnh đại diện</label>
                    <input type="file" class="form-control" name="image" id="image" />
                    <img src="/uploads/avatar/{{ $user->image }}" class="img-fluid rounded-circle">
                </div>
                <div class="col-12">
                    <div class="d-grid">
                        <button class="btn bsb-btn-xl btn-primary py-3" type="submit">Sửa</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

