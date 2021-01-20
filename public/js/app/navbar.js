window.onload = () => {
    console.log('test');
    const navbar = document.getElementById('navbar');
    const burger = document.getElementById('btn-hamburger');
    setNavbar(navbar,burger);
}


const setClassNavbar  = (navbar) => {
    if(navbar.classList.contains('nav-mobile')) {
        navbar.classList.remove('nav-mobile');
    }
    if(navbar.classList.contains('nav-tablet')) {
        navbar.classList.remove('nav-tablet');
    }
    if(navbar.classList.contains('nav-desktop')) {
        navbar.classList.remove('nav-desktop');
    }
    if(navbar.classList.contains('active')) {
        navbar.classList.remove('active');
    }

    if(clientType == 'desktop' ) {
        navbar.classList.add('nav-desktop');
    } else if ( clientType == 'tablet' ) {
        navbar.classList.add('nav-tablet');
    } else {
        navbar.classList.add('nav-mobile');
    }
}


const setClientType =  () => {
    const w = window.innerWidth;
    if( w > 1280 ) {
        return  'desktop';
    } else if( w > 768 ) {
        return 'tablet';
    } else {
        return 'mobile';
    }
}


const setNavbar = (navbar,burger) => {
    // Set navbar onload
    clientType = setClientType();
    loadFunc(navbar,burger);
    // Set Navbar onresize
    window.onresize = () => {
        clientType = setClientType();
        setClassNavbar(navbar);
    }
};



function loadFunc(navbar,burger) {
    setClassNavbar(navbar);
    if(burger) {
        burger.addEventListener('click',function() {
            if( navbar.classList.contains('nav-mobile') || navbar.classList.contains('nav-tablet')) {
                navbar.classList.toggle('active');
            }
        });
    }   
}


