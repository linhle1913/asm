@extends('client.author.layout.master')

@section('title')
    Danh sách bài viết
@endsection

@section('content')
    <div class="card border-0 shadow">
        <div class="card-header  text-white">
            Bài viết
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
        <div class="card-body pb-0">
            <a href="{{ route('author.create') }}" class="btn btn-primary">Thêm bài viết</a>
            <table class="table  table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Trạng thái</th>
                        <th width="150">Action</th>
                    </tr>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>
                                @if ($post->is_active == 0)
                                    Chờ phê duyệt
                                @else
                                    Đã được đăng tải
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('author.edit', $post->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="#" onclick="event.preventDefault(); deletePost({{ $post->id }});"
                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
        </div>

    </div>
@endsection
@section('script')
    <script>
        function deletePost(postId) {
            if (confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
                fetch(`post/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: data.message,
                            }).then(() => {
                                location.reload();
                            });
                        }
                    })
            }
        }
    </script>
@endsection
