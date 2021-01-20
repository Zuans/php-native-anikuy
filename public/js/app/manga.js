const removeMagList = async (e) => {
    const {
        utils,
        constant : Constant,
    } = module;
    const id = e.currentTarget.dataset.id; 
    const url = `${Constant.baseUrl}/Manga/removeLove`;
    const bodyData = {
        mangaId : id,
    };
    try {
        const { data } = await utils.httpRequest('POST',url,bodyData);
        if(data.length == 0 ) { 
            // clear div with class card-list-love
            utils.clearCardList('card-list-manga','card-list-love');
        }
        const mangaCards = await setMangaCardLove(data);
        if(mangaCards) {
            // first clear the div tag with card-list-love class
            utils.clearCardList('card-list-manga','card-list-love');
            mangaCardList.insertAdjacentHTML('beforeend',mangaCards);
            // Bring listener to remove btn again
            const newRemoveBtn = document.querySelectorAll('.remove-btn-manga');
            newRemoveBtn.forEach( btn => {
                btn.addEventListener('click',function(e){
                    removeMagList(e);
                });
            }); 
        }
    } catch(err) {
        console.log(err);
    }
}



const setMangaCardLove = async(data) => {
    try {
        const allManga = await mangaSetById(data);
        const resultSplit = await splitManga(allManga);
        const allMangaCard = await mangaCardLove(resultSplit);
        return allMangaCard;
    } catch(err){
        console.log(err);
    }
}


const mangaSetById = async(data) => {
    const { 
        utils,
        constant,
    } = module;
    const imgDefault = `${constant.baseUrl}/assets/img/card-1.png`;
    const allManga = await Promise.all(data.map( async(d) => {
        const id = d.manga_id;
        const url = `${constant.baseUrlApi}/manga?filter[id]=${id}`;
        let mangaData;
        let mangaID;
        try {
            const response = await utils.animangaRequest('GET',url);
            // Assign data response to mangaData
            mangaData = response[0].attributes;
            mangaID = response[0].id;
        } catch(err) {
            console.log(err);
        }
        const manga = {
            id : mangaID,
            title : utils.setLang(mangaData.titles),
            synopsis : utils.sliceSynopsis(mangaData.synopsis),
            fullSynopsis : mangaData.synopsis,
            rating : mangaData.averageRating ? mangaData.averageRating : '???',
            ratingRank : mangaData.ratingRank ? mangaData.ratingRank : '???',
            ageRating : mangaData.ageRating ? mangaData.ageRating : 'Unknown',
            user : mangaData.userCount ? mangaData.userCount : '???' ,
            status : mangaData.status ? mangaData.status : '???',
            aired : utils.setAired(mangaData.starDate,mangaData.endDate),
            chapCount : mangaData.chapterCount ? mangaData.chapterCount : '???',
            serialization : mangaData.serialization ? mangaData.serialization : '???',
            mangaType : mangaData.mangaType,
            imgPoster : mangaData.posterImage ? mangaData.posterImage.small : imgDefault,
            imgPosterFl : mangaData.posterImage ? mangaData.posterImage.large : imgDefault,
            imgCover : mangaData.coverImage ? mangaData.coverImage.original  : imgDefault ,
        }
        return manga;
    }));
    return allManga;
}


const splitManga = (allManga) => {
    const result = [];
    if(allManga.length > 3 ) {
        let splitManga = [];
        allManga.forEach((manga,index) => {
        
            if((index + 1) == allManga.length ) {
                // if split manga is full delete all value
                if(splitManga.length == 3 ) {
                    result.push(splitManga);
                    splitManga = [];
                }
                splitManga.push(manga);
                result.push(splitManga);
            } else if( index % 3 == 0 && index != 0 ) {
                result.push(splitManga);
                splitManga = [];
                splitManga.push(manga);
            } else {
                splitManga.push(manga);
            }
        });
    } else {
        result.push(allManga);
    }
    return result;
}

