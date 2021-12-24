<?php
    class Entity_Problem
    {
        private $id;
        private $name;
        private $description;
        private $inputDescription;
        private $outputDescription;
        public function __construct($_idprop, $_nameprop, $_description, $_inputDescription, $_outputDescription)
        {
            $this->id = $_idprop;
            $this->name = $_nameprop;
            $this->description = $_description;
            $this->inputDescription = $_inputDescription;
            $this->outputDescription = $_outputDescription;
        }
        public function getId()
        {
            return $this->id;
        }
        public function getName()
        {
            return $this->name;
        }
        public function getDescription()
        {
            return $this->description;
        }
        public function getInputDescription()
        {
            return $this->inputDescription;
        }
        public function getOutputDescription()
        {
            return $this->outputDescription;
        }
    }
?>