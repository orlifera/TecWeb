let signupContent = document.querySelector(".signup-container"),
  stagebtn1a = document.querySelector(".stagebtn1a"),
  stagebtn1b = document.querySelector(".stagebtn1b"),
  stagebtn2a = document.querySelector(".stagebtn2a"),
  stagebtn2b = document.querySelector(".stagebtn2b"),
  stagebtn3a = document.querySelector(".stagebtn3a"),
  stagebtn3b = document.querySelector(".stagebtn3b"),
  stageno1 = document.querySelector(".stageno-1"),
  stageno2 = document.querySelector(".stageno-2"),
  stageno3 = document.querySelector(".stageno-3"),
  signupContent1 = document.querySelector(".stage1-content"),
  signupContent2 = document.querySelector(".stage2-content"),
  signupContent3 = document.querySelector(".stage3-content"),
  loginLink = document.querySelector(".login-link");

function showStage(...contents) {
  contents.forEach(contents => {
    if (contents.classList.contains("hidden"))
      contents.classList.remove("hidden");
    contents.classList.add("show");
  });
}

function hideStage(...contents) {
  contents.forEach(contents => {
    if (contents.classList.contains("show"))
      contents.classList.remove("show");
    contents.classList.add("hidden");
  });
}

function areFieldsCompleted(stageContent) {
  let inputs = stageContent.querySelectorAll('input');
  for (let input of inputs) {
    if (input.type !== 'submit' && input.type !== 'button' && input.value.trim() === '') {
      return false; // Found an empty field, return false.
    }
  }
  return true; // All fields are filled.
}

function switchStage(toHide, toShow, forward = true) {

  if (toHide === signupContent2 && forward) {
    var emailInput = signupContent2.querySelector('input[type="email"]');
    // if (emailInput && !emailInput.checkValidity()) {
    //     alert('Per favore, inserie un indirizzo email valido.');
    //     return false; // Prevents moving to the next stage if email is invalid
    // }
  }
  if (forward && !areFieldsCompleted(toHide)) {
    alert('Per favore, compila tutti i campi prima di procedere al prossimo stage.');
    return false;
  }
  hideStage(toHide);
  showStage(toShow);
  return true;
}

document.addEventListener('DOMContentLoaded', function () {
  showStage(signupContent1);
  hideStage(signupContent2, signupContent3);
  stageno1.classList.add("completed");


  stagebtn1b.addEventListener('click', function () {
    if (switchStage(signupContent1, signupContent2, true)) {
      stageno1.classList.remove("stageno");
      stageno2.classList.add("completed");
      loginLink.classList.add("hidden");
    }
  });

  stagebtn2a.addEventListener('click', function () {
    if (switchStage(signupContent2, signupContent1, false)) {
      stageno2.classList.remove("completed");
      stageno1.classList.add("stageno");
      loginLink.classList.remove("hidden");
    }
  });

  stagebtn2b.addEventListener('click', function () {
    if (switchStage(signupContent2, signupContent3, true)) {
      stageno2.classList.remove("stageno");
      stageno3.classList.add("completed");
    }
  });

  stagebtn3a.addEventListener('click', function () {
    if (switchStage(signupContent3, signupContent2, false)) {
      stageno3.classList.remove("completed");
      stageno2.classList.add("stageno");
    }
  });
});

