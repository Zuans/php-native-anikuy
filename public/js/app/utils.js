




const setFormData = (data) => {
    const formData = new FormData();
    for ( const property in data ) {
        formData.append(property,data[property]);
    }
    return formData;
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
            return await anime.json();
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
            let result = await anime.json();
            return result.data;
        } catch(err) {
            console.log(err);
        }
    }
}


const alertError = (el,text) => {
    el.style.display = "block";
    el.textContent = text;
    const height = el.offsetHeight;
    el.style.height = "0px";
    el.classList.add('is-visible');
    el.style.height = `${height}px`;
    el.classList.add('error');
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
            return result;
        } catch(err) {
            console.log(err)
        }
    } else {
        try {
            const response = await fetch(url,{
                method : 'GET',
                mode : 'same-origin',
                credentials : 'same-origin',
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


const clearCardList = (parentEl,className) => {
    const parent = document.getElementById(parentEl);
    const childs = parent.children;
    [...childs].forEach(chld => {
        if(chld.classList.contains(className)) {
            chld.remove();
        }
    });
    return;
};


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


const setEpsLen = (length,count) => {
    let duration;
    if(length > 60 ) {
        const hours = Math.floor(length / 60 );
        const minutes = length - ( hours  * 60 );
        duration = `${hours} and ${minutes}`;
    } else {
        duration = `${length} min`;
    }
    if(count != 1) {
        duration += ` per eps`;
    } 
    return duration;
}

const setAired = (startDate,endDate) => {
    const stDate = startDate ? startDate : '?';
    const edDate = endDate ? endDate : '?';
    return `${stDate} to ${edDate}`;
}






define({
    setFormData,
    alertError,
    animangaRequest,
    httpRequest,
    clearCardList,
    sliceSynopsis,
    setLang,
    setEpsLen,
    setAired
})

