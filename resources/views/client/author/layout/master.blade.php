<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @include('client.author.layout.css')
</head>

<body>
    <div class="container-fluid shadow-lg header">
        <div class="container">
            @include('client.author.layout.header')
        </div>
    </div>

    <div class="container">
        <div class="row my-5">
            @include('client.author.layout.sidebar')
            <div class="col-md-9">

                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Nội dung',
                tabsize: 2,
                height: 500
            });
        });
    </script>
    @yield('script')
</body>

</html>
