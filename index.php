<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="./global.css" rel="stylesheet">
  <script src="./global.js"></script>
  <title>EDU KU</title>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
  <div class="h-screen overflow-hidden">

    <!-- left -->
    <div class="flex lg:justify-center lg:items-center h-full">
      <div class="flex-1 items-center justify-center h-full hidden lg:block">
        <img src="./image/bookOpen.jpg" alt="logo" class="w-full h-full object-cover" />
      </div>
      <!-- right -->
      <div class="flex-1 flex items-center justify-center h-full relative bg-gray-50">
        <form class="flex flex-col w-full h-full justify-center items-center border border-gray-100"
          onsubmit="checkLogin(event)">
          <div class="w-11/12 sm:w-4/5 md:w-3/5 lg:w-3/4 xl:w-7/10 2xl:w-1/2 shadow-xl bg-white p-4 rounded-xl">
            <div class="space-y-4">
              <div class="w-full flex justify-center items-center mb-6">
                <img src="./image/logo.png" alt="Logo" class="h-14 w-16">
                <h1 class="text-3xl font-bold text-[#866BC2] ml-3 antialiased">EDU KU</h1>
              </div>
              <div>
                <label class="block text-gray-500 font-bold mb-1 pr-4 pb-1" for="username">
                  Username
                </label>
                <div class="p-0.5 rounded-lg bg-gradient-to-r from-blue-500/50 to-purple-500/50 focus-within:from-purple-500 focus-within:to-blue-500">
                  <input type="text" id="username"
                    class="bg-purple-50 appearance-none rounded-lg w-full py-1 px-4 placeholder-gray-400 text-gray-700 focus:bg-white outline-none"
                    placeholder="กรอกชื่อผู้ใช้งาน..." />
                </div>
              </div>

              <div>
                <label class="block text-gray-500 font-bold mb-1 pr-4 pb-1" for="password">
                  Password
                </label>
                <div class="p-0.5 rounded-lg bg-gradient-to-r from-blue-500/50 to-purple-500/50 focus-within:from-purple-500 focus-within:to-blue-500">
                  <input type="password" id="password"
                    class="bg-purple-50 appearance-none rounded-lg w-full py-1 px-4 placeholder-gray-400 text-gray-700 focus:bg-white outline-none"
                    placeholder="กรอกรหัสผ่าน..." />
                </div>
              </div>
              <div class="mb-2">
                <a href="#" class="text-sm text-blue-500 hover:underline">ลืมรหัสผ่าน?</a>
              </div>
              <button
                class="cursor-pointer w-full text-base md:text-lg shadow-md bg-gradient-to-r from-blue-500 to-purple-500 hover:from-purple-500 hover:to-blue-500 transition hover:-translate-y-1 hover:shadow-lg text-white font-bold py-1 px-4 rounded"
                type="submit">
                ลงชื่อเข้าใช้
              </button>
              <div class="w-full flex justify-center">
                <button type="button" class="flex justify-center items-center w-full text-base md:text-lg shadow-md border-2 text-[#006c67] cursor-pointer border-[#006c67] hover:bg-[#006c67] hover:text-white transition hover:shadow-lg py-1 px-4 rounded" onclick="window.location.reload();">
                  KU All-Login
                </button>
              </div>
            </div>
          </div>
        </form>
        <!-- alert error -->
        <div id="alertBox"
          class="hidden absolute bottom-5 right-4 translate-x-full transition-transform duration-500 bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md"
          role="alert">
          <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <path
                  d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
              </svg></div>
            <div>
              <p class="font-bold">Login Error</p>
              <p class="text-sm">Username หรือ Password ไม่ถูกต้อง</p>
            </div>
          </div>
        </div>
        <!--  -->
      </div>
    </div>
  </div>
</body>

</html>
