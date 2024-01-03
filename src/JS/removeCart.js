let remCart = document.getElementsByClassName("removeCart");

function removeFromCart() {
  var name = this.getAttribute("name");
  prova = name.split("t");
  id = prova[1];
  window.location.href = "../php/removeFromCart.php?id=" + id;
  alert("Prodotto rimosso dal carrello!");
}

document.addEventListener("DOMContentLoaded", function () {
  for (var i = 0; i < remCart.length; i++) {
    remCart[i].addEventListener("click", removeFromCart);
  }
});
