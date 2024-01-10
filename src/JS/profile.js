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
      this.parentElement.classList.add('active');

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
});
