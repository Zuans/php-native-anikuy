const module = {};

define(function(require){
    const utils = require('../../app/utils');
    const constant = require('../../app/constant');
    const navbar = require('../../app/navbar');
    const browser = require('../../app/browser');
    module.navbar = navbar;
    module.utils = utils;
    module.constant = constant;
    module.browser = browser;
});

window.onload = () => {
    module.navbar.setNavbar();
}