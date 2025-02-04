// gestione della sidenav 
const first = document.getElementById('personalInfo');
let firstNav = document.getElementById('firstNav');
let exp = document.getElementById('expiry-date');


document.addEventListener('DOMContentLoaded', function () {
  function showFieldset(targetId) {
    document.querySelectorAll('fieldset').forEach(fieldset => {
      fieldset.classList.remove('show');
      fieldset.classList.add('hidden');
    });

    document.querySelectorAll('.nav-item').forEach(navItem => {
      navItem.classList.remove('active');
    });

    const targetFieldset = document.getElementById(targetId);
    if (targetFieldset) {
      targetFieldset.classList.remove('hidden');
      targetFieldset.classList.add('show');
    }

    const activeNavItem = document.querySelector(`[data-target='${targetId}']`);
    if (activeNavItem && activeNavItem.parentElement.classList.contains('nav-item')) {
      activeNavItem.parentElement.classList.add('active');
    }
  }

  const savedFieldset = sessionStorage.getItem('activeFieldset');
  if (savedFieldset) {
    showFieldset(savedFieldset);
  } else {
    showFieldset('personalInfo');
  }

  document.querySelectorAll('.sidenav a').forEach(link => {
    link.addEventListener('click', function (event) {
      event.preventDefault();

      const targetId = this.getAttribute('data-target');
      showFieldset(targetId);

      sessionStorage.setItem('activeFieldset', targetId);
    });
  });

});

exp.addEventListener('input', function (e) {
  var input = e.target;
  var value = input.value;
  var length = value.length;
  var cursorPosition = input.selectionStart;

  if ((length === 3 && e.inputType === 'deleteContentBackward') ||
    (cursorPosition === 3 && e.inputType === 'deleteContentBackward')) {
    input.value = value.substring(0, 2);
    e.preventDefault();
  } else if (length === 2 && !value.includes('/')) {
    input.value = value + '/';
  }
});