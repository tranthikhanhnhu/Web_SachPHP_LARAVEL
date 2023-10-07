<!DOCTYPE html>
<html dir="ltr" lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Smart BookStore</title>
    <base />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('client/js/jquery/jquery-2.1.1.min.js')}}"></script>
    <link href="{{asset('client/css/font-awesome/client/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('client/css/fonts.googleapis.com/css6641.css')}}?family=PT+Serif:400,400i" rel="stylesheet">
    <link href="{{asset('client/css/fonts.googleapis.com/css79d8.css')}}?family=Oswald:400,700" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{asset('client/css/caprica/carousel.css')}}" />
    <link rel="stylesheet" type="textv/css" href="{{asset('client/css/caprica/custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/css/caprica/lightbox.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/css/caprica/animate.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/css/caprica/search_suggestion.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/js/jquery/magnific/magnific-popup.css')}}" />
    <link href="{{asset('client/css/stylesheet.css')}}" rel="stylesheet">
    
    
    
    <link href="{{asset('client/js/jquery/magnific/magnific-popup.css')}}" type="text/css" rel="stylesheet" media="screen" />
    <link href="{{asset('client/js/search_suggestion/jquery-ui.html')}}" type="text/css" rel="stylesheet" media="screen" />


    <link rel="stylesheet" type="text/css" href="{{asset('client/theme/OPC010003_01/stylesheet/caprica/carousel.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/theme/OPC010003_01/stylesheet/caprica/custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/theme/OPC010003_01/stylesheet/caprica/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/theme/OPC010003_01/stylesheet/caprica/lightbox.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/theme/OPC010003_01/stylesheet/caprica/animate.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/theme/OPC010003_01/stylesheet/caprica/search_suggestion.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('client/javascript/jquery/magnific/magnific-popup.css')}}" />



    <!-- Caprica Start -->
    <script src="{{asset('client/js/caprica/custom.js')}}"></script>
    <script src="{{asset('client/js/caprica/jstree.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/carousel.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/caprica.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/jquery.custom.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/jquery.formalize.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/jquery.elevatezoom.min.js')}}"></script>
    <script src="{{asset('client/js/lightbox/lightbox-2.6.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/tabs.js')}}"></script>
    <script src="{{asset('client/js/caprica/jquery.bxslider.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('client/js/caprica/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('client/js/caprica/doubletaptogo.js')}}"></script>
    <script src="{{asset('client/js/caprica/parallex.js')}}"></script>
    <script src="{{asset('client/js/jquery/magnific/jquery.magnific-popup.min.js')}}"></script>
    <!-- Caprica End -->
    
    <script src="{{asset('client/js/common.js')}}"></script>
    <link rel="icon" href="{{asset('client/image/catalog/cart.png')}}"/>
    
    <script src="{{asset('client/js/jquery/magnific/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('client/js/jquery/datetimepicker/moment.js')}}"></script>
    <script src="{{asset('client/js/jquery/datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('client/js/search_suggestion/search_suggestion.html')}}"></script>
    <script src="{{asset('client/js/search_suggestion/jquery-ui-2.html')}}"></script>
    <link href="{{asset('fontawesome/css/all.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('client/css/index.css')}}" />


    <!-- Jquery ui -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>


<body @yield('body-class')>

    @include('client.pages.header')

    
    @yield('content')


    @include('client.pages.footer')


    <script src="{{asset('client/js/index.js')}}"></script>

    <!-- Jquery ui -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('custom-js')

</body>

</html>
