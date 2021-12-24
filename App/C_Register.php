<?php
    include("../Model/BO/BO.php");
?>
<?php
    class C_Register
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
            if($this->BO->register($username,$password))
            {
                echo true;
            }
            else
            {
                echo false;
            }
        }
    }
?>
<?php
    $C_Register = new C_Register();
    $C_Register->doPost();
?>