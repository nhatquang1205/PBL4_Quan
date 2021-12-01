<?php
    include_once("../Model/M_Problem.php");
    class Control_Problem
    {
        public function invoke()
        {
            $modelProblem = new Model_Problem();
            $problems_List = $modelProblem->getAllProblem();
            include_once("../UI/ShowProblem.html");
        }
    }
    $C_Problem = new Control_Problem();
    $C_Problem->invoke();
?>