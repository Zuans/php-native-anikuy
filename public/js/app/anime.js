const removeAniList = async (e) => {
    const { utils } = module;
    const animeId = e.currentTarget.dataset.id;
    const url = `${module.constant.baseUrl}/Anime/removeLove`;
    const bodyData = {
        animeId,
    };
    try {
        // http request func from utils.js is required
        const responses = await utils.httpRequest('POST',url,bodyData);
        const animeCardLove = await setAnimeCardLove(responses.data);
        if(animeCardLove) {
            const animeListChild = animeCardList.children;
            [...animeListChild].forEach( e => {
                if(e.classList.contains('card-list-love')) {
                    e.remove();
                }
            });
            animeCardList.insertAdjacentHTML('beforeend',animeCardLove);
            // Bring all new remove button click listener func
            const newRemoveBtn = document.querySelectorAll('.remove-btn-anime');
            newRemoveBtn.forEach( btn => {
                btn.addEventListener('click',function(e){
                    console.log('wadawdaw');
                    removeAniList(e);
                })
            })
        }
    } catch(err) {
        console.log(err);
    }
};





const setAnimeCardLove = async (data) => {
    try {
        const allAnime = await animeSetById(data);
        const splitAnimes = await splitAnime(allAnime);
        const animeCardsLove = await animeCardLove(splitAnimes);
        return animeCardsLove;
    } catch(err) {
        console.log(err);
    }
}


const animeSetById = async (data) => {
    const { utils } = module;
    const baseImg =`${module.constant.baseUrl}/assets/img/card-1.png`;
    try {
        const allAnime = await Promise.all(data.map( async (d) => {
            const id = d.anime_id;
            const url = `${module.constant.baseUrlApi}/anime?filter[id]=${id}`;
            try {
                // animanga func from utils is required
                const data = await utils.animangaRequest('GET',url);
                // ANIME Structure
                const anime = {
                    // Some utils function are required
                    id : data[0].id,
                    showType : data[0].attributes.showType,
                    synopsis : utils.sliceSynopsis( data[0].attributes.synopsis ),
                    fullSynopsis : data[0].attributes.synopsis,
                    title :  utils.setLang( data[0].attributes.titles ),
                    rating : data[0].attributes.averageRating ? data[0].attributes.averageRating : '-' ,
                    ratingRank : data[0].attributes.ratingRank,
                    ageRating : data[0].attributes.ageRating,
                    user : data[0].attributes.userCount,
                    status : data[0].attributes.status,
                    aired : utils.setAired(
                        data[0].attributes.startDate,
                        data[0].attributes.endDate
                    ),
                    epsCount: data[0].attributes.episodeCount,
                    epsLength : utils.setEpsLen(
                        data[0].attributes.episodeLength,
                        data[0].attributes.episodeCount
                    ),
                    imgPoster : data[0].attributes.posterImage ? data[0].attributes.posterImage.small : baseImg,
                    imgPosterFl : data[0].attributes.posterImage ? data[0].attributes.posterImage.large : baseImg,
                    imgCover : data[0].attributes.coverImage ? data[0].attributes.coverImage.original : baseImg,
                }
                return anime;
            } catch(err) {
                console.log(err);
            }
        }));
        return allAnime;
    } catch(err) {
        console.log(err);
    }
} 


const splitAnime = ( animes ) => {
    const result = [];

    if(animes.length > 3 ) {
        let splitAnime = [];
        animes.forEach( (anime,index) => {
            if( animes.length == (index + 1) ) {
                if(splitAnime.length == 3 ) {
                    result.push(splitAnime);
                    splitAnime = [];
                }
                splitAnime.push(anime);
                result.push(splitAnime);
            }
            else if( index % 3 == 0  && index != 0 ) {
                result.push(splitAnime);
                splitAnime = [];
                splitAnime.push(anime);
            } else {
                splitAnime.push(anime);
            }
        });
    } else {
        result.push(animes);
    }
    return result;
}

