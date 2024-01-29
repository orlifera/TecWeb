let addCart = document.getElementById("addToCart");

function addToCart() {
  var scriptTag = document.querySelector('script[src$="cart.js"]');
  var id = scriptTag.getAttribute("data-id");
  var categoria = scriptTag.getAttribute("data-categoria");
  var nomeProdotto = document.getElementById("nome").innerText;
  var tipologiaProdotto = document.getElementById("tipo").innerText;
  var descrProdotto = document.getElementById("descrizione").innerText;
  var prezzoProdotto = document.getElementById("prezzo").innerText;
  var disponibilita = document.getElementById("dispon").innerText;
  if (disponibilita === "Non disponibile") {
    alert("Prodotto non disponibile, ci scusiamo per il disagio!");
    return;
  }
  var imageFilePath = document
    .getElementsByClassName("product-image")[0]
    .getAttribute("src");
  var quantity = document.querySelector(".quantity").value;
  var coloreProdotto = document.getElementById("colore").value;
  var splitValori = prezzoProdotto.split("€");
  var prezzo = splitValori[1];

  splitValori = disponibilita.split(":");
  var url =
    "../php/addToCart.php?id=" +
    id +
    "&nome=" +
    nomeProdotto +
    "&tipo=" +
    tipologiaProdotto +
    "&descrizione=" +
    descrProdotto +
    "&prezzo=" +
    prezzo +
    "&colore=" +
    coloreProdotto +
    "&quantita=" +
    quantity +
    "&path=" +
    imageFilePath +
    "&categoria=" +
    categoria;
  window.location.href = url;
}

document.addEventListener("DOMContentLoaded", function () {
  addCart.addEventListener("click", addToCart);
});
