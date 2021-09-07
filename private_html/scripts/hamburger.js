const hamburger = document.querySelector('.hamburger');
const hamburgerMenu = document.querySelector('.hamburgerOpen');
const menuItem = [...document.querySelectorAll('.menuItem')];

let hamburgerOpen = false;

hamburger.addEventListener('click', () => {
    if(hamburgerOpen == true) {
        hamburgerOpen = false;
        hamburger.classList.remove('open');
        hamburgerMenu.style.left = "-100vw";
    } else {
        hamburgerMenu.style.display = "flex";
        hamburgerOpen = true;
        hamburger.classList.add('open');
        hamburgerMenu.style.left = "0";
    }
})

menuItem.forEach(e => e.addEventListener('click', () => {
    hamburgerOpen = false;
    hamburger.classList.remove('open');
    hamburgerMenu.style.left = "-100vw";
}))
function close(){
    hamburgerMenu.style.display = "none";
    hamburgerOpen = false;
    hamburger.classList.remove('open');
    hamburgerMenu.style.left = "-100vw";
}
window.addEventListener('resize', close);