let minus = document.getElementById("minus");
let plus = document.getElementById("plus");
let selectColore = document.getElementById("colore");
let immagine = document.querySelector("img");
var idValue = getParameterByName("id", window.location.href);
var categoriaValue = getParameterByName("categoria", window.location.href);

let imageFilePath =
  "../../assets/images/" + categoriaValue + "/" + idValue + ".jpg";

function incrementValue(disponibilita) {
  var inputElement = document.getElementById("quantity");
  var value = parseInt(inputElement.value, 10);
  var max = disponibilita.split(":")[1].trim(); //elimini spazi

  if (max == 0) {
    return;
  }
  if (value < max) {
    value++;
  } else {
    value = max;
  }
  document.querySelector("input[type='number']").value = value;
}

function decrementValue() {
  var value = document.querySelector("input[type='number']").value;
  if (value == 0) {
    return;
  }
  if (value > 1) value--;
  else value = 1;
  document.querySelector("input[type='number']").value = value;
}

function changeColorProductImage() {
  let selectedColor = selectColore.value;

  if (selectedColor == "Nero") {
    imageFilePath =
      "../../assets/images/" + categoriaValue + "/" + idValue + ".jpg";
  } else if (selectedColor == "Bianco") {
    imageFilePath =
      "../../assets/images/" + categoriaValue + "/" + idValue + "_W.jpg";
  }
  immagine.src = imageFilePath;
}

function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

document.addEventListener("DOMContentLoaded", function () {
  var disponibilita = document.getElementById("disponibilita").innerText;
  minus.addEventListener("click", decrementValue);
  plus.addEventListener("click", function () {
    incrementValue(disponibilita);
  });

  selectColore.addEventListener("change", function () {
    changeColorProductImage();
  });

  selectColore.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
      changeColorProductImage();
    }
    if (event.key === "Tab") {
      selectColore.removeAttribute("size");
    }
  });

  // Aggiungi un gestore di evento al cambio di opzione per nascondere le opzioni
  selectColore.addEventListener("change", function () {
    selectColore.removeAttribute("size");
  });
});
