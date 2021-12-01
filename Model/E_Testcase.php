<?php
    class Entity_Testcase
    {
        private $ID_Prob;
        private $Input;
        private $Output;
        private function __construct($_idprop, $_input, $_output)
        {
            $this->ID_Prob = $_idprop;
            $this->Input = $_input;
            $this->Output = $_output;
        }
        public function getID_Prob()
        {
            return $this->ID_Prob;
        }
        public function getInput()
        {
            return $this->Input;
        }
        public function getOutput()
        {
            return $this->Output;
        }
    }
?>