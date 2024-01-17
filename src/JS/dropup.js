function showDrop(q, p) { 
  q.classList.remove("hidden");
  q.classList.add("show");
  p.classList.add("obscured");
  console.log("show");
}

function hideDrop(q, p) {
  q.classList.remove("show");
  q.classList.add("hidden");
  p.classList.remove("obscured")
  console.log("remove");
}

var main = document.querySelector('main');

document.addEventListener('DOMContentLoaded', function () {
  document.addEventListener('click', function(event) {
    var trigger1 = document.getElementById("trigger1");
    var trigger2 = document.getElementById("trigger2");
    var drop1 = document.getElementById("drop-catalogo");
    var drop2 = document.getElementById("profile-dropup");
    if (trigger1.contains(event.target)) { 
      if (drop1.classList.contains("show")) {
        hideDrop(drop1, main);
      }
      else if (drop1.classList.contains("hidden")) {
        showDrop(drop1, main);
      }
    }
    else if (trigger2.contains(event.target)) {
      if (drop2.classList.contains("show")) {
        hideDrop(drop2, main);
      }
      if (drop2.classList.contains("hidden")) {
        showDrop(drop2, main);
      }
    }
    else if (!(trigger1.contains(event.target) || trigger2.contains(event.target))) {
      closeAllDropUp(drop1, drop2);
    }
  });
});

function closeAllDropUp(drop1, drop2) {
  hideDrop(drop1, main);
  hideDrop(drop2, main);
}