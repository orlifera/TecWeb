// croce per togliere banner
var banner = document.querySelectorAll(".banner");
var cross_msg = document.querySelectorAll(".cross-msg");
document.addEventListener('click', function (event) {
    cross_msg.forEach(cross => {
        if (cross.contains(event.target)) {
            banner.forEach(banner => {
                banner.classList.add("hidden");
            });
            cross.classList.add("hidden");
        }
    });
});