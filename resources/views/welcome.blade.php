<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="shortcut icon" href="./assets/img/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />
    <title>DuyBao English Center</title>
    <link rel="shortcut icon" href="images/icon_title.png">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

</head>

<body class="text-gray-800 antialiased">
    <nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 ">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none hidden" id="example-collapse-navbar">
                <ul class="flex flex-col lg:flex-row list-none mr-auto">
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
    <main>
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                        <div class="pr-12">
                            <h1 class="text-white font-semibold text-5xl">
                                Welcome to</br>
                                DB English center!
                            </h1>
                            <p class="mt-8 text-lg text-gray-300">
                                Comprehensive curriculum that equally develops all four skills of
                                </br>Listening - Speaking - Reading - Writing, including courses on TOEIC and IELTS.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <section class="pb-20 bg-gray-300 -mt-24">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap">
                    <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-red-400">
                                    <i class="fas fa-award"></i>
                                </div>
                                <h6 class="text-xl font-semibold">Giá trị cốt lõi</h6>
                                <p class="mt-2 mb-4 text-gray-600">
                                    Ở DBEC luôn đề cao 5 giá trị gồm: Trách nhiệm & đam mê, Toàn diện, Nhân văn, Tiên phong, Vì cộng đồng...
                                </p>
                                <a href="{{ route('posts-details', 8) }}" class="hover:text-red-500">
                                    <p>Xem thêm</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 px-4 text-center">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-blue-400">
                                    <i class="fas fa-retweet"></i>
                                </div>
                                <h6 class="text-xl font-semibold">Hệ thống cơ sở</h6>
                                <p class="mt-2 mb-4 text-gray-600">
                                    Cơ sở vật chất tại DBEC được lắp đặt đầy đủ và thường xuyên được bảo trì, mang đến cho người dạy và người học cảm giác thoải mái và an toàn...
                                </p>
                                <a href="{{ route('posts-details', 9) }}" class="hover:text-red-500">
                                    <p>Xem thêm</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6 w-full md:w-4/12 px-4 text-center">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-green-400">
                                    <i class="fas fa-fingerprint"></i>
                                </div>
                                <h6 class="text-xl font-semibold">Vì sao nên chọn DBEC</h6>
                                <p class="mt-2 mb-4 text-gray-600">
                                    DBEC là nơi đào tạo các lộ trình tiếng anh từ cơ bản đến nâng cao với giá thành hợp lí nhất...
                                </p>
                                <a href="{{ route('posts-details', 10) }}" class="hover:text-red-500">
                                    <p>Xem thêm</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mt-20">
                    <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
                        <h3 class="text-3xl mb-2 font-semibold leading-normal">
                            {{ $post11->title }}
                        </h3>
                        <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700">
                            {!! $post11->content !!}
                        </p>
                    </div>
                    <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-pink-600">
                            <img src="{{ asset('images/posts/'.$post11->picture) }}" alt="{{ $post11->picture }}" class="w-full align-middle rounded-t-lg" />
                            <blockquote class="relative p-8 mb-4">
                                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 583 95" class="absolute left-0 w-full block" style="height: 95px; top: -94px;">
                                    <polygon points="-30,95 583,95 583,65" class="text-pink-600 fill-current"></polygon>
                                </svg>
                                <h4 class="text-xl font-bold text-white">
                                    Toàn diện và Phát triển
                                </h4>
                                <p class="text-md font-light mt-2 text-white">
                                    Toàn diện trong đào tạo liên thông từ tiếng Anh trẻ em đến chuẩn đầu ra IELTS quốc tế
                                </p>
                            </blockquote>
                        </div>
                    </div>
                    <div class="w-full md:w-5/12 px-4 mr-auto ml-auto mt-16">
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-pink-600">
                            <img src="{{ asset('images/posts/'.$post12->picture) }}" alt="{{ $post12->picture }}" class="w-full align-middle rounded-t-lg" />
                            <blockquote class="relative p-8 mb-4">
                                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 583 95" class="absolute left-0 w-full block" style="height: 95px; top: -94px;">
                                    <polygon points="-30,95 583,95 583,65" class="text-pink-600 fill-current"></polygon>
                                </svg>
                                <h4 class="text-xl font-bold text-white">
                                    Tiên phong
                                </h4>
                                <p class="text-md font-light mt-2 text-white">
                                    Tiên phong trong đào tạo giáo viên và xây dựng môi trường sinh hoạt chuyên môn
                                </p>
                            </blockquote>
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                        <h3 class="text-3xl mb-2 font-semibold leading-normal">
                            {{ $post12->title }}
                        </h3>
                        <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700">
                            {!! $post12->content !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-20 pb-48 " id="teachers">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center mb-24">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold">Giảng viên</h2>
                        <p class="text-lg leading-relaxed m-4 text-gray-600">
                            Giảng viên là lực lượng nồng cốt của DBEC, là người chỉ đường dẫn lối cho học viên đến với thành công.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap mt-24 justify-center">
                    @foreach($teachers as $t)
                        <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                            <a href="{{ route('teachers-details', $t->id) }}">
                                <div class="px-6">
                                    <img src="{{ asset('images/avatars/'.$t->avatar) }}" alt="{{ $t->avatar }}" class="transform transition-transform duration-400 hover:scale-125 shadow-lg rounded-full max-w-full mx-auto" style="max-width: 120px;" />
                                    <div class="pt-6 text-center">
                                        <h5 class="text-xl font-bold">{{ $t->level }}. {{ $t->name }}</h5>
                                        <p class="mt-1 text-sm text-gray-500 font-semibold">
                                            Kinh nghiệm giảng dạy: {{ $t->experience }} năm
                                        </p>
                                        <div class="mt-6">
                                            <button href="{{ route('teachers-details', $t->id) }}" class="bg-blue-400 hover:bg-blue-600 text-white rounded-xl outline-none focus:outline-none mr-1 mb-1 px-2 py-2" type="button">
                                                Show More
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="text-white justify-center flex flex-wrap">
                {{ $teachers->appends(['teachers' => request('teachers', 1)])->fragment('teachers')->links() }}
            </div>
        </section>
        <section class="pb-20 relative block bg-gray-900">
            <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20" style="height: 80px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-900 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4 lg:pt-24 lg:pb-64">
                <div class="flex flex-wrap text-center justify-center">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold text-white">Posts of DuyBao English Center</h2>
                        <h4 class = "text-xl text-white mt-4">This is the place to update the latest news from DBEC</h4>
                    </div>
                </div>
                <div class="flex flex-wrap mt-24 justify-center">
                    <div class="flex-wrap grid grid-cols-3 gap-4 text-white">
                        @foreach($posts as $post)
                            <div class="col-span-3 sm:col-span-1 mt-8">
                                <a href="{{ route('posts-details', $post->id) }}">
                                    <div class="px-6">
                                        <img src="{{ asset('images/posts/'.$post->picture) }}" alt="{{ $post->picture }}" class="transform transition-transform duration-400 hover:scale-125 shadow-lg mx-auto max-h-72" />
                                        <div class="pt-6 text-center ">
                                            <i class="fas fa-calendar mr-2 mb-4"></i>
                                                {{ \Carbon\Carbon::parse($post->updated_at)->format('d-m-Y') }}
                                            <h5 class="text-xl font-bold">{{ $post->title }}</h5>
                                            <p class="mt-1 text-sm uppercase font-semibold">
                                                <a class="hover:text-red-500" href="{{ route('posts-details', $post->id) }}">Xem thêm</a>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
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
        <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
            <i class="fas fa-arrow-up"></i>
        </button>

    </footer>

    <script>
        window.onload = function() {
            if (window.location.hash) {
                var hash = window.location.hash;
                document.querySelector(hash).scrollIntoView();
            }
        }
    </script>
</body>

</html>
