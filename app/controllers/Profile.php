<?php 

class Profile extends Controller {

    public function info() {
        // instance class
        $User = new User_model;
        $MangaLove = new MangaLove_model;
        $AnimeLove = new AnimeLove_model;
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if(!$userId) {
            return $this->redirect('Auth/indexLogin');
        }
        $userInfo = $User->getUserById($userId);
        $loveCount = $User->loveCount($userId);
        $commentCount = $User->commentCount($userId);
        return $this->view('profile/info',[
            'userInfo' => $userInfo,
            'loveCount' => $loveCount,
            'commentCount' => $commentCount,
        ]);
    }


    public function edit() {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        if(!$userId) {
            Flash::setFlash('error','Please login first');
           return $this->redirect('Auth/indexLogin'); 
        }

        // Check validate user
        $User = new User_model;
        // User info
        $userInfo = $User->getUserById($userId);
        $loveCount = $User->loveCount($userId);
        
        // set method update;
        $updateMethod = null;
        $password;
        if(isset($_POST['new-password'])) {
            // this update method is change password
            $updateMethod = 'change password';
            $password = $_POST['old-password'];
            // check if new password same with confirm password
            if($_POST['new-password'] != $_POST['confirm-password']) {
                Flash::setFlash('error','New and confirm not same please try again!');
                return $this->view('profile/info',[
                    'userInfo' => $userInfo,
                    'loveCount' => $loveCount
                ]);
            }
        }else {
            $password = $_POST['password'];
        }

        // Validate user
        $validate = $User->validate($userId,$password);
        if(isset($validate['error'])) {
            Flash::setFlash('error',$validate['error']);
            return $this->view('profile/info',[
                'userInfo' => $userInfo,
                'loveCount' => $loveCount,
            ]);
        }


        // Check update method then update it
        if($updateMethod == 'change password') {
            $isUpdated = $User->updatePass($userId,$_POST);
        } else {
            $isUpdated = $User->update($userId,$_POST);
        }
        if(!$isUpdated) {
            Flash::setFlash('error','Something wrong when update account please try again!');
            return $this->view('profile/info',[
                'userInfo' => $userInfo,
            ]);
            
        }
        // Successfully update user and get mew user info
        Flash::setFlash('success','Your account has benn successfully changed');
        $newUserInfo = $User->getUserById($userId);
 
        // And change SESSION username
        $_SESSION['username'] = $newUserInfo['username'];
        return $this->view('profile/info',[
            'userInfo' => $newUserInfo,
            'loveCount' => $loveCount,
        ]);
    }

    public function loveList() {
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
        $loveAnime = [];
        if($userId) {
            // Get Anime Love
            $AnimeLove = new AnimeLove_model;
            $animeResult = $AnimeLove->getByUserId($userId);
            $animesLove  = [];
            if(empty($animeResult)) {
                $animesLove =  null;
            } else {
                $animesLove = Anime::setAnimeLove($animeResult);
            }
            // Get Manga Love
            $MangaLove = new MangaLove_model;
            $mangaResult = $MangaLove->getByUserId($userId);
            $mangasLove = [];
            if(empty($mangaResult)) {
                $mangasLove =  null;
            } else {
                $mangasLove = Manga::setMangaLove($mangaResult);;
            }
            return $this->view('profile/love_list',[
                'animesLove' => $animesLove,
                'mangasLove' => $mangasLove,
                ]
            );
        } else {
            return $this->redirect('Auth/indexLogin');
        }

    }
}


?>