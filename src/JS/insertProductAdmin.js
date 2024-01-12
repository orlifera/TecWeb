let aggiungiProdotto = document.querySelector(".inserisciProdotto");

let variabile_decisionale = "";

function insertProduct() {
  let scriptTag = document.querySelector(
    'script[src$="insertProductAdmin.js"]'
  );
  let category = scriptTag.getAttribute("data-categoria");

  if (category == "product") {
    var id = encodeURIComponent(document.getElementById("id").value);
    var nome = encodeURIComponent(document.getElementById("nome").value);
    var immagine = encodeURIComponent(
      document.getElementById("immagine").value
    );
    var categoria = document.getElementById("categoria").value;
    var disponibilita = encodeURIComponent(
      document.getElementById("disponibilita").value
    );
    var prezzo = encodeURIComponent(document.getElementById("prezzo").value);
    if (!/^\d+$/.test(disponibilita) && !/^\d+$/.test(prezzo)) {
      alert("Errore: inserimento valori non corretto");
      return;
    }

    var descrizione = encodeURIComponent(
      document.getElementById("descrizione").value
    );
    var colore = encodeURIComponent(document.getElementById("colore").value);
    variabile_decisionale = "product";

    var riferimento = "";
    if (
      id == "" ||
      nome == "" ||
      tipo == "" ||
      prezzo == "" ||
      immagine == "" ||
      categoria == "" ||
      disponibilita == "" ||
      descrizione == "" ||
      colore == ""
    ) {
      alert("Compila tutti i campi");
      return;
    }

    if (categoria == "pc" || categoria == "kbd") {
      riferimento = categoria;
    }

    var url =
      "../php/addProductOnDB.php?id=" +
      id +
      "&nome=" +
      nome +
      "&tipo=" +
      tipo +
      "&descrizione=" +
      descrizione +
      "&prezzo=" +
      prezzo +
      "&colore=" +
      colore +
      "&disponibilita=" +
      disponibilita +
      "&path=" +
      immagine +
      "&categoria=" +
      categoria +
      "&riferimento=" +
      riferimento +
      "&variabile_decisionale=" +
      variabile_decisionale;
  } else if (category == "sale") {
    var codice = encodeURIComponent(document.getElementById("codice").value);
    var data_emissione = encodeURIComponent(
      document.getElementById("data_emissione").value
    );
    var data_scadenza = encodeURIComponent(
      document.getElementById("data_scadenza").value
    );
    var username = encodeURIComponent(
      document.getElementById("username").value
    );
    var valore = encodeURIComponent(document.getElementById("valore").value);
    if (!/^\d+$/.test(valore)) {
      alert("Errore: inserimento valori non corretto");
      return;
    }
    variabile_decisionale = "sale";

    if (
      codice == "" ||
      data_emissione == "" ||
      data_scadenza == "" ||
      username == "" ||
      valore == ""
    ) {
      alert("Compila tutti i campi");
      return;
    }

    var url =
      "../php/addProductOnDB.php?id=" +
      codice +
      "&data_emissione=" +
      data_emissione +
      "&data_scadenza=" +
      data_scadenza +
      "&username=" +
      username +
      "&valore=" +
      valore +
      "&variabile_decisionale=" +
      variabile_decisionale;
  } else {
    var id = encodeURIComponent(document.getElementById("id").value);
    var utente = encodeURIComponent(document.getElementById("utente").value);
    var quantitaOrdinata = encodeURIComponent(
      document.getElementById("quantitaOrdinata").value
    );
    var indirizzo = encodeURIComponent(
      document.getElementById("indirizzo").value
    );
    var prezzo = encodeURIComponent(document.getElementById("prezzo").value);
    if (!/^\d+$/.test(prezzo) && !/^\d+$/.test(quantitaOrdinata)) {
      alert("Errore: inserimento valori non corretto");
      return;
    }
    variabile_decisionale = "order";

    if (
      id == "" ||
      utente == "" ||
      quantitaOrdinata == "" ||
      indirizzo == "" ||
      prezzo == ""
    ) {
      alert("Compila tutti i campi");
      return;
    }

    var url =
      "../php/addProductOnDB.php?id=" +
      id +
      "&utente=" +
      utente +
      "&quantitaOrdinata=" +
      quantitaOrdinata +
      "&indirizzo=" +
      indirizzo +
      "&prezzo=" +
      prezzo +
      "&variabile_decisionale=" +
      variabile_decisionale;
  }

  var conferma = confirm("Sei sicuro di voler procedere?");

  // Se l'utente conferma, chiamiamo la funzione callphp
  if (conferma) {
    callphp(url);
  } else {
  }
}

// function insertSale() {
//   var codice = document.getElementById("codice").value;
//   var data_emissione = document.getElementById("data_emissione").value;
//   var data_scadenza = document.getElementById("data_scadenza").value;
//   var username = document.getElementById("username").value;
//   var valore = document.getElementById("valore").value;
//   var isUsed = false;
//   variabile_decisionale = "sale";
//   if (
//     codice == "" ||
//     data_emissione == "" ||
//     data_scadenza == "" ||
//     username == "" ||
//     valore == ""
//   ) {
//     alert("Compila tutti i campi");
//     return;
//   }

//   var url =
//     "../php/addProductOnDB.php?id=" +
//     codice +
//     "&data_emissione=" +
//     data_emissione +
//     "&data_scadenza=" +
//     data_scadenza +
//     "&username=" +
//     username +
//     "&isUsed=" +
//     isUsed +
//     "&valore=" +
//     valore +
//     "&variabile_decisionale=" +
//     variabile_decisionale;
//   var conferma = confirm("Sei sicuro di voler inserire lo sconto?");

//   // Se l'utente conferma, chiamiamo la funzione callphp
//   if (conferma) {
//     callphp(url);
//   } else {
//   }
// }

function callphp(url) {
  window.location.href = url;
}

document.addEventListener("DOMContentLoaded", function () {
  aggiungiProdotto.addEventListener("click", insertProduct);
});
