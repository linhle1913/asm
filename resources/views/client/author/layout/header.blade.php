<div class="container">
    <div class="d-flex justify-content-between">
        <h1 class="text-center"><a href="{{ route('home') }}" class="h3 text-white text-decoration-none">Reader</a></h1>
        <div class="d-flex align-items-center navigation">
            @if (Auth::check())

            @else
            <a href="{{ Route('account.login') }}" class="text-white">Đăng nhập</a>
            <a href="{{ Route('account.register') }}" class="text-white ps-2">Đăng kí</a>
            @endif
        </div>
    </div>
</div>
