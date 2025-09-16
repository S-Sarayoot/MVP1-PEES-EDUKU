<div class="w-full bg-white p-[35px]">
    <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($title ?? 'เมนู') ?></h2>

    <div class="relative">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php foreach ($items as $item): ?>
                    <div class="swiper-slide">
                       <?php component('components/card.php', $item) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ปุ่มเลื่อน -->
        <div class="absolute left-0 top-1/2 -translate-y-1/2 z-10">
            <button class="swiper-button-prev w-16 h-5 bg-green-700/95 text-white p-2 rounded-full shadow"></button>
        </div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 z-10">
            <button class="swiper-button-next w-16 h-5 bg-green-700/80 text-white p-2 rounded-full shadow"></button>
        </div>
    </div>
</div>

<script>
    new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 10    ,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            1: { slidesPerView: 1},
            425: { slidesPerView: 1.2},
            768: { slidesPerView: 2},
            1024: { slidesPerView: 2.3 },
            1440: { slidesPerView: 4.5 }
        }
    });
</script>
