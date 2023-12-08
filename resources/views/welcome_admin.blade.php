<!DOCTYPE html>
<html>

@include('components.header-homepage')

<body class="text-gray-800 antialiased">
    {{-- @include('components.nav-homepage') --}}
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
            {{-- <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div> --}}
        </div>
    </main>

    {{-- @include('components.footer-homepage') --}}

</body>
</html>
