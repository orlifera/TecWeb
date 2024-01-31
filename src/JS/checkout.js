// gestione del checkout
let ordine = document.getElementById("proceed");

function order() {
  var nome = document.getElementById("fname");

  var cognome = document.getElementById("lname");

  var email = document.getElementById("email");
  var phone = document.getElementById("phone");
  var indirizzo = document.getElementById("address");
  var citta = document.getElementById("city");
  var cap = document.getElementById("cap");

  var urlRiferimento = new URL(window.location.href);
  var id = urlRiferimento.searchParams.get("id");
  var quantitaOrdinata = urlRiferimento.searchParams.get("quantitaOrdinata");
  var prezzo = urlRiferimento.searchParams.get("prezzo");
  var oggetti = urlRiferimento.searchParams.get("oggetti");

  if (id) {
    var url =
      "../php/order.php?id=" +
      id +
      "&quantitaOrdinata=" +
      quantitaOrdinata +
      "&nome=" +
      nome.value +
      "&cognome=" +
      cognome.value +
      "&email=" +
      email.value +
      "&phone=" +
      phone.value +
      "&indirizzo=" +
      indirizzo.value +
      "&citta=" +
      citta.value +
      "&cap=" +
      cap.value +
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
