<?php

class Auth extends Controller {
    
    public function indexLogin() {
        $this->view('login',[
            'error' => []
        ]);
    } 

    public function indexRegister() {
        $this->view('register',[
            'error' => [],
        ]);
    }


    public function login() {
        $Users = new User_model;
        $errors = [];

        $user = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        $userInfo = $Users->getUserByEmail($user['email']);
        // Check User info
        if($userInfo) {
            // Verifying Password
            $verifyPassword = password_verify($user['password'],$userInfo['password']);
            if($verifyPassword) {
                $_SESSION['user_id'] = $userInfo['ID'];
                $_SESSION['username'] = $userInfo['username'];
                $_SESSION['email'] = $userInfo['email'];
                $this->redirect('Home/index');
            } else {
                $errors['account'] = 'Your Email or Password is incorrect';
            }
        } else {
            $errors['account'] = 'Your Email or Password is incorrect';
        }
        
        // Checking Error
        if($errors) {
            return $this->view('login',[
                'error' => $errors,
            ]);
        }



        // return $this->redirect('Home/index');

    }

    public function register() {
        $error = $this->validationSignUp($_POST);
        if($error) {
            return $this->view('register',[
                'error' => $error,
            ]);
        }
        $user = new User_model;
        $result = $user->addUser($_POST);
        if($result === 1 ) {
            Flash::setFlash('success','Success created');
            $this->redirect('Auth/indexLogin/success');
        } else {
            throw new Exception('Query Error');
        }
        
    }


    public function logout() {
        echo $_SESSION['user_id'];
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        $this->redirect('Home/index');
    }

    public function validationSignUp($inputs = []) {
        $errors = [];
        $Users = new User_model;


        // If validation
        if(!$inputs['username']) $errors['username'] = 'Username is required';
        if(!$inputs['email']) $errors['email'] = 'Email is required';
        if(!$inputs['password']) $errors['password'] = 'Password is required';
        if(strlen($inputs['password']) < 6 ) $errors['password'] = 'Password must great than 6 character';
        if($inputs['password'] != $inputs['confirm-password']) $errors['confirm-password'] = 'Please re-type same password';
        if(!filter_var($inputs['email'],FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Your email is invalid';
        
        if($errors) {
            return $errors;
        } else {
            $emailExist = $Users->getUserByEmail($inputs['email']);
            if($emailExist) $errors['account'] = 'Email Already Exist';
            return $errors;
        }
    }

}

?>

