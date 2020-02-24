<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Maroc-NST') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                
            }

           

            .m-b-md {
                margin-bottom: 30px;
            }

            .zoom{
                float:left;
                display:inline-block;
               
                transition: transform .2s;
                padding: 0 50px;
             
                    font-weight: 600;
                    letter-spacing: .1rem;
                    text-decoration: none;
                    text-transform: uppercase;

                    -webkit-transition: all .2s ease-in-out;
                  transition: all .2s ease-in-out;
               
               
                }

              
                    .zoom:hover {
                    -webkit-transform: scale(1.4);
                            transform: scale(1.4);
                    }

                    a {
                            background-color: red;
                        box-shadow: 0 5px 0 darkred;
                        color: white;
                        padding: 1em 1.5em;
                        position: relative;
                        text-decoration: none;
                        text-transform: uppercase;
                        }

                        a:hover {
                        background-color: #ce0606;
                        cursor: pointer;
                        }

                        a:active {
                        box-shadow: none;
                        top: 5px;
                        }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->

            <div class="content">
                <div class="title m-b-md" style="margin-bottom: 20%">
                {{ config('app.name', 'Maroc-NST') }}
                </div>

                    
                <div class="zoom" >
                    <a href="/client-home"  >Je suis un Client</a>
                </div>
                <div class="zoom" >
                    <a href="/nst-home"  >Je suis un Staff</a>
                </div>
            </div>
        </div>
    </body>
</html>
