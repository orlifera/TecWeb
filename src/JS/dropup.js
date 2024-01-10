function showDrop(q) { 
  q.classList.remove("hidden");
  q.classList.add("show");
}

function hideDrop(q) {
  q.classList.remove("show");
  q.classList.add("hidden");
}

function toggleDrop(event) {
  console.log("clicked", event.currentTarget);
  var trigger = event.currentTarget;
  var dropup = trigger.nextElementSibling;
  if (dropup.classList.contains("show")) {
    hideDrop(dropup);
  } 
  else if (dropup.classList.contains("hidden")) {
    showDrop(dropup);
  }
}

document.addEventListener('DOMContentLoaded', function () {

  document.querySelectorAll('.dropup-trigger').forEach(function (drop) {
        drop.addEventListener('click', toggleDrop);
    });

});

function closeAllDropUp() {
        var dropup = document.querySelector('.dropup-list');
        dropup.forEach(drop => {
            if (dropup.classList.contains('show')) hideDrop(drop);
        });
    }

document.addEventListener('click', function (event) {
        if (!event.target.matches('.dropup-trigger, .dropup-list, .dropup-list *')) {
            closeAllDropUp();
        }
    });