// Declare Var
const module = {};
const loveIcon = document.getElementById('love-icon');
const commentBody = document.getElementById('comment-body');
const commentList = document.querySelector('.all-comments');
const addComment = document.getElementById('add-comment');
const txtComment = document.getElementById('input-comment');
const btnLoadEl = document.getElementById('btn-more-comnt');
const btnLoad = {
    limit : 5,
    click : 1,
}


define(function(require){
    const utils = require('./app/utils');
    const constant = require('./app/constant');
    const navbar = require('./app/navbar');
    const browser = require('./app/browser');
    const comment = require('./app/comment');
    module.navbar = navbar;
    module.utils = utils;
    module.constant = constant;
    module.browser = browser;
    module.comment = comment;
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

// check if addComment btn exist
if(addComment) {
    addComment.addEventListener('click', async function(e){
        const {
            constant,
            utils,
            comment,
        } = module;
        let bodyData;
        // Set Url
        const urlCurrent = window.location.href.toString().split('/');
        const type = urlCurrent[urlCurrent.length - 3];
        const id = urlCurrent[urlCurrent.length - 1];
        if( type == "Anime" ) {
            bodyData = {
                text : txtComment.value,
                animeId : id,
            }
        } else {
            bodyData = {
                text : txtComment.value,
                mangaId : id,
            }
        }
        const urlReq = `${constant.baseUrl}/${type}/addComment`;
        try {
            const response = await utils.httpRequest('POST',urlReq,bodyData);
            if(response.status == 'error') throw new Error(response.msg);
            const commentList = commentBody.querySelector(':scope, .all-comments');
            const commentCard = comment.setCard(response.data);
            commentList.insertAdjacentHTML('afterbegin',commentCard);
            txtComment.value = "";
        } catch(err) {
            console.log(err);
        }
    
    });
}


btnLoadEl.addEventListener('click',async function(e){
    const { 
        utils,
        constant,
        comment 
    } = module;
    btnLoad.click++;
    let url = "";
    const currntUrl = window.location.href.toString().split('/');
    const type = currntUrl[currntUrl.length -3];
    const id = currntUrl[currntUrl.length - 1];
    const bodyData = {
        totalLimit : btnLoad.limit * btnLoad.click,
        id,
    };
    if( type === 'Anime' ) {
        url = `${constant.baseUrl}/Comment/loadMoreAnime`;
    } else {
        url = `${constant.baseUrl}/Comment/loadMoreManga`;
    }
    try {
        const {error,data} = await utils.httpRequest('POST',url,bodyData);
        if(error) throw new Error(msg);
        // If all data has loaded
        if(data.allComment.length == data.totalData ) {
            btnLoadEl.remove();
        };
        comment.delAllCard(commentList,'comment-card');
        const newList = comment.setAllCard(data.allComment);
        commentList.insertAdjacentHTML('afterbegin',newList);
    } catch(err) {
        console.log(err);
    }
    
});