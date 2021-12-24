<?php
    include_once("C:\\xampp\htdocs\\xampp\\PBL4_Quang\Model\Entities/E_Problem.php");
    include_once("C:\\xampp\htdocs\\xampp\\PBL4_Quang\Model\Entities/E_Testcase.php");
    include_once("C:\\xampp\htdocs\\xampp\\PBL4_Quang\Model\Entities/E_State.php");
    class DAO
    {
        public $connect;
        public function __construct()
        {
            $severname = "localhost";
            $username = "root";
            $password = "";
            $databasename = "pbl4";    
            $this->connect = mysqli_connect($severname,$username,$password,$databasename);
            if($this->connect)
            {
                mysqli_query($this->connect,"set names 'UTF-8'");
            }
            else echo 'Ket noi that bai'.mysqli_connect_error();
        }
        public function register($username, $password)
        {
            $sql1 = "select * from account where username = $username";
            $result = mysqli_query($this->connect,$sql1);
            if($row = mysqli_fetch_array($result))
            {
                return false;
            }
            else
            {
                $sql2 = "insert into account values ('$username','$password')";
                $result = mysqli_query($this->connect,$sql2);
                $listProblem = $this->getAllProblem();
                for($i = 0; $i < sizeof($listProblem); ++$i)
                {
                    $sql3 = "insert into state values('$username','" . $listProblem[$i]->getId() . "', '0')";
                    $result = mysqli_query($this->connect,$sql3);
                }
                return true;
            } 
        }
        public function getStateByUsername($username)
        {
            $sql = "select * from state where username = '$username'";
            $result = mysqli_query($this->connect,$sql);
            $i = 0;
            while($row = mysqli_fetch_array($result))
            {
                $id = $row['id'];
                $username = $row['username'];
                $state = $row['state'];
                $states[$i++] = new Entity_State($id,$username,$state);
            }
            return $states;
        }
        public function checkLogin($username, $password)
        {
            if($username == "" || $password == "") return false;
            $sql = "select * from account where username = '" . $username . "' and password = '" . $password ."'";
            $result = mysqli_query($this->connect,$sql);
            if($row = mysqli_fetch_array($result))
            {
                return true;
            }
            else return false;
        }

        public function getAllProblem()
        {
            $sql = "Select * from problem";
            $result = mysqli_query($this->connect, $sql);
            $i = 0;
            while($row = mysqli_fetch_array($result))
            {
                $id = $row['id'];
                $name = $row['name'];
                $description = $row['description'];
                $inputDescription = $row['inputDescription'];
                $outputDescription = $row['outputDescription'];
                $probs[$i++] = new Entity_Problem($id,$name,$description,$inputDescription,$outputDescription);
            }
            return $probs;
        }
        public function getProblemByProblemID($id)
        {
            $sql = "Select * from problem where id = '" .$id ."'";
            $result = mysqli_query($this->connect, $sql);
            while($row = mysqli_fetch_array($result))
            {
                $id = $row['id'];
                $name = $row['name'];
                $description = $row['description'];
                $inputDescription = $row['inputDescription'];
                $outputDescription = $row['outputDescription'];
                $probs = new Entity_Problem($id,$name,$description,$inputDescription,$outputDescription);
            }
            return $probs;
        }
        public function getIOByProblemID($id)
        {
            $sql = "Select * from testcase where id = '" .$id ."'";
            $result = mysqli_query($this->connect, $sql);
            $i = 0;
            if(mysqli_fetch_array($result) > 0)
            {
            while($row = mysqli_fetch_array($result))
            {
                $id = $row['id'];
                $input = $row['input'];
                $output = $row['output'];
                $testcases[$i++] = new Entity_Testcase($id, $input, $output);
            }
            return $testcases;
            }
            else return 0;
        }
        public function updateState($username, $id)
        {
            $sql = "update state set state = '1' where username = '$username' and id = '$id'";
            $result = mysqli_query($this->connect,$sql);
            return $result;
        }
    }
?>