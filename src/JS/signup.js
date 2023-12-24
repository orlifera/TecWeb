let signupContent = document.querySelector(".signup-container"),
    stagebtn1a = document.querySelector(".stagebtn1a"),
    stagebtn1b = document.querySelector(".stagebtn1b"),
    stagebtn2a = document.querySelector(".stagebtn2a"),
    stagebtn2b = document.querySelector(".stagebtn2b"),
    stagebtn3a = document.querySelector(".stagebtn3a"),
    stagebtn3b = document.querySelector(".stagebtn3b"),
    signupContent1 = document.querySelector(".stage1-content"),
    signupContent2 = document.querySelector(".stage2-content"),
    signupContent3 = document.querySelector(".stage3-content");

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

function switchStage(toHide, toShow) {
    hideStage(toHide);
    showStage(toShow);
}

document.addEventListener('DOMContentLoaded', function () {
    showStage(signupContent1);
    hideStage(signupContent2, signupContent3);



    stagebtn1b.addEventListener('click', function () {
        switchStage(signupContent1, signupContent2);
    });

    stagebtn2a.addEventListener('click', function () {
        switchStage(signupContent2, signupContent1);
    });

    stagebtn2b.addEventListener('click', function () {
        switchStage(signupContent2, signupContent3);
    });

    stagebtn3a.addEventListener('click', function () {
        switchStage(signupContent3, signupContent2);
    });


});

