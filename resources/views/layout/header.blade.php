<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @yield("meta")
        <title>@yield("title")</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="{{asset("css/semantic.min.css")}}">
        <!-- Js -->
        <script src="{{asset("js/jquery.min.js")}}"></script>
        <script src="{{asset("js/semantic.min.js")}}"></script>
        @yield("top_include")
        <style>
          body{
            background: #EEEEEE;
          }
        </style>
    </head>
    <body>
