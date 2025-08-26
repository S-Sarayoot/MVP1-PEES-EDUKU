<div class="w-full bg-white p-[35px]">
    <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($title ?? 'เมนู') ?></h2>

    <div class="relative">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php foreach ($items as $item): ?>
                    <div class="swiper-slide">
                        <div class="bg-gray-200 w-[240px] min-h-[300px] rounded-lg shadow-md overflow-hidden flex flex-col justify-between">
                            <!-- พื้นที่เนื้อหาการ์ด -->
                            <div class="flex items-center justify-center h-32">
                                <?php if (!empty($item['icon'])): ?>
                                    <img src="<?= htmlspecialchars($item['icon']) ?>" alt="icon" class="w-16 h-16 object-contain">
                                <?php else: ?>
                                    <span class="text-xl font-bold text-center"><?= htmlspecialchars($item['label']) ?></span>
                                <?php endif; ?>
                            </div>

                            <!-- ส่วนล่าง -->
                            <div class="bg-pink-50 w-full text-center py-2">
                                <p class="font-medium"><?= htmlspecialchars($item['description']) ?></p>
                                <a href="<?= htmlspecialchars($item['link']) ?>" class="mt-2 inline-block bg-purple-900 text-white px-3 py-1 rounded">
                                    ดูทั้งหมด
                                </a>
                            </div>
                        </div>
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
