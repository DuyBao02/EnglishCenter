<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <link rel="shortcut icon" href="./assets/img/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/creativetimofficial/tailwind-starter-kit/compiled-tailwind.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <title>Management system</title>
    <link rel="shortcut icon" href="images/icon_title.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="text-gray-800 antialiased">
    <main>
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 73vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black">
                </span>
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
                            <a type="button" class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 w-1/2 py-2 mt-8 text-white bg-emerald-600 hover:bg-emerald-800 rounded-lg" href="{{URL::to('login')}}"><i class="fas fa-sign-in-alt mr-2"></i>
                                L O G I N
                            </a>
                            <a type="button" class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 w-1/2 px-18 py-2 mt-4 text-white bg-pink-500 rounded-lg hover:bg-pink-700" href="{{URL::to('register-admin')}}"><i class="fas fa-user-plus mr-2"></i>
                                Admin Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
    </main>
    <footer class="relative bg-gray-300 py-10">
        <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20" style="height: 80px">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
        <div class="container mx-auto px-8">
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
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="flex flex-wrap items-top mb-6">
                        <div class="w-full lg:w-6/12 px-4 ml-auto">
                            <a href="https://github.com/ngduybao2002/nlcsn_laravel.git" class="bg-white text-gray-900 shadow-lg font-normal h-13 w-13 items-center justify-center align-center rounded-full outline-none focus:outline-none p-6" type="button">
                                <i class="flex fab fa-github justify-center"></i>Github
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
