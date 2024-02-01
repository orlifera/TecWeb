// differenzia accessori tastiere e computer
let acc = document.getElementById("accessories");

function showAccessories(riferimento) {
  window.location.href =
    "../php/getCatalog.php?categoria=acc&riferimento=" + riferimento;
}

document.addEventListener("DOMContentLoaded", function () {
  var scriptTag = document.querySelector(
    'script[src$="accessoriesHandler.js"]'
  );
  var riferimento = scriptTag.getAttribute("data-riferimento");
  if (riferimento === "acc") {
    acc.parentNode.removeChild(acc);
  } else {
    acc.addEventListener("click", function () {
      showAccessories(riferimento);
    });
  }
});
