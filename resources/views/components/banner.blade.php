<div class="swiper-container banner-box">
    <div class="swiper-wrapper">

        @foreach ($banners as $b)
            <div class="swiper-slide banner-content">
                <img src="images/banners/{{ $b->picture }}"  alt="Banner " . {{ $b->id}} class="banner-image">
            </div>
        @endforeach

    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Navigation -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>

    new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            dynamicBullets: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });

</script>

<style>

    .banner-box {
        position: relative;
    }

    .banner-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 20px;
        margin: auto;
        display: block;
    }

    .banner-content {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 20px;
        text-align: center;
    }

    .swiper-container, .swiper-slide {
        padding-top: 20px;
        padding-bottom: 20px;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }
</style>
