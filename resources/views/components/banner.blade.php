<div class="swiper-container banner-box">
    <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide banner-content">
            <img src="https://giaviet.edu.vn/public/upload/slide/PANO%201600X700-optimize.png" alt="Banner 1" class="banner-image">
        </div>
        <!-- Slide 2 -->
        <div class="swiper-slide banner-content">
            <img src="https://giaviet.edu.vn/public/upload/slide/WEB%202011(1).png" alt="Banner 2" class="banner-image">
        </div>
        <!-- Slide 3 -->
        <div class="swiper-slide banner-content">
            <img src="https://ila.edu.vn/wp-content/uploads/2023/06/co-so-vat-chat-khoa-hoc-smart-teen.png" alt="Banner 3" class="banner-image">
        </div>
        <!-- Slide 4 -->
        <div class="swiper-slide banner-content">
            <img src="https://ila.edu.vn/wp-content/uploads/2023/03/center-4.png" alt="Banner 4" class="banner-image">
        </div>
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
