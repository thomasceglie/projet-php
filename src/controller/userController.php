<?php 

class UserController{

    static function addUser() {
        $model = new UserModel;
        $flash = new FlashController;

        $articles = [];
        $userModel = new FrontEndModel;
        $articles = $userModel->listPost();

        if(!isset($_POST['admin'])){
            $_POST['admin'] = false;
        }
        
        $check_email = $model->checkEmail($_POST['email']);

        if(!isset($_POST['admin'])){
            $_POST['admin'] = false;
        }
        if($_POST['pass'] === $_POST['pass_verify']) {
            $model->insertUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['pass'], $_POST['admin']);
            require_once PROJECTPATH . "/views/listView.php";
        }
        else if ($check_email === false) {
            $flash->setFlash("L'email existe déja");
        }
         else {
            $flash->setFlash('Mauvaise combinaison de mot de passe');
        }
    }

    static function logUser() {
        $model = new UserModel;
        $flash = new FlashController;

        $articles = [];
        $modelUser = new FrontEndModel;
        $articles = $modelUser->listPost();

        $check_account = $model->checkAccount($_POST['email'], $_POST['pass']);
        if($check_account == true) {
            require_once PROJECTPATH . "/views/listView.php";
        } else {
            $flash->setFlash('Mauvais mot de passe et/ou email');
            require_once PROJECTPATH . "/views/login.php";
        }
    }

    static function getUsers(){
        $users = [];
        $model = new UserModel;
        $users = $model->listUsers();
        require_once PROJECTPATH . "/views/usersView.php";
    }

    static function deleteUser() {
        $model = new UserModel;
        $model->deleteUser($_GET['id']);
        header("Location: /usersView ");
    }

    static function updateAdmin() {
        $model = new UserModel;
        $model->updateAdmin($_GET['id']);
        header("Location: /usersView ");
    }
}