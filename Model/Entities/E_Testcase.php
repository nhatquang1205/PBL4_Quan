<?php
    class Entity_Testcase
    {
        private $id;
        private $input;
        private $output;
        public function __construct($_idprop, $_input, $_output)
        {
            $this->id = $_idprop;
            $this->input = $_input;
            $this->output = $_output;
        }
        public function getId()
        {
            return $this->id;
        }
        public function getInput()
        {
            return $this->input;
        }
        public function getOutput()
        {
            return $this->output;
        }
    }
?>