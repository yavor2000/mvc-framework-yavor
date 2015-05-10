<?php

class QuestionsController extends BaseController
{
    private $db;

    public function onInit()
    {
        $this->title = "Questions";
        $this->db = new QuestionsModel();
    }

    public function index()
    {
        $this->questions = $this->db->getAll();
    }

    public function view($id)
    {
        $this->question = $this->db->getById($id);
        if (!isset($this->question['title'])) {
            $this->hasQuestion = false;
            $this->addErrorMessage("No such question");
        } else {
            $this->hasQuestion = true;
            $this->answers = $this->db->getAllAnswersForQuestion($id);
            $this->title = $this->question['title'];
            $_SESSION['currentQuestionId'] = $id;
            $username = $this->getUsername();
            if ($username) {
                $userDb = new UsersModel();
                $userId = $userDb->getByUsername($username);
            } else {
                $userId = null;
            }
            $this->db->addVisit($id, $userId);
        }
    }

    public function create()
    {
        $this->title = "Ask Question";
        if (!$this->isLoggedIn) {
            $this->addErrorMessage("Please log in first!");
            $this->redirectToUrl("/users/login");
        }
        if ($this->isPost) {
            $title = $_POST['question_title'];
            $content = $_POST['question_content'];
            $username = $this->getUsername();
            $categoryId = $_POST['category_id'];
            $tagsString = $_POST['question_tags'];
            $tagsArray = explode(", ", $tagsString);
            if ($title == '' || $content == '' || count($tagsArray) == 0) {
                $this->addErrorMessage("Please fill out all fields to create question.");

                return;
            }

            if ($this->db->createQuestion($title, $content, $username, $categoryId, $tagsArray)) {
                $this->addInfoMessage("Question created.");
                $this->redirect('questions');
            } else {
                $this->addErrorMessage("Error creating question.");
            }
        }
    }

    public function delete($id)
    {
        if (!$this->isLoggedIn) {
            $this->addErrorMessage("Please log in first!");
            $this->redirectToUrl("/users/login");
        }

        if (!$this->userIsAuthorToQuestion($id)) {
            $this->addErrorMessage("You cannot delete this question.");
        }

        if ($this->db->deleteQuestion($id)) {
            $this->addInfoMessage("Question deleted.");
        } else {
            $this->addErrorMessage("Cannot delete question.");
        }
        $this->redirect('questions');
    }


}