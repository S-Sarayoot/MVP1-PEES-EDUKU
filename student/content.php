<?php
require_once __DIR__ . '/../backend/config/credential.php';

function path_external(string $type, string $file): string {
		$parts = explode('/', (string)($_SERVER['REQUEST_URI'] ?? ''));
		$parts = array_values(array_filter($parts));

		$prefix = '';
		foreach ($parts as $index => $part) {
				if ($index > 0 && $part !== 'workshop') {
						break;
				}
				$prefix .= '../';
		}

		return $prefix . ($type === '' ? '' : $type . '/') . $file;
}

function path_image(string $type, string $file): string {
		return path_external($type, $file);
}

function Breadcrumb(): array {
		$parts = explode('/', (string)($_SERVER['REQUEST_URI'] ?? ''));
		$parts = array_values(array_filter($parts));

		$newPath = [];
		foreach ($parts as $index => $part) {
				$newPath[$index] = [
						'name' => ($index === 0 ? 'Home' : $part),
						'path' => 'https://dev.kittelweb.xyz/' . implode('/', array_slice($parts, 0, $index + 1)),
				];
		}
		return $newPath;
}

$Breadcrumb = Breadcrumb();
$pageTitle = 'Content';
?>

<!doctype html>
<html lang="th">
<head>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
	<link href="<?php echo path_external('', 'global.css'); ?>" rel="stylesheet">
	<script src="<?php echo path_external('', 'global.js'); ?>"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js" crossorigin="anonymous"></script>
	<title>EquityLearnKU - <?php echo htmlspecialchars($pageTitle); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-gray-100">
	<div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto">

		<div class="bg-white w-full h-14 fixed top-0 left-0 md:hidden">
			<button id="openSidebar" class="md:hidden py-3 px-4 text-xl font-bold text-[#866BC2]">☰</button>
		</div>

		<div id="sidebar" class="fixed md:static row-span-10 md:row-span-12 md:col-span-3 xl:col-span-2 top-0 left-0 md:mt-2 h-screen max-w-[300px] px-4 bg-white flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0 md:h-[calc(100vh-25px)] md:max-w-[300px] rounded-r-2xl text-gray-800 shadow-xl z-40">
			<div class="flex items-center py-3 font-semibold text-base mb-4 mt-3">
				<button id="openSidebar2" class="md:hidden px-2 text-xl font-bold text-[#866BC2]">☰</button>
				<img src="<?php echo path_image('image', 'logo.png'); ?>" alt="Logo" class="h-8 w-9 md:h-10 md:w-11 xl:h-11 xl:w-12 ms-6">
				<h1 class="text-lg md:text-lg xl:text-lg ps-2 xl:ps-3 font-bold antialiased text-[#866BC2]">EquityLearnKU</h1>
			</div>
			<hr class="border-[#866BC2] mb-4 mx-5">
			<nav class="flex-1 overflow-y-auto w-full">
				<ul id="nav-data" class="space-y-2 px-2 max-md:w-60 text-sm lg:text-base text-gray-700"></ul>
			</nav>
		</div>

		<div class="flex flex-wrap justify-between items-center md:col-span-9 xl:col-span-10 row-span-1 bg-[#9886CE] w-full h-full rounded-bl-xl shadow-lg max-md:hidden">
			<form class="max-w-md ms-3">
				<div class="flex items-center relative">
					<div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
						<svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
						</svg>
					</div>
					<input type="search" id="search" class="block w-sm lg:w-md h-full py-1.5 ps-10 text-sm text-gray-900 border border-purple-300 rounded-lg bg-purple-50 focus:ring-purple-500 focus:border-purple-500" placeholder="Search" required />
					<button type="submit" class="absolute right-2 text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-white rounded-lg text-sm lg:text-sm px-2 h-[80%] lg:px-3">Search</button>
				</div>
			</form>
			<div class="flex items-center bg-white rounded-full w-56 mr-3 my-1">
				<div class="bg-purple-100 text-purple-800 rounded-full py-1 px-1.5 flex-shrink-0">
					<svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
					</svg>
				</div>
				<p id="nameuser" class="grow text-left text-base text-purple-800 font-semibold truncate"><?php echo $credential_user_name ?? ''; ?></p>
				<button id="logoutBtn" class="ml-2 px-4 py-1.5 text-sm text-white bg-purple-700 rounded-full hover:bg-purple-800 whitespace-nowrap flex-shrink-0">
					<svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M13 2C10.2386 2 8 4.23858 8 7C8 7.55228 8.44772 8 9 8C9.55228 8 10 7.55228 10 7C10 5.34315 11.3431 4 13 4H17C18.6569 4 20 5.34315 20 7V17C20 18.6569 18.6569 20 17 20H13C11.3431 20 10 18.6569 10 17C10 16.4477 9.55228 16 9 16C8.44772 16 8 16.4477 8 17C8 19.7614 10.2386 22 13 22H17C19.7614 22 22 19.7614 22 17V7C22 4.23858 19.7614 2 17 2H13Z" fill="#ffffffff"/>
						<path d="M3 11C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13H11.2821C11.1931 13.1098 11.1078 13.2163 11.0271 13.318C10.7816 13.6277 10.5738 13.8996 10.427 14.0945C10.3536 14.1921 10.2952 14.2705 10.255 14.3251L10.2084 14.3884L10.1959 14.4055L10.1915 14.4115C10.1914 14.4116 10.191 14.4122 11 15L10.1915 14.4115C9.86687 14.8583 9.96541 15.4844 10.4122 15.809C10.859 16.1336 11.4843 16.0346 11.809 15.5879L11.8118 15.584L11.822 15.57L11.8638 15.5132C11.9007 15.4632 11.9553 15.3897 12.0247 15.2975C12.1637 15.113 12.3612 14.8546 12.5942 14.5606C13.0655 13.9663 13.6623 13.2519 14.2071 12.7071L14.9142 12L14.2071 11.2929C13.6623 10.7481 13.0655 10.0337 12.5942 9.43937C12.3612 9.14542 12.1637 8.88702 12.0247 8.7025C11.9553 8.61033 11.9007 8.53682 11.8638 8.48679L11.822 8.43002L11.8118 8.41602L11.8095 8.41281C11.4848 7.96606 10.859 7.86637 10.4122 8.19098C9.96541 8.51561 9.86636 9.14098 10.191 9.58778L11 9C10.191 9.58778 10.1909 9.58773 10.191 9.58778L10.1925 9.58985L10.1959 9.59454L10.2084 9.61162L10.255 9.67492C10.2952 9.72946 10.3536 9.80795 10.427 9.90549C10.5738 10.1004 10.7816 10.3723 11.0271 10.682C11.1078 10.7837 11.1931 10.8902 11.2821 11H3Z" fill="#ffffffff"/>
					</svg>
				</button>
			</div>
		</div>

		<script>
			window.onload = function () {
				const openSidebar = document.getElementById('openSidebar');
				const openSidebar2 = document.getElementById('openSidebar2');
				const sidebar = document.getElementById('sidebar');
				[openSidebar, openSidebar2].forEach(btn => {
					if (btn && sidebar) {
						btn.onclick = function () {
							sidebar.classList.toggle('translate-x-0');
							sidebar.classList.toggle('-translate-x-full');
						};
					}
				});
			};
		</script>

		<div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
			<p class="text-gray-700 mb-4 mr-4">
				<?php
					foreach ($Breadcrumb as $index => $item) {
						if (count($Breadcrumb) === 1) {
							break;
						}
						if ($index === count($Breadcrumb) - 1) {
							echo '<span class="text-gray-700 mb-4 mr-4">' . htmlspecialchars($item['name']) . '</span>';
						} else {
							echo '<a href="' . htmlspecialchars($item['path']) . '" class="text-gray-400 hover:font-semibold hover:text-[#433878]">' . htmlspecialchars($item['name']) . '</a> &gt; ';
						}
					}
				?>
			</p>

			<div class="w-full py-8">
				<article class="bg-white rounded-xl shadow-md p-6">
					<h1 class="text-3xl font-bold mb-4">วิดีโอสอนเรื่องแรงและการเคลื่อนที่</h1>
					<div class="mb-6">
						<div class="aspect-w-16 aspect-h-9 mb-4">
							<iframe class="rounded-lg w-full h-200" src="https://www.youtube.com/embed/xe_vvMlX3MQ" title="YouTube video" frameborder="0" allowfullscreen></iframe>
						</div>
						<div class="text-gray-600 text-sm mb-2">
							โดย <span class="font-semibold">ครูสมชาย ใจดี</span> | หมวดหมู่: <span class="font-semibold">วิดีโอ</span>
						</div>
					</div>
					<div class="prose max-w-none mb-6">
						<p>วิดีโอการสอนนี้นำเสนอเนื้อหาเกี่ยวกับแรงและการเคลื่อนที่ในชีวิตประจำวัน พร้อมตัวอย่างและกิจกรรมให้ผู้เรียนได้ทดลองปฏิบัติจริง</p>
						<p>เนื้อหาในวิดีโอประกอบด้วยการอธิบายหลักการของแรงประเภทต่าง ๆ เช่น แรงโน้มถ่วง แรงเสียดทาน และแรงแม่เหล็ก พร้อมตัวอย่างสถานการณ์จริงที่พบในชีวิตประจำวัน เช่น การผลัก การดึง และการเคลื่อนที่ของวัตถุ</p>
						<p>ผู้เรียนจะได้ฝึกคิดวิเคราะห์ผ่านกิจกรรมทดลอง เช่น การใช้ลูกบอลกลิ้งบนพื้นผิวต่าง ๆ เพื่อสังเกตผลของแรงเสียดทาน และการทดลองสร้างแรงด้วยอุปกรณ์ง่าย ๆ เพื่อเข้าใจหลักการพื้นฐานของฟิสิกส์</p>
						<p>วิดีโอนี้เหมาะสำหรับนักเรียนระดับมัธยมศึกษาตอนต้นที่ต้องการเสริมความเข้าใจในบทเรียนฟิสิกส์ และสามารถนำไปประยุกต์ใช้ในชีวิตประจำวันได้จริง</p>
					</div>
					<a href="https://www.youtube.com/watch?v=xe_vvMlX3MQ" target="_blank" rel="noopener" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">ดูวิดีโอฉบับเต็ม</a>
				</article>
			</div>
		</div>
	</div>
</body>
</html>