const mangaCardLove = (allManga) => {
    const { constant } = module;
    const allCards = allManga.map(mangaList => {
        let cardList = `<div class="card-list-love">`
        // first cardList el
        if(mangaList[0]) {
            cardList += `<div class="first">
            <h1 class="animanga-title" >${mangaList[0].title}</h1>
            <div class="animanga-info">
                <div class="img-wrapper">   
                    <img src="${mangaList[0].imgPosterFl}" alt="">
                    <div class="detail">      
                        <ul>
                            <li>Rating : ${mangaList[0].rating}</li>
                            <li>Age Rating : ${mangaList[0].ageRating}</li>
                            <li>Aired : ${mangaList[0].aired}</li>
                            <li>User : ${mangaList[0].user}</li>
                            <li>Status : ${mangaList[0].status}</li>
                            <li>Serialization by : ${mangaList[0].serialization}</li>
                            <li>
                                <div class="action">
                                    <button>
                                        <a href="${constant.baseUrl}Manga/show/${mangaList[0].id}">Detail</a>
                                    </button>
                                    <button class="remove-btn-manga" data-id="${mangaList[0].id}">Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>`
        }
        // second cardList el
        if(mangaList[1]) {
            cardList += `<div class="second">
            <h1 class="title">${mangaList[1].title}</h1>
            <div class="animanga-info">
                <img src="${mangaList[1].imgPoster}" alt="">
                <div class="detail">
                    <ul>
                        <li>Rating : ${mangaList[1].rating}</li>
                        <li>Age Rating : ${mangaList[1].ageRating}</li>
                        <li>Aired : ${mangaList[1].aired}</li>
                        <li>User : ${mangaList[1].user}</li>
                        <li>Status : ${mangaList[1].status}</li>
                        <li>Serialization by : ${mangaList[1].serialization}</li>
                        <li>
                            <div class="action">
                                <button>
                                    <a href="${constant.baseUrl}Manga/show/${mangaList[1].id}">Detail</a>
                                </button>
                                <button class="remove-btn-manga" data-id="${mangaList[1].id}">Remove</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>`
        }
        // third cardList el
        if(mangaList[2]) {
            cardList += `<div class="third">
            <h1 class="title">${mangaList[2].title}</h1>
            <div class="img-wrapper">
                <img src="${mangaList[2].imgCover} alt="">
            </div>
            <div class="animanga-info">
                <div class="detail">
                <ul>
                    <li>Rating : ${mangaList[2].rating}</li>
                    <li>Age Rating : ${mangaList[2].ageRating}</li>
                    <li>Aired : ${mangaList[2].aired}</li>
                    <li>User : ${mangaList[2].user}</li>
                    <li>Status : ${mangaList[2].status}</li>
                    <li>Serialization by : ${mangaList[2].serialization}</li>
                    <li>
                        <div class="action">
                            <button>
                                <a href="${constant.baseUrl}Manga/show/${mangaList[2].id}">Detail</a>
                            </button>
                            <button class="remove-btn-manga" data-id="${mangaList[2].id}">Remove</button>
                        </div>
                    </li>
                </ul>
                </div>
            </div>
        </div>`
        }

        // close div tag
        cardList += `</div>`

        return cardList
    });
    return allCards
}


const setMangaCard = (allManga) => {
    const urlDetail = module.constant.baseURL + 'Manga/show';
    console.log(module.constant.base)
    const resultManga = allManga.map( manga => {
        const synopsis = manga.attributes.synopsis ? sliceSynopsis(manga.attributes.synopsis) : "This manga doesn't synopsis";
        const title = setLang(manga.attributes.titles);
        return `<div class="card">
        <div class="img-wrapper">
            <img src="${ manga.attributes.coverImage ? manga.attributes.coverImage.original : 'assets/img/card-1.png'}" alt="${title}">
            <i class="fas fa-star icons icon-rating "><span>${manga.attributes.averageRating}</span></i>
            <i class="fas fa-user icons icon-user"><span>${manga.attributes.userCount}</span></i>
            <i class="fas fa-tv icons icon-eps "><span>${manga.attributes.episodeLength ? manga.attributes.episodeLength : '?' }</span></i>
        </div>
        <div class="content-wrapper" >
            <h1>${title}</h1>
            <h4 class="manga-status">Status&nbsp;${manga.attributes.status}</h4>
            <span class="manga-synopsis" >${synopsis}</span>
            <a href="${urlDetail}/${manga.id}" class="btn-details" >Details</a>
        </div>
    </div>`
    });
    return resultManga;
}




define({
    splitManga,
    removeMagList,
    setMangaCardLove,
    mangaCardLove,
    mangaSetById,
    setMangaCard,
});