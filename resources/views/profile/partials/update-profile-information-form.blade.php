<section>
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
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address. But you can't change Email !") }}
        </p>
    </header>

    <!-- Preview avatar image -->
    <div id="avatarModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Your Avatar
                            </h3>
                            <div class="mt-2">
                                <img id="avatarImage" src="" alt="New Avatar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeAvatarModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    @if (Auth::user()->role == 'Admin')
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mt-6">
                <div class="max-w-xl mt-6 flex flex-col items-center">
                    <x-input-label for="avatar" :value="__('Avatar')" />
                    <a href="#" onclick="showAvatar('{{ asset('images/avatars/'.$user->avatar) }}')"><img src="{{ asset('images/avatars/' . $user->avatar) }}" alt="Current Avatar" class="w-32 h-32 rounded-full mb-2" data-avatar-name="{{ $user->avatar }}"></a>
                    <input id="avatar" name="avatar" type="file" class="mt-1 block w-full" />

                    <input type="hidden" id="defaultAvatar" name="defaultAvatar">
                    <button id="setDefaultAvatar" type="button" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Set Default Avatar</button>
                    
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input placher readonly id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                
                <div class="max-w-xl mt-6">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="birthday" :value="__('Birthday')" />
                    <x-text-input type="date" id="birthday" name="birthday" class="mt-1 block w-full" :value="old('birthday', $user->birthday)" required autofocus autocomplete="birthday" />
                    <x-input-error class="mt-2" :messages="$errors->get('birthday')" />
                </div class="mt-6">

                <div class="max-w-xl mt-6">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required autofocus autocomplete="address" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
        
                <div class="flex items-center gap-4 mt-6">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
        
                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 3000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </div>
        </form>

    @elseif (Auth::user()->role == 'Teacher')
        <form method="post" action="{{ route('receive-edit-request') }}" class=" space-y-6" enctype="multipart/form-data">
            @csrf
        
            <div class="mt-6">
                <div class="max-w-xl mt-6 flex flex-col items-center">
                    <x-input-label for="avatar" :value="__('Avatar')" />
                    <a href="#" onclick="showAvatar('{{ asset('images/avatars/'.$user->avatar) }}')"><img src="{{ asset('images/avatars/' . $user->avatar) }}" alt="Current Avatar" class="w-32 h-32 rounded-full mb-2" data-avatar-name="{{ $user->avatar }}"></a>
                    <input id="avatar" name="avatar" type="file" class="mt-1 block w-full" />

                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />

                    <input type="hidden" id="defaultAvatar" name="defaultAvatar">
                    <button id="setDefaultAvatar" type="button" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Set Default Avatar</button>
                </div>
                
                <div class="max-w-xl mt-6">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input placher readonly id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                
                <div class="max-w-xl mt-6">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
        
                <div class="max-w-xl mt-6">
                    <x-input-label for="experience" :value="__('Experience')" />
                    <x-text-input id="experience" name="experience" type="text" class="mt-1 block w-full" :value="old('experience', $user->experience)" required autofocus autocomplete="experience" />
                    <x-input-error class="mt-2" :messages="$errors->get('experience')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="level" :value="__('Level')" />
                    <select id="level" name="level" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="level" :value="old('level')">
                        <option hidden>Level</option>
                        <option value="Professor" {{ old('level', $user->level) == 'Professor' ? 'selected' : '' }}>Professor</option>
                        <option value="AssociateProfessor" {{ old('level', $user->level) == 'AssociateProfessor' ? 'selected' : '' }}>Associate Professor</option>
                        <option value="PhD" {{ old('level', $user->level) == 'PhD' ? 'selected' : '' }}>PhD</option>
                        <option value="Master" {{ old('level', $user->level) == 'Master' ? 'selected' : '' }}>Master</option>
                        <option value="Engineer" {{ old('level', $user->level) == 'Engineer' ? 'selected' : '' }}>Engineer</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('level')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="birthday" :value="__('Birthday')" />
                    <x-text-input type="date" id="birthday" name="birthday" class="mt-1 block w-full" :value="old('birthday', $user->birthday)" required autofocus autocomplete="birthday" />
                    <x-input-error class="mt-2" :messages="$errors->get('birthday')" />
                </div class="mt-6">

                <div class="max-w-xl mt-6">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required autofocus autocomplete="address" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
        
                <div class="flex items-center gap-4 mt-6">
                    @if (Auth::user()->pendingEdit()->exists() || Auth::user()->pendingSecondEdit()->exists())
                        <x-primary-button disabled class="cursor-not-allowed">{{ __('Waiting...') }}</x-primary-button>
                    @else
                        <x-primary-button>{{ __('Send') }}</x-primary-button>
                    @endif
                </div>
            </div>
        </form>
    
    @elseif (Auth::user()->role == 'Student')
    <form method="post" action="{{ route('receive-edit-request') }}" class=" space-y-6" enctype="multipart/form-data">
            @csrf
        
            <div class="mt-6">
                <div class="max-w-xl mt-6 flex flex-col items-center">
                    <x-input-label for="avatar" :value="__('Avatar')" />
                    <a href="#" onclick="showAvatar('{{ asset('images/avatars/'.$user->avatar) }}')"><img src="{{ asset('images/avatars/' . $user->avatar) }}" alt="Current Avatar" class="w-32 h-32 rounded-full mb-2" data-avatar-name="{{ $user->avatar }}"></a>
                    <input id="avatar" name="avatar" type="file" class="mt-1 block w-full" />
                    <input type="hidden" id="defaultAvatar" name="defaultAvatar">
                    <button id="setDefaultAvatar" type="button" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Set Default Avatar</button>
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input placher readonly id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                
                <div class="max-w-xl mt-6">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="birthday" :value="__('Birthday')" />
                    <x-text-input type="date" id="birthday" name="birthday" class="mt-1 block w-full" :value="old('birthday', $user->birthday)" required autofocus autocomplete="birthday" />
                    <x-input-error class="mt-2" :messages="$errors->get('birthday')" />
                </div class="mt-6">

                <div class="max-w-xl mt-6">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required autofocus autocomplete="address" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="max-w-xl mt-6">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
        
                <div class="flex items-center gap-4 mt-6">
                    @if (Auth::user()->pendingEdit()->exists() || Auth::user()->pendingSecondEdit()->exists())
                        <x-primary-button disabled class="cursor-not-allowed">{{ __('Waiting...') }}</x-primary-button>
                    @else
                        <x-primary-button>{{ __('Send') }}</x-primary-button>
                    @endif
                </div>
            </div>
        </form>
    @endif

    
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // Preview avatar image
    function showAvatar(imageSrc) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('avatarModal').classList.remove('hidden');
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }

    // Set Default Avatar
    document.getElementById('setDefaultAvatar').addEventListener('click', function() {
        var currentAvatarName = document.querySelector('img[data-avatar-name]').getAttribute('data-avatar-name');
        if (currentAvatarName === 'avatar_default.png') {
            swal({
                title: 'Error',
                text: 'Avatar is already set to default! \n You cannot set it to default again!',
                icon: 'error',
                button: 'OK',
                timer: 5000,
                dangerMode: true,
                html: true
            });
            return;
        }
        document.getElementById('defaultAvatar').value = '1';
        this.classList.remove('bg-blue-500', 'hover:bg-blue-700');
        this.classList.add('bg-red-500', 'hover:bg-red-700');
    });
    
</script>

