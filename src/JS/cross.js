var banner = document.querySelectorAll(".banner");
var cross = document.querySelectorAll(".cross");

document.addEventListener('click', function (event) {
    cross.forEach(cross => {
        if (cross.contains(event.target)) {
            banner.forEach(banner => {
                banner.classList.add("hidden");
            });
        }
        cross.classList.add("hidden");
    });
});