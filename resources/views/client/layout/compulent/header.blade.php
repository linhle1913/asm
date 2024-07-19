<div class="container">
    <nav class="navbar navbar-expand-lg navbar-white">
        <a class="navbar-brand order-1" href="{{ route('home') }}">
            <img class="img-fluid" width="100px" src="/theme/images/logo.png" alt="Reader | Hugo Personal Blog Template">
        </a>
        <div class="collapse navbar-collapse text-center order-lg-2 order-3" id="navigation">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route('home') }}" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Trang chủ
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Bài viết
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Liên hệ</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="shop.html">Về chúng tôi</a>
                </li>
            </ul>
        </div>

        <div class="order-2 order-lg-3 d-flex align-items-center">
            <!-- search -->
            <form class="search-bar">
                <input id="search-query" name="s" type="search" placeholder="Type &amp; Hit Enter...">
            </form>

            <button class="navbar-toggler border-0 order-1" type="button" data-toggle="collapse"
                data-target="#navigation">
                <i class="ti-menu"></i>
            </button>
            <div>
                @if (Auth::check())
                <a href="{{ route('account.profile') }}" class="btn btn-success">Tài khoản</a>
                <a href="{{ route('account.logout') }}" class="btn btn-light">Đăng xuất</a>
                @else
                <a href="{{ Route('account.login') }}" class="btn btn-success">Đăng nhập</a>
                <a href="{{ route('account.register') }}" class="btn btn-light">Đăng kí</a>
                @endif
            </div>
        </div>

    </nav>
</div>
