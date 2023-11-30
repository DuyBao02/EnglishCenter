<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bills') }}
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
            swal('Error', '{{ Session::get('error') }}', 'error',{
                button:true,
                button:'OK',
                timer:5000,
            });
        }
        </script>
    @endif

    {{-- <form action="" method="" class="flex items-center space-x-4 mx-4 lg:mx-0 lg:float-right lg:px-40 mt-4">
        <input type="search" name="search" id="" value="{{ $search }}" placeholder="Search by title" class="border p-2 px-4 rounded-full w-96 focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
        <button type="" class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-full">Search</button>
        <a href="{{ route('banners') }}">
            <button type="button" class="bg-gray-300 hover:bg-gray-200 px-4 py-2 rounded-full">Reset</button>
        </a>
    </form> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Bill data table -->
                <div class="my-4 mx-4 sm:rounded-lg">
                    <h3 class="text-2xl font-bold mb-4">List</h3>
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">@sortablelink('id_bill')</th>
                                    <th class="px-4 py-3">@sortablelink('user_id')</th>
                                    <th class="px-4 py-3">Name Courses</th>
                                    <th class="px-4 py-3">@sortablelink('payment_time')</th>
                                    <th class="px-4 py-3">@sortablelink('tuitionFee')</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($bills))
                                        @foreach ($bills as $b)
                                            <tr>
                                                <!-- Table data  -->
                                                <td class="px-4 py-3">{{ $b->id_bill }}</td>
                                                <td class="px-4 py-3">{{ $b->user->name }}</td>
                                                <td class="px-4 py-3">
                                                    @foreach(json_decode($b->name_bill, true) as $id_course)
                                                        @php
                                                            $course = \App\Models\Course::find($id_course);
                                                            $tuitionFeeInUSD = \App\Models\Course::getTuitionFeeInUSD($id_course);
                                                        @endphp
                                                            {{ $course->id_course ?? 'N/A' }}
                                                    @endforeach
                                                </td>
                                                <td class="px-4 py-3">{{ $b->payment_time }}</td>
                                                <td class="px-4 py-3">{{ number_format($b->tuitionFee) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {!! $bills->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
      <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
