<!DOCTYPE html>
<html>

@include('components.header-homepage')

<body class="text-gray-800 antialiased">



    @include('components.nav-homepage')
    <main>
        <div class="relative pt-16 pb-8 flex content-center items-center justify-center" style="min-height: 60vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                        <div class="pr-12">
                            <h1 class="text-white font-semibold text-4xl mb-8">
                                Contributing Feedback
                            </h1>
                            <form action="{{ route('feedback') }}" method="POST">
                                @csrf
                                <label for="comment_content"></label>
                                <textarea id="comment_content" name="comment_content" placeholder="Comment here..." rows="5" cols="80" required autofocus autocomplete="comment_content"></textarea><br />
                                <div class="my-4 flex items-center justify-center w-full">
                                    <x-danger-button>
                                        {{ __('Send') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-white fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <section class="pt-20 pb-24">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-center text-center mb-24">
                    <div class="grid grid-cols-2 gap-4 mt-16">
                        <div class="col-span-2 sm:col-span-1">
                            <iframe class="map"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15715.309578979477!2d105.76044688128938!3d10.031098185838209!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883d2192b0f1%3A0x4c90a391d232ccce!2zVHLGsOG7nW5nIEPDtG5nIE5naOG7hyBUaMO0bmcgVGluIHbDoCBUcnV54buBbiBUaMO0bmcgKENUVSk!5e0!3m2!1svi!2s!4v1680923439730!5m2!1svi!2s"
                                width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <div class="wrapper max-w-full bg-gray-200 font-sans pt-5 shadow-md rounded-2xl">
                            <div class="col-span-2 sm:col-span-1">
                                <h2 class="text-black font-semibold text-xl">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <a href="https://ctu.edu.vn">
                                        Trường Đại Học Cần Thơ Khu II, </br>Đ. 3/2, Xuân Khánh, Ninh Kiều, Cần
                                        Thơ
                                    </a>
                                </h2></br>

                                <h2 class="text-black font-semibold text-xl">
                                    <i class="fas fa-graduation-cap"></i>
                                    Trường Công Nghệ Thông Tin và Truyền Thông
                                </h2></br>

                                <h2 class="text-black font-semibold text-xl">
                                    <i class="fas fa-clock"></i> 7:30 - 20:30
                                </h2></br>

                                <h2 class="text-black font-semibold text-xl">
                                    <i class="fas fa-envelope"></i>
                                    <a style="color: #000;text-decoration: none;" href="mailto:dbec@gmail.com"> dbec@gmail.com</a>
                                </h2></br>

                                <h2 class="text-black font-semibold text-xl">
                                    <i class="fas fa-envelope"></i>
                                    <a style="color: #000;text-decoration: none;" href="mailto:baob2016946@student.ctu.edu.vn"> baob2016946@student.ctu.edu.vn</a>
                                </h2></br>

                                <h2 class="text-black font-semibold text-xl">
                                    <i class="fas fa-mobile-alt"></i>
                                    <a style="color: #000;text-decoration: none;" href="tel:+84 932941222"> +84 932941222</a>
                                </h2></br>

                                <h2 class="text-black font-semibold text-xl">
                                    <i class="fas fa-phone-alt"></i>
                                    <a style="color: #000;text-decoration: none;" href="tel:+84 123456789"> (0123) 4 567 789</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <hr class="my-8 border-gray-400"/>
    </main>

    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        window.onload = function() {
            if (window.location.hash) {
                var hash = window.location.hash;
                document.querySelector(hash).scrollIntoView();
            }
        }
    </script>

</body>

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

</html>
