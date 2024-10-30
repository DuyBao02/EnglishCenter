<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banners') }}
        </h2>
    </x-slot>

    @if (Session::has('success'))
        <script>
            window.onload = function() {
                swal('Success', '{{ Session::get('success') }}', 'success', {
                    button: true,
                    button: 'OK',
                    timer: 5000,
                });
            }
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            window.onload = function() {
                swal('Error', '{{ Session::get('error') }}', 'error', {
                    button: true,
                    button: 'OK',
                    timer: 5000,
                });
            }
        </script>
    @endif

    <!-- Zoom in picture's post -->
    <div id="pictureModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 border-b-2 border-gray-500"
                                id="modal-title">
                                <!-- Teacher Name -->
                            </h3>
                            <div class="mt-4">
                                <img id="pictureImage" src="" alt="Teacher Avatar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeAvatarModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form action="" method="" class="flex items-center space-x-4 mx-4 lg:mx-0 lg:float-right lg:px-40 mt-4">
        <input autofocus type="search" name="search" id="" value="{{ $search }}"
            placeholder="Search by title"
            class="border p-2 px-4 rounded-full w-96 focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
        <button type="" class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-full">Search</button>
        <a href="{{ route('banners') }}">
            <button type="button" class="bg-gray-300 hover:bg-gray-200 px-4 py-2 rounded-full">Reset</button>
        </a>
    </form>

    <div class="py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Bill data table -->
                <div class="my-4 mx-4 sm:rounded-lg">
                    <h3 class="text-2xl font-bold mb-4">List</h3>
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr
                                        class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">@sortablelink('id')</th>
                                        <th class="px-4 py-3">User Created</th>
                                        <th class="px-4 py-3">@sortablelink('title')</th>
                                        <th class="px-4 py-3">@sortablelink('picture')</th>
                                        <th class="px-4 py-3">@sortablelink('created_at')</th>
                                        <th class="px-4 py-3">Show/Hide</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if (isset($banners))
                                        @foreach ($banners as $b)
                                            <tr>
                                                <!-- Table data  -->
                                                <td class="px-4 py-3">{{ $b->id }}</td>
                                                <td class="px-4 py-3">{{ $b->user->name }}</td>
                                                <td class="px-4 py-3">{{ $b->title }}</td>
                                                <td class="px-4 py-3">
                                                    <a class="hover:text-red-500 transform transition-transform duration-400 hover:scale-150"
                                                        href="#" alt="{{ $b->picture }}"
                                                        onclick="showPicture('{{ asset('images/banners/' . $b->picture) }}', '{{ $b->picture }}')">{{ $b->picture }}</a>
                                                </td>

                                                <td class="px-4 py-3">{{ $b->created_at }}</td>

                                                <td class="px-4 py-3">
                                                    <form action="{{ route('update-showhide-banner', $b->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="showhide"
                                                            value="{{ $b->showhide }}">
                                                        <button type="submit">
                                                            @if ($b->showhide == 1)
                                                                <!-- Heroicon name: eye -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                </svg>
                                                            @else
                                                                <!-- Heroicon name: eye-slash -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                            @endif
                                                        </button>
                                                    </form>
                                                </td>

                                                <td class="py-3">
                                                    <form action="{{ route('banner-delete', $b->id) }}" method="POST"
                                                        onsubmit="confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="confirmDeleteBanner(event, '{{ route('banner-delete', $b->id) }}')">
                                                            <img class="h-6 w-6 inline-block transform transition-transform duration-400 hover:scale-150"
                                                                src="images/trash.png" alt="">
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {!! $banners->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>

                {{-- Create banner Form --}}
                <div class="p-6 text-gray-900 mt-4">
                    <h3 class="text-2xl font-bold">Create new Banner</h3>

                    <form action="{{ route('create-banner') }}" method="POST" class="mt-4"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                                <input required :value="old('title')" type="text" id="title" name="title"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="picture"
                                    class="block text-gray-700 text-sm font-bold mb-2">Picture</label>
                                <input required id="picture" class="block mt-1 w-full" type="file"
                                    name="picture" value="{{ old('picture') }}" autofocus autocomplete="picture" />
                            </div>

                        </div>

                        <div class="my-4 flex items-center justify-center w-full">
                            <x-primary-button type="submit">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
        <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    //Zoom in picture
    function showPicture(imageSrc, name) {
        document.getElementById('pictureImage').src = imageSrc;
        document.getElementById('modal-title').innerText = name;
        document.getElementById('pictureModal').classList.remove('hidden');
    }

    function closeAvatarModal() {
        document.getElementById('pictureModal').classList.add('hidden');
    }

    //ConfirmDeletePost
    function confirmDeleteBanner(event, route) {
        event.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this banner!",
                icon: "warning",
                buttons: true,
                timer: 5000,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    deleteBanner(route);
                }
            });
    }

    function deleteBanner(route) {
        fetch(route, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    swal("Poof! Banner has been deleted!", {
                            icon: "success",
                            timer: 5000,
                            buttons: {
                                confirm: {
                                    text: "OK",
                                    value: true,
                                    visible: true,
                                    closeModal: true
                                }
                            }
                        })
                        .then((value) => {
                            // Reload the page when user clicks on OK or after 5 seconds
                            if (value) {
                                location.reload();
                            } else {
                                setTimeout(function() {
                                    location.reload();
                                }, 5000);
                            }
                        });
                } else {
                    swal("Oops! Something went wrong, please refresh your website!", {
                        icon: "error",
                        timer: 5000,
                    });
                }
            });
    }
</script>
