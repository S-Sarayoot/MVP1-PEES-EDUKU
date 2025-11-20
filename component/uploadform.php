<div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 relative">

                <button type="button" onclick="toggleModal(false)"
            class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-2xl cursor-pointer text-[32px]">&times;</button>

        <h2 class="text-2xl font-semibold text-purple-700 mb-4 text-shadow-sm">เพิ่มสื่อการสอน</h2>
        <hr class="-mx-6 text-gray-300">
    <form id="uploadForm" class="grid grid-cols-1 gap-5 mt-6" method="POST" enctype="multipart/form-data" action="../backend/api/upload.php">
            <div class="w-full text-center flex flex-col justify-center items-center border border-gray-300 rounded-xl hover:border-gray-400 shadow-md px-4 py-6 max-w-xl">
                <label for="fileUpload" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-5 rounded-lg cursor-pointer shadow-md">เลือกไฟล์</label>
                <input type="file" name="file" id="fileUpload" class="hidden">
                <p id="fileName" class="mt-2 text-sm text-gray-500">ยังไม่มีไฟล์</p>
            </div>
            <div class="flex flex-col justify-between space-y-4">
                <div>
                    <label for="description" class="block font-semibold mb-2">คำอธิบาย:</label>
                    <textarea id="description" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-purple-500" placeholder="ใส่คำอธิบาย..." name="description" required></textarea>
                </div>
                <div>
                    <label for="category" class="block font-semibold mb-2">ประเภท:</label>
                    <select id="category" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-purple-500" name="category" required>
                        <option disabled selected>-- เลือกประเภท --</option>
                        <option value="image">รูปภาพ</option>
                        <option value="video">วิดีโอ</option>
                        <option value="document">แหล่งการเรียนรู้</option>
                        <option value="lesson_plan">แผนการจัดการเรียนรู้</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 ">
                <button type="button" onclick="toggleModal(false)" class="px-4 py-2 rounded-full border border-gray-300 text-black hover:bg-gray-400 transition">ยกเลิก</button>
                <button type="submit" class="px-4 py-2 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition">อัปโหลด</button>
            </div>
        </form>
    </div>
</div>
</form>
<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const category = document.getElementById('category');
    if (!category.value || category.selectedIndex === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาเลือกประเภท',
            text: 'โปรดเลือกประเภทของสื่อการสอนก่อนส่งข้อมูล',
            confirmButtonColor: '#F59E42'
        });
        return;
    }
    const formData = new FormData(this);
    fetch('../backend/api/upload_media.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: 'Upload successful!',
                confirmButtonColor: '#6D28D9'
            }).then(() => {
                toggleModal(false);
                document.getElementById('uploadForm').reset();
                document.getElementById('fileName').textContent = 'ยังไม่มีไฟล์';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'Upload failed: ' + data.message,
                confirmButtonColor: '#EF4444'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'An error occurred while uploading the file.',
            confirmButtonColor: '#EF4444'
        });
    });
});
document.getElementById('fileUpload').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'ยังไม่มีไฟล์';
    document.getElementById('fileName').textContent = fileName;
});
</script>