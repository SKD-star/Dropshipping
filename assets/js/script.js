/**
 * NovaDrop Admin Master Interactive Script
 */

document.addEventListener("DOMContentLoaded", function () {
  const savedMode = localStorage.getItem("theme_mode") || "light";
  if (savedMode === "dark") {
    document.body.classList.add("dark-mode");
    document.body.classList.remove("light-mode");
    const toggleIcon = document.querySelector(".btn-toggle i");
    if (toggleIcon) {
      toggleIcon.classList.remove("fa-sun");
      toggleIcon.classList.add("fa-moon");
    }
  } else {
    document.body.classList.add("light-mode");
    document.body.classList.remove("dark-mode");
  }

  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("keyup", searchTable);
  }
});

function toggleMode() {
  const body = document.body;
  const toggleIcon = document.querySelector(".btn-toggle i");
  if (body.classList.contains("dark-mode")) {
    body.classList.remove("dark-mode");
    body.classList.add("light-mode");
    localStorage.setItem("theme_mode", "light");
    if (toggleIcon) {
      toggleIcon.classList.remove("fa-moon");
      toggleIcon.classList.add("fa-sun");
    }
  } else {
    body.classList.remove("light-mode");
    body.classList.add("dark-mode");
    localStorage.setItem("theme_mode", "dark");
    if (toggleIcon) {
      toggleIcon.classList.remove("fa-sun");
      toggleIcon.classList.add("fa-moon");
    }
  }
}

function toggleNavbar() {
  const navbarCollapse = document.getElementById("navbar-nav");
  if (!navbarCollapse) return;
  navbarCollapse.classList.toggle("shownav");
  navbarCollapse.classList.toggle("show");
}

function searchTable() {
  const input = document.getElementById("searchInput");
  if (!input) return;
  const filter = input.value.toLowerCase().trim();
  const table = document.getElementById("userTable") || document.querySelector(".usr-table");
  if (!table) return;
  const tr = table.getElementsByTagName("tr");

  for (let i = 1; i < tr.length; i++) {
    let rowText = tr[i].textContent || tr[i].innerText;
    if (rowText.toLowerCase().indexOf(filter) > -1) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}
