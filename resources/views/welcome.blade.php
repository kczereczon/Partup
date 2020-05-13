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
        @if(!empty($auth_user))
        <script>
            window.sessionStorage.authUser = {!! json_encode($auth_user); !!};
        </script>
        @endif
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-3">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                <div v-if="isLogged" class="ml-auto navbar-nav">
                    <li class="nav-item"><router-link :to="{name: 'StudentZone'}" tag="a" :class="['nav-link']">Student Zone</router-link></li>
                    <li class="nav-item"><router-link :to="{name: 'TeacherZone'}" tag="a" :class="['nav-link']">Teacher Zone</router-link></li>
                    <li class="nav-item"><router-link :to="{name: 'LeaderZone'}" tag="a" :class="['nav-link']">Leader Zone</router-link></li>
                    <li class="nav-item"><a href="#" @click="logout" :class="['nav-link']">Logout</a></li>
                </div>
                <div v-if="!isLogged" class="ml-auto navbar-nav">
                    <li class="nav-item"><router-link :to="{name: 'Register'}" tag="a" :class="['nav-link']">Register</router-link></li>
                    <li class="nav-item"><router-link :to="{name: 'Login'}" tag="a" :class="['nav-link', '']">Login</router-link></li>
                </div>
            </div>
            </nav>
            <router-view></router-view>
        </div>
        <script src="js/app.js">
        </script>
    </body>
</html>
