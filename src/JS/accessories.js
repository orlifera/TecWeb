let acc = document.getElementById("accessories");

function showAccessories() {
  window.location.href = "../php/getCatalogAccessories.php";
}

document.addEventListener("DOMContentLoaded", function () {
  acc.addEventListener("click", showAccessories);
});
