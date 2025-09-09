<div class="w-full bg-white p-[35px]">
    <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($title ?? 'เมนู') ?></h2>

    <div class="relative">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php foreach ($items as $item): ?>
                    <div class="swiper-slide">
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition w-full h-[300px] overflow-hidden flex flex-col justify-between border-2 border-gray-200">
                            <!-- พื้นที่เนื้อหาการ์ด -->
                            <div class="h-full flex items-center justify-center overflow-hidden">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="icon" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex flex-col justify-center items-center bg-[#9886CE]">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#544A71"><path d="m480-420 240-160-240-160v320ZM228-85q-33 5-59.5-15.5T138-154L85-591q-4-33 16-59t53-30l46-6v326q0 66 47 113t113 47h372q-6 24-24 41.5T664-138L228-85Zm132-195q-33 0-56.5-23.5T280-360v-440q0-33 23.5-56.5T360-880h440q33 0 56.5 23.5T880-800v440q0 33-23.5 56.5T800-280H360Z"/></svg>
                                        <span class="text-xl text-white font-bold text-center"><?= htmlspecialchars($item['title']) ?></span>
                                        <span class="text-xs text-[#544A71] text-center">โดย <?= htmlspecialchars($item['author']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <a href="https://dev.kittelweb.xyz/student/storage#cat=<?= htmlspecialchars($item['tag']) ?>" class="absolute top-2 left-2 bg-gray-900/60 text-white text-xs px-2 py-1 rounded">
                                <?= htmlspecialchars($item['tag']) ?>
                            </a>
                            <!-- ส่วนล่าง -->
                            <div class="bg-pink-50 w-full text-center p-2">
                                <h3 class=" font-semibold text-gray-800 text-lg leading-snug text-left truncate"><a target="_blank" href="<?= htmlspecialchars($item['src']) ?>"><?= htmlspecialchars($item['title']) ?></a></h3>
                               <div class="text-left text-xs text-gray-500">
                                <p class="line-clamp-1"><?= htmlspecialchars($item['description']) ?></p>
                                <div class="flex items-center mt-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="24px" fill="#9886CE"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/></svg>
                                    <p><?= htmlspecialchars($item['author']) ?> </p>
                                </div>
                               
                               </div>
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
