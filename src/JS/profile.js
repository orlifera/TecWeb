// Ottieni tutti i link nella navbar
// const links = document.querySelectorAll('.sidenav a');

// // Aggiungi un gestore di eventi a ciascun link
// links.forEach(link => {
//   link.addEventListener('click', (event) => {
//     event.preventDefault();

//     // Ottieni il valore dell'attributo data-target
//     const targetId = link.getAttribute('data-target');

//     // Ottieni il fieldset corrispondente
//     const targetFieldset = document.getElementById(targetId);

//     // Nascondi tutti i fieldset
//     const allFieldsets = document.querySelectorAll('fieldset');
//     allFieldsets.forEach(fieldset => {
//       fieldset.classList.remove('show');
//     });

//     // Mostra solo il fieldset corrispondente al link cliccato
//     targetFieldset.classList.add('show');
//   });
// });

const first = document.getElementById('personalInfo');
let firstNav = document.getElementById('firstNav');
let exp = document.getElementById('expiry-date');


document.addEventListener('DOMContentLoaded', function () {

  if (first) {
    first.classList.remove('hidden');
    first.classList.add('show');
    firstNav.classList.add('active');
  }

  document.querySelectorAll('.sidenav a').forEach(link => {
    link.addEventListener('click', function (event) {
      event.preventDefault();

      // Remove active class from all nav items
      document.querySelectorAll('.nav-item').forEach(navItem => {
        navItem.classList.remove('active');
      });

      // Add active class to clicked nav item's parent li
      if (this.parentElement.classList.contains('nav-item')) {
        this.parentElement.classList.add('active');
      }

      const targetId = this.getAttribute('data-target');

      // Hide all fieldsets
      document.querySelectorAll('fieldset').forEach(fieldset => {
        fieldset.classList.remove('show');
        fieldset.classList.add('hidden');
      });

      // Show the targeted fieldset
      const targetFieldset = document.getElementById(targetId);
      if (targetFieldset) {
        targetFieldset.classList.remove('hidden');
        targetFieldset.classList.add('show');
      }
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

});