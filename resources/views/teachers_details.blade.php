<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />
    <title>DuyBao English Center</title>
    <link rel="shortcut icon" href="images/icon_title.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

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
                    <li class="flex items-center">
                        <a class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" 
                        href="{{ route('posts') }}">
                            <i class="lg:text-gray-300 text-gray-500 far fa-file-alt text-lg leading-lg mr-2">
                            </i>
                            Posts
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
    <main class="profile-page">
        <section class="relative block" style="height: 500px;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1499336315816-097655dcfbda?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2710&amp;q=80");'>
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
                                <div class="relative">
                                    <img src="{{ asset('images/avatars/'.$teacherDetails->avatar) }}" alt="{{ $teacherDetails->avatar }}" class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16" style="max-width: 150px;" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-28">
                            <h3 class="text-4xl font-semibold leading-normal mb-2 text-gray-800">
                                {{ $teacherDetails->level }}. {{ $teacherDetails->name }}
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-gray-500 font-bold uppercase">
                                <i class="fas fa-map-marker-alt mr-2 text-lg text-gray-500"></i>
                                {{ $teacherDetails->address }}
                            </div>
                            <div class="mb-2 text-gray-700 mt-10">
                                <i class="fas fa-briefcase mr-2 text-lg text-gray-500"></i>Teaching experience: {{ $teacherDetails->experience }} years
                            </div>
                            <div class="mb-2 text-gray-700">
                                <i class="fas fa-paper-plane mr-2 text-lg text-gray-500"></i>Email: {{ $teacherDetails->email }}
                            </div>
                        </div>
                        <div class="mt-10 py-10 border-t border-gray-300 text-center">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-9/12 px-4">
                                    <p class="mb-4 text-lg leading-relaxed text-gray-800">
                                        Nghề dạy học là một nghề tôn quý và trách nhiệm, trong đó giáo viên đóng vai trò quan 
                                        trọng trong việc hướng dẫn và truyền đạt kiến thức cho học sinh. Họ không chỉ là 
                                        người truyền đạt kiến thức mà còn là nguồn động viên, nguồn cảm hứng cho sự phát triển 
                                        của thế hệ trẻ. Giáo viên giúp học sinh khám phá và phát triển tiềm năng của họ, đồng thời 
                                        xây dựng nền tảng cho tương lai của xã hội thông qua việc giáo dục và hướng dẫn.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
        <i class="fas fa-arrow-up"></i>
    </button>
</body>

</html>