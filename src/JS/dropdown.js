
document.addEventListener('DOMContentLoaded', function () {
    
    const menu = document.getElementById('menu');
    closeAllDropdowns();
    function toggleDropdown(dropdownList) {
        if (dropdownList.classList.contains('hidden')) {
            dropdownList.classList.remove('hidden');
            dropdownList.classList.add('show');
        } else {
            dropdownList.classList.remove('show');
            dropdownList.classList.add('hidden');
        }
    }

    // chiude tutti i dropdown
    function closeAllDropdowns() {
        menu.querySelectorAll('.show').forEach(dropdown => {
            dropdown.classList.remove('show');
            dropdown.classList.add('hidden');
        });
    }

    const dropdownTriggers = menu.querySelectorAll('.dropdown-trigger');
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                console.log("primo if")
                event.preventDefault(); 
                const dropdownList = this.nextElementSibling;
                toggleDropdown(dropdownList);
            }
        });

        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Tab' && event.shiftKey) {
                const dropdownList = this.nextElementSibling;
                if (dropdownList.classList.contains('show')) {
                    toggleDropdown(dropdownList, false);
                }
            }
        });
    });

    // chiude dropdown se clicco fuori
    document.addEventListener('click', function (event) {
        if (!event.target.matches('#menu .dropdown-trigger, .dropdown-list, .dropdown-list *')) {
            closeAllDropdowns();
        }
    });

    // reso accessibile con tab
    document.querySelectorAll('.dropdown-list').forEach(function (list) {
        list.addEventListener('keydown', function (event) {
            if (event.key === 'Tab') {
                const focusableElements = 'a[href], button:not([disabled])';
                const visibleElements = Array.from(this.querySelectorAll(focusableElements));
                const firstElement = visibleElements[0];
                const lastElement = visibleElements[visibleElements.length - 1];

                if (event.shiftKey && document.activeElement === firstElement) { 
                    toggleDropdown(this, false);
                    this.previousElementSibling.focus();
                } else if (!event.shiftKey && document.activeElement === lastElement) { // chiudi dropdown se si fa tab fuori dalla lista
                    toggleDropdown(this, false);
                }
            }
        });
    });

});
