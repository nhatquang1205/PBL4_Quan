<?php
    include_once("E_Problem.php");
    class Model_Problem
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

        public function getAllProblem()
        {
            $sql = "Select * from problem";
            $result = mysqli_query($this->connect, $sql);
            $i = 0;
            while($row = mysqli_fetch_array($result))
            {
                $ID_Prob = $row['ID_Prob'];
                $Name_Prob = $row['Name_Prob'];
                $Description = $row['Description'];
                $InputDescription = $row['InputDescription'];
                $OutputDescription = $row['OutputDescription'];
                $probs[$i++] = new Entity_Problem($ID_Prob,$Name_Prob,$Description,$InputDescription,$OutputDescription);
            }
            return $probs;
        }
    }
?>