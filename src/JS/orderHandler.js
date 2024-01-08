let ordine = document.getElementById("processOrder");

function order() {
  var quantityInput = document.querySelector(".quantity").value;
  var scriptTag = document.querySelector('script[src$="orderHandler.js"]');
  var id = scriptTag.getAttribute("data-id");

  var quantita = scriptTag.getAttribute("data-quantita");
  if (id) {
    var url =
      "../php/order.php?id=" +
      id +
      "&quantitaOrdinata=" +
      (quantityInput == quantita ? quantita : quantityInput);
    window.location.href = url;
  } else {
    alert("Carrello vuoto!");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  ordine.addEventListener("click", order);
});
