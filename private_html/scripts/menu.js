const menuBtn = document.querySelector('.mobileMenu');
const menuItems = document.querySelector('.mobileMenuItems');
menuBtn.addEventListener('click', () => {
    if(menuBtn.classList.contains('open')){
        menuBtn.classList.remove('open2');
        setTimeout(function(){menuBtn.classList.remove('open');}, 350);
        menuItems.classList.remove('open');
    } else {
        menuBtn.classList.add('open');
        setTimeout(function(){menuBtn.classList.add('open2');}, 350);
        menuItems.classList.add('open');
    }
});