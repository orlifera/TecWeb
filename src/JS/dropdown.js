document.addEventListener('DOMContentLoaded', function () {
    
    const menu = document.getElementById('menu');
    closeAllDropdowns();
    // Function to open or close a specific dropdown
    function toggleDropdown(dropdownList) {
        if (dropdownList.classList.contains('hidden')) {
            // Open the dropdown
            dropdownList.classList.remove('hidden');
            dropdownList.classList.add('show');
        } else {
            // Close the dropdown
            dropdownList.classList.remove('show');
            dropdownList.classList.add('hidden');
        }
    }

    // Close all dropdowns
    function closeAllDropdowns() {
        menu.querySelectorAll('.show').forEach(dropdown => {
            dropdown.classList.remove('show');
            dropdown.classList.add('hidden');
        });
    }

    // Handle keydown events for dropdown triggers
    const dropdownTriggers = menu.querySelectorAll('.dropdown-trigger');
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                console.log("primo if")
                event.preventDefault(); // Prevent the default action
                const dropdownList = this.nextElementSibling;
                toggleDropdown(dropdownList);
            }
        });

        // Close dropdown when reverse tabbing from the trigger
        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Tab' && event.shiftKey) {
                const dropdownList = this.nextElementSibling;
                if (dropdownList.classList.contains('show')) {
                    toggleDropdown(dropdownList, false);
                }
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (event) {
        if (!event.target.matches('#menu .dropdown-trigger, .dropdown-list, .dropdown-list *')) {
            closeAllDropdowns();
        }
    });

    // Manage focus within dropdown lists
    document.querySelectorAll('.dropdown-list').forEach(function (list) {
        list.addEventListener('keydown', function (event) {
            if (event.key === 'Tab') {
                const focusableElements = 'a[href], button:not([disabled])';
                const visibleElements = Array.from(this.querySelectorAll(focusableElements));
                const firstElement = visibleElements[0];
                const lastElement = visibleElements[visibleElements.length - 1];

                if (event.shiftKey && document.activeElement === firstElement) {
                    // Close dropdown and move focus to the dropdown trigger
                    toggleDropdown(this, false);
                    this.previousElementSibling.focus();
                } else if (!event.shiftKey && document.activeElement === lastElement) {
                    // Close dropdown when tabbing forward from the last element
                    toggleDropdown(this, false);
                }
            }
        });
    });

});
