document.addEventListener('DOMContentLoaded', function () {

    // Function to open or close a specific dropdown
    function toggleDropdown(dropdownList, open = null) {
        const isHidden = dropdownList.classList.contains('hide');
        if (open === true || (open === null && isHidden)) {
            // Open the dropdown
            dropdownList.classList.remove('hide');
            dropdownList.classList.add('visible');
        } else if (open === false || (open === null && !isHidden)) {
            // Close the dropdown
            dropdownList.classList.add('hide');
            dropdownList.classList.remove('visible');
        }
    }

    // Close all dropdowns
    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-list.visible').forEach(dropdown => {
            dropdown.classList.remove('visible');
            dropdown.classList.add('hide');
        });
    }

    // Handle keydown events for dropdown triggers
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault(); // Prevent the default action
                const dropdownList = this.nextElementSibling;
                toggleDropdown(dropdownList);
            }
        });

        // Close dropdown when reverse tabbing from the trigger
        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Tab' && event.shiftKey) {
                const dropdownList = this.nextElementSibling;
                if (dropdownList.classList.contains('visible')) {
                    toggleDropdown(dropdownList, false);
                }
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (event) {
        if (!event.target.matches('.dropdown-trigger, .dropdown-list, .dropdown-list *')) {
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
