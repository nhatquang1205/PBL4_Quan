<?php
    include("../Model/BO/BO.php");
    class Control_Problem
    {
        private $BO;
        public function __construct()
        {
            $this->BO = new BO();
        }
        public function doGet()
        {
            $username = $_REQUEST['username'];
            $problems_List = $this->BO->getAllProblem();
            $state = $this->BO->getStateByUsername($username);
            include_once("../UI/ShowProblem.html");
        }
    }
    $C_Problem = new Control_Problem();
    $C_Problem->doGet();
?>