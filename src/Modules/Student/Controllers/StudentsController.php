<?php

declare(strict_types=1);

namespace MyApp\Student\Controllers;

use MyApp\Common\ControllerBase;
use MyApp\Student\Services\StudentsService;
use MyApp\Student\Forms\StudentsForm;
use MyApp\Student\Models\Students;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * Class StudentsController
 *
 * @package MyApp\Student\Controllers
 */
class StudentsController extends ControllerBase
{
    /**
     * @var StudentsService Instance of StudentsService
     */
    private StudentsService $studentsService;

    /**
     * Initialize method.
     */
    public function initialize()
    {
        parent::initialize();
        $this->tag->title()->set('Manage your students');

        $this->studentsService = new StudentsService();
    }

    /**
     * @Get("students/index")
     */
    public function indexAction()
    {
        $this->view->form = new StudentsForm();
    }

    /**
     * @Get("students/:params")
     */
    public function searchAction()
    {
        if ($this->request->isPost()) {
            $query = Criteria::fromInput(
                $this->di,
                Students::class,
                $this->request->getPost()
            );

            $this->persistent->searchParams = ['di' => null] + $query->getParams();
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $students = $this->studentsService->getAllStudents($parameters);

        if (count($students) == 0) {
            $this->flash->notice('The search did not find any student');

            $this->dispatcher->forward([
                'controller' => 'students',
                'action'     => 'index',
            ]);

            return;
        }

        $paginator = new Paginator([
            'model' => Students::class,
            'parameters' => $parameters,
            'limit' => 10,
            'page'  => $this->request->getQuery('page', 'int', 1),
        ]);

        $this->view->page = $paginator->paginate();
        $this->view->students = $students;
    }

    /**
     * @Post("students/create")
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->view->form = new StudentsForm(null, ['edit' => false]);
            return;
        }

        $form = new StudentsForm();
        $student = new Students();
        $data = $this->request->getPost();

        if (!$form->isValid($data,$student)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            $this->view->form = $form;
            return;
        }

        try {
            $this->studentsService->createStudent($data);
            $this->flash->success('Created student successfully');
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = new StudentsForm(null, ['edit' => false]);
    }

    /**
     * @Put("students/update")
     */
    public function updateAction(string $code)
    {
        $student = $this->studentsService->getStudentByCode($code);
        if (!$this->request->isPost()) {
            if (!$student) {
                $this->flash->error('Student not found');
                $this->dispatcher->forward([
                    'controller' => 'students',
                    'action'     => 'index',
                ]);
                return;
            }

            $this->view->student = $student;
            $this->view->form = new StudentsForm($student, ['edit' => true]);
            return;
        }

        $form = new StudentsForm();
        $data = $this->request->getPost();

        if (!$form->isValid($data,$student)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }

            $this->view->student = $student;
            $this->view->form = $form;
            return;
        }

        try {
            $this->studentsService->updateStudent($student, $data);
            $this->flash->success('Updated student successfully');
            $this->view->student = $student;
            $this->view->form = $form;
            return;
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = new StudentsForm(null, ['edit' => false]);
    }

    /**
     * @Delete("students/delete")
     */
    public function deleteAction(string $code)
    {
        try {
            $this->studentsService->deleteStudent($code);
            $this->flash->success('Deleted student successfully');

            $this->dispatcher->forward([
                'module'     => 'student',
                'controller' => 'students',
                'action'     => 'search',
            ]);
        } catch (\Exception $e) {
            $this->flash->error('Failed to delete student: ' . $e->getMessage());
        }
    }
}
