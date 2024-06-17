<?php

declare(strict_types=1);

namespace MyApp\Auth\Controllers;

use MyApp\Common\ControllerBase;
use MyApp\Common\ErrorException;
use MyApp\Auth\Models\Users;
use MyApp\Auth\Services\AuthsService;
use MyApp\Auth\Forms\LoginForm;
use MyApp\Auth\Forms\RegisterForm;

/**
 * Class AuthsController
 *
 * @package MyApp\Auth\Controllers
 */
class AuthsController extends ControllerBase
{
    private AuthsService $authService;

    /**
     * Initialize method.
     */
    public function initialize()
    {
        $this->tag->title()->set('Sign Up/Sign In');
        parent::initialize();
        $this->authService = new AuthsService();
    }

    /**
     * @Get("/")
     */
    public function indexAction(): void
    {
        $this->flash->notice('Hello, have a good day');
    }

    /**
     * @Post("auths/signin")
     */
    public function signinAction(): void
    {
        $form = new LoginForm();

        if (!$this->request->isPost()) {     
            $this->view->form = $form;
            return;
        }

        $username = $this->request->getPost('username', 'string');
        $password = $this->request->getPost('password', 'string');

        if (empty($username) || empty($password)) {
            $this->flash->error('Username and password cannot be empty');
            $this->view->form = $form;
            return;
        }

        try {
            $user = $this->authService->loginUser($this->request->getPost());
    
            $this->registerSession($user);
            $this->flash->success('Welcome ' . $user->username);

            $this->dispatcher->forward([
                'controller' => 'auths',
                'action' => 'index',
            ]);
        } catch (ErrorException $e) {
            $this->flash->error($e->getMessage());
            $this->view->form = $form;
        }
    }

    /**
     * @Post("auths/signup")
     */
    public function signupAction(): void
    {
        $form = new RegisterForm();
        $newUser = new Users();
        $postData = $this->request->getPost();

        if (!$this->request->isPost()) {
            $this->view->form = $form;
            return;
        }

        if (!$form->isValid($postData, $newUser)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            $this->view->form = $form;
            return;
        }

        try {
            $result = $this->authService->registerUser($postData, $newUser);

            if(!$result) {  
                foreach ($form->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
                $this->view->form = $form;
                return;
            }
    
            $this->flash->success('Register successfully, please log-in');

            $this->dispatcher->forward([
                'controller' => 'auths',
                'action' => 'index',
            ]);
        } catch (ErrorException $e) {
            $this->flash->error($e->getMessage());
            $this->view->form = $form;
        }
  
       
    }

    /**
     * set Sesstion method.
     *
     * @param Users $user 
     */
    private function registerSession(Users $user): void
    {
        $this->session->set('auth', [
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role
        ]);
    }

    /**
     * @Get("auths/signout")
     */
    public function signoutAction(): void
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        $this->dispatcher->forward([
            'controller' => 'auths',
            'action' => 'index',
        ]);
    }
}