const animeCardLove = (listAnime) => { 
    const cardsList =  listAnime.map((animes,index) => {
        let cardList  = ' <div class="card-list-love">';
        // If array with index 0 exist make cardlove with class first
        if(animes[0]) {
            cardList += `<div class="first">
            <h1 class="animanga-title" >${animes[0].title}</h1>
            <div class="animanga-info">
                <div class="img-wrapper">   
                    <img src="${animes[0].imgPosterFl}" alt="">
                    <div class="detail">      
                        <ul>
                            <li>${animes[0].showType}</li>
                            <li>Rating : ${animes[0].rating}</li>
                            <li>Age Rating : ${animes[0].ageRating}</li>
                            <li>Aired : ${animes[0].aired}</li>
                            <li>User : ${animes[0].user}</li>
                            <li>Status : ${animes[0].status}</li>
                            <li>
                                <div class="action">
                                    <button>Detail</button>
                                    <button class="remove-btn-anime" data-id="${animes[0].id}">Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>`
        }
        // If array with index 1 exist make cardlove with class second
        if(animes[1]) {
            cardList += `<div class="second">
            <h1 class="title">${animes[1].title}</h1>
            <div class="animanga-info">
                <img src="${animes[1].imgPoster}" alt="">
                <div class="detail">
                    <ul>
                        <li>${animes[1].showType}</li>
                        <li>${animes[1].rating}&nbsp; ratings</li>
                        <li>${animes[1].user}&nbsp; users</li>
                        <li>
                            <div class="action">
                                <button>Detail</button>
                                <button class="remove-btn-anime" data-id="${animes[1].id}"">Remove</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>`
        }
        // If array with index 2 exist make cardlove with class third
        if(animes[2]) {
            cardList += `<div class="third">
            <h1 class="title">${animes[2].title}</h1>
            <div class="img-wrapper">
                <img src="${animes[2].imgCover}" alt="">
            </div>
            <div class="animanga-info">
                <div class="detail">
                <ul>
                    <li>${animes[2].showType}</li>
                    <li>${animes[2].rating}&nbsp; ratings</li>
                    <li>${animes[2].user}&nbsp; users</li>
                    <li>
                        <div class="action">
                            <button>Detail</button>
                            <button class="remove-btn-anime" data-id="${animes[2].user}">Remove</button>
                        </div>
                    </li>
                </ul>
                </div>
            </div>
        </div>`
        }
        cardList += '</div>';
        return cardList;
    });
    
    return cardsList.join('\n');
}


const setAnimeCard = (animes) => {
    const urlDetail = `${module.constant.baseUrl}/Anime/show`;
    const allAnime = animes.map(anime => {
        const synopsis = anime.attributes.synopsis ? module.utils.sliceSynopsis(anime.attributes.synopsis) : "This anime doesn't have synopsis" ;
        const language = module.utils.setLang(anime.attributes.titles);
        return `<div class="card">
        <div class="img-wrapper">
            <img src="${ anime.attributes.coverImage ? anime.attributes.coverImage.original : 'assets/img/card-1.png'}" alt="${language}">
            <i class="fas fa-star icons icon-rating "><span>${anime.attributes.averageRating}</span></i>
            <i class="fas fa-user icons icon-user"><span>${anime.attributes.userCount}</span></i>
            <i class="fas fa-tv icons icon-eps "><span>${anime.attributes.episodeLength ? anime.attributes.episodeLength : '?' }</span></i>
        </div>
        <div class="content-wrapper" >
            <h1>${language}</h1>
            <h4 class="anime-status">Status&nbsp;${anime.attributes.status}</h4>
            <span class="anime-synopsis" >${synopsis}</span>
            <a href="${urlDetail}/${anime.id}" class="btn-details" >Details</a>
        </div>
    </div>`
    });
    return allAnime;
}





define({
    removeAniList,
    setAnimeCardLove,
    animeSetById,
    splitAnime,
    animeCardLove,
    setAnimeCard,
})