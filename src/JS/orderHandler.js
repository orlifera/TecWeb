// gestione degli ordini
let ordine = document.getElementById("processOrder");

function order() {
  var scriptTag = document.querySelector('script[src$="orderHandler.js"]');
  var id = scriptTag.getAttribute("data-id");
  var quantita = scriptTag.getAttribute("data-quantita");
  var oggetti = scriptTag.getAttribute("data-oggetti");
  var prezzo = scriptTag.getAttribute("data-prezzo");
  var sessione = scriptTag.getAttribute("data-sessione");

  if (id) {
    if (sessione == "non registrato") {
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
      var nome = scriptTag.getAttribute("data-nome");
      var cognome = scriptTag.getAttribute("data-cognome");
      var indirizzo = scriptTag.getAttribute("data-indirizzo");
      var citta = scriptTag.getAttribute("data-citta");
      var cap = scriptTag.getAttribute("data-cap");
      var email = scriptTag.getAttribute("data-email");
      var phone = scriptTag.getAttribute("data-phone");

      var url =
        "../php/order.php?id=" +
        id +
        "&quantitaOrdinata=" +
        quantita +
        "&prezzo=" +
        prezzo +
        "&oggetti=" +
        oggetti +
        "&nome=" +
        nome +
        "&cognome=" +
        cognome +
        "&indirizzo=" +
        indirizzo +
        "&citta=" +
        citta +
        "&cap=" +
        cap +
        "&email=" +
        email +
        "&phone=" +
        phone;

      window.location.href = url;
    }
  } else {
    alert("Carrello vuoto!");
    ordine.disabled = true;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  ordine.addEventListener("click", order);
});
