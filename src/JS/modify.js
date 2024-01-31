// gestione della modifica di prodotti o sconti
let mod = document.getElementById("modificaProdotto");

function modifyProduct() {
  let scriptTag = document.querySelector('script[src$="modify.js"]');
  let category = scriptTag.getAttribute("data-categoria");
  if (category == "product") {
    var id = scriptTag.getAttribute("data-id");
    var riferimento = scriptTag.getAttribute("data-riferimento");
    var nome = getValueOrPlaceholder("nome");
    var tipo = getValueOrPlaceholder("tipo");
    var prezzo = getValueOrPlaceholder("prezzo");
    var immagine = getValueOrPlaceholder("path_image");
    var categoria = getValueOrPlaceholder("categoria");
    var disponibilita = getValueOrPlaceholder("disponibilita");
    var descrizione = getValueOrPlaceholder("descrizione");
    var colore = getValueOrPlaceholder("colore");

    if (!/^\d+$/.test(disponibilita) && !/^\d+$/.test(prezzo)) {
      alert("Errore: inserimento valori non corretto");
      return;
    }

    if (id == "" || id == null) {
      alert("Errore: id non valido");
      return;
    }

    var riferimento1 = riferimento == "" ? categoria : riferimento;

    var url =
      "../php/updateProduct.php?id=" +
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
      riferimento1 +
      "&variabile_decisionale=" +
      category;
  } else if (category == "sale") {
    var codice = scriptTag.getAttribute("data-id");
    var data_emissione = getValueOrPlaceholder("data_emissione");
    var data_scadenza = getValueOrPlaceholder("data_scadenza");
    var username = getValueOrPlaceholder("username");
    var isUsed = getValueOrPlaceholder("isUsed");
    var valore = getValueOrPlaceholder("valore");

    if (!/^\d+$/.test(valore)) {
      alert("Errore: inserimento valori non corretto");
      return;
    }

    var url =
      "../php/updateProduct.php?id=" +
      codice +
      "&data_emissione=" +
      data_emissione +
      "&data_scadenza=" +
      data_scadenza +
      "&username=" +
      username +
      "&isUsed=" +
      (isUsed == "Buono usato" ? 1 : 0) +
      "&valore=" +
      valore +
      "&variabile_decisionale=" +
      category;
  } else {
    var codice = scriptTag.getAttribute("data-id");
    var utente = getValueOrPlaceholder("utente");
    var quantitaOrdinata = getValueOrPlaceholder("quantitaOrdinata");
    var indirizzo = getValueOrPlaceholder("indirizzo");
    var prezzo = getValueOrPlaceholder("prezzo");

    if (!/^\d+$/.test(quantitaOrdinata) && !/^\d+$/.test(prezzo)) {
      alert("Errore: inserimento valori non corretto");
      return;
    }

    var url =
      "../php/updateProduct.php?id=" +
      codice +
      "&utente=" +
      utente +
      "&quantitaOrdinata=" +
      quantitaOrdinata +
      "&indirizzo=" +
      indirizzo +
      "&prezzo=" +
      prezzo +
      "&variabile_decisionale=" +
      category;
  }
  callphp(url);
}

function callphp(url) {
  window.location.href = url;
}

function getValueOrPlaceholder(id) {
  var inputElement = document.getElementById(id);
  return inputElement.value !== ""
    ? inputElement.value
    : inputElement.placeholder;
}

document.addEventListener("DOMContentLoaded", function () {
  mod.addEventListener("click", modifyProduct);
});
