// document.addEventListener('DOMContentLoaded', function () {

//     // Handle focus on the dropdown button
//     const dropButton = document.getElementById('drop-p');
//     dropButton.addEventListener('keydown', function (event) {
//         if (event.key === 'Enter' || event.key === ' ') {
//             // Toggle dropdown visibility
//             const dropdownList = this.nextElementSibling;
//             const isVisible = dropdownList.style.display === 'block';
//             dropdownList.style.display = isVisible ? 'none' : 'block';
//         }
//     });

//     // Get all dropdown links
//     const dropdownLinks = document.querySelectorAll('ul.dropdown-list a');
//     if (dropdownLinks.length > 0) {
//         // Close dropdown when focus moves away from the last link
//         const lastDropdownLink = dropdownLinks[dropdownLinks.length - 1];
//         lastDropdownLink.addEventListener('blur', function (event) {
//             const nextActiveElement = event.relatedTarget;
//             if (!nextActiveElement || !nextActiveElement.closest('.dropdown-list')) {
//                 this.closest('ul.dropdown-list').style.display = 'none';
//             }
//         });

//         // Handle Shift+Tab on the first dropdown link
//         const firstDropdownLink = dropdownLinks[0];
//         firstDropdownLink.addEventListener('keydown', function (event) {
//             if (event.key === 'Tab' && event.shiftKey) {
//                 this.closest('ul.dropdown-list').style.display = 'none';
//             }
//         });
//     }

//     // Close dropdown when clicking outside
//     document.addEventListener('click', function (event) {
//         if (!event.target.matches('#drop-p, .dropdown-list *')) {
//             document.querySelectorAll('.dropdown-list').forEach(menu => {
//                 menu.style.display = 'none';
//             });
//         }
//     });

//     // Close dropdown when mouse clicks outside
//     document.addEventListener('click', function (event) {
//         if (!event.target.matches('#drop-p, .dropdown-list *')) {
//             document.querySelectorAll('.dropdown-list').forEach(menu => {
//                 menu.style.display = 'none';
//             });
//         }
//     });

// });


document.addEventListener('DOMContentLoaded', function () {

    // Function to toggle dropdown visibility
    function toggleDropdown(dropdownTrigger) {
        const dropdownList = dropdownTrigger.nextElementSibling;
        if (dropdownList && dropdownList.classList.contains('dropdown-list')) {
            const isVisible = dropdownList.style.display === 'block';
            dropdownList.style.display = isVisible ? 'none' : 'block';
        }
    }

    // Function to close dropdown
    function closeDropdown(dropdownList) {
        if (dropdownList) {
            dropdownList.style.display = 'none';
        }
    }

    // Handle keydown and focus events for all dropdown triggers
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                toggleDropdown(this);
            }
        });

        //handles focus on tab
        // trigger.addEventListener('focus', function () {
        //     toggleDropdown(this);
        // });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        if (!event.target.matches('.dropdown-trigger, .dropdown-list *')) {
            document.querySelectorAll('.dropdown-list').forEach(closeDropdown);
        }
    });

    // Handle focus change within dropdown
    document.querySelectorAll('.dropdown-list').forEach(function (list) {
        list.addEventListener('focusout', function (event) {
            if (!this.contains(event.relatedTarget)) {
                closeDropdown(this);
            }
        });
    });

});
