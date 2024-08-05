@extends('admin.layout.master')

@section('title')
    Danh sách thẻ chờ duyệt
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
            <table class="table  table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Tên thẻ</th>
                        <th width="150">Action</th>
                    </tr>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td>
                                <form action="{{ route('admin.updateTag') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $tag->id }}">
                                    <select name="is_active" id="">
                                        <option value="0" @if ($tag->is_active == 0) selected @endif>Chưa duyệt
                                        </option>
                                        <option value="1" @if ($tag->is_active == 1) selected @endif>Đã duyệt
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
            {{ $tags->links() }}
        </div>

    </div>
@endsection
