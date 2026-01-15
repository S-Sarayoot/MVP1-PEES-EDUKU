<?php 
    require_once 'base.php';
?>


<title>EquityLearnKU - คลังทรัพยากร</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        
        <?php include_once '../component/sidebar.php' ?>


        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex flex-col">
                <div class="flex justify-between mb-4 md:mx-4">
                    <h1 class="text-xl text-[#433878]">โพสต์</h1>
                    <p class="text-gray-700"><a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                            class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                        > Storage > Post</p>
                </div>
                <div id="post-detail" class="w-full bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="flex flex-col items-center">
                        <img id="post-thumb" src="../image/no-thumbnail.png" alt="thumbnail" class=" max-h-72 object-contain rounded mb-4 bg-gray-100">
                        <h1 id="post-title" class="text-2xl font-bold text-[#433878] mb-2">-</h1>
                        <div class="text-gray-500 mb-2" id="post-category">-</div>
                        <div class="text-gray-400 text-xs mb-4" id="post-date">-</div>
                        <div id="post-content" class="prose max-w-none mb-4">-</div>
                        <div id="post-media" class="w-full flex flex-col gap-2"></div>
                        
                    </div>
                </div>
            </div>
            <!-- Recommended Posts Card -->
            <div class="flex flex-col items-center mt-8">
                <div class="w-full bg-white shadow-md rounded-lg p-4 mb-4">
                    <h2 class="text-lg font-semibold text-[#433878] mb-4">โพสต์แนะนำ</h2>
                    <div id="recommended-posts" class="grid grid-cols-1 md:grid-cols-4 gap-4 w-full"></div>
                </div>
            </div>
        </div>
    </div>  
</body>

</html>

<script>
    function getPostIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    const postId = getPostIdFromUrl();
    const detail = document.getElementById('post-detail');
    if (!postId) {
        detail.innerHTML = '<div class="p-8 text-center text-gray-400">ไม่พบโพสต์</div>';
    } else {
        fetch(`../backend/api/get_post_byid.php?id=${postId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.data) {
                const post = data.data;
                document.getElementById('post-thumb').src = (post.thumbnail);
                document.getElementById('post-title').textContent = post.title || '-';
                document.getElementById('post-category').textContent = post.category || '-';
                document.getElementById('post-date').textContent = post.created_at ? post.created_at.substring(0,10) : '-';
                document.getElementById('post-content').innerHTML = post.description || '-';
                // Media preview
                const mediaDiv = document.getElementById('post-media');
                mediaDiv.innerHTML = '';
                // Images
                let images = [];
                try { images = post.images ? JSON.parse(post.images) : []; } catch { images = []; }
                images.forEach(img => {
                    mediaDiv.innerHTML += `<img src="../uploads/${img}" class="w-full max-h-128 object-contain rounded mb-2">`;
                });
                // Videos
                let videos = [];
                try { videos = post.videos ? JSON.parse(post.videos) : []; } catch { videos = []; }
                videos.forEach(vid => {
                    mediaDiv.innerHTML += `<video src="../uploads/${vid}" class="w-full max-h-128 rounded mb-2" controls></video>`;
                });
                // Files
                let files = [];
                try { files = post.files ? JSON.parse(post.files) : []; } catch { files = []; }
                files.forEach(f => {
                    mediaDiv.innerHTML += `<a href="../uploads/${f}" target="_blank" class="block text-blue-600 underline mb-1">${f}</a>`;
                });
                // Media link
                if (post.media_link) {
                    let m;
                    // YouTube
                    if ((m = post.media_link.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]+)/))) {
                        mediaDiv.innerHTML += `<div class="mt-2"><iframe width="100%" height="800" src="https://www.youtube.com/embed/${m[1]}?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>`;
                    }
                    // TikTok
                    else if ((m = post.media_link.match(/tiktok\.com\/(@[\w.-]+)\/video\/([0-9]+)/))) {
                        mediaDiv.innerHTML += `<div class="mt-2"><iframe width="100%" height="800" src="https://www.tiktok.com/embed/v2/${m[2]}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>`;
                    }
                    // อื่น ๆ
                    else {
                        mediaDiv.innerHTML += `<div class="mt-2">Link : <a href="${post.media_link}" target="_blank" class="text-blue-500 underline">${post.media_link}</a></div>`;
                    }
                }
            } else {
                detail.innerHTML = '<div class="p-8 text-center text-gray-400">ไม่พบโพสต์</div>';
            }
        });
    }

    // Recommended posts
    const recommendedDiv = document.getElementById('recommended-posts');
    fetch('../backend/api/get_posts.php')
    .then(res => res.json())
    .then(data => {
        if (data.success && Array.isArray(data.data)) {
            let posts = data.data.filter(p => p.id != postId);
            // สุ่ม 4 รายการ
            posts = shuffle(posts).slice(0, 4);
            recommendedDiv.innerHTML = '';
            posts.forEach(item => {
                recommendedDiv.innerHTML += `
                    <div class="bg-white rounded-lg shadow-lg flex flex-col overflow-hidden">
                        <a href="post?id=${item.id}">
                            <img src="${item.thumbnail}" alt="thumbnail" class="w-full h-40 object-cover bg-gray-100">
                        </a>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <a href="post?id=${item.id}" class="font-semibold text-[#433878] text-lg mb-1 hover:underline">${item.title || '-'}</a>
                                <p class="text-gray-500 text-sm mb-2">${item.category || '-'}</p>
                                <p class="text-gray-400 text-xs">${item.uploaded_at ? item.uploaded_at.substring(0,10) : '-'}</p>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            recommendedDiv.innerHTML = '<div class="p-4 text-gray-400">ไม่พบโพสต์แนะนำ</div>';
        }
    });

    function shuffle(array) {
        let currentIndex = array.length, randomIndex;
        while (currentIndex != 0) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex--;
            [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
        }
        return array;
    }
</script>