const first = document.getElementById('personalInfo');
let firstNav = document.getElementById('firstNav');
let exp = document.getElementById('expiry-date');


document.addEventListener('DOMContentLoaded', function () {
  // Function to show a specific fieldset
  function showFieldset(targetId) {
    // Hide all fieldsets
    document.querySelectorAll('fieldset').forEach(fieldset => {
      fieldset.classList.remove('show');
      fieldset.classList.add('hidden');
    });

    // Remove active class from all nav items
    document.querySelectorAll('.nav-item').forEach(navItem => {
      navItem.classList.remove('active');
    });

    // Show the targeted fieldset
    const targetFieldset = document.getElementById(targetId);
    if (targetFieldset) {
      targetFieldset.classList.remove('hidden');
      targetFieldset.classList.add('show');
    }

    // Set the corresponding nav item as active
    const activeNavItem = document.querySelector(`[data-target='${targetId}']`);
    if (activeNavItem && activeNavItem.parentElement.classList.contains('nav-item')) {
      activeNavItem.parentElement.classList.add('active');
    }
  }

  // Check for saved fieldset in sessionStorage
  const savedFieldset = sessionStorage.getItem('activeFieldset');
  if (savedFieldset) {
    showFieldset(savedFieldset);
  } else {
    // Default to personalInfo if nothing is saved
    showFieldset('personalInfo');
  }

  // Add event listeners to nav links
  document.querySelectorAll('.sidenav a').forEach(link => {
    link.addEventListener('click', function (event) {
      event.preventDefault();

      const targetId = this.getAttribute('data-target');
      showFieldset(targetId);

      // Save the current fieldset to sessionStorage
      sessionStorage.setItem('activeFieldset', targetId);
    });
  });

});

exp.addEventListener('input', function (e) {
  var input = e.target;
  var value = input.value;
  var length = value.length;
  var cursorPosition = input.selectionStart;

  // Handle backspace/delete at slash
  if ((length === 3 && e.inputType === 'deleteContentBackward') ||
    (cursorPosition === 3 && e.inputType === 'deleteContentBackward')) {
    input.value = value.substring(0, 2);
    e.preventDefault();
  } else if (length === 2 && !value.includes('/')) {
    input.value = value + '/';
  }
});