let addCart = document.getElementById("addToCart");
let mostra = document.getElementById("showCart");

function displayCart() {
  window.location.href = "../php/cart.php";
}

function addToCart() {
  var scriptTag = document.querySelector('script[src$="cart.js"]');
  var id = scriptTag.getAttribute("data-id");
  var categoria = scriptTag.getAttribute("data-categoria");
  var nomeProdotto = document.getElementById("nome").innerText;
  var tipologiaProdotto = document.getElementById("tipo").innerText;
  var descrProdotto = document.getElementById("descrizione").innerText;
  var prezzoProdotto = document.getElementById("prezzo").innerText;
  var disponibilita = document.getElementById("disponibilita").innerText;
  if (disponibilita === "Non disponibile") {
    alert("Prodotto non disponibile, ci scusiamo per il disagio!");
    return;
  }
  var quantity = document.getElementById("quantity").value;
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
  alert("Prodotto aggiunto al carrello!");
}

document.addEventListener("DOMContentLoaded", function () {
  mostra.addEventListener("click", displayCart);
  addCart.addEventListener("click", addToCart);
});
