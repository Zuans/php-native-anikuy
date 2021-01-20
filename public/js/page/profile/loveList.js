const module = {};
const animeCardList = document.getElementById('card-list-anime');
const animeRemoveBtn = document.querySelectorAll('.remove-btn-anime');
const mangaCardList = document.getElementById('card-list-manga');
const mangaRemoveBtn = document.querySelectorAll('.remove-btn-manga');

define(function(require){
    const utils = require('../../app/utils');
    const constant = require('../../app/constant');
    const anime = require('../../app/anime');
    const manga = require('../../app/manga');
    module.utils = utils;
    module.constant = constant;
    module.anime = anime;
    module.manga = manga;
});

        // remove anime function
        if(animeRemoveBtn) {
            animeRemoveBtn.forEach( async(btn) => {
                try {   
                    btn.addEventListener('click',function(e) {
                        const { 
                            utils,
                            anime 
                        } = module;
                        anime.removeAniList(e);
                    });
                } catch(err) {
                    console.log(err);
                }
            });
        }

        if(mangaRemoveBtn) {
            mangaRemoveBtn.forEach( btn => {
                btn.addEventListener('click',function(e) {
                    const { 
                        utils,
                        manga,
                    } =  module;

                    manga.removeMagList(e);
                });
            });
        }









