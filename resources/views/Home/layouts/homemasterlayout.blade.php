<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Home - Start Bootstrap Template</title>
        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        {{-- Owl Carousels --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- Another Link of Owl Carousel --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
           {{-- Custom CSS --}}
         <link rel="stylesheet" href="{{asset('css/style.css')}}">
         {{-- Custom CSS end --}}
        <style>
            a{
                color: #1A5319;
            }
        </style>
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A5319;">
            <div class="container">
                <a class="navbar-brand" href="{{route('homepage')}}">Hashim Blogs</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex justify-content-center align-items-center">
                        {{-- @yield('active_home') --}}
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('homepage')}}">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('allblogs')}}">All Blogs</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('bloggers')}}">Bloggers</a></li>
                        @if(Auth::guest())
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('loginPage')}}">Login</a></li>
                        @elseif (Auth::user()->role == 'user')
                            <li class="nav-item">
                                <div class="dropdown">
                                    <button style="border: none;background-color: unset;color: white;" class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                      {{Auth::user()->name}}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="nav-link active text-dark" aria-current="page" href="{{route('logoutUser')}}">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        @yield('header')
        <!-- Page content-->
        @yield('content')
        <!-- Footer-->
        <footer class="py-5" style="background-color: #1A5319;">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>       
    </body>
</html>
