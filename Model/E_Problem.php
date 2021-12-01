<?php
    class Entity_Problem
    {
        private $ID_Prob;
        private $Name_Prob;
        private $Description;
        private $InputDescription;
        private $OutputDescription;
        public function __construct($_idprop, $_nameprop, $_description, $_inputDescription, $_outputDescription)
        {
            $this->ID_Prob = $_idprop;
            $this->Name_Prob = $_nameprop;
            $this->Description = $_description;
            $this->InputDescription = $_inputDescription;
            $this->OutputDescription = $_outputDescription;
        }
        public function getID_Prob()
        {
            return $this->ID_Prob;
        }
        public function getName_Prob()
        {
            return $this->Name_Prob;
        }
        public function getDescription()
        {
            return $this->Description;
        }
        public function getInputDescription()
        {
            return $this->InputDescription;
        }
        public function getOutputDescription()
        {
            return $this->OutputDescription;
        }
    }
?>