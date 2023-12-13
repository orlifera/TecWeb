document.addEventListener('DOMContentLoaded', function () {

    if (getCookie("MLTech") != null) {   // se il cookie è già stato impostato
        hidePopUp();
    }
    else {
        let popUp = document.getElementById('cookie-section');
        popUp.style.display = 'block';
    }

    let date = new Date();
    date = date.toUTCString();

    function hidePopUp() {
        console.log('hide');
        console.log("creato")
        let popUp = document.getElementById('cookie-section');
        popUp.style.display = 'none';
    }

    document.getElementById('accept').addEventListener('click', function () {
        setCookie("MLTech", "user", 30);
        hidePopUp();
    });

    document.getElementById('reject').addEventListener('click', function () {
        hidePopUp();
    });
});

function setCookie(name, value, days) {
    console.log('called')
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (encodeURIComponent(value) || "") + expires + "; path=/";
}

function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }

    }
    return null;
}