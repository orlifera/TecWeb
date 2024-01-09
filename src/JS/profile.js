// Ottieni tutti i link nella navbar
const links = document.querySelectorAll('.sidenav a');

// Aggiungi un gestore di eventi a ciascun link
links.forEach(link => {
  link.addEventListener('click', (event) => {
    event.preventDefault();

    // Ottieni il valore dell'attributo data-target
    const targetId = link.getAttribute('data-target');

    // Ottieni il fieldset corrispondente
    const targetFieldset = document.getElementById(targetId);

    // Nascondi tutti i fieldset
    const allFieldsets = document.querySelectorAll('fieldset');
    allFieldsets.forEach(fieldset => {
      fieldset.classList.remove('show');
    });

    // Mostra solo il fieldset corrispondente al link cliccato
    targetFieldset.classList.add('show');
  });
});

// let info = document.getElementById('personalInfo'), 
//     changePsw = document.getElementById('changePsw'), 
//     address = docuemnt.getElementById('address'), 
//     payments = document.getElementById('payment'), 
//     fieldset = document.querySelector('fieldProfile'); 


//     function showCard(...contents) {
//         contents.forEach(contents => {
//             if (contents.classList.contains("hidden"))
//                 contents.classList.remove("hidden");
//             contents.classList.add("show");
//         });
//     }

//     function hideCard(...contents) {
//         contents.forEach(contents => {
//             if (contents.classList.contains("show"))
//                 contents.classList.remove("show");
//             contents.classList.add("hidden");
//         });
//     }

//     function switchCard(toHide, toShow) {
//         hideCard(toHide);
//         showCard(toShow);
//     }
// document.addEventListener('DOMContentLoaded', function(){

//     fieldset.addEventListener('click', function(){
//         if(fieldset.classList.contains('hidden')){
//             switchCard()
//         }
//     })

// }); 

