// gestione delle funzionalità date in ProductAdmin
let insert = document.getElementsByClassName("insertItem");
let remove = document.getElementsByClassName("removeItem");
let modify = document.getElementsByClassName("modifyItem");
let viewDetails = document.getElementsByClassName("viewDetails");

var scriptElement = document.querySelector('script[src$="admin.js"]');

function insertItem() {
  var tipologia = this.getAttribute("data-categoria");
  if (tipologia == "prodotti") {
    window.location.href = "../php/insert.php?category=product";
  } else if (tipologia == "sconti") {
    window.location.href = "../php/insert.php?category=sale";
  }
}

function removeItem() {
  var id = this.getAttribute("data-id");
  var tipologia = this.getAttribute("data-categoria");
  if (id && id.length > 0) {
    if (tipologia == "prodotti") {
      var category = "product";
      var url = "../php/removeProduct.php?id=" + id + "&category=" + category;
      callphp(url);
    } else if (tipologia == "sconti") {
      var category = "sale";
      var url = "../php/removeProduct.php?id=" + id + "&category=" + category;
      callphp(url);
    } else {
      var category = "order";
      var url = "../php/removeProduct.php?id=" + id + "&category=" + category;
      callphp(url);
    }
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

function modifyItem() {
  var id = this.getAttribute("data-id");
  var tipologia = this.getAttribute("data-categoria");
  if (id && id.length > 0) {
    if (tipologia == "prodotti") {
      category = "product";
      var url = "../php/modifyProduct.php?id=" + id + "&category=" + category;
      callphp(url);
    } else if (tipologia == "sconti") {
      category = "sale";
      var url = "../php/modifyProduct.php?id=" + id + "&category=" + category;
      callphp(url);
    } else {
      category = "order";
      var url = "../php/modifyProduct.php?id=" + id + "&category=" + category;
      callphp(url);
    }
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

function viewDetailsItem() {
  var id = this.getAttribute("data-id");
  window.location.href = "../php/viewDetails.php?id=" + id;
}

function callphp(url) {
  window.location.href = url;
}

function getSelectedIds() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
  var selectedIds = Array.from(checkboxes).map(function (checkbox) {
    return checkbox.id;
  });
  return selectedIds;
}

document.addEventListener("DOMContentLoaded", function () {
  for (let i = 0; i < insert.length; i++) {
    insert[i].addEventListener("click", insertItem);
  }

  for (let i = 0; i < remove.length; i++) {
    remove[i].addEventListener("click", removeItem);
  }

  // Iterate through modifyButtons and attach event listener to each button
  for (let i = 0; i < modify.length; i++) {
    modify[i].addEventListener("click", modifyItem);
  }

  for (let i = 0; i < viewDetails.length; i++) {
    viewDetails[i].addEventListener("click", viewDetailsItem);
  }
});
