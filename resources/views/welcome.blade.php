<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Vue Router Message Example From Scratch - ItSolutionStuff.com</title>
        <link href="css/app.css" rel="stylesheet" type="text/css">
        <script src="https://kit.fontawesome.com/fb57c0e906.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-3">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul v-if="isLogged" class="navbar-nav ml-auto">
                        <router-link :to="{name: 'StudentZone'}" tag="button" class="btn btn-primary">Student Zone</router-link>
                        <router-link :to="{name: 'TeacherZone'}" tag="button" class="btn btn-primary ml-1">Teacher Zone</router-link>
                        <router-link :to="{name: 'LeaderZone'}" tag="button" class="btn btn-primary ml-1">Leader Zone</router-link>
                        <li><button @click="logout" class="btn btn-light ml-1">Logout</button></li>
                    </ul>

                     <ul v-if="!isLogged" class="navbar-nav ml-auto">
                        <router-link :to="{name: 'Register'}" tag="button" class="btn btn-primary">Register</router-link>
                        <router-link :to="{name: 'Login'}" tag="button" class="btn btn-primary ml-1">Login</router-link>
                    </ul>
                </div>
            </div>
            </nav>
            <router-view></router-view>
        </div>
        <script src="js/app.js" ></script>
    </body>
</html>
