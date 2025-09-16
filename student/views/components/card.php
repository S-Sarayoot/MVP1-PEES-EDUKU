<div class="bg-white rounded-lg shadow hover:shadow-lg transition w-full h-[300px] overflow-hidden flex flex-col justify-between border-2 border-gray-200 relative">
    <!-- พื้นที่เนื้อหาการ์ด -->
    <div class="h-full flex items-center justify-center overflow-hidden">
        <?php if (!empty($data['image'])): ?>
            <img src="<?= htmlspecialchars($data['image']) ?>" alt="icon" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full flex flex-col justify-center items-center bg-[#9886CE]">
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#544A71"><path d="m480-420 240-160-240-160v320ZM228-85q-33 5-59.5-15.5T138-154L85-591q-4-33 16-59t53-30l46-6v326q0 66 47 113t113 47h372q-6 24-24 41.5T664-138L228-85Zm132-195q-33 0-56.5-23.5T280-360v-440q0-33 23.5-56.5T360-880h440q33 0 56.5 23.5T880-800v440q0 33-23.5 56.5T800-280H360Z"/></svg>
                <span class="text-xl text-white font-bold text-center"><?= htmlspecialchars($data['title']) ?></span>
                <span class="text-xs text-[#544A71] text-center">โดย <?= htmlspecialchars($data['author']) ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tag หมวดหมู่ -->
    <a href="https://dev.kittelweb.xyz/student/storage#cat=<?= htmlspecialchars($data['tag']) ?>" class="absolute top-2 left-2 bg-gray-900/60 text-white text-xs px-2 py-1 rounded">
        <?= htmlspecialchars($data['tag']) ?>
    </a>

    <!-- ส่วนล่าง -->
    <div class="bg-pink-50 w-full text-center p-2">
        <h3 class="font-semibold text-gray-800 text-lg leading-snug text-left truncate">
            <a target="_blank" href="<?= htmlspecialchars($data['src']) ?>"><?= htmlspecialchars($data['title']) ?></a>
        </h3>
        <div class="text-left text-xs text-gray-500">
            <p class="line-clamp-1"><?= htmlspecialchars($data['description']) ?></p>
            <div class="flex items-center mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="24px" fill="#9886CE"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/></svg>
                <p><?= htmlspecialchars($data['author']) ?></p>
            </div>
        </div>
    </div>
</div>