<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
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

    <!-- Zoom in picture's post -->
    <div id="pictureModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 border-b-2 border-gray-500" id="modal-title">
                                <!-- Teacher Name -->
                            </h3>
                            <div class="mt-4">
                                <img id="pictureImage" src="" alt="Teacher Avatar">
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Create post Form --}}
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold">Create new post</h3>
                    
                    <form action="{{ route('create-post') }}" method="POST" class="mt-6" enctype="multipart/form-data">
                        @csrf
                    
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                                <input required :value="old('title')"
                                    type="text" 
                                    id="title"
                                    name="title"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            
                            <div class="col-span-2 sm:col-span-1">
                                <label for="picture" class="block text-gray-700 text-sm font-bold mb-2">Picture</label>
                                <input required id="picture" class="block mt-1 w-full" type="file" name="picture" value="{{ old('picture') }}" autofocus autocomplete="picture" />
                            </div>
                        
                        </div>
                    
                        <div class="mt-4">
                            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                            <textarea required="required" :value="old('content')"
                                id="content"
                                name="content"
                                rows="3"
                                autofocus autocomplete="content"
                                class="form-control web-editor shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </textarea>

                        </div>
                    
                        <div class="my-4 flex items-center justify-center w-full">
                            <x-primary-button type="submit">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                
                <!-- Post data table -->
                <div class="my-4 mx-4 sm:rounded-lg">
                    <h3 class="text-2xl font-bold mb-4">Posts List</h3>
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Title</th>
                                    <th class="px-4 py-3">Picture</th>
                                    <th class="px-4 py-3">Content</th>
                                    <th class="px-4 py-3"></th>
                                    <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($posts))
                                        @foreach ($posts as $p)
                                            <tr>
                                                <!-- Table data  -->
                                                <td class="px-4 py-3">{{ $p->id }}</td>
                                                <td class="px-4 py-3">{{ $p->title }}</td>
                                                <td class="px-4 py-3">
                                                    <a class="hover:text-red-500 transform transition-transform duration-400 hover:scale-150" href="#" alt="{{ $p->picture }}" onclick="showPicture('{{ asset('images/posts/'.$p->picture) }}', '{{ $p->picture }}')">{{ $p->picture }}</a>
                                                </td>
                                                <td class="px-4 py-3">Press Edit to read the content</td>
                                                <td class="py-3">
                                                    <a type="buttom" href="{{ route('post-edit', $p->id) }}">
                                                        <img class="h-6 w-6 inline-block transform transition-transform duration-400 hover:scale-150" src="images/edit.png" alt="">
                                                    </a> 
                                                </td>

                                                <td class="py-3">
                                                    <form action="{{ route('post-delete', $p->id) }}" method="POST" onsubmit="confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="confirmDeletePost(event, '{{ route('post-delete', $p->id) }}')">
                                                            <img class="h-6 w-6 inline-block transform transition-transform duration-400 hover:scale-150" src="images/trash.png" alt="">
                                                        </button>
                                                    </form>
                                                </td>
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
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
      <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ Vite::asset('vendor/tinymce/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

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

    tinymce.init({
        selector: '.web-editor', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });

    //ConfirmDeletePost
    function confirmDeletePost(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this lesson!",
            icon: "warning",
            buttons: true,
            timer: 5000,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                deletePost(route);
            }
        });
    }

    function deletePost(route) {
        fetch(route, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                swal("Poof! Post has been deleted!", {
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