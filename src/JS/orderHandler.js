let ordine = document.getElementById("processOrder");

function order() {
  var quantityInput = document.querySelector(".quantity").value;
  var prezzo = document.getElementsByClassName("product-price")[0].innerHTML;
  prezzo = prezzo.replace("€", "");
  var scriptTag = document.querySelector('script[src$="orderHandler.js"]');
  var id = scriptTag.getAttribute("data-id");
  var quantita = scriptTag.getAttribute("data-quantita");
  var oggetti = scriptTag.getAttribute("data-oggetti");
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
