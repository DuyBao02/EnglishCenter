<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />
    <title>DuyBao English Center</title>
    <link rel="shortcut icon" href="images/icon_title.png">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

@if (Session::has('success'))
<script>
    window.onload = function() {
        swal('Success', '{{ Session::get('success') }}', 'success', {
                button: true
                , button: 'OK'
                , timer: 5000
            , });
    }

</script>
@endif

@if (Session::has('error'))
<script>
    window.onload = function() {
        swal('Error', '{{ Session::get('error') }}', 'error', {
                button: true
                , button: 'OK'
                , timer: 5000
            , });
    }

</script>
@endif

<body class="text-gray-800 antialiased">
    <nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 ">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none hidden" id="example-collapse-navbar">
                <ul class="flex flex-col lg:flex-row list-none mr-auto">
                    <li class="flex items-center">
                        <a class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" 
                        href=" {{ route('welcome') }} ">
                            <i class="fas fa-home lg:text-gray-300 text-gray-500 text-lg leading-lg mr-2"></i>
                            Home Page
                        </a>
                    </li>
                    <li class="flex items-center">
                        <a class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" 
                        href=" {{ route('management-system') }} ">
                            <i class="fas fa-university lg:text-gray-300 text-gray-500 text-lg leading-lg mr-2"></i>
                            Management System
                        </a>
                    </li>
                </ul>
                <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
                    @if(Auth::check())
                    <li class="flex items-center">
                        <form method="POST" action="{{ route('logout-homepage') }}">
                            @csrf
                            <a class="bg-white hover:bg-emerald-300 text-gray-800 active:bg-gray-100 transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3" type="button" style="transition: all 0.15s ease 0s;" :href="route('logout-homepage')" onclick="event.preventDefault();
                                          this.closest('form').submit();">
                                <i class="fas fa-sign-in-alt mr-2"></i>Hi, {{ Auth::user()->name }}
                            </a>
                        </form>
                    </li>
                    @else
                    <li class="flex items-center">
                        <a class="bg-white hover:bg-emerald-300 text-gray-800 active:bg-gray-100 transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3" type="button" style="transition: all 0.15s ease 0s;" href="{{URL::to('login')}}">
                            <i class="fas fa-sign-in-alt mr-2"></i> L O G I N
                        </a>
                    </li>
                    <li class="flex items-center">
                        <a class="bg-white hover:bg-red-300 text-gray-800 active:bg-gray-100 transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3" type="button" style="transition: all 0.15s ease 0s;" href="{{URL::to('register')}}">
                            <i class="fas fa-user-plus mr-2"></i> R E G I S T E R
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 50vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                        <div class="pr-12">
                            <h1 class="text-white font-semibold text-5xl">
                                Posts!
                            </h1>
                            <div class="mt-8 text-gray-300 text-xl">
                                This is the place to update the latest news from DBEC
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-white fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        
        <section class="pt-20 pb-48">
            <div class="container mx-auto px-4">
                <div class="flex-wrap mt-24 grid grid-cols-3 gap-4">
                    @foreach($posts as $p) 
                        
                        <div class="col-span-3 sm:col-span-1">
                            <a href="{{ route('posts-details', $p->id) }}">
                                <div class="px-6">
                                    <img src="{{ asset('images/posts/'.$p->picture) }}" alt="{{ $p->picture }}" class="transform transition-transform duration-400 hover:scale-125 shadow-lg mx-auto max-h-72" />
                                    <div class="pt-6 text-center">
                                        <i class="fas fa-calendar mr-2 mb-4"></i>
                                            {{ \Carbon\Carbon::parse($p->updated_at)->format('d-m-Y') }}
                                        <h5 class="text-xl font-bold">{{ $p->title }}</h5>
                                        <p class="mt-1 text-sm text-gray-500 uppercase font-semibold">
                                            <a class="hover:text-red-500" href="{{ route('posts-details', $p->id) }}">Xem thêm</a>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                    @endforeach
                </div>
            </div>
        </section>
        
    </main>
    <footer class="relative bg-gray-300 pt-8 pb-6">
        <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20" style="height: 80px;">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <div class="w-full lg:w-6/12 px-4">
                    <h4 class="text-3xl font-semibold">Let's keep in touch!</h4>
                    <h5 class="text-lg mt-0 mb-2 text-gray-700">
                        Please contact us if you have a problem, we will respond as soon as possible.
                    </h5>
                    <div class="mt-6 content-left items-left justify-center">
                        <i class="fas fa-envelope"></i> dbec@gmail.com
                        <span class="jax-header-seperator mr-4"></span>
                        <i class="fas fa-clock"></i> 7:30 - 20:30
                        <span class="jax-header-seperator mr-4"></span>
                        <i class="fas fa-phone"></i> (0123) 4 567 789 - 0932 941 222
                    </div>
                    <div class="mt-6">
                        <button class="bg-white text-blue-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3" type="button">
                            <i class="flex fab fa-twitter"></i></button><button class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3" type="button">
                            <i class="flex fab fa-facebook-square"></i></button><button class="bg-white text-pink-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3" type="button">
                            <i class="flex fab fa-dribbble"></i></button><a class="bg-white text-gray-900 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2 p-3" type="button" href="https://github.com/ngduybao2002/nlcsn_laravel.git">
                            <i class="flex fab fa-github"></i>
                        </a>
                    </div>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="flex flex-wrap items-top mb-6">
                        <div class="w-full lg:w-4/12 px-4 ml-auto">
                            <span class="block uppercase text-gray-600 text-sm font-semibold mb-2">Useful Links</span>
                            <ul class="list-unstyled">
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">About Us</a>
                                </li>
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">Blog</a>
                                </li>
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">Github</a>
                                </li>
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">Free Products</a>
                                </li>
                            </ul>
                        </div>
                        <div class="w-full lg:w-4/12 px-4">
                            <span class="block uppercase text-gray-600 text-sm font-semibold mb-2">Other Resources</span>
                            <ul class="list-unstyled">
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">MIT License</a>
                                </li>
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">Terms &amp; Conditions</a>
                                </li>
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">Privacy Policy</a>
                                </li>
                                <li>
                                    <a class="text-gray-700 hover:text-gray-900 font-semibold block pb-2 text-sm" href="">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-400" />
        </div>
    </footer>
</body>

<button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
    <i class="fas fa-arrow-up"></i>
</button>

</html>
