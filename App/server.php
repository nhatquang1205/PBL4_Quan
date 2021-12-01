<?php include_once 'Extension/IOHelper.php';?>

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
    function ReadInput($inputPath){
        if(filesize($inputPath) > 0)
        {
            $input = IOHelper::ReadFile($inputPath);
            return $input;
        }
        else return " ";
    }
    function ReadOutput($outputPath, $errorPath){
        if (filesize($outputPath) > 0)
        {   
            $content = IOHelper::ReadFile($outputPath);
            IOHelper::WriteFile($outputPath,"");
        }
        else if(filesize($errorPath) > 0)
        {
            $content = "Compiler Error \n" . IOHelper::ReadFile($errorPath);
            IOHelper::WriteFile($errorPath,"");
        }
        else $content = "No output";
        return $content;  
    }
?>
<?php

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $fileName = $_GET['fileName'];
        $language = strtolower(($_GET['language']));

        $data = array();

        $inputPath = "IO/Input/" . $fileName. ".txt";
        
        $data['input'] = ReadInput($inputPath);
        
        $filePath = "Code/" .$language. "/" . $fileName . "." . $language;
        
        $data['code'] = IOHelper::ReadFile($filePath);

        ExecuteCode($filePath, $language, $fileName);

        $outputPath = __DIR__."\IO\output.txt";
        $errorPath = __DIR__."\IO\\error.txt";
        
        $data['output'] = ReadOutput($outputPath,$errorPath);
        
        $exeFilePath = "Code/". $fileName . ".exe";
        IOHelper::DeleteFile($exeFilePath);

        echo json_encode($data);
    }
    else
    {
        $language = strtolower($_POST['language']);
        $code = $_POST['code'];
        $inputCode = $_POST['inputCode'];
        $method = $_POST['method'];

        $random = substr(md5(mt_rand()), 0, 7);

        $filePath = "Code/" .$language. "/" . $random . "." . $language;
        $inputPath = "IO/Input/" . $random. ".txt";

        IOHelper::WriteFile($filePath,$code);
        IOHelper::WriteFile($inputPath,$inputCode);

        $data = array();
        ExecuteCode($filePath,$language,$random);

        $outputPath = __DIR__."\IO\output.txt";
        $errorPath = __DIR__."\IO\\error.txt";

        $data['output'] = ReadOutput($outputPath,$errorPath);

        $exeFilePath = "Code/". $random . ".exe";
        IOHelper::DeleteFile($exeFilePath);

        if ($method == "share")
        {
            $host= gethostname();
            $ip = gethostbyname($host);
    
            $data['IP'] = $ip;

            $data['fileName'] = $random;
            $data['language'] = $language;
        }

        echo json_encode($data);
    }
?>