    <nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 ">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
                <button
                    class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
                    type="button" onclick="toggleNavbar('example-collapse-navbar')">
                    <i class="text-white fas fa-bars"></i>
                </button>
            </div>
            <div class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none hidden"
                id="example-collapse-navbar">
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
                    <li class="flex items-center">
                        <a class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold"
                            href="{{ route('contact') }}">
                            <i class="lg:text-gray-300 text-gray-500 fas fa-phone-alt text-lg leading-lg mr-2">
                            </i>
                            Contact us
                        </a>
                    </li>

                    <li class="flex items-center">
                        <a class="lg:text-white lg:hover:text-gray-300 text-gray-800 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold"
                            href="{{ route('current_courses') }}">
                            <i class="lg:text-gray-300 text-gray-500 fas fa-book text-lg leading-lg mr-2">
                            </i>
                            Current courses
                        </a>
                    </li>
                </ul>

                <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
                    @if (Auth::check())
                        <li class="flex items-center">
                            <form method="POST" action="{{ route('logout-homepage') }}">
                                @csrf
                                <a class="bg-white hover:bg-emerald-300 text-gray-800 active:bg-gray-100 transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                    type="button" style="transition: all 0.15s ease 0s;"
                                    :href="route('logout-homepage')"
                                    onclick="event.preventDefault();
                                          this.closest('form').submit();">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Hi, {{ Auth::user()->name }}
                                </a>
                            </form>
                        </li>
                    @else
                        <li class="flex items-center">
                            <a class="bg-white hover:bg-emerald-300 text-gray-800 active:bg-gray-100 transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                type="button" style="transition: all 0.15s ease 0s;" href="{{ URL::to('login') }}">
                                <i class="fas fa-sign-in-alt mr-2"></i> L O G I N
                            </a>
                        </li>
                        <li class="flex items-center">
                            <a class="bg-white hover:bg-red-300 text-gray-800 active:bg-gray-100 transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                type="button" style="transition: all 0.15s ease 0s;" href="{{ URL::to('register') }}">
                                <i class="fas fa-user-plus mr-2"></i> R E G I S T E R
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <script>
        function toggleNavbar(collapseID) {
          document.getElementById(collapseID).classList.toggle("hidden");
          document.getElementById(collapseID).classList.toggle("block");
        }
    </script>
