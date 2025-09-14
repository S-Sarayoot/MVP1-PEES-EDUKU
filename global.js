const BASE_LINK = "https://dev.kittelweb.xyz";

function createSideBar(data) {
  console.log("Creating sidebar with data:", data);

  let ulSideBar = document.getElementById("nav-data");

  data?.forEach((entry) => {
    let listData = document.createElement("li");
    let linkData = document.createElement("a");

    linkData.className =
      "flex items-center px-4 py-2 rounded hover:bg-gray-100";

    linkData.href = entry.path;
    linkData.innerText = entry.name;

    listData.appendChild(linkData);
    ulSideBar.appendChild(listData);
  });
}

function linkPage(link) {
  window.location.href = link;
}

// login/Logout function
function checkLogin(event) {
  if (event) {
    event.preventDefault();
  }
  let username = document.getElementById("username").value;
  let password = document.getElementById("password").value;
  let alertBox = document.getElementById("alertBox");

  if (username === "admin" && password === "1234") {
    sideBarMenu = [
      { name: "Dashboard", path: BASE_LINK + "/admin/dashboard_admin" },
      { name: "คลังทรัพยากร", path: BASE_LINK + "/admin/storage_admin" },
      { name: "workshop/แผนฯ", path: BASE_LINK + "/admin/workshop_admin" },
      { name: "ผู้ใช้งาน", path: BASE_LINK + "/admin/users_admin" },
      { name: "ระบบให้คำปรึกษา", path: BASE_LINK + "/admin/consulting" },
      { name: "รายงาน/log", path: BASE_LINK + "/admin/log_admin" },
    ];
    localStorage.setItem("sideMenu", JSON.stringify(sideBarMenu));

   linkPage("/admin/dashboard_admin");
  }
  else if (username === "teacher" && password === "1234") {
    sideBarMenu = [
      { name: "Dashboard", path: BASE_LINK + "/teacher/dashboard" },
      { name: "คลังทรัพยากร", path: BASE_LINK + "/teacher/storage" },
      { name: "workshop/แผนฯ", path: BASE_LINK + "/teacher/workshop" },
      { name: "ระบบให้คำปรึกษา", path: BASE_LINK + "/teacher/consulting" },    ];
    localStorage.setItem("sideMenu", JSON.stringify(sideBarMenu));

   linkPage("/teacher/storage");
  }else if (username === "student" && password === "1234") {
    sideBarMenu = [
      { name: "Dashboard", path: BASE_LINK + "/student/" },
      { name: "คลังทรัพยากร", path: BASE_LINK + "/student/storage" },
      { name: "workshop/แผนฯ", path: BASE_LINK + "/student/workshop" },
      { name: "ระบบให้คำปรึกษา", path: BASE_LINK + "/student/consulting" },
      { name: "ระบบติดตามผลฯ", path: BASE_LINK + "/student/" },
      { name: "ระบบสะท้อนความคิด", path: BASE_LINK + "/student/" },
      { name: "ผู้ใช้งาน", path: BASE_LINK + "/student/user" },
    ];
    localStorage.setItem("sideMenu", JSON.stringify(sideBarMenu));

    linkPage("/student");
  } else {
    alertBox.classList.remove("hidden");

    setTimeout(() => {
      alertBox.classList.remove("translate-x-full");
      alertBox.classList.add("translate-x-0");
    }, 10);

    setTimeout(() => {
      alertBox.classList.remove("translate-x-0");
      alertBox.classList.add("translate-x-full");

      setTimeout(() => {
        alertBox.classList.add("hidden");
      }, 500);
    }, 3000);
  }
}

function logout() {
    if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
        localStorage.removeItem("sideMenu");
        window.location.href = "index";
    }
}

