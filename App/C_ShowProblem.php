<?php
    include("../Model/BO/BO.php");
    class Control_ShowProblem
    {
        public function invoke()
        {
            $id = $_GET['id'];
            $username = $_GET['username'];
            $BO = new BO();
            $problem = $BO->getProblemByProblemID($id);
            $testCase = $BO->getIOByProblemID($id);
            for($i = 0; $i < sizeof($testCase); ++$i)
            {
                $input = implode(" ",explode("@@", $testCase[$i]->getInput()));
                $listInput[$i] = $input; 
                $output = implode(" ",explode("@@", $testCase[$i]->getOutput()));
                $listOutput[$i] = $output;
            }
            include_once("../UI/ProblemDetails.html");
        }
    }
    $C_Problem = new Control_ShowProblem();
    $C_Problem->invoke();
?>