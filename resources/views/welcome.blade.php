<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fafad05c14.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="jumbotron text-center bg-light jumbotron-fluid">
    <div class="container">
        <h2 class="text-primary"><i class="fas fa-industry"></i> mrpbase</h2>
        <h1 class="display-4">{{ __('Take Control of Your Manufacturing') }}</h1>
        <p class="lead">{{ __('The simplest, yet smartest, self-service manufacturing software for your business.') }}</p>
        @guest
        <div>
            <button class="btn btn-primary btn-lg px-3 my-2" onclick="location.href='{{ url('register') }}'">{{ __('Register') }}</button>
            <button class="btn btn-seconday btn-lg px-3 my-2" onclick="location.href='{{ url('login') }}'">{{ __('Login') }}</button>
        </div>
        @endguest
        @auth
        <div>
            <button class="btn btn-primary btn-lg px-3 my-2" onclick="location.href='{{ url('home') }}'">{{ __('Enter Here') }}</button>
        </div>
        @endauth
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <i class="fas fa-list text-light"></i>
                    <h3 class="text-light pt-3">{{ __('Control your orders') }}</h3>
                    <p class="text-light">{{ __('Improve customer satisfaction, shorten lead times and ship promptly.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <i class="fas fa-users text-light"></i>
                    <h3 class="text-light pt-3">{{ __('Manage your clients') }}</h3>
                    <p class="text-light">{{ __('Manage your contacts easily, No more spreadsheets!') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <i class="fas fa-box text-light"></i>
                    <h3 class="text-light pt-3">{{ __('Plan your productions') }}</h3>
                    <p class="text-light">{{ __('Benefit from accurate automatic planning and a realistic production schedule.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="row justify-content-center my-5 py-5">
    2020 - mrpbase
</div<
</footer>


</body>
</html>
