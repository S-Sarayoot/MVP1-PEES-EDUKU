function linkPage(link) {
  window.location.href = link;
}

function checkLogin(event) {
  if (event) {
    event.preventDefault();
  }
  let username = document.getElementById("username").value;
  let password = document.getElementById("password").value;
  let alertBox = document.getElementById("alertBox");

  if (username === "admin" && password === "1234") {
    linkPage("./admin/dashboard_admin.php");
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
    window.location.href = "index.html";
  }
}
