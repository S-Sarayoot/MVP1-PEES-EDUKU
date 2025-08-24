function createSideBar(data) {
  console.log('Creating sidebar with data:', data);
  
  let ulSideBar = document.getElementById("nav-data");  

  data?.forEach((entry) => {
    let listData = document.createElement("li");  
    let linkData = document.createElement("a");  
  
    linkData.className = "flex items-center px-4 py-2 rounded hover:bg-gray-100";
  
    linkData.href = entry.path
    linkData.innerText = entry.name

    listData.appendChild(linkData);
    ulSideBar.appendChild(listData);
  })

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
      { name: "Dashboard", path: "/admin/dashboard_admin" },  
      { name: "คลังทรัพยากร", path: "/admin/store_admin" },
      { name: "workshop/แผนฯ", path: "/admin/user_admin" },
      { name: "ผู้ใช้งาน", path: "/admin/file_admin" },
      { name: "รายงาน/log", path: "/admin/file_admin" },
    ]
    localStorage.setItem("sideMenu", JSON.stringify(sideBarMenu));


    linkPage("/admin/dashboard_admin");
  }else if (username === "student" && password === "1234") {
    sideBarMenu = [
      { name: "Dashboard", path: "/student/" },  
      { name: "คลังทรัพยากร", path: "/student/store_student" },
      { name: "workshop/แผนฯ", path: "/student/user_student" },
      { name: "ระบบให้คำปรึกษา", path: "/student/file_student" },
      { name: "ระบบติดตามผลฯ", path: "/student/file_student" },
      { name: "ระบบของการสะท้อนความคิด", path: "/student/file_student" },
    ]
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

  createSideBar(localStorage.getItem("sideMenu") ? JSON.parse(localStorage.getItem("sideMenu")) : []);
  [allFiles, stores, users, online].forEach((info) => {
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
