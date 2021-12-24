<?php
    class Entity_State
    {
        private $id;
        private $username;
        private $state;
        public function __construct($_id, $_username, $_state)
        {
            $this->id = $_id;
            $this->name = $_username;
            $this->state = $_state;
        }
        public function getId()
        {
            return $this->id;
        }
        public function getUsername()
        {
            return $this->username;
        }
        public function getState()
        {
            return $this->state;
        }
    }
?>