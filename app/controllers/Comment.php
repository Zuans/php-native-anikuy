<?php

class Comment extends Controller {

    public function loadMoreAnime() {

        // Instance Class
        $AnimeComment = new AnimeComment_model;
        
        $post = Helper::postData();
        if(!$post) {
            echo Helper::setError('Error when check data please try again');
            return;
        }
        $moreComment = $AnimeComment->getByAnimeId($post['id'],$post['totalLimit']);
        if(!$moreComment) {
            echo Helper::setError('No data avaible');
            return;
        }

        echo Helper::setSuccess('Success get all data',$moreComment);
        return;
    }

    public function loadMoreManga() {
    
        // Instance Class
        $MangaComment = new MangaComment_model;

        $post = Helper::postData();
        if(!$post) {
            echo Helper::setError('Error when parsing request');
            return;
        }

        $moreManga = $MangaComment->getByMangaId($post['id'],$post['totalLimit']);
        if(!$moreManga) {
            echo Helper::setError('No data avaible',404);
            return;

        }

        echo Helper::setSuccess('Success load more anime',$moreManga);
        return;
    }

}


?>