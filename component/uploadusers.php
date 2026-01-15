<div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-xl p-4 md:p-6 relative">

        <button onclick="toggleModal(false, 'uploadModal')"
            class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-2xl cursor-pointer text-[32px]">&times;</button>

        <h2 class="text-2xl font-semibold text-purple-700 mb-4 text-shadow-sm">เพิ่มผู้ใช้งาน</h2>
        <hr class="-mx-6 text-gray-300">
        <form id="uploadUserForm" class="grid grid-cols-1 gap-5 mt-6" enctype="multipart/form-data">
            <!-- <div class="w-full flex flex-col justify-center items-center border border-gray-300 rounded-xl hover:border-gray-400 shadow-md mt-3 px-2 py-6 max-w-xl">
                <label for="fileUpload" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-5 rounded-lg cursor-pointer shadow-md">เลือกไฟล์</label>
                <input type="file" name="file" id="fileUpload" class="hidden">
                <p id="fileName" class="mt-2 text-sm text-gray-500">ยังไม่มีไฟล์</p>
            </div> -->
            <div class="flex flex-col space-y-4 mt-4">
                <div>
                    <label for="user_type" class="block font-semibold mb-2">ประเภทผู้ใช้งาน:</label>
                    <select name="user_type" id="user_type" class="border border-gray-300 rounded-lg p-1 focus:outline-none focus:ring-1 focus:ring-purple-500 w-full" required>
                        <option disabled value="">-- เลือกประเภท --</option>
                        <option value="student" selected>นิสิต</option>
                        <option value="teacher">ผู้ทรงคุณวุฒิ</option>
                        <option value="admin">ผู้ดูแลระบบ</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div id="studentCodeGroup" class="hidden">
                        <label for="user_code" class="block font-semibold mb-2">รหัสนิสิต(สำหรับเข้าระบบ):</label>
                        <input type="text" name="user_code" id="user_code"
                            class="border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="กรอกรหัสนิสิต"
                            pattern="^[0-9]+$"
                            inputmode="numeric"
                            maxlength="20"
                            autocomplete="off"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                    </div>
                    <div id="usernameGroup">
                        <label for="username" class="block font-semibold mb-2">Username:</label>
                        <input type="email" name="username" id="username" class="border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="กรอกอีเมล" required>
                    </div>
                    <div>
                        <label for="password" class="block font-semibold mb-2">Password:</label>
                        <input type="password" name="password" id="password" class="border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="กรอกรหัสผ่าน" required>
                    </div>
                </div>
                <div>
                    <label for="user_name" class="block font-semibold mb-2">ชื่อ - นามสกุล:</label>
                    <input type="text" name="user_name" id="user_name" class="border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="กรอกชื่อ - นามสกุล" required>
                </div>
                
                
                

                <div id="academicGroup" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                    <div>
                        <label for="academic_year" class="block font-semibold mb-2">ปีการศึกษา:</label>
                        <input type="text" name="academic_year" id="academic_year"
                            class="border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="เช่น 2568"
                            inputmode="numeric"
                            maxlength="4"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                    </div>
                    <div>
                        <label for="academic_term" class="block font-semibold mb-2">ภาคการศึกษา:</label>
                        <select name="academic_term" id="academic_term" 
                            class="border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-1 focus:ring-purple-500 w-full">
                            <option disabled selected value="">-- เลือกภาค --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="faculty_id" class="block font-semibold mb-2">คณะ:</label>
                        <select name="faculty_id" id="faculty_id" class="border border-gray-300 rounded-lg p-1 focus:outline-none focus:ring-1 focus:ring-purple-500 w-full" required>
                            <option disabled selected value="">-- เลือกคณะ --</option>
                            <!-- option จะถูกเติมด้วย JS -->
                        </select>
                    </div>
                    <div>
                        <label for="major_id" class="block font-semibold mb-2">สาขาวิชา:</label>
                        <select name="major_id" id="major_id" class="border border-gray-300 rounded-lg p-1 focus:outline-none focus:ring-1 focus:ring-purple-500 w-full" required>
                            <option disabled selected value="">-- เลือกสาขาวิชา --</option>
                            <!-- option จะถูกเติมด้วย JS -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-end gap-3 mt-6">
                <button type="button" onclick="toggleModal(false, 'uploadModal')" class="px-4 py-2 rounded-full border border-gray-300 text-black hover:bg-gray-400 transition">ยกเลิก</button>
                <button type="submit" class="px-4 py-2 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition">บันทึก</button>
            </div>
        </form>
        <hr class=" -mx-6 text-gray-300 mt-6 -mb-1">
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ดึงข้อมูลคณะ
    fetch('../backend/api/get_faculty.php')
        .then(res => res.json())
        .then(data => {
            const facultySelect = document.getElementById('faculty_id');
            data.forEach(faculty => {
                const option = document.createElement('option');
                option.value = faculty.id;
                option.textContent = faculty.name;
                facultySelect.appendChild(option);
            });
        });

    // ดึงข้อมูลสาขาวิชา
    fetch('../backend/api/get_major.php')
        .then(res => res.json())
        .then(data => {
            const majorSelect = document.getElementById('major_id');
            data.forEach(major => {
                const option = document.createElement('option');
                option.value = major.id;
                option.textContent = major.name;
                majorSelect.appendChild(option);
            });
        });

    function applyUserTypeUI(userType) {
        const studentCodeGroup = document.getElementById('studentCodeGroup');
        const academicGroup = document.getElementById('academicGroup');
        const usernameGroup = document.getElementById('usernameGroup');
        const usernameInput = document.getElementById('username');
        const userCodeInput = document.getElementById('user_code');
        const academicYear = document.getElementById('academic_year');
        const academicTerm = document.getElementById('academic_term');

        if (userType === 'student') {
            studentCodeGroup.classList.remove('hidden');
            academicGroup.classList.remove('hidden');
            if (usernameGroup) usernameGroup.classList.add('hidden');
            if (usernameInput) { usernameInput.required = false; usernameInput.value = ''; usernameInput.disabled = true; }
            if (userCodeInput) userCodeInput.required = true;
            if (academicYear) academicYear.required = true;
            if (academicTerm) academicTerm.required = true;
        } else {
            studentCodeGroup.classList.add('hidden');
            academicGroup.classList.add('hidden');
            if (usernameGroup) usernameGroup.classList.remove('hidden');
            if (usernameInput) { usernameInput.required = true; usernameInput.disabled = false; }
            if (userCodeInput) { userCodeInput.required = false; userCodeInput.value = ''; }
            if (academicYear) { academicYear.required = false; academicYear.value = ''; }
            if (academicTerm) { academicTerm.required = false; academicTerm.value = ''; }
        }
    }

    // แสดง/ซ่อนช่องรหัสนิสิตตามประเภทผู้ใช้งาน
    const userTypeSelect = document.getElementById('user_type');
    userTypeSelect.addEventListener('change', function() {
        applyUserTypeUI(this.value);
    });

    // ตั้ง default เป็นนิสิต + apply UI ทันที
    userTypeSelect.value = userTypeSelect.value || 'student';
    applyUserTypeUI(userTypeSelect.value);

    let savingUser = false;

    // (student) username is derived from student code on submit

    // บันทึกผู้ใช้งาน
    document.getElementById('uploadUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if (savingUser) return;

        const submitBtn = this.querySelector('button[type="submit"]');
        const formData = new FormData(this);

        // ถ้าเป็น student ให้ใช้รหัสนิสิตแทน username
        const userType = formData.get('user_type');
        if (userType === 'student') {
            const code = (formData.get('user_code') || '').toString().trim();
            formData.set('username', code);
        }

        savingUser = true;
        if (submitBtn) submitBtn.disabled = true;
        Swal.fire({
            title: 'กำลังบันทึก... ',
            text: 'โปรดรอสักครู่',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('../backend/api/create_user.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ',
                    text: 'เพิ่มผู้ใช้งานเรียบร้อยแล้ว',
                    confirmButtonColor: '#6D28D9'
                }).then(() => {
                    toggleModal(false);
                    this.reset();
                    // หลัง reset ให้กลับมาเป็น default (นิสิต) และ apply UI
                    const sel = document.getElementById('user_type');
                    if (sel) {
                        sel.value = 'student';
                        applyUserTypeUI(sel.value);
                    }
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: data.message || 'ไม่สามารถบันทึกข้อมูลได้',
                    confirmButtonColor: '#EF4444'
                });
            }
        })
        .catch(() => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์',
                confirmButtonColor: '#EF4444'
            });
        })
        .finally(() => {
            savingUser = false;
            if (submitBtn) submitBtn.disabled = false;
        });
    });
});
</script>