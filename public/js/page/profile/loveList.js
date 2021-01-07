const module = {};
const animeCardList = document.getElementById('card-list-anime');
const animeRemoveBtn = document.querySelectorAll('.remove-btn-anime');
const mangaCardList = document.getElementById('card-list-manga');
const mangaRemoveBtn = document.querySelectorAll('.remove-btn-manga');

define(function(require){
    const utils = require('../../app/utils');
    const constant = require('../../app/constant');
    const navbar = require('../../app/navbar');
    const browser = require('../../app/browser');
    const anime = require('../../app/anime');
    const manga = require('../../app/manga');
    module.navbar = navbar;
    module.utils = utils;
    module.constant = constant;
    module.browser = browser;
    module.anime = anime;
    module.manga = manga;
});

const utils = {};

window.onload = () => {
    module.navbar.setNavbar();

    // remove anime function
    animeRemoveBtn.forEach( btn => {
        const { 
            utils,
            anime 
        } = module;
        btn.addEventListener('click',function(e) {
            anime.removeAniList(e);
        });
    });

    mangaRemoveBtn.forEach( btn => {
        const { 
            manga,
        } = module;
        btn.addEventListener('click',function(e) {
            manga.removeMagList(e);
        });
    });
}








