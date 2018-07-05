<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="application-name" content="Vuesume">
    <meta name="description" content="Vuesume - Dynamic Curriculum Vitae">
    <meta name="keywords" content="Vuesume,Vue,CV,Resume">
    <meta name="author" content="Dennis Russell">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vuesume</title>

    <link rel="manifest" href="{{ asset('js/manifest.json') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Vuesume">
    <meta name="theme-color" content="#3273dc">
    <meta name="msapplication-navbutton-color" content="#3273dc">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bulma.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&amp;subset=latin-ext" rel="stylesheet"> 
  </head>
  <body>
    <!-- <noscript>
      <p>Javascript is required to use this application.<p>
      <p>Please consider enabling Javascript or switching browsers.<p>
    </noscript> -->
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
<script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>