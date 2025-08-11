<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="./global.js"></script>
  <title>EDU KU</title>
</head>

<body>
  <!-- left -->
  <div class="lg:flex justify-center items-center h-screen bg-[#866BC2]">
    <div class="flex flex-1 items-center justify-center h-full max-lg:hidden">
      <img src="./image/bookOpen.jpg" alt="logo" class="w-full h-full object-cover" />
    </div>
    <!--  -->
    <!-- right -->
    <div
      class="lg:flex-1 items-center justify-center h-full relative bg-white max-md:rounded-t-[120px] max-lg:rounded-t-[200px]">
      <form class="flex flex-col justify-center w-full h-full items-center p-4 border-1 border-gray-100 drop-shadow-md "
        onsubmit="checkLogin(event)">
        <div class="w-[85%] sm:w-[70%] md:w-[60%] lg:w-[75%] xl:w-[70%] 2xl:w-1/2">
          <div class="space-y-4">
            <div class=" w-full flex justify-center items-center mb-8">
              <img src="./image/logo.png" alt="Logo" class="h-16 w-17">
              <h1 class="text-4xl font-bold text-[#866BC2] ml-3 font-sans antialiased">EDU KU</h1>
            </div>
            <div>
              <label class="block text-gray-500 font-bold mb-1 md:mb-0 pr-4 pb-1" for="username">
                Username
              </label>
              <input
                class="bg-purple-50 appearance-none border-2 border-[#866BC2] rounded w-full py-2 px-4 text-gray-400 focus:outline-none focus:bg-white focus:border-purple-500"
                id="username" type="text" placeholder="กรุณากรอกชื่อผู้ใช้งาน" />
            </div>
            <div>
              <label class="block text-gray-500 font-bold mb-1 md:mb-0 pr-4 pb-1" for="inline-password">
                Password
              </label>
              <input
                class="bg-purple-50 appearance-none border-2 border-[#866BC2] rounded w-full py-2 px-4 text-gray-400 focus:outline-none focus:bg-white focus:border-purple-500"
                id="password" type="password" placeholder="กรอกรหัสผ่าน" />
            </div>
            <div class="flex flex-row items-center">
              <label class=" block text-violet-500 font-bold ">
                <input class="mr-2" type="checkbox" />
                <span class="text-md"> ลืมรหัสผ่าน? </span>
              </label>
            </div>
            <button
              class="w-full shadow bg-[#866BC2] hover:bg-purple-400 text-lg md:text-xl focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
              type="submit">
              ลงชื่อเข้าใช้
            </button>
          </div>
        </div>
      </form>
      <!-- alert error -->
      <div id="alertBox"
        class="hidden absolute bottom-5 right-4 transform translate-x-full transition-transform duration-500 bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md"
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
    <!--  -->
  </div>
  </div>
</body>

</html>