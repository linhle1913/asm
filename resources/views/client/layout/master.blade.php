<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    @include('client.layout.compulent.head')
</head>

<body>
    <!-- navigation -->
    <header class="navigation fixed-top">
        @include('client.layout.compulent.header')
    </header>
    <!-- /navigation -->

    @yield('content')

    <footer class="footer">
        @include('client.layout.compulent.footer')
    </footer>

    @include('client.layout.compulent.js')
</body>

</html>
