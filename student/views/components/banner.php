<div class="flex w-full   rounded-lg overflow-hidden shadow-lg">
    <!-- Left Content -->
    <div class="w-1/2 bg-gray-200 p-6 flex flex-col justify-center">
        <h2 class="text-2xl font-bold mb-2"><?= htmlspecialchars($title) ?></h2>
        <p class="text-gray-700"><?= htmlspecialchars($subtitle) ?></p>
    </div>

    <!-- Right Media -->
    <div class="relative w-1/2 h-56 bg-black overflow-hidden">
        <div id="banner-media-<?= htmlspecialchars($id) ?>" class="w-full h-full"></div>

        <!-- Play Button Overlay -->
        <div class="absolute inset-0 flex items-center justify-center">
            <button id="play-btn-<?= htmlspecialchars($id) ?>" class="bg-red-300 bg-opacity-60 rounded-full p-4 hover:bg-opacity-80 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <polygon points="5,3 19,12 5,21" fill="white"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    const banner<?= $id ?> = document.getElementById("banner-media-<?= $id ?>");
    const playBtn<?= $id ?> = document.getElementById("play-btn-<?= $id ?>");
    const mediaUrl<?= $id ?> = "<?= $mediaUrl ?>";
    let isVideo<?= $id ?> = false;

    if (mediaUrl<?= $id ?>.match(/\.(mp4|webm|ogg)$/i)) {
        isVideo<?= $id ?> = true;
        banner<?= $id ?>.innerHTML = `
            <video id="banner-video-<?= $id ?>" class="w-full h-full object-cover" muted>
                <source src="${mediaUrl<?= $id ?>}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
    } else if (mediaUrl<?= $id ?>.match(/\.(jpg|jpeg|png|gif|webp)$/i)) {
        banner<?= $id ?>.innerHTML = `<img src="${mediaUrl<?= $id ?>}" alt="Banner" class="w-full h-full object-cover">`;
    } else {
        banner<?= $id ?>.innerHTML = `<div class="flex items-center justify-center text-white">Unsupported media</div>`;
    }

    playBtn<?= $id ?>.addEventListener("click", () => {
        if (isVideo<?= $id ?>) {
            const video = document.getElementById("banner-video-<?= $id ?>");
            video.play();
            playBtn<?= $id ?>.style.display = "none";
        }
    });
</script>
