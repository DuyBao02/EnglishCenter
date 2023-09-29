<head>
    <title>Signup</title>
</head>

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="columns-2">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

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
                    </div>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
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

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
                        <option hidden>Role</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Student">Student</option>
                    </select>
                </div>            
            </div>

        </div>

        <!-- Gender -->
        <div class="">
            <x-input-label for="gender" :value="__('Gender')" />
            <div class="flex justify-around mt-2">
                <!--First radio-->
                    <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                    <input
                    class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 rounded-full"
                    type="radio"
                    name="gender"
                    id="male" required
                    value="1" />
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
                    value="0" />
                    <label
                    class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                    for="female" required
                    >Female</label>
                </div>
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
    </form>
</x-guest-layout>