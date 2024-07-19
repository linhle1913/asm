<div class="col-md-3">
    <div class="card border-0 shadow-lg">
        <div class="card-header  text-white">
            Chào mừng, {{ Auth::user()->name }}
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <img src="images/profile-img-1.jpg" class="img-fluid rounded-circle" alt="Luna John">
            </div>
            <div class="h5 text-center">
                <strong>{{ Auth::user()->name }}</strong>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-lg mt-3">
        <div class="card-body sidebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="book-listing.html">Danh sách bài viết</a>
                </li>
                <li class="nav-item">
                    <a href="reviews.html">Thẻ</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}">Về lại trang người đọc</a>
                </li>
            </ul>
        </div>
    </div>
</div>
