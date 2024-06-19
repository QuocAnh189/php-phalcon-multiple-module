<?php

declare(strict_types=1);

namespace MyApp\User\Controllers;

use MyApp\Common\ControllerBase;
use MyApp\User\Services\UsersService;
use MyApp\User\Forms\UsersForm;
use MyApp\User\Models\Users;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * @RoutePrefix("/api")
 */
class UsersController extends ControllerBase
{
    /**
     * @var UsersService Instance of usersService
     */
    private UsersService $usersService;

    /**
     * Initialize method.
     */
    public function initialize()
    {
        parent::initialize();
        $this->tag->title()->set('Manage your users');

        $this->usersService = new UsersService();
    }

    /**
     * @Get("/users/")
     */
    public function indexAction()
    {
        $this->view->form = new UsersForm();
    }

    /**
     * @Get("/users/:params")
     */
    public function searchAction()
    {
        if ($this->request->isPost()) {
            $query = Criteria::fromInput(
                $this->di,
                Users::class,
                $this->request->getPost()
            );

            $this->persistent->searchParams = ['di' => null] + $query->getParams();
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $users = $this->usersService->findUsers($parameters);

        if (count($users) == 0) {
            $this->flash->notice('The search did not find any user');

            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'index',
            ]);

            return;
        }

        $paginator = new Paginator([
            'model' => users::class,
            'parameters' => $parameters,
            'limit' => 10,
            'page'  => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->page = $paginator->paginate();
        $this->view->users = $users;
    }

    /**
     * @Post("/users/create")
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->view->form = new UsersForm(null, ['edit' => false]);
            return;
        }

        $form = new usersForm();
        $user = new users();
        $data = $this->request->getPost();

        if (!$form->isValid($data,$user)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            $this->view->form = $form;
            return;
        }

        try {
            $this->usersService->createuser($data);
            $this->flash->success('Created user successfully');
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = new usersForm(null, ['edit' => false]);
    }

    /**
     * @Put("/users/update/{id}")
     */
    public function updateAction(string $id)
    {
        $user = $this->usersService->getUserById($id);
        if (!$this->request->isPost()) {
            if (!$user) {
                $this->flash->error('user not found');
                $this->dispatcher->forward([
                    'controller' => 'users',
                    'action'     => 'index',
                ]);
                return;
            }

            $this->view->user = $user;
            $this->view->form = new usersForm($user, ['edit' => true]);
            return;
        }

        $form = new usersForm();
        $data = $this->request->getPost();

        if (!$form->isValid($data, $user)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            $this->view->user = $user;
            $this->view->form = $form;
            return;
        }

        try {
            $this->usersService->updateuser($user, $data);
            $this->flash->success('Updated user successfully');
            $this->view->user = $user;
            $this->view->form = $form;
            return;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = new usersForm(null, ['edit' => false]);
    }

    /**
     * @Delete("/users/delete/{id}")
     */
    public function deleteAction(string $id)
    {
        try {
            $this->usersService->deleteuser($id);
            $this->flash->success('Deleted user successfully');

            $this->dispatcher->forward([
                'controller' => 'users',
                'action'     => 'search',
            ]);
        } catch (\Exception $e) {
            $this->flash->error('Failed to delete user: ' . $e->getMessage());
        }
    }
}
