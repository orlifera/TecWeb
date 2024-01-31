// gestione degli ordini
let ordine = document.getElementById("processOrder");

function order() {
  var scriptTag = document.querySelector('script[src$="orderHandler.js"]');
  var id = scriptTag.getAttribute("data-id");
  var quantita = scriptTag.getAttribute("data-quantita");
  var oggetti = scriptTag.getAttribute("data-oggetti");
  var prezzo = scriptTag.getAttribute("data-prezzo");

  prezzoTotale = prezzo.split(",");

  alert(prezzoTotale);
  if (id) {
    var url =
      "../pages/checkout.html?id=" +
      id +
      "&quantitaOrdinata=" +
      quantita +
      "&prezzo=" +
      prezzo +
      "&oggetti=" +
      oggetti;
    window.location.href = url;
  } else {
    alert("Carrello vuoto!");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  ordine.addEventListener("click", order);
});
