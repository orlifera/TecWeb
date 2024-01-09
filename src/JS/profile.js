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


document.addEventListener('DOMContentLoaded', function () {
  if (first) {
    first.classList.remove('hidden');
    first.classList.add('show');
  }
  document.querySelectorAll('.sidenav a').forEach(link => {
    link.addEventListener('click', function (event) {
      event.preventDefault();
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