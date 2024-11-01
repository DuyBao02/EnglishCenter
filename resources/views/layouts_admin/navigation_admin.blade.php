<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo/>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard-admin')" :active="request()->routeIs('dashboard-admin')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('course-admin')" :active="request()->routeIs('course-admin', 'create-course', 'student-list-admin', 'course-edit')">
                        {{ __('Courses') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('rl-custom-admin')" :active="request()->routeIs('rl-custom-admin',  'lesson-edit', 'room-edit')">
                        {{ __('Rooms & Lessons') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('users-management')" :active="request()->routeIs('users-management')">
                        {{ __('Users Management') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @php
                        $secondEdits = \App\Models\Secondedit::all();
                        $buttonColor = $secondEdits->count() > 0 ? 'relative' : '';
                    @endphp

                    <x-nav-link :href="route('edit-request')" :active="request()->routeIs('edit-request')" class="{{ $buttonColor }}">
                        {{ __('Edit Requests') }}
                        @if($secondEdits->count() > 0)
                            <span class="absolute top-4 right-0 inline-block w-2 h-2 bg-green-600 rounded-full"></span>
                        @endif
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @php
                        $secondFeedbacks = \App\Models\SecondFeedbacks::all();
                        $buttonColor = $secondFeedbacks->count() > 0 ? 'relative' : '';
                    @endphp

                    <x-nav-link :href="route('showFBtoAdmin')" :active="request()->routeIs('showFBtoAdmin', 'showFeedbacks')" class="{{ $buttonColor }}">
                        {{ __('Feedbacks') }}
                        @if($secondFeedbacks->count() > 0)
                            <span class="absolute top-4 right-0 inline-block w-2 h-2 bg-green-600 rounded-full"></span>
                        @endif
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-10">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                           Other
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('posts-admin')">
                                {{ __('Posts') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('banners')">
                                {{ __('Banners') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('bills')">
                                {{ __('Bills') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="sm:flex sm:items-center">
                    <label class="switch">
                        <span class="sun"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="#ffd43b"><circle r="5" cy="12" cx="12"></circle><path d="m21 13h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm-17 0h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm13.66-5.66a1 1 0 0 1 -.66-.29 1 1 0 0 1 0-1.41l.71-.71a1 1 0 1 1 1.41 1.41l-.71.71a1 1 0 0 1 -.75.29zm-12.02 12.02a1 1 0 0 1 -.71-.29 1 1 0 0 1 0-1.41l.71-.66a1 1 0 0 1 1.41 1.41l-.71.71a1 1 0 0 1 -.7.24zm6.36-14.36a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm0 17a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm-5.66-14.66a1 1 0 0 1 -.7-.29l-.71-.71a1 1 0 0 1 1.41-1.41l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.29zm12.02 12.02a1 1 0 0 1 -.7-.29l-.66-.71a1 1 0 0 1 1.36-1.36l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.24z"></path></g></svg></span>
                        <span class="moon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="m223.5 32c-123.5 0-223.5 100.3-223.5 224s100 224 223.5 224c60.6 0 115.5-24.2 155.8-63.4 5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6-96.9 0-175.5-78.8-175.5-176 0-65.8 36-123.1 89.3-153.3 6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"></path></svg></span>
                        <input type="checkbox" class="input">
                        <span class="slider"></span>
                      </label>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-800 focus:outline-none transition ease-in-out duration-150">
                            <div><img class="w-12 h-12 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-125" src="{{ asset('images/avatars/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"></div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard-admin')" :active="request()->routeIs('dashboard-admin')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('course-admin')" :active="request()->routeIs('course-admin')">
                {{ __('Course Custom') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('rl-custom-admin')" :active="request()->routeIs('rl-custom-admin')">
                {{ __('Rooms & Lessons Custom') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users-management')" :active="request()->routeIs('users-management')">
                {{ __('Teacher Management') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users-management')" :active="request()->routeIs('users-management')">
                {{ __('Edit Request') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->role }}: {{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
