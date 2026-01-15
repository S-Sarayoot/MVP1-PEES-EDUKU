<?php
require_once __DIR__ . '/../backend/config/credential.php';
require_once __DIR__ . '/base.php';

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptParts = explode('/', trim($scriptName, '/'));
$appBase = '/' . ($scriptParts[0] ?? '');
?>
	<title>EquityLearnKU - ข้อมูลส่วนตัว</title>
</head>

<body class="bg-gray-100">
	<div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto">
		<!-- Navigation -->
		<?php include_once '../component/sidebar.php' ?>

		<div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
			<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
				<div class="flex items-center justify-between gap-4 mb-4">
					<h2 class="text-2xl font-semibold">ข้อมูลส่วนตัว</h2>
					<div id="profile-status" class="text-sm text-gray-500"></div>
				</div>

				<form id="profileForm" class="grid grid-cols-1 md:grid-cols-2 gap-4" autocomplete="off">
                    
					<div class="md:col-span-2">
						<label class="text-sm text-gray-600">Username</label>
						<input id="username" name="username" type="text" readonly class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 text-gray-500" value="<?php echo htmlspecialchars((string)($credential_username ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

                    
					<div class="md:col-span-2">
						<label class="text-sm text-gray-600">รหัสผู้ใช้</label>
						<input id="user_code" name="user_code" type="text" readonly class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-100 text-gray-500" value="<?php echo htmlspecialchars((string)($credential_user_code ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

					<div class="md:col-span-2">
						<label class="text-sm text-gray-600">ชื่อ-นามสกุล</label>
						<input id="user_name" name="user_name" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" value="<?php echo htmlspecialchars((string)($credential_user_name ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>


					<div>
						<label class="text-sm text-gray-600">เบอร์โทรศัพท์</label>
						<input id="user_telephone" name="user_telephone" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" value="<?php echo htmlspecialchars((string)($credential_user_telephone ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

					<div>
						<label class="text-sm text-gray-600">ผู้ติดต่อ (ถ้ามี)</label>
						<input id="user_contactname" name="user_contactname" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" value="<?php echo htmlspecialchars((string)($credential_user_contactname ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

					<div class="md:col-span-2">
						<label class="text-sm text-gray-600">ที่อยู่</label>
						<input id="user_address" name="user_address" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" value="<?php echo htmlspecialchars((string)($credential_user_address ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

					<div>
						<label class="text-sm text-gray-600">จังหวัด</label>
						<input id="user_province" name="user_province" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" value="<?php echo htmlspecialchars((string)($credential_user_province ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

					<div>
						<label class="text-sm text-gray-600">อำเภอ/เขต</label>
						<input id="user_district" name="user_district" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" value="<?php echo htmlspecialchars((string)($credential_user_district ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

					<div>
						<label class="text-sm text-gray-600">รหัสไปรษณีย์</label>
						<input id="user_zipcode" name="user_zipcode" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" value="<?php echo htmlspecialchars((string)($credential_user_zipcode ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
					</div>

					<div>
						<label class="text-sm text-gray-600">ชั้นปี</label>
						<input id="academic_year" name="academic_year" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" placeholder="เช่น 1/2/3/4">
					</div>

					<div>
						<label class="text-sm text-gray-600">ภาคเรียน</label>
						<input id="academic_term" name="academic_term" type="text" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300" placeholder="เช่น 1 หรือ 2">
					</div>

					<div>
						<label class="text-sm text-gray-600">คณะ</label>
						<select id="faculty_id" name="faculty_id" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300">
							<option value="">-</option>
						</select>
					</div>

					<div>
						<label class="text-sm text-gray-600">สาขา</label>
						<select id="major_id" name="major_id" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-purple-300">
							<option value="">-</option>
						</select>
					</div>

					<div class="md:col-span-2 flex justify-end gap-2 pt-2">
						<button id="reloadBtn" type="button" class="px-5 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">โหลดใหม่</button>
						<button id="saveBtn" type="submit" class="px-6 py-2 rounded-md bg-gradient-to-r from-green-500 to-blue-500 text-white font-semibold shadow hover:opacity-90 transition">บันทึก</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		(() => {
			const APP_BASE = <?php echo json_encode($appBase, JSON_UNESCAPED_SLASHES); ?>;
			const statusEl = document.getElementById('profile-status');
			const form = document.getElementById('profileForm');
			const reloadBtn = document.getElementById('reloadBtn');
			const saveBtn = document.getElementById('saveBtn');

			const fields = {
				user_code: document.getElementById('user_code'),
				user_name: document.getElementById('user_name'),
				username: document.getElementById('username'),
				user_telephone: document.getElementById('user_telephone'),
				user_contactname: document.getElementById('user_contactname'),
				user_address: document.getElementById('user_address'),
				user_province: document.getElementById('user_province'),
				user_district: document.getElementById('user_district'),
				user_zipcode: document.getElementById('user_zipcode'),
				academic_year: document.getElementById('academic_year'),
				academic_term: document.getElementById('academic_term'),
				faculty_id: document.getElementById('faculty_id'),
				major_id: document.getElementById('major_id'),
			};

			const setStatus = (text) => {
				if (statusEl) statusEl.textContent = text || '';
			};

			const fillSelect = (select, items, currentId) => {
				if (!select) return;
				const keepFirst = select.querySelector('option[value=""]');
				select.innerHTML = '';
				if (keepFirst) select.appendChild(keepFirst);
				(items || []).forEach((it) => {
					const opt = document.createElement('option');
					opt.value = String(it?.id ?? '');
					opt.textContent = it?.name ?? '-';
					select.appendChild(opt);
				});
				if (currentId !== undefined && currentId !== null && String(currentId) !== '') {
					select.value = String(currentId);
				}
			};

			const applyUser = (u) => {
				if (!u) return;
				if (fields.user_code) fields.user_code.value = u.user_code ?? fields.user_code.value;
				if (fields.user_name) fields.user_name.value = u.user_name ?? '';
				if (fields.username) fields.username.value = u.username ?? '';
				if (fields.user_telephone) fields.user_telephone.value = u.user_telephone ?? '';
				if (fields.user_contactname) fields.user_contactname.value = u.user_contactname ?? '';
				if (fields.user_address) fields.user_address.value = u.user_address ?? '';
				if (fields.user_province) fields.user_province.value = u.user_province ?? '';
				if (fields.user_district) fields.user_district.value = u.user_district ?? '';
				if (fields.user_zipcode) fields.user_zipcode.value = u.user_zipcode ?? '';
				if (fields.academic_year) fields.academic_year.value = u.academic_year ?? '';
				if (fields.academic_term) fields.academic_term.value = u.academic_term ?? '';

				if (fields.faculty_id && u.faculty_id !== undefined) fields.faculty_id.value = String(u.faculty_id ?? '');
				if (fields.major_id && u.major_id !== undefined) fields.major_id.value = String(u.major_id ?? '');
			};

			const loadLookups = async (u) => {
				const [fac, maj] = await Promise.all([
					fetch(`${APP_BASE}/backend/api/get_faculty.php`).then((r) => r.json()).catch(() => []),
					fetch(`${APP_BASE}/backend/api/get_major.php`).then((r) => r.json()).catch(() => []),
				]);
				fillSelect(fields.faculty_id, Array.isArray(fac) ? fac : [], u?.faculty_id);
				fillSelect(fields.major_id, Array.isArray(maj) ? maj : [], u?.major_id);
			};

			const loadMe = async () => {
				setStatus('กำลังโหลด...');
				try {
					const res = await fetch(`${APP_BASE}/backend/api/get_me.php`, { headers: { 'Accept': 'application/json' } });
					const payload = await res.json();
					if (!payload?.success || !payload.user) throw new Error(payload?.message || 'โหลดข้อมูลไม่สำเร็จ');
					applyUser(payload.user);
					await loadLookups(payload.user);
					setStatus('');
				} catch (e) {
					console.error(e);
					setStatus('โหลดข้อมูลไม่สำเร็จ');
				}
			};

			if (reloadBtn) reloadBtn.addEventListener('click', loadMe);
			loadMe();

			if (form) {
				form.addEventListener('submit', async (e) => {
					e.preventDefault();
					if (saveBtn) saveBtn.disabled = true;
					setStatus('กำลังบันทึก...');

					try {
						const fd = new FormData(form);
						const res = await fetch(`${APP_BASE}/backend/api/update_me.php`, {
							method: 'POST',
							body: fd,
							headers: { 'Accept': 'application/json' },
						});
						const payload = await res.json().catch(() => null);
						if (!payload?.success) throw new Error(payload?.message || 'บันทึกไม่สำเร็จ');
						setStatus('');
						await Swal.fire({
							title: 'บันทึกสำเร็จ',
							icon: 'success',
							confirmButtonColor: '#7c3aed',
						});
						loadMe();
					} catch (err) {
						console.error(err);
						setStatus('');
						Swal.fire({
							title: 'บันทึกไม่สำเร็จ',
							text: String(err?.message || 'ลองใหม่อีกครั้ง'),
							icon: 'error',
							confirmButtonColor: '#7c3aed',
						});
					} finally {
						if (saveBtn) saveBtn.disabled = false;
					}
				});
			}
		})();
	</script>
</body>
</html>
