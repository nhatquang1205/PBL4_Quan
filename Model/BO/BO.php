<?php
    include_once("C:\\xampp\htdocs\\xampp\\PBL4_Quang\Model\Entities/E_Problem.php");
    include_once("C:\\xampp\htdocs\\xampp\\PBL4_Quang\Model\Entities/E_Testcase.php");
    include_once("C:\\xampp\htdocs\\xampp\\PBL4_Quang\Model\Entities/E_State.php");
    include_once("C:\\xampp\htdocs\\xampp\\PBL4_Quang\Model\DAO/DAO.php");
    class BO
    {
        public $DAO;
        public function __construct()
        {
            $this->DAO = new DAO();
        }
        public function getAllProblem()
        {
            return $this->DAO->getAllProblem();
        }
        public function getProblemByProblemID($id)
        {
            return $this->DAO->getProblemByProblemID($id);
        }
        public function getIOByProblemID($id)
        {
            return $this->DAO->getIOByProblemID($id);
        }
        public function register($username, $password)
        {
            return $this->DAO->register($username,$password);
        }
        public function checkLogin($username, $password)
        {
            return $this->DAO->checkLogin($username,$password);
        }
        public function getStateByUsername($username)
        {
            return $this->DAO->getStateByUsername($username);
        }
        public function updateState($username, $id)
        {
            return $this->DAO->updateState($username,$id);
        }
    }
?>