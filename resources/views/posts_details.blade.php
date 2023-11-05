<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />

    <title>DuyBao English Center</title>
    <link rel="shortcut icon" href="images/icon_title.png">
</head>

<body class="text-gray-800 antialiased">
    <nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 ">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none hidden" id="example-collapse-navbar">
                <ul class="flex flex-col lg:flex-row list-none mr-auto">
                    <li class="flex items-center">
                        <a href="{{ route('welcome') }}"><img src="images/dbec.png" alt="" class="h-14 rounded-full"></a>
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
    <main >
        <section class="relative block" style="height: 400px;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover bg-gray-300">
                <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </section>
        <section class="relative py-16 bg-gray-300">
            <div class="container mx-auto px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
                                <div class="relative pb-20">
                                    <img src="{{ asset('images/posts/'.$postDetails->picture) }}" alt="{{ $postDetails->picture }}" class="-m-16 mx-auto" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-12">
                            <h3 class="text-4xl font-semibold leading-normal mb-2 text-gray-800">
                                {{ ($postDetails->title) }}
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold uppercase">
                                <i class="fas fa-calendar mr-2 text-lg text-gray-500"></i>
                                {{ \Carbon\Carbon::parse($postDetails->updated_at)->format('d-m-Y') }}
                            </div>
                            <div class="mb-2 text-gray-700">
                                Posted by: {{ ($postDetails->user->name) }}
                            </div>
                        </div>
                        <div class="mt-10 py-10 border-t border-gray-300 text-left">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-9/12 px-4">
                                    <div class="mb-4 leading-relaxed text-gray-800">
                                        {!! $postDetails->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                Bài viết liên quan: 
            </div>
        </div>
        <hr class="my-6 border-gray-400" />
    </footer>

</body>

</html>