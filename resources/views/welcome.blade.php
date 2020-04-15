<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Maroc-NST') }}</title>

    <!-- Fonts -->

    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('old_nst/css/reset.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('old_nst/css/style.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('old_nst/css/grid_12.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('old_nst/css/slider.css') }}">
    <link href='http://fonts.googleapis.com/css?family=Condiment' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
    <script src="{{ asset('old_nst/js/jquery-1.7.min.js') }}"></script>
    <script src="{{ asset('old_nst/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('old_nst/js/tms-0.4.x.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.slider')._TMS({
                show: 0,
                pauseOnHover: true,
                prevBu: false,
                nextBu: false,
                playBu: false,
                duration: 1000,
                preset: 'fade',
                pagination: true,
                pagNums: false,
                slideshow: 7000,
                numStatus: true,
                banners: 'fromRight',
                waitBannerAnimation: false,
                progressBar: false
            })
        });
    </script>
    <!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
   		<script type="text/javascript" src=""{{ asset('old_nst/js/html5.js') }}"></script>
    	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('old_nst/css/ie.css') }}">
	<![endif]-->


</head>

<body>
    <div class="main">
        <!--==============================header=================================-->
        <header>
            <h1><a href="/"><img src="{{ asset('old_nst/images/logosnt.png') }}" alt=""></a></h1>
            <div class="form-search">
                <form id="form-search" method="post">
                    <input type="text" value="Type here..." onBlur="if(this.value=='') this.value='Type here...'" onFocus="if(this.value =='Type here...' ) this.value=''" />
                    <a href="#" onClick="document.getElementById('form-search').submit()" class="search_button"></a>
                </form>
               
              
                
            </div>
            <br>
            <div class="form-search" style="margin: 0px 10px auto; text-align: center;">
               

                <a href="/client-home" class="button">Espace Client</a>
                <a href="/nst-home" class="button">Espace NST</a>
                
            </div>
            
              
           
            <div class="clear"></div>
            <nav class="box-shadow">
                <div>
                    <ul class="menu">
                        <li class="home-page current"><a href="/"><span></span></a></li>
                        <li><a href="/about">Présentation</a></li>
                        <li><a href="/services">Activités</a></li>
                        <li><a href="/projects">Produits</a></li>
                        <li><a href="/clients">Partenaires</a></li>
                        <li><a href="/contacts">Espace clients</a></li>
                    </ul>
                    <div class="social-icons">
                        <span>Suivez-nous :</span>
                        <a href="#" class="icon-3"></a>
                        <a href="https://web.facebook.com/khalid.hicham.75436" class="icon-2" target="_blank"></a>
                        <a href="https://twitter.com/maroc_nst" class="icon-1" target="_blank"></a>
                    </div>
                    <div class="clear"></div>
                </div>
            </nav>
        </header>
        <!--==============================content================================-->

        @yield('content')
        
    </div>
    <!--==============================footer=================================-->
    <footer>
        <p>Copyright © 2017 - MAROC NST</p>
        <p>Site Web : <a href="http://www.marocnst.ma" target="_blank" rel="nofollow">www.marocnst.ma</a> - @ : <a href="marocnst@gmail.com" target="_blank" rel="nofollow">marocnst@gmail.com</a></p>
        <p>SAV : <a href="http://contact@marocnst.ma" target="_blank" rel="nofollow">contact@marocnst.ma</a></p>
    </footer>
</body>

</html>