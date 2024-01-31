// funzionalità dello switch

const switchTheme = () => {
    const rootElem = document.documentElement;
    let dataTheme = rootElem.getAttribute('data-theme'), newTheme;
    newTheme = (dataTheme === 'light') ? 'dark' : 'light';

    rootElem.setAttribute('data-theme', newTheme);

    localStorage.setItem('theme', newTheme);

}

document.querySelector('#theme-switcher').addEventListener('click', switchTheme);


document.querySelector('#theme-switcher').addEventListener('keypress', function (event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        switchTheme();
    }
});

document.addEventListener('click', function(event) {
    var trigger = document.getElementById('mob-theme-switcher');
    if (trigger.contains(event.target)) {
        console.log('hey', event.target);
        switchTheme();
    }
});