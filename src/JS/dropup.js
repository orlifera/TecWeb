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

function toggleDrop(event) {
  var trigger = event.currentTarget;
  var dropup = trigger.nextElementSibling;
  if(dropup && dropup.classList.contains("dropup-list")) {
    if (dropup.classList.contains("show")) {
      hideDrop(dropup, main);
    } 
    else if (dropup.classList.contains("hidden")) {
      showDrop(dropup, main);
    }
  }
}

document.addEventListener('DOMContentLoaded', function () {

  document.addEventListener('click', function (event) {
    var clicked = event.target.closest('.dropup-trigger');
    if (clicked) {
      console.log("clicked",clicked)
      toggleDrop(event);
    } else {
      closeAllDropUp();
    }
  });
  // document.querySelectorAll('.dropup-trigger').forEach(function (drop) {
  //   drop.addEventListener('click', toggleDrop);
  // });

});

function closeAllDropUp() {
  document.querySelectorAll('.dropup-list').forEach(drop => {
    if (drop.classList.contains('show')) hideDrop(drop, main);
  });
}

// document.addEventListener('click', function(event) {
//     var dropupList = document.querySelector('.dropup-list');
//     var dropupTrigger = document.querySelector('.dropup-trigger');

//     if (!(dropupList.contains(event.target) || dropupTrigger.contains(event.target))) {
//       closeAllDropUp();
//     }
//   });