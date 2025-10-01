<?php
// 代码生成时间: 2025-10-02 03:01:22
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Message as Message;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Filter;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Paginator\Adapter\Model\Config as PaginatorConfig;
use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;

// SkillCertificationPlatform Controller
class SkillCertificationPlatform extends Controller
{

    // Error handling function
    public function onError($error)
    {
        $this->flashSession->error($error->getMessage());
        return $this->response->redirect('skill-certification-platform/index');
    }

    public function indexAction()
    {
        // Create a query builder instance
        $builder = $this->modelsManager->createBuilder();
        // Select skills
        $builder->columns('*');
        $builder->from('Skill');

        // Create a Paginator instance
        $config = new PaginatorConfig([
            'model' => 'Skill',
            'builder' => $builder,
            'limit' => 10,
            'page' => $this->request->getQuery('page', 'int', 1)
        ]);
        $paginator = new Paginator($config);
        $this->view->setVar('page', $paginator->getPaginate());
    }

    public function createAction()
    {
        try {
            if ($this->request->isPost()) {
                $skill = new Skill();
                // Filter and sanitize input data
                $input = $this->request->getPost('skill', 'striptags');
                $skill->name = $input['name'];
                $skill->description = $input['description'];
                // Validate data
                if (!$skill->save()) {
                    foreach ($skill->getMessages() as $message) {
                        $this->flashSession->error($message->getMessage());
                    }
                    return;
                }

                // Redirect to index action
                $this->flashSession->success('Skill created successfully');
                return $this->response->redirect('skill-certification-platform/index');
            }
        } catch (Exception $e) {
            $this->onError($e);
        }
    }

    // Add, edit, delete, and other actions as needed

}

// Skill Model
class Skill extends Phalcon\Mvc\Model
{
    public $id;
    public $name;
    public $description;

    // Validate data
    public function validation()
    {
        // Check if name is present
        if (!$this->name) {
            $this->appendMessage(new Message('Name is required'));
            return false;
        }
        // Add more validations as needed
    }

    // Initialize model
    public function initialize()
    {
        $this->setSource('skills');
    }
}
