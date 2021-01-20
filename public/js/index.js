const baseAPIUrl = 'https://kitsu.io/api/edge';

const animeResult = document.getElementById('anime-result');
const mangaResult = document.getElementById('manga-result');
const genreSelect = document.getElementById('select-genre');
const titleContent = document.getElementById('title-content');
const module  = {};

define(function(require) {  
    const utils = require('./app/utils');
    const constant = require('./app/constant');
    const anime = require('./app/anime');
    const manga = require('./app/manga');
    module.anime = anime;
    module.manga = manga;
    module.constant = constant;
    module.utils = utils;
    return;
});





genreSelect.addEventListener('change',async function(event){
    const { anime : Anime ,utils } = module;
    if(animeResult) {
        try {   
            const selectEl = event.target;
            const selectedValue =  selectEl.options[selectEl.selectedIndex].value;
            animeResult.querySelector(':scope .card-list').innerHTML = "<h2>Loading Please Wait</h2>";
            let  url = `${baseAPIUrl}/anime?filter[categories]=${selectedValue}&sort=-averageRating`;
            const anime = await utils.animangaRequest('GET',url,null);
            const animeList = Anime.setAnimeCard(anime);
            console.log(selectedValue);
            titleContent.textContent = `Anime Search By Categories "${selectedValue}"`;
            animeResult.querySelector(':scope .card-list').innerHTML = animeList.join(" ");
        } catch(err) {
            console.log(err);
        }
    } else {
        const { manga : Manga ,utils } = module;
        try {
            const selectEl = event.target;
            const selectedValue =  selectEl.options[selectEl.selectedIndex].value;
            mangaResult.querySelector(':scope .card-list').innerHTML = "<h2>Loading Please Wait</h2>";
            let  url = `${baseAPIUrl}/manga?filter[categories]=${selectedValue}&sort=-averageRating`;
            const manga = await utils.animangaRequest('GET',url,null);
            const mangaList = Manga.setMangaCard(manga);
            titleContent.textContent = `Manga Search By Categories "${selectedValue}"`;
            mangaResult.querySelector(':scope .card-list').innerHTML = mangaList.join(" ");
        } catch(err) {
            console.log(err);
        }
    }

})
