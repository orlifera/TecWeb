var ham = document.getElementById("hamburger");
var side = document.querySelector(".sidenav");
var link = document.querySelectorAll(".nav-item");

function toggleHam() {
    if (!(side.classList.contains("open"))) {
        side.classList.add("open");
        ham.classList.add("visible");
    }
    else {
        side.classList.remove("open");
        ham.classList.remove("visible");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    side.classList.remove("open");
    ham.classList.remove("visible");

    ham.addEventListener("click", toggleHam);
    link.forEach(link => {
        link.addEventListener("click", toggleHam);
    });
});