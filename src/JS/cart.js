//crei variabili carello e prodotto prendendo da php

let carrello = document.getElementById("addToCart");
let mostra = document.getElementById("showCart");

function displayCart() {
  // Recupera i dati del carrello dalla sessione
  var cart = JSON.parse(sessionStorage.getItem("cart"));

  // Se il carrello è vuoto, mostra un messaggio appropriato
  if (!cart || cart.length === 0) {
    document.write("<p>Il tuo carrello è vuoto.</p>");
    return;
  }

  // Altrimenti, crea una tabella con i prodotti nel carrello
  var table = '<table border="1"><tr><th>Prodotto</th><th>Prezzo</th></tr>';

  for (var i = 0; i < cart.length; i++) {
    table +=
      "<tr><td>" +
      cart[i].name +
      "</td><td>" +
      cart[i].price.toFixed(2) +
      "</td></tr>";
  }

  table += "</table>";

  // Inserisce la tabella nella pagina HTML
  document.write(table);
}

function addToCart() {
  var productName = "Prodotto";
  var productPrice = 20.0;

  // Crea un oggetto prodotto
  var product = {
    name: productName,
    price: productPrice,
  };

  // Controlla se il carrello è già presente nella sessione
  if (sessionStorage.getItem("cart") === null) {
    // Se il carrello non esiste, crea un nuovo carrello
    var cart = [];
  } else {
    // Se il carrello esiste, recupera il carrello esistente dalla sessione
    var cart = JSON.parse(sessionStorage.getItem("cart"));
  }

  // Aggiungi il prodotto al carrello
  cart.push(product);

  // Salva il carrello aggiornato nella sessione
  sessionStorage.setItem("cart", JSON.stringify(cart));

  // Notifica all'utente che il prodotto è stato aggiunto al carrello (puoi personalizzare questo messaggio)
  alert("Prodotto aggiunto al carrello!");
}

function removeFromCart(index) {
  // Recupera i dati del carrello dalla sessione
  var cart = JSON.parse(sessionStorage.getItem("cart"));

  // Rimuovi il prodotto dal carrello
  cart.splice(index, 1);

  // Salva il carrello aggiornato nella sessione
  sessionStorage.setItem("cart", JSON.stringify(cart));
  alert("Prodotto eliminato dal carrello!");

  // Aggiorna la visualizzazione del carrello
  displayCart();
}

document.addEventListener("DOMContentLoaded", function () {
  mostra.addEventListener("click", displayCart);
  carrello.addEventListener("click", addToCart);
});
