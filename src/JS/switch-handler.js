//switch function to toggle between light and dark mode

const switchTheme = () => {
    //get root element and data theme value 
    const rootElem = document.documentElement
    let dataTheme = rootElem.getAttribute('data-theme'),
        newTheme

    //if dataTheme is light, change to dark, else change to light. Whatever is set, we apply the opposite
    newTheme = (dataTheme === 'light') ? 'dark' : 'light';

    //set the new theme to the root element
    rootElem.setAttribute('data-theme', newTheme);

    //set the local storage to the new theme
    localStorage.setItem('theme', newTheme);

}

//event listener to listen for the click on the switch button

document.querySelector('#theme-switcher').addEventListener('click', switchTheme);


//this is for the div with tabindex. It calls the switchTheme function when the enter key is pressed. 
document.querySelector('#theme-switcher').addEventListener('keypress', function (event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        switchTheme();
    }
});