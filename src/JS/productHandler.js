let minus = document.getElementById("minus");
let plus = document.getElementById("plus");

function incrementValue() {
  var value = document.querySelector("input[type='number']").value;
  value++;
  document.querySelector("input[type='number']").value = value;
}

function decrementValue() {
  var value = document.querySelector("input[type='number']").value;
  if (value > 1) value--;
  else value = 1;
  document.querySelector("input[type='number']").value = value;
}

document.addEventListener("DOMContentLoaded", function () {
  minus.addEventListener("click", decrementValue);
  plus.addEventListener("click", incrementValue);
});
