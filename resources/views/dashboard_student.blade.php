<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
    @if ($errors->has('email'))
    <script>
        window.onload = function() {
            swal('Error', '{{ $errors->first('email') }}', 'error', {
                button: true,
                button: 'OK',
                timer: 5000, 
            });
        }
    </script>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center text-3xl">
                    {{ __("Welcome") }} {{ Auth::user()->name }}{{ __(" !") }}
                    </br>
                    {{ __("Have a good day !") }}
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <!-- Lesson data -->
                        <div class="w-full overflow-hidden rounded-lg shadow-xs col-span-2 sm:col-span-1">
                            <div class="w-full overflow-x-auto">
                                <caption class="caption-top mb-2 font-semibold text-sm text-gray-800">
                                    Lessons
                                </caption>
                                <table class="w-full whitespace-nowrap mt-4">
                                    <thead>
                                        <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Time Start</th>
                                        <th class="px-4 py-3">Time End</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y">
                                        @if(isset($lessons))
                                            @foreach ($lessons as $l)
                                            <!-- Table data  -->
                                                <tr class="text-base font-medium tracking-wide text-left text-gray-500 border-b bg-gray-50">
                                                    <td class="px-4 py-3">{{ $l->id_lesson }}</td>
                                                    <td class="px-4 py-3">{{ $l->start_time }}</td>
                                                    <td class="px-4 py-3">{{ $l->end_time }}</td>   
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Room Data -->
                        <div class="w-full overflow-hidden rounded-lg shadow-xs col-span-2 sm:col-span-1">
                            <div class="w-full overflow-x-auto">
                                <caption class="caption-top mb-2 font-semibold text-lg text-gray-800">
                                    Rooms
                                </caption>
                                <table class="w-full whitespace-nowrap mt-4">
                                    <thead>
                                        <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Name Room</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y">
                                        @if(isset($rooms))
                                            @foreach ($rooms as $r)
                                            <!-- Table data  -->
                                                <tr class="text-base font-medium tracking-wide text-left text-gray-500 border-b bg-gray-50">
                                                <td class="px-4 py-3">{{ $r->id_room }}</td>
                                                <td class="px-4 py-3">{{ $r->name_room }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
