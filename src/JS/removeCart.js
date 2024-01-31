let remCart = document.getElementsByClassName("removeItemCart");
let remAllCart = document.getElementById("removeAll");

function removeFromCart() {
  var name = this.getAttribute("name");
  prova = name.split("t");
  id = prova[1];
  window.location.href = "../php/removeFromCart.php?id=" + id;
}

function removeAll() {
  window.location.href = "../php/removeAllCart.php";
}

document.addEventListener("DOMContentLoaded", function () {
  for (var i = 0; i < remCart.length; i++) {
    remCart[i].addEventListener("click", removeFromCart);
  }
  remAllCart.addEventListener("click", removeAll);
});
