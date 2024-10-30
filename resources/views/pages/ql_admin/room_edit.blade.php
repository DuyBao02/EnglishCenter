<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center text-3xl">

                    <div class="w-full flex justify-center items-center">
                        <!-- Room form -->
                        <div class="bg-red-200 max-h-56 w-72 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="text-lg mt-2">Edit Room</div>
                                <form action="{{ isset($room) ? route('room-custom-update', $room->id_room) : route('room-custom-store') }}" method="POST" class="flex flex-col items-center my-auto">
                                    @csrf
                                    <div class="mt-4 flex items-center justify-center w-full">
                                        <label for="id_room" class="block text-sm font-medium text-gray-700 mr-2">ID Room</label>
                                        <input readonly type="text" id="id_room" name="id_room" value="{{ isset($room) ? $room->id_room : '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="mt-4 flex items-center justify-center w-full">
                                        <label for="name_room" class="block text-sm font-medium text-gray-700 mr-2">Name</label>
                                        <input autofocus required type="text" id="name_room" name="name_room" value="{{ isset($room) ? $room->name_room : '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="my-4 flex items-center justify-center w-full">
                                        <x-primary-button type="submit">
                                            {{ __('Save') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
