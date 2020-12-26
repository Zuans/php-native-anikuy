// Declare Var
const module = {};
const loveIcon = document.getElementById('love-icon');


define(function(require){
    const utils = require('./app/utils');
    const constant = require('./app/constant');
    const navbar = require('./app/navbar');
    const browser = require('./app/browser');
    module.navbar = navbar;
    module.utils = utils;
    module.constant = constant;
    module.browser = browser;
});

window.onload = () => {
    const settNavbar = module.navbar.setNavbar;
    settNavbar();
}


loveIcon.addEventListener('click',async function() {
    const isLoved = loveIcon.classList.contains('love');
    // Init request
    const httpRequest = module.utils.httpRequest;
    const baseUrl = module.constant.baseUrl;
    // Get anime id from url
    const url = window.location.href.toString().split('/');
    const type = url[url.length - 3];
    
    // Set body data
    let bodyData;

    if(type == 'Manga') {
        const mangaId = url[url.length -1];
        bodyData = {
            mangaId,
        }
    } else {
        const animeId = url[url.length -1];
        bodyData = {
            animeId,
        }
    }

    if(isLoved) {
        const request = `${type}/removeLove`;
        const urlRequest = `${baseUrl}/${request}`;
        console.log(bodyData);
        try {
            const { status,msg} = await httpRequest('POST',urlRequest,bodyData);
            if(status == 'success') {
                loveIcon.classList.remove('love');
            } else {
                console.error(msg);
            }
        } catch(err) {
            console.log(err);
        }
    } else {
        const request = `${type}/addLove`;
        const urlRequest = `${baseUrl}/${request}`;
        try {
            const {status,msg} = await httpRequest('POST',urlRequest,bodyData);
            if(status == 'success') {
                loveIcon.classList.add('love');
            } else {
                console.error(msg);
            }
        } catch(err) {
            console.log(err);
        }
    }




})