let ordine = document.getElementById("processOrder");

function order() {
  var scriptTag = document.querySelector('script[src$="orderHandler.js"]');
  var id = scriptTag.getAttribute("data-id");

  var quantita = scriptTag.getAttribute("data-quantita");

  if (id) {
    var url = "../php/order.php?id=" + id + "&quantitaOrdinata=" + quantita;
    window.location.href = url;
  } else {
    alert("Carrello vuoto!");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  ordine.addEventListener("click", order);
});
