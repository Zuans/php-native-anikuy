const baseAPIUrl = 'https://kitsu.io/api/edge';

const animeResult = document.getElementById('anime-result');
const mangaResult = document.getElementById('manga-result');
const genreSelect = document.getElementById('select-genre');
const module  = {};

define(function(require) {  
    const browser = require('./app/browser');
    const utils = require('./app/utils');
    const constant = require('./app/constant');
    const navbar = require('./app/navbar');
    const anime = require('./app/anime');
    module.anime = anime;
    module.constant = constant;
    module.browser = browser;
    module.utils = utils;
    module.navbar = navbar;
    return;
});

window.onload = () => {
    const settNavbar = module.navbar.setNavbar;
    settNavbar();
}




genreSelect.addEventListener('change',async function(event){
    const { anime : Anime ,utils } = module;
    if(animeResult) {
        const selectEl = event.target;
        const selectedValue =  selectEl.options[selectEl.selectedIndex].value;
        let  url = `${baseAPIUrl}/anime?filter[categories]=${selectedValue}&sort=-averageRating`;
        const anime = await utils.animangaRequest('GET',url,null);
        const animeList = Anime.setAnimeCard(anime);
        animeResult.querySelector(':scope .card-list').innerHTML = animeList.join(" ");
    } else {
        const selectEl = event.target;
        const selectedValue =  selectEl.options[selectEl.selectedIndex].value;
        let  url = `${baseAPIUrl}/manga?filter[categories]=${selectedValue}&sort=-averageRating`;
        const manga = await utils.animangaRequest('GET',url,null);
        const mangaList = module.utils.setMangaCard(manga);
        mangaResult.querySelector(':scope .card-list').innerHTML = mangaList.join(" ");
    }

})
