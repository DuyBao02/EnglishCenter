<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tuition') }}
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
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col w-full mb-20">
                        <div class="bg-white border rounded-lg shadow-lg px-6 py-8 max-w-md mx-auto mt-8">
                            <h1 class="font-bold text-2xl my-4 text-center text-blue-600">TuitionFee</h1>
                            <hr class="mb-2">
                            <div class="flex justify-between mb-6">
                                <h1 class="text-lg font-bold">Invoice</h1>
                                <div class="text-gray-700 ml-12">
                                    <div>Date: {{ date('d-m-Y') }}</div>
                                    @foreach ($bills as $b)
                                        <div>Invoice #: {{ $b->id_bill }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-8">
                                <h2 class="text-lg font-bold mb-4">Bill To:</h2>
                                <div class="text-gray-700 mb-2">{{ Auth::user()->name }}</div>
                                <div class="text-gray-700 mb-2">{{ Auth::user()->address }}</div>
                                <div class="text-gray-700 mb-2">{{ Auth::user()->email }}</div>
                                <div class="text-gray-700">{{ Auth::user()->phone }}</div>
                            </div>
                            <table class="w-full mb-8">
                                <thead>
                                    <tr>
                                        <th class="text-left font-bold text-gray-700">Description</th>
                                        <th class="text-right font-bold text-gray-700">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bills as $b)
                                        @foreach(json_decode($b->name_bill, true) as $id_course)
                                            @php
                                                $course = \App\Models\Course::find($id_course);
                                                $tuitionFeeInUSD = \App\Models\Course::getTuitionFeeInUSD($id_course);
                                            @endphp
                                            <tr>
                                                <td class="text-left text-gray-700">{{ $course->id_course ?? 'N/A' }}</td>
                                                <td class="text-right text-gray-700">${{ number_format($tuitionFeeInUSD, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-left font-bold text-gray-700">Total</td>
                                        <td class="text-right font-bold text-gray-700">${{ number_format(($b->tuitionFee)/23000 ?? 0, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div>
                                 @if ($b->is_paid == 0)
                                    <form action="{{ route('paypal', $b->id_bill) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="price" value="{{ number_format(($b->tuitionFee)/23000 ?? 0, 2) }}">
                                        <button class="transform transition-transform duration-400 hover:scale-125" type="submit" style="background: none; border: none;">
                                            <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" alt="Pay with PayPal" />
                                        </button>
                                    </form>
                                @else
                                    <div class="text-gray-700 mb-2 text-center bg-yellow-200 rounded-full">Thank you for your payment!</div>
                                @endif
                            </div>
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
