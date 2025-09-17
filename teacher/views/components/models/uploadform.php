<div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 relative">

                <button type="button" onclick="toggleModal(false)"
            class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-2xl cursor-pointer text-[32px]">&times;</button>

        <h2 class="text-2xl font-semibold text-purple-700 mb-4 text-shadow-sm">เพิ่มสื่อการสอน</h2>
        <hr class="-mx-6 text-gray-300">
        <form class="grid grid-cols-1 gap-5 mt-6">
            <div
                class="w-full text-center flex flex-col justify-center items-center border border-gray-300 rounded-xl hover:border-gray-400 shadow-md px-4 py-6 max-w-xl">
                <label for="fileUpload"
                    class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-5 rounded-lg cursor-pointer shadow-md">
                    เลือกไฟล์
                </label>
                <input type="file" name="file" id="fileUpload" class="hidden">
                <p id="fileName" class="mt-2 text-sm text-gray-500">ยังไม่มีไฟล์</p>
            </div>

            <div class="flex flex-col justify-between space-y-4">
                <div>
                    <label for="description" class="block font-semibold mb-2">คำอธิบาย:</label>
                    <textarea id="description" rows="4"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-purple-500"
                        placeholder="ใส่คำอธิบาย..."></textarea>
                </div>

                <div>
                    <label for="category" class="block font-semibold mb-2">ประเภท:</label>
                    <select id="category"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-purple-500">
                        <option disabled selected>-- เลือกประเภท --</option>
                        <option value="video">Image</option>
                        <option value="pdf">Videos</option>
                        <option value="image">Documents</option>
                        <option value="link">Story Board</option>
                        <option value="image">Exams</option>
                        <option value="image">Script</option>
                    </select>
                </div>
            </div>
        </form>
        <hr class="-mx-6 text-gray-300 mt-6 -mb-1">
        <form class="grid grid-row-2 gap-5">
            <div class="flex justify-end gap-3 mt-6 ">
                <button type="button" onclick="toggleModal(false)"
                    class="px-4 py-2 rounded-full border border-gray-300 text-black hover:bg-gray-400 transition">ยกเลิก</>
                <button type="button"
                    class="px-4 py-2 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition">อัปโหลด</button>
            </div>
        </form>
    </div>
</div>