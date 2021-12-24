<?php
    include("../Model/BO/BO.php");
?>
<?php
    class C_CheckLogin
    {
        private $BO;
        public function __construct()
        {
            $this->BO = new BO();
        }
        public function doPost()
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if($this->BO->checkLogin($username,$password))
            {
                $problems_List = $this->BO->getAllProblem();
                $state = $this->BO->getStateByUsername($username);
                include_once("../UI/ShowProblem.html");
            }
            else
            {
                header('location:../UI/ide.html');
            }
        }
    }
?>
<?php
    $C_CheckLogin = new C_CheckLogin();
    $C_CheckLogin->doPost();
?>