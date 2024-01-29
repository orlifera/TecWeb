document.addEventListener('DOMContentLoaded', function () {
    var dropdownButtons = document.querySelectorAll('.dropbtn');

    dropdownButtons.forEach(function (dropdownButton) {
        dropdownButton.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            // Close all dropdowns before toggling the current one
            document.querySelectorAll(".dropdown-content.show").forEach(function (openDropdown) {
                openDropdown.classList.remove('show');
            });

            // Toggle the current dropdown
            this.nextElementSibling.classList.toggle('show');
        });
    });

    // Close all dropdowns if the user clicks outside of them
    window.addEventListener('click', function (event) {
        document.querySelectorAll(".dropdown-content.show").forEach(function (openDropdown) {
            openDropdown.classList.remove('show');
        });
    });
});
