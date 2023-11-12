<!DOCTYPE html>
<html>

@include('components.header-homepage')

<body class="text-gray-800 antialiased">
    @include('components.nav-homepage')
    <main>
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                        <div class="pr-12">
                            <h1 class="text-white font-semibold text-5xl">
                                Welcome to</br>
                                DB English center!
                            </h1>
                            <p class="mt-8 text-lg text-gray-300">
                                Comprehensive curriculum that equally develops all four skills of
                                </br>Listening - Speaking - Reading - Writing, including courses on TOEIC and IELTS.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <section class="pb-20 bg-gray-300 -mt-24">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap mb-20">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-xl">
                        <div class="w-full px-4 text-center">
                            <div class="items-center justify-center w-full">
                                @include('components.banner')
                            </div>
                        </div>
                    </div>
                    <div class="lg:pt-12 pt-6 w-full md:w-4/12 px-4 text-center">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-red-400">
                                    <i class="fas fa-award"></i>
                                </div>
                                <h6 class="text-xl font-semibold">Giá trị cốt lõi</h6>
                                <p class="mt-2 mb-4 text-gray-600">
                                    Ở DBEC luôn đề cao 5 giá trị gồm: Trách nhiệm & đam mê, Toàn diện, Nhân văn, Tiên phong, Vì cộng đồng...
                                </p>
                                <a href="{{ route('posts-details', 8) }}" class="hover:text-red-500">
                                    <p>Xem thêm</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 px-4 text-center">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-blue-400">
                                    <i class="fas fa-retweet"></i>
                                </div>
                                <h6 class="text-xl font-semibold">Hệ thống cơ sở</h6>
                                <p class="mt-2 mb-4 text-gray-600">
                                    Cơ sở vật chất tại DBEC được lắp đặt đầy đủ và thường xuyên được bảo trì, mang đến cho người dạy và người học cảm giác thoải mái và an toàn...
                                </p>
                                <a href="{{ route('posts-details', 9) }}" class="hover:text-red-500">
                                    <p>Xem thêm</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6 w-full md:w-4/12 px-4 text-center">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg">
                            <div class="px-4 py-5 flex-auto">
                                <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-green-400">
                                    <i class="fas fa-fingerprint"></i>
                                </div>
                                <h6 class="text-xl font-semibold">Vì sao nên chọn DBEC</h6>
                                <p class="mt-2 mb-4 text-gray-600">
                                    DBEC là nơi đào tạo các lộ trình tiếng anh từ cơ bản đến nâng cao với giá thành hợp lí nhất...
                                </p>
                                <a href="{{ route('posts-details', 10) }}" class="hover:text-red-500">
                                    <p>Xem thêm</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center">
                    <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
                        <h3 class="text-3xl mb-2 font-semibold leading-normal">
                            {{ $post11->title }}
                        </h3>
                        <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700">
                            {!! $post11->content !!}
                        </p>
                    </div>
                    <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-pink-600">
                            <img src="{{ asset('images/posts/'.$post11->picture) }}" alt="{{ $post11->picture }}" class="w-full align-middle rounded-t-lg" />
                            <blockquote class="relative p-8 mb-4">
                                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 583 95" class="absolute left-0 w-full block" style="height: 95px; top: -94px;">
                                    <polygon points="-30,95 583,95 583,65" class="text-pink-600 fill-current"></polygon>
                                </svg>
                                <h4 class="text-xl font-bold text-white">
                                    Toàn diện và Phát triển
                                </h4>
                                <p class="text-md font-light mt-2 text-white">
                                    Toàn diện trong đào tạo liên thông từ tiếng Anh trẻ em đến chuẩn đầu ra IELTS quốc tế
                                </p>
                            </blockquote>
                        </div>
                    </div>
                    <div class="w-full md:w-5/12 px-4 mr-auto ml-auto mt-16">
                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-pink-600">
                            <img src="{{ asset('images/posts/'.$post12->picture) }}" alt="{{ $post12->picture }}" class="w-full align-middle rounded-t-lg" />
                            <blockquote class="relative p-8 mb-4">
                                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 583 95" class="absolute left-0 w-full block" style="height: 95px; top: -94px;">
                                    <polygon points="-30,95 583,95 583,65" class="text-pink-600 fill-current"></polygon>
                                </svg>
                                <h4 class="text-xl font-bold text-white">
                                    Tiên phong
                                </h4>
                                <p class="text-md font-light mt-2 text-white">
                                    Tiên phong trong đào tạo giáo viên và xây dựng môi trường sinh hoạt chuyên môn
                                </p>
                            </blockquote>
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                        <h3 class="text-3xl mb-2 font-semibold leading-normal">
                            {{ $post12->title }}
                        </h3>
                        <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-700">
                            {!! $post12->content !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="pt-20 pb-48 " id="teachers">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center mb-24">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold">Giảng viên</h2>
                        <p class="text-lg leading-relaxed m-4 text-gray-600">
                            Giảng viên là lực lượng nồng cốt của DBEC, là người chỉ đường dẫn lối cho học viên đến với thành công.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap mt-24 justify-center">
                    @foreach($teachers as $t)
                        <div class="w-full md:w-6/12 lg:w-3/12 lg:mb-0 mb-12 px-4">
                            <a href="{{ route('teachers-details', $t->id) }}">
                                <div class="px-6">
                                    <img src="{{ asset('images/avatars/'.$t->avatar) }}" alt="{{ $t->avatar }}" class="transform transition-transform duration-400 hover:scale-125 shadow-lg rounded-full max-w-full mx-auto" style="max-width: 120px;" />
                                    <div class="pt-6 text-center">
                                        <h5 class="text-xl font-bold">{{ $t->level }}. {{ $t->name }}</h5>
                                        <p class="mt-1 text-sm text-gray-500 font-semibold">
                                            Kinh nghiệm giảng dạy: {{ $t->experience }} năm
                                        </p>
                                        <div class="mt-6">
                                            <button href="{{ route('teachers-details', $t->id) }}" class="bg-blue-400 hover:bg-blue-600 text-white rounded-xl outline-none focus:outline-none mr-1 mb-1 px-2 py-2" type="button">
                                                Show More
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="text-white justify-center flex flex-wrap">
                {{ $teachers->appends(['teachers' => request('teachers', 1)])->fragment('teachers')->links() }}
            </div>
        </section>
        <section class="pb-20 relative block bg-gray-900">
            <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20" style="height: 80px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-900 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4 lg:pt-24 lg:pb-64">
                <div class="flex flex-wrap text-center justify-center">
                    <div class="w-full lg:w-6/12 px-4">
                        <h2 class="text-4xl font-semibold text-white">Posts of DuyBao English Center</h2>
                        <h4 class = "text-xl text-white mt-4">This is the place to update the latest news from DBEC</h4>
                    </div>
                </div>
                <div class="flex flex-wrap mt-24 justify-center">
                    <div class="flex-wrap grid grid-cols-3 gap-4 text-white">
                        @foreach($posts as $post)
                            <div class="col-span-3 sm:col-span-1 mt-8">
                                <a href="{{ route('posts-details', $post->id) }}">
                                    <div class="px-6">
                                        <img src="{{ asset('images/posts/'.$post->picture) }}" alt="{{ $post->picture }}" class="transform transition-transform duration-400 hover:scale-125 shadow-lg mx-auto max-h-72" />
                                        <div class="pt-6 text-center ">
                                            <i class="fas fa-calendar mr-2 mb-4"></i>
                                                {{ \Carbon\Carbon::parse($post->updated_at)->format('d-m-Y') }}
                                            <h5 class="text-xl font-bold">{{ $post->title }}</h5>
                                            <p class="mt-1 text-sm uppercase font-semibold">
                                                <a class="hover:text-red-500" href="{{ route('posts-details', $post->id) }}">Xem thêm</a>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('components.footer-homepage')

    <script>

        window.onload = function() {
            if (window.location.hash) {
                var hash = window.location.hash;
                document.querySelector(hash).scrollIntoView();
            }
        }
    </script>
</body>

</html>
