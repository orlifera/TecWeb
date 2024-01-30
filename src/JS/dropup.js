var main = document.querySelector('main');

function showDrop(q) { 
  q.classList.remove("hidden");
  q.classList.add("show");
}

function hideDrop(q) {
  q.classList.remove("show");
  q.classList.add("hidden");
}

document.addEventListener('DOMContentLoaded', function () {
  var trigger1 = document.getElementById("trigger1");
  var trigger2 = document.getElementById("trigger2");
  var drop1 = document.getElementById("drop-catalogo");
  var drop2 = document.getElementById("profile-dropup");
  var cross = document.querySelectorAll(".cross");

  closeAllDropUp(drop1, drop2); 
    document.addEventListener('click', function(event) {
    cross.forEach(cross => {
      if (cross.contains(event.target)) closeAllDropUp;
    });
    if (trigger1.contains(event.target)) { 
      if (drop1.classList.contains("show")) {
        hideDrop(drop1);
        main.classList.remove("obscured");
      }
      else if (drop1.classList.contains("hidden")) {
        showDrop(drop1);
        hideDrop(drop2);
        main.classList.add("obscured");
      }
    }
    else if (trigger2.contains(event.target)) {
      if (drop2.classList.contains("show")) {
        hideDrop(drop2);
        main.classList.remove("obscured");
      }
      else if (drop2.classList.contains("hidden")) {
        showDrop(drop2);
        hideDrop(drop1);
        main.classList.add("obscured");
      }
    }
    else if (!(trigger1.contains(event.target) || trigger2.contains(event.target))) {
      closeAllDropUp(drop1, drop2);
    }
  });
});

function closeAllDropUp(drop1, drop2) {
  hideDrop(drop1);
  hideDrop(drop2);
  main.classList.remove("obscured");
}