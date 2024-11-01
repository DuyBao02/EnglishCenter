<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Feedbacks') }}
            </h2>
        </div>
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

    <!-- Zoom in avatar -->
    <div id="avatarModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="mt-4">
                                <img id="avatarImage" src="" alt="User Avatar">
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

    <form action="" method="" class="flex items-center space-x-4 mx-4 lg:mx-0 lg:float-right lg:px-40 mt-4">
        <input autofocus type="search" name="search" id="" value="{{ $search }}" placeholder="Search by name or email" class="border p-2 px-4 rounded-full w-96 focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
        <button type="" class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-full">Search</button>
        <a href="{{ route('showFeedbacks') }}">
            <button type="button" class="bg-gray-300 hover:bg-gray-200 px-4 py-2 rounded-full">Reset</button>
        </a>
    </form>

    <div class="py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Post data table -->
                <div class="my-4 mx-4 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">@sortablelink('id')</th>
                                    <th class="px-4 py-3">Avatar</th>
                                    <th class="px-4 py-3">@sortablelink('user_id')</th>
                                    <th class="px-4 py-3">@sortablelink('user_id')</th>
                                    <th class="px-4 py-3">@sortablelink('comment_content')</th>
                                    <th class="px-4 py-3">@sortablelink('datesend')</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($allfbs))
                                        @foreach ($allfbs as $s)
                                            <tr>
                                                <!-- Table data  -->
                                                <td class="px-4 py-3">{{ $s->id }}</td>
                                                <td class="px-4 py-3">
                                                    <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$s->user->avatar) }}" alt="{{ $s->user->avatar }}" onclick="showAvatar('{{ asset('images/avatars/'.$s->user->avatar) }}')">
                                                </td>
                                                <td class="px-4 py-3">{{ $s->user->role }}: {{ $s->user->name }}</td>
                                                <td class="px-4 py-3">{{ $s->user->email }}</td>
                                                <td class="px-4 py-3 whitespace-pre-line">{!! $s->comment_content !!}</td>
                                                <td class="px-4 py-3">{{ $s->datesend }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {!! $allfbs->appends(\Request::except('page'))->render() !!}
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

<script>
    //Zoom in avatar
    function showAvatar(imageSrc, teacherName) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('avatarModal').classList.remove('hidden');
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }
</script>
