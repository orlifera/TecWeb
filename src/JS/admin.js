let insert = document.getElementById("insertItem");
let remove = document.getElementById("removeItem");
let modify = document.getElementById("modifyItem");

let selectAll = document.getElementById("selectAllItem");
let deselectAll = document.getElementById("deselectAllItem");
var scriptElement = document.querySelector('script[src$="admin.js"]');
var tipologia = scriptElement.getAttribute("data-categoria");

function insertItem() {
  if (tipologia == "prodotti") {
    window.location.href = "../php/insert.php?category=product";
  } else if (tipologia == "sconti") {
    window.location.href = "../php/insert.php?category=sale";
  } else {
    window.location.href = "../php/insert.php?category=order";
  }
}

function removeItem() {
  var id = getSelectedIds();
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
  var id = getSelectedIds();
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

function selectAllCheckboxes() {
  if (tipologia == "prodotti") {
    var prodottoCheckboxes = document.querySelectorAll(".pc");
    prodottoCheckboxes.forEach(function (checkbox) {
      checkbox.checked = true;
    });

    var tastieraCheckboxes = document.querySelectorAll(".kbd");
    tastieraCheckboxes.forEach(function (checkbox) {
      checkbox.checked = true;
    });

    var accCheckboxes = document.querySelectorAll(".acc");
    accCheckboxes.forEach(function (checkbox) {
      checkbox.checked = true;
    });
  } else if (tipologia == "sconti") {
    var sailCheckboxes = document.querySelectorAll(".sail");
    sailCheckboxes.forEach(function (checkbox) {
      checkbox.checked = true;
    });
  } else {
    var orderCheckboxes = document.querySelectorAll(".order");
    orderCheckboxes.forEach(function (checkbox) {
      checkbox.checked = true;
    });
  }
}

function deselectAllCheckboxes() {
  if (tipologia == "prodotti") {
    var prodottoCheckboxes = document.querySelectorAll(".pc");
    prodottoCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });

    var tastieraCheckboxes = document.querySelectorAll(".kbd");
    tastieraCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });

    var accCheckboxes = document.querySelectorAll(".acc");
    accCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });
  } else if (tipologia == "sconti") {
    var sailCheckboxes = document.querySelectorAll(".sail");
    sailCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });
  } else {
    var orderCheckboxes = document.querySelectorAll(".order");
    orderCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });
  }
}

document.addEventListener("DOMContentLoaded", function () {
  selectAll.addEventListener("click", function () {
    selectAllCheckboxes();
  });
  deselectAll.addEventListener("click", function () {
    deselectAllCheckboxes();
  });
  insert.addEventListener("click", insertItem);
  remove.addEventListener("click", removeItem);
  modify.addEventListener("click", modifyItem);
});
