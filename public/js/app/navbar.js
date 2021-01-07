const burger = document.getElementById('btn-hamburger');
const navbar = document.getElementById('navbar');



const setNavbar = () => {
    // Set navbar onload
    clientType = module.browser.setClientType();
    loadFunc();
    // Set Navbar onresize
    window.onresize = () => {
        clientType = module.browser.setClientType();
        classNavbar();
    }
};



function loadFunc() {
    module.utils.classNavbar();
    burger.addEventListener('click',function() {
        if( navbar.classList.contains('nav-mobile') || navbar.classList.contains('nav-tablet')) {
            navbar.classList.toggle('active');
        }
    });
}



define({
    setNavbar,
})