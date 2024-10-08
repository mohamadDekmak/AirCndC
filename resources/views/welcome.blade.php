<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')

    <title>Document</title>
</head>
<body class="mx-5">
<div class="flex justify-center">
    <img  class="w-[135px]" src="/assets/logo1.png" alt="">
    <img class="object-contain w-[200px]" src="/assets/logo2.jpg" alt="">
</div>
@include('partials/lang_switch')
@yield('body')
<style>
    input{
        outline: none;
        padding: 0 10px;
    }
</style>
</body>
</html>