let sideBarMenu;
// admin function
document.addEventListener("DOMContentLoaded", () => {
    let allFiles = document.getElementById("allFile");
    let stores = document.getElementById("store");
    let users = document.getElementById("user");
    let online = document.getElementById("online");

    const btnLogin = document.getElementById("btn-login");
    btnLogin?.addEventListener("click", (e) => {
        e.preventDefault();
        checkLogin();
    });

    const savedMenu = localStorage.getItem("sideMenu");
    createSideBar(savedMenu ? JSON.parse(savedMenu) : []);
  [allFiles, stores, users, online].forEach((info) => {
    if (!info) return;
    switch (info.id) {
      case "allFile":
        info.textContent = "243";
        break;
      case "store":
        info.textContent = "12";
        break;
      case "user":
        info.textContent = "2590";
        break;
      case "online":
        info.textContent = "5";
        break;
      default:
        info.textContent = "0";
        break;
    }
  });
});

function toggleModal(show) {
    const modal = document.getElementById('uploadModal');
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
    } else {
        modal.classList.add('hidden');
    }
}
function checkAnswer(event) {
  event.preventDefault();
  let box = document.getElementById("score");
  box.innerHTML = ""; 
  let message = document.createElement("p");

  message.textContent = "อยู่ในระหว่างการตรวจสอบคำตอบ...";
  message.className = "text-base p-4 text-blue-600";

  box.appendChild(message);

  setTimeout(() => {
    message.remove();
    box.innerHTML += `
    <div class="text-xl border border-purple-500 shadow-md w-fit py-4 px-12 rounded-lg flex">
        <span class="text-green-500 text-center pr-2">5</span>
        <span class="text-center">/ 10</span>
    </div>
    `;
  }, 3000);
}



// teacher
const data = [
  { title: "นวัตกรรมตัวอย่างห้องเรียนเสมอภาค", desc: "Image", img: "https://www.eef.or.th/wp-content/uploads/2021/01/all-1-scaled-1-768x1024.jpeg", type: "image" },
  { title: "วีดีโอสอนภาษาอังกฤษ รหัสวิชา1022934", desc: "Videos", img: "https://i.ytimg.com/vi/71bDQNpPtOs/maxresdefault.jpg", type: "videos" },
  { title: "แหล่งการเรียนรู้แนะนำ", desc: "แหล่งการเรียนรู้แนะนำ", img: "https://media.the101.world/wp-content/uploads/2022/07/05140421/Sorravit_20220722_PolicyInsight-Banner.png", type: "learning" },
  { title: "แผนการจัดการเรียนรีู้ตัวอย่าง", desc: "แผนการจัดการเรียนรู้", img: "https://online.pubhtml5.com/lbvh/amtn/files/large/1.jpg?1622465202", type: "plan" },
  { title: "เกณฑ์การประเมิณคะแนน รหัสวิชา1022934", desc: "เกณฑ์การประเมิณ", img: "../image/rubric.png", type: "criteria" }
];
document.addEventListener("DOMContentLoaded", () => {
    const cardWrapper = document.getElementById("cardWrapper");
    const dropdownButton = document.getElementById("dropdownButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    function renderCards(filter = "all") {
        cardWrapper.innerHTML = "";
        let filtered = data;
        if (filter !== "all") {
            filtered = data.filter(item => item.type === filter);
        }

        filtered.forEach(item => {
            const card = `
                <div class="bg-gradient-to-r from-purple-500 to-purple-800 p-4 rounded-lg text-white shadow">
                    <img src="${item.img}" alt="${item.title}" class="w-full h-32 object-cover rounded">
                    <h3 class="mt-2 font-bold">${item.title}</h3>
                    <p class="text-sm">${item.desc}</p>
                    <button class="mt-2 px-3 py-1 bg-white/20 rounded">Read More</button>
                </div>
            `;
            cardWrapper.innerHTML += card;
        });
    }

    // dropdown
    dropdownButton?.addEventListener("click", () => {
        dropdownMenu.classList.toggle("hidden");
    });

    dropdownMenu?.querySelectorAll("a").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const filter = e.target.getAttribute("data-filter");
            renderCards(filter);
            dropdownMenu.classList.add("hidden");
        });
    });

    renderCards(); // โหลดครั้งแรก
});
