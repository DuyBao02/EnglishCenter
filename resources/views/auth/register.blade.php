<head>
    <title>Signup</title>
</head>

<x-guest-layout>
    @if (Session::has('success'))
        <script>
        window.onload = function() {
            swal('Success', '{{ Session::get('success') }}', 'success',{
                button:true,
                button:'OK',
                timer:5000,
            });
        }
        </script>
    @endif
    @if (Session::has('error'))
        <script>
        window.onload = function() {
            swal('Error', '{{ Session::get('error') }}', 'error',{
                button:true,
                button:'OK',
                timer:5000,
            });
        }
        </script>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="columns-2">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')"/>

                <div class="flex mt-1 mb-2">
                    <div class="relative flex-1 col-span-4" x-data="{ show: true }">
                        <input class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                id="password"
                                :type="show ? 'password' : 'text'"
                                name="password"
                                required autocomplete="new-password"
                                placeholder = "Least 8 characters"
                                />

                        <button type="button" class="flex absolute inset-y-0 right-0 items-center pr-3" @click="show = !show" :class="{'hidden': !show, 'block': show }">
                            <!-- Heroicon name: eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <button type="button" class="flex absolute inset-y-0 right-0 items-center pr-3" @click="show = !show" :class="{'block': !show, 'hidden': show }">
                            <!-- Heroicon name: eye-slash -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>

                        <p id="capslock-warning" class="text-red-500" hidden >Caps Lock is on.</p>
                    </div>
                </div>

            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <div class="flex mt-1 mb-2">
                    <div class="relative flex-1 col-span-4" x-data="{ show: true }">
                        <input class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                id="password_confirmation"
                                :type="show ? 'password' : 'text'"
                                name="password_confirmation"
                                required autocomplete="new-password"
                                placeholder = "Least 8 characters" />

                        <button type="button" class="flex absolute inset-y-0 right-0 items-center pr-3" @click="show = !show" :class="{'hidden': !show, 'block': show }">
                            <!-- Heroicon name: eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <button type="button" class="flex absolute inset-y-0 right-0 items-center pr-3" @click="show = !show" :class="{'block': !show, 'hidden': show }">
                            <!-- Heroicon name: eye-slash -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Birthday -->
            <div class="mt-8">
                <x-input-label for="birthday" :value="__('Birthday')" />
                <x-text-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" required autofocus autocomplete="birthday" />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
            </div>

            <!-- Phone -->
            <div class="mt-5">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
            </div>

            <!-- Role -->
            <div class="mt-5">
                <x-input-label for="role" :value="__('Role')" />
                <div class="flex justify-around">
                    <select id="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="role" :value="old('role')" required autofocus autocomplete="role">
                        <option value="" {{ old('role') == '' ? 'selected' : '' }}>Role</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Student">Student</option>
                    </select>
                </div>
            </div>

        </div>
        <!-- Display teacher register -->
        <div id="teacherFields" class="transition-all duration-500 ease-in-out opacity-0 h-0 overflow-hidden grid grid-cols-2 gap-4">
            <!-- Teaching Experience -->
            <div class="col-span-2 sm:col-span-1" >
                <x-input-label for="experience" :value="__('Teaching Experience')"/>
                <x-text-input id="experience" class="block mt-1 w-full" type="text" min="1" max="50" name="experience" :value="old('experience')" placeholder="From 1 year"/>
            </div>

            <!-- Level -->
            <div class="col-span-2 sm:col-span-1">
                <x-input-label for="level" :value="__('Level')" />
                <select id="level" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="level" :value="old('level')">
                    <option value="" hidden {{ old('level') == '' ? 'selected' : '' }}>Level</option>
                    <option value="Professor" {{ old('level') == 'Professor' ? 'selected' : '' }}>Professor</option>
                    <option value="AssociateProfessor" {{ old('level') == 'AssociateProfessor' ? 'selected' : '' }}>Associate Professor</option>
                    <option value="PhD" {{ old('level') == 'PhD' ? 'selected' : '' }}>PhD</option>
                    <option value="Master" {{ old('level') == 'Master' ? 'selected' : '' }}>Master</option>
                    <option value="Engineer" {{ old('level') == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Gender -->
                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <div class="flex justify-around mt-2">
                        <!--First radio-->
                            <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                            <input
                            class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 rounded-full"
                            type="radio"
                            name="gender"
                            id="male" required
                            value="male" />
                            <label
                            class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                            for="male"required
                            >Male</label>
                            </div>

                        <!--Second radio-->
                        <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                            <input
                            class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 rounded-full"
                            type="radio"
                            name="gender"
                            id="female" required
                            value="female" />
                            <label
                            class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                            for="female" required
                            >Female</label>
                        </div>
                    </div>
                </div>
                <!-- Avatar -->
                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="avatar" :value="__('Avatar (less than 4MB)')" />
                    <input id="avatar" class="block mt-1 w-full" type="file" name="avatar" value="{{ old('avatar') }}" autofocus autocomplete="avatar" />
                </div>
        </div>

        <div class="mt-4 flex items-center justify-center">
            <a class="text-sm text-gray-600 hover:text-red-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <!-- Spinner -->
        <div id="spinner" class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="flex items-center justify-center h-screen">
                <div class="relative">
                    <div class="h-24 w-24 rounded-full border-t-8 border-b-8 border-gray-200"></div>
                    <div class="absolute top-0 left-0 h-24 w-24 rounded-full border-t-8 border-b-8 border-blue-500 animate-spin">
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //Loading spinner
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('spinner').style.display = 'flex';
    });

    //Dropdown teacher
    document.getElementById('role').addEventListener('change', function() {
        var teacherFields = document.getElementById('teacherFields');
        if (this.value === 'Teacher') {
            teacherFields.style.height = '80px'; // Set a fixed height when visible
            teacherFields.classList.remove('opacity-0', 'h-0');
        } else {
            teacherFields.style.height = '0'; // Set height to 0 immediately
            teacherFields.classList.add('opacity-0');
        }
    });

    const passwordInput  = document.getElementById('password')
    const warning = document.getElementById('capslock-warning')

    passwordInput.addEventListener('keyup', (event) => {
        if (event.getModifierState('CapsLock')){
            warning.hidden = false
        }
        else {
            warning.hidden = true
        }
    })

</script>
