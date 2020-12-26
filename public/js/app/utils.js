

const classNavbar  = () => {
    const navbar = document.getElementById('navbar');
    navbar.classList.remove('nav-mobile');
    navbar.classList.remove('nav-tablet');
    navbar.classList.remove('nav-desktop');
    navbar.classList.remove('active');
    if(clientType == 'desktop' ) {
        navbar.classList.add('nav-desktop');
    } else if ( clientType == 'tablet' ) {
        navbar.classList.add('nav-tablet');
    } else {
        navbar.classList.add('nav-mobile');
    }
}


const setFormData = (data) => {
    const formData = new FormData();
    for ( const property in data ) {
        formData.append(property,data[property]);
    }
    return formData;
}

const httpRequest = async (method,url,data) => {
    if(method == "PUT") {
        try {
            const response = await fetch(url,{
                method : 'PUT',
                headers : {
                    'Content-Type' : 'application/json',
                },
                body : JSON.stringify(data),
            });
            let result = await response.json();
            return result;
        } catch(err) {
            console.log(err);
        }
    } else if(method == 'POST') {
        try {
            const response = await fetch(url,{
                method : 'POST',
                mode : 'same-origin',
                credentials : 'same-origin',
                headers : {
                    'Content-Type' : 'application/json',
                },
                body : JSON.stringify(data),
            });
            let result = await response.json();
            console.log(result);
            return result;
        } catch(err) {
            console.log(err)
        }
    } else {
        try {
            const response = await fetch(url,{
                method : 'GET',
                headers : {
                    'Content-Type': 'application/json',
                }
            });
            let result = await response.json();
            return result;
        } catch(err) {
            console.log(err);
        }
    }
}

const animangaRequest = async (method,url,data) => {
    if(method == "PUT") {
        try {
            const anime = await fetch(url,{
                method : 'PUT',
                headers : {
                    'Content-Type' : 'application/json',
                },
                body : JSON.stringify(data),
            });
            return anime.json();
        } catch(err) {
            console.log(err);
        }
    } else if(method == 'POST') {
        try {
            const anime = await fetch(url,{
                method : 'GET',
                headers : {
                    'Content-Type' : 'application/vnd.api+json',
                },
                body : JSON.stringify(data),
            });
            return anime.json();
        } catch(err) {
            console.log(err)
        }
    } else {
        try {
            const anime = await fetch(url,{
                method : 'GET',
                headers : {
                    'Accept': 'application/vnd.api+json',
                    'Content-Type': 'application/vnd.api+json'
                }
            });
            console.log(anime);
            let result = await anime.json();
            return result.data;
        } catch(err) {
            console.log(err);
        }
    }
}

const setAnime = (animes) => {
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

const setManga = (allManga) => {
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
    console.log(resultManga);
    return resultManga;
}


const sliceSynopsis = (synopsis) => {

    const splitSynop = synopsis.split(" ");
    if( splitSynop.length > 50 ) {
        return splitSynop.slice(0,50).join(" ") + ". . .";
    } else {
        return splitSynop.join(" ");
    };
}

const setLang = (lang) => {
    if( lang.hasOwnProperty('en_jp')) {
        return lang.en_jp;
    } else if( lang.hasOwnProperty('en')) {
        return lang.en;
    } else if( lang.hasOwnProperty('en_us')) {
        return lang.en_us;
    } else {
        return lang.jp;
    }
}


// DONT FORGET MAKE SET MANGA FUNCTION !!!!!!!!






define({
    classNavbar,
    setFormData,
    httpRequest,
    animangaRequest,
    setAnime,
    setManga,
    sliceSynopsis,
    setLang
})

