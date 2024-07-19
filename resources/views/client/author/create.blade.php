@extends('client.author.layout.master')

@section('title')
    Danh sách bài viết
@endsection

@section('content')
    <div class="card border-0 shadow">
        <div class="card-header  text-white">
            Thêm bài viết
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success">
                <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('author.store') }}" id="postForm" name="postForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Tiêu đề"
                        name="title" id="title" value="{{ old('title') }}" />
                    @error('title')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="Image" class="form-label">Thumbnail</label>
                    <input type="file" class="form-control" name="thumbnail" id="thumbnail" />
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Nội dung</label>
                    <textarea name="content" id="summernote" class="form-control @error('content') is-invalid @enderror"
                        placeholder="Description" cols="30" rows="5">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tag" class="form-label">Thẻ</label>
                    <br>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Thêm thẻ mới
                    </button>
                    <select class="form-select @error('tag') is-invalid @enderror" id="multiple-select-field"
                        data-placeholder="Choose anything" multiple name="tag[]">
                        @foreach ($tag as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    @error('tag')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                    <div class="mb-3">
                        <button class="btn btn-primary mt-2" type="submit">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm thẻ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tagForm" name="tagForm">
                        @csrf
                        <label for="name">Thêm thẻ mới</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Tên thẻ">
                        <p></p>
                        <button class="btn btn-primary mt-2" type="submit">Thêm thẻ mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#tagForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('author.tag.store') }}',
                type: 'post',
                dataType: 'json',
                data: $("#tagForm").serializeArray(),
                success: function(response) {
                    if (response.status == true) {
                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').
                        html('')
                        window.location.href = "{{ route('author.create') }}"
                    } else {
                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').
                            html(errors.name)
                        } else {
                            $("#name").removeClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').
                            html()
                        }
                    }
                }
            })
        })
    </script>
@endsection
