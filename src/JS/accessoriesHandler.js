let acc = document.getElementById("accessories");

function showAccessories() {
  var scriptTag = document.querySelector(
    'script[src$="accessoriesHandler.js"]'
  );
  var riferimento = scriptTag.getAttribute("data-riferimento");
  window.location.href =
    "../php/getCatalog.php?categoria=acc&riferimento=" + riferimento;
}

document.addEventListener("DOMContentLoaded", function () {
  acc.addEventListener("click", showAccessories);
});
