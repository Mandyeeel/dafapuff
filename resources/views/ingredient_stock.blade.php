<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/style.css">
        
    </head>
    <body>
        <div id="app">
          <stock-list
            name="{{ $name }}"
            last_num="{{ $last_num }}"
            unit="{{ $unit }}"
            stocks="{{ $stocks }}"
            ingredient="{{ $ingredient }}"
            brands="{{ $brands }}"
          ></stock-list>
        </div>
    </body>
    <script src="/js/app.js"></script>
</html>