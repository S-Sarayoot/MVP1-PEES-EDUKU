<?php require_once 'base.php'; ?>


<title>โพสต์สื่อมัลติมีเดีย | EquityLearnKU</title>

</head>
<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex flex-col">
                <div class="flex justify-between mb-4 md:mx-4">
                    <h1 class="text-xl text-[#433878]">สร้างโพสต์สื่อมัลติมีเดีย</h1>
                    <p class="text-gray-700"><a href="storage_admin"
                            class="text-gray-400  hover:font-semibold hover:text-[#433878]">คลังทรัพยากร</a>
                        > เพิ่มสื่อ</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <form id="mediaPostForm" enctype="multipart/form-data" class="space-y-5">
                        <!-- หัวข้อโพสต์ -->
                        <div>
                            <label class="block font-semibold mb-1">หัวข้อโพสต์</label>
                            <input type="text" name="title" class="w-full border rounded-lg px-3 py-2" placeholder="กรอกหัวข้อ..." required>
                        </div>
                        <!-- ประเภทสื่อ (category) -->
                        <div>
                            <label class="block font-semibold mb-1">ประเภทสื่อ</label>
                            <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                                <option value="">-- เลือกประเภท --</option>
                                <option value="ทั่วไป">ทั่วไป</option>
                                <option value="วิดีโอ">วิดีโอ</option>
                                <option value="ภาพ">ภาพ</option>
                                <option value="ลิงก์">ลิงก์</option>
                                <option value="เอกสาร">เอกสาร</option>
                            </select>
                        </div>
                        <!-- เนื้อหา (rich text) -->
                        <div>
                            <label class="block font-semibold mb-1">เนื้อหา</label>
                            <textarea id="content" name="content" class="w-full border rounded-lg px-3 py-2 min-h-[120px]" placeholder="พิมพ์เนื้อหา สามารถจัดข้อความ ใส่ลิงก์ ฯลฯ" ></textarea>
                        </div>
                        <!-- อัพโหลดไฟล์ -->
                        <div>
                            <label class="block font-semibold mb-1">อัปโหลดไฟล์ (ถ้ามี)</label>
                            <button type="button" id="uploadFileBtn" class="border border-blue-500 text-blue-500 bg-transparent px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition">เลือกไฟล์</button>
                            <input type="file" name="files[]" multiple class="hidden" id="fileInput">
                            <div id="preview-files" class="flex flex-wrap gap-2 mt-2"></div>
                        </div>
                        <!-- อัปโหลดรูปภาพ -->
                        <div>
                            <label class="block font-semibold mb-1">รูปภาพ (ถ้ามี)</label>
                            <button type="button" id="uploadImageBtn" class="border border-blue-500 text-blue-500 bg-transparent px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition">เลือกไฟล์รูปภาพ</button>
                            <input type="file" name="images[]" accept="image/*" multiple class="hidden" id="imageInput">
                            <div id="preview-images" class="flex flex-wrap gap-2 mt-2"></div>
                        </div>
                        <!-- อัปโหลดวิดีโอ -->
                        <div>
                            <label class="block font-semibold mb-1">วิดีโอ (ถ้ามี)</label>
                            <button type="button" id="uploadVideoBtn" class="border border-blue-500 text-blue-500 bg-transparent px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition">เลือกไฟล์วิดีโอ</button>
                            <input type="file" name="videos[]" accept="video/*" multiple class="hidden" id="videoInput">
                            <div id="preview-videos" class="flex flex-wrap gap-2 mt-2"></div>
                        </div>
                        <!-- ลิงก์ Youtube/TikTok -->
                        <div>
                            <label class="block font-semibold mb-1">แนบลิงก์ Youtube หรือ TikTok</label>
                            <input type="url" name="media_link" class="w-full border rounded-lg px-3 py-2" placeholder="วางลิงก์ Youtube หรือ TikTok">
                        </div>
                        <!-- ปุ่มโพสต์ -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">แก้ไขโพสต์</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Rich Text Editor (ใช้ CDN ของ TinyMCE หรือ CKEditor) -->
<script src="https://cdn.tiny.cloud/1/dzcsf7dom8o3tpzedz2b8ja0md7st1h9iu86fkvmm1bq81f4/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
let __pendingTinyContent = null;

function setPostEditorContent(html) {
    const value = String(html ?? '');
    const editor = window.tinymce ? tinymce.get('content') : null;
    if (editor) {
        editor.setContent(value);
        return;
    }
    __pendingTinyContent = value;
    const textarea = document.getElementById('content');
    if (textarea) textarea.value = value;
}

try {
    if (window.tinymce && typeof tinymce.init === 'function') {
        tinymce.init({
            selector: '#content',
            height: 250,
            menubar: false,
            branding: false,
            toolbar_mode: 'floating',
            setup: (editor) => {
                editor.on('init', () => {
                    if (__pendingTinyContent !== null) {
                        editor.setContent(__pendingTinyContent);
                        __pendingTinyContent = null;
                    }
                });
            }
        });
    }
} catch (e) {
    console.warn('TinyMCE init failed; fallback to textarea.', e);
}

// ฟังก์ชันดึง id จาก url
function getPostIdFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get('id');
}

// โหลดข้อมูลโพสต์หลัง DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    const postId = getPostIdFromUrl();
    if (!postId) return;
    fetch(`../backend/api/edit_post_byid.php?id=${postId}`)
    .then(res => res.json())
    .then(data => {
        if (data.success && data.data) {
            const post = data.data;
            document.querySelector('input[name="title"]').value = post.title || '';
            document.querySelector('select[name="category"]').value = post.category || '';
            document.querySelector('input[name="media_link"]').value = post.media_link || '';
            setPostEditorContent(post.description || '');
            // แสดง preview ไฟล์/รูป/วิดีโอเดิม (ถ้ามี)
            // รูปภาพ
            const previewImages = document.getElementById('preview-images');
            previewImages.innerHTML = '';
            let images = [];
            try {
                images = post.images ? JSON.parse(post.images) : [];
            } catch { images = []; }
            if (Array.isArray(images)) {
                images.forEach(imgUrl => {
                    const img = document.createElement('img');
                    img.src = '../uploads/' + imgUrl;
                    img.className = 'h-16 w-16 object-cover rounded border';
                    previewImages.appendChild(img);
                });
            }

            // วิดีโอ
            const previewVideos = document.getElementById('preview-videos');
            previewVideos.innerHTML = '';
            let videos = [];
            try {
                videos = post.videos ? JSON.parse(post.videos) : [];
            } catch { videos = []; }
            if (Array.isArray(videos)) {
                videos.forEach(videoUrl => {
                    const video = document.createElement('video');
                    video.src = '../uploads/' + videoUrl;
                    video.className = 'h-16 w-16 object-cover rounded border';
                    video.controls = true;
                    previewVideos.appendChild(video);
                });
            }

            // ไฟล์ทั่วไป
            const previewFiles = document.getElementById('preview-files');
            previewFiles.innerHTML = '';
            let files = [];
            try {
                files = post.files ? JSON.parse(post.files) : [];
            } catch { files = []; }
            if (Array.isArray(files)) {
                files.forEach(fileName => {
                    const a = document.createElement('a');
                    a.href = '../uploads/' + fileName;
                    a.textContent = fileName;
                    a.target = '_blank';
                    a.className = 'border rounded px-2 py-1 text-xs bg-gray-50 block';
                    previewFiles.appendChild(a);
                });
            }
        }
    });

});


// อัพโหลดไฟล์ทั่วไป
document.getElementById('uploadFileBtn').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});
document.getElementById('fileInput').addEventListener('change', function(e) {
    const preview = document.getElementById('preview-files');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const div = document.createElement('div');
        div.className = 'border rounded px-2 py-1 text-xs bg-gray-50';
        div.textContent = file.name;
        preview.appendChild(div);
    });
});

// อัพโหลดรูปภาพ
document.getElementById('uploadImageBtn').addEventListener('click', function() {
    document.getElementById('imageInput').click();
});
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('preview-images');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const img = document.createElement('img');
            img.src = ev.target.result;
            img.className = 'h-16 w-16 object-cover rounded border';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

// อัพโหลดวิดีโอ
document.getElementById('uploadVideoBtn').addEventListener('click', function() {
    document.getElementById('videoInput').click();
});
document.getElementById('videoInput').addEventListener('change', function(e) {
    const preview = document.getElementById('preview-videos');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const video = document.createElement('video');
        video.src = URL.createObjectURL(file);
        video.className = 'h-16 w-16 object-cover rounded border';
        video.controls = true;
        preview.appendChild(video);
    });
});


// ส่งฟอร์มด้วย AJAX
document.getElementById('mediaPostForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const editor = window.tinymce ? tinymce.get('content') : null;
    const html = editor ? editor.getContent() : (document.getElementById('content')?.value || '');
    formData.set('description', html);

    // แสดง Swal.fire loading
    if (window.Swal) {
      Swal.fire({
        title: 'กำลังอัปโหลด...',
        text: 'กรุณารอสักครู่',
        allowOutsideClick: false,
        didOpen: () => { 
            Swal.showLoading(); 
        }
      });
    }
    const postId = getPostIdFromUrl();
    formData.append('id', postId);
    fetch('../backend/api/edit_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (window.Swal) Swal.close();
        if (data.success) {
            Swal.fire({ 
                icon: 'success', 
                title: 'สำเร็จ', 
                text: 'บันทึกข้อมูลสำเร็จ\nกำลังกลับไปหน้าคลังทรัพยากร...',
                timer: 5000,
                showConfirmButton: false
            });
            form.reset();
            const editor = window.tinymce ? tinymce.get('content') : null;
            if (editor) editor.setContent('');
            document.getElementById('preview-images').innerHTML = '';
            document.getElementById('preview-videos').innerHTML = '';
            setTimeout(function() {
                window.location.href = 'storage_admin';
            }, 5000);
        } else {
            alert(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        }
    })
    .catch(() => {
        Swal.close();
        Swal.fire({
            icon: 'error',
            title: 'ผิดพลาด',
            text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์'
        });
        }
    );
});
</script>
</body>
</html>