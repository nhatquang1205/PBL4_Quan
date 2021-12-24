<?php include_once 'Extension/IOHelper.php';
    include("../Model/BO/BO.php");
?>
<?php
    class Controller_Judge
    {
        private $BO;
        private $outputPath = __DIR__."\IO\output.txt";
        private $errorPath = __DIR__."\IO\\error.txt";
        public function __construct()
        {
            $this->BO = new BO();
        }
        private function Judge($id, $language, $inputPath, $filePath, $fileName){
            $result = "True Answer";
            $testcases = $this->BO->getIOByProblemID($id);
            $index = -1;
            $size = sizeof($testcases);
            for($i = 0; $i < sizeof($testcases); ++$i)  
            {
                $inputCode = explode("@@", $testcases[$i]->getInput());
                IOHelper::WriteFile($inputPath,implode("\n",$inputCode));
                
                ExecuteCode($filePath, $language, $fileName);
                $outputTrue = explode("@@", $testcases[$i]->getOutput());
                $fileSize = filesize($filePath);
                $outputCheck = explode("\n",ReadOutput($this->outputPath, $this->errorPath, $fileSize));
                $check = $this->check($outputTrue,$outputCheck);
                if($check == "Compiler Error" || $check == "Wrong Answer")
                {
                    $result = $check;
                    $index = $i+1;
                    break;
                }
            }
            $data = array();
            $data['result'] = $result;
            $data['index'] = $index;
            $data['size'] = $size;
            return $data;
        }
        private function check($outputTrue, $outputCheck){
            if($outputCheck[0] == "Compiler Error")
            {
                return "Compiler Error";
            }
            if(sizeof($outputCheck) != sizeof($outputTrue)) return "Wrong Answer";
            else
            {
                for($i = 0; $i < sizeof($outputCheck); ++$i)
                {
                    if(trim($outputCheck[$i]) != trim($outputTrue[$i])) return "Wrong Answer";
                }
                return "True Answer";
            }
        }
        public function doPost(){
            $id = $_POST['id'];
            $language = $_POST['language'];
            $code = $_POST['code'];
            $username = $_POST['username'];
            $random = substr(md5(mt_rand()), 0, 7);

            $filePath = "Code/" .$language. "/" . $random . "." . $language;
            $inputPath = "IO/Input/" . $random. ".txt";
            IOHelper::WriteFile($filePath,$code);

            $data = $this->Judge($id, $language, $inputPath, $filePath, $random);
            
            echo json_encode($data);

            if($data['result'] == "True Answer")
            {
                $this->BO->updateState($username,$id);
            }

            $exeFilePath = "Code/". $random . ".exe";
            IOHelper::DeleteFile($exeFilePath);
            IOHelper::DeleteFile($inputPath);
            IOHelper::DeleteFile($filePath);
        }
    }
?>

<?php
    function ExecuteCode($filePath, $language, $fileName){
        if($language == "cpp") {
            $outputExe = "Code\\" . $fileName . ".exe";
            shell_exec("g++ $filePath -o $outputExe > " .__DIR__. "\IO\\error.txt 2>&1");
            $command = "pwsh -Command Get-Content " . __DIR__ . "\IO\Input\\" .$fileName.".txt | " . __DIR__ . "\\$outputExe > " . __DIR__ . "\IO\output.txt";
            shell_exec($command);
        }
        if($language == "c") {
            $outputExe = "Code\\". $fileName . ".exe";
            shell_exec("gcc $filePath -o $outputExe > " .__DIR__. "\IO\\error.txt 2>&1");
            $command = "pwsh -Command Get-Content " . __DIR__ . "\IO\Input\\" .$fileName.".txt | " . __DIR__ . "\\$outputExe > " . __DIR__ . "\IO\output.txt";
            shell_exec($command);
        }
        if($language == "py")
        {
            shell_exec("pwsh -Command Get-Content " . __DIR__ . "\IO\Input\\" .$fileName.".txt | python ". __DIR__ ."\\$filePath > " . __DIR__ . "\IO\output.txt 2>&1" );
        }
    }
    function ReadOutput($outputPath, $errorPath, $fileSize){
        if (filesize($outputPath) > 0)
        {   
            $content = IOHelper::ReadFile($outputPath, $fileSize);
            IOHelper::WriteFile($outputPath,"");
        }
        else if(filesize($errorPath) > 0)
        {
            $content = "Compiler Error\n" . IOHelper::ReadFile1($errorPath);
            IOHelper::WriteFile($errorPath,"");
        }
        else $content = "No output";
        return $content;  
    }
?>

<?php 
    $controller = new Controller_Judge();
    $controller->doPost();
?>