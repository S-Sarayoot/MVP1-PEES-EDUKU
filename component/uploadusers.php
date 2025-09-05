<div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 relative">

        <button onclick="toggleModal(false)"
            class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-2xl cursor-pointer text-[32px]">&times;</button>

        <h2 class="text-2xl font-semibold text-purple-700 mb-4 text-shadow-sm">เพิ่มผูุ้ใช้งาน</h2>
        <hr class="-mx-6 text-gray-300">
        <form class="grid grid-cols-1 gap-5 mt-6">
            <div
                class="w-full text-center flex flex-col justify-center items-center border border-gray-300 rounded-xl hover:border-gray-400 shadow-md mt-3 px-2 py-15 max-w-xl">
                <label for="fileUpload"
                    class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-5 rounded-lg cursor-pointer shadow-md">
                    เลือกไฟล์
                </label>
                <input type="file" name="file" id="fileUpload" class="hidden">
                <p id="fileName" class="mt-2 text-sm text-gray-500">ยังไม่มีไฟล์</p>
            </div>
            <div class="flex items-center justify-center mt-4">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="mx-4 text-gray-500 text-sm">OR</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>
            <div class="flex flex-col justify-between space-y-4">
                <div>
                    <label for="description" class="block font-semibold mb-2">Name:</label>
                    <input type="text" id="username"
                        class="border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Name..." required "/>
                    <label for=" description" class="block font-semibold mt-4 mb-2">Password:</label>
                    <input type="text" id="password"
                        class="border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full mb-3 p-2.5"
                        placeholder="Password..." required "/>
                </div>
            </div>
        </form>
        <hr class=" -mx-6 text-gray-300 mt-6 -mb-1">
                    <form class="grid gap-5">
                        <div class="flex items-center justify-between gap-4 mt-2">
                            <!-- Select (ซ้ายสุด) -->
                            <div class="flex flex-col">
                                <label for="category" class="block font-semibold mb-1">ประเภท:</label>
                                <select id="category"
                                    class="border border-gray-300 rounded-lg p-1 focus:outline-none focus:ring-1 focus:ring-purple-500">
                                    <option disabled selected>-- เลือกประเภท --</option>
                                    <option value="std">นิสิต</option>
                                    <option value="tch">ผู้ทรงคุณวุฒิ</option>
                                    <option value="admin">ผู้ดูแลระบบ</option>
                                </select>
                            </div>

                            <!-- ปุ่ม (ขวาสุด) -->
                            <div class="flex gap-3 mt-7">
                                <button type="button" onclick="toggleModal(false)"
                                    class="px-4 py-2 rounded-full border border-gray-300 text-black hover:bg-gray-400 transition">
                                    ยกเลิก
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition">
                                    อัปโหลด
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>