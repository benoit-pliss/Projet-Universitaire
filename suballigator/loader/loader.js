document.addEventListener("DOMContentLoaded", function () {
    loader = document.getElementById("loader");
    setTimeout(function () {
      loader.style.opacity = 0;
    }, 1000);
    setTimeout(function () {
      loader.style.visibility = "hidden";
    }, 1000);
  });