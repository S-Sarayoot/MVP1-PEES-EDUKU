function linkPage(link) {
  window.location.href = link;
}

function checkLogin() {
  let username = document.getElementById("username").value;
  let password = document.getElementById("password").value;
  let alertBox = document.getElementById("alertBox");

  if (username === "admin" && password === "1234") {
    linkPage("https://dev.kittelweb.xyz/admin/dashboard_admin");
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

// admin function
document.addEventListener("DOMContentLoaded", () => {
  let allFiles = document.getElementById("allFile");
  let stores = document.getElementById("store");
  let users = document.getElementById("user");
  let online = document.getElementById("online");

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
