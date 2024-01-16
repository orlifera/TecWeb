let insert = document.getElementById("insertProduct");
let remove = document.getElementById("removeProduct");
let modify = document.getElementById("modifyProduct");
let insertSconto = document.getElementById("insertSconto");
let removeSconto = document.getElementById("removeSconto");
let modifySconto = document.getElementById("modifySconto");
let insertOrder = document.getElementById("insertOrder");
let removeOrder = document.getElementById("removeOrder");
let modifyOrder = document.getElementById("modifyOrder");

let selectAllProduct = document.getElementById("selectAllProduct");
let deselectAllProduct = document.getElementById("deselectAllProduct");
let selectAllSail = document.getElementById("selectAllSail");
let deselectAllSail = document.getElementById("deselectAllSail");
let selectAllOrder = document.getElementById("selectAllOrder");
let deselectAllOrder = document.getElementById("deselectAllOrder");

let category = "";

function getSelectedIds() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
  var selectedIds = Array.from(checkboxes).map(function (checkbox) {
    return checkbox.id;
  });

  return selectedIds;
}

function insertProduct() {
  // window.location.href = "../pages/insertProduct.html";
  window.location.href = "../php/insert.php?category=product";
}

function modifyProduct() {
  var id = getSelectedIds();
  category = "product";
  if (id && id.length > 0) {
    var url = "../php/modifyProduct.php?id=" + id + "&category=" + category;
    callphp(url);
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

function removeProduct() {
  var id = getSelectedIds();
  var category = "product";
  if (id && id.length > 0) {
    var url = "../php/removeProduct.php?id=" + id + "&category=" + category;
    callphp(url);
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

function callphp(url) {
  window.location.href = url;
}

function selectAllCheckboxes(choice) {
  if (choice == true) {
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
  } else if (choice == false) {
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

function deselectAllCheckboxes(choice) {
  if (choice == true) {
    var prodottoCheckboxes = document.querySelectorAll(".pc");
    prodottoCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });

    // Seleziona tutte le checkbox con la classe '.kbd'
    var tastieraCheckboxes = document.querySelectorAll(".kbd");
    tastieraCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });

    var accCheckboxes = document.querySelectorAll(".acc");
    accCheckboxes.forEach(function (checkbox) {
      checkbox.checked = false;
    });
  } else if (choice == false) {
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

function insertSail() {
  // window.location.href = "../pages/insertSale.html";
  window.location.href = "../php/insert.php?category=sale";
}

function removeSail() {
  var id = getSelectedIds();
  var category = "sale";
  if (id && id.length > 0) {
    var url = "../php/removeProduct.php?id=" + id + "&category=" + category;
    callphp(url);
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

function modifySail() {
  var id = getSelectedIds();
  category = "sale";
  if (id && id.length > 0) {
    var url = "../php/modifyProduct.php?id=" + id + "&category=" + category;
    callphp(url);
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

function insertOrdine() {
  // window.location.href = "../pages/insertOrder.html";
  window.location.href = "../php/insert.php?category=order";
}

function removeOrdine() {
  var id = getSelectedIds();
  var category = "sale";
  if (id && id.length > 0) {
    var url = "../php/removeProduct.php?id=" + id + "&category=" + category;
    callphp(url);
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

function modifyOrdine() {
  var id = getSelectedIds();
  category = "order";
  if (id && id.length > 0) {
    var url = "../php/modifyProduct.php?id=" + id + "&category=" + category;
    callphp(url);
  } else {
    alert("Seleziona prima un prodotto!");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  insert.addEventListener("click", insertProduct);
  remove.addEventListener("click", removeProduct);
  modify.addEventListener("click", modifyProduct);

  insertSconto.addEventListener("click", insertSail);
  removeSconto.addEventListener("click", removeSail);
  modifySconto.addEventListener("click", modifySail);
  selectAllProduct.addEventListener("click", function () {
    selectAllCheckboxes(true);
  });

  deselectAllProduct.addEventListener("click", function () {
    deselectAllCheckboxes(true);
  });

  selectAllSail.addEventListener("click", function () {
    selectAllCheckboxes(false);
  });

  deselectAllSail.addEventListener("click", function () {
    deselectAllCheckboxes(false);
  });

  selectAllOrder.addEventListener("click", function () {
    selectAllCheckboxes();
  });

  deselectAllOrder.addEventListener("click", function () {
    deselectAllCheckboxes();
  });

  insertOrder.addEventListener("click", insertOrdine);
  removeOrder.addEventListener("click", removeOrdine);
  modifyOrder.addEventListener("click", modifyOrdine);
});
