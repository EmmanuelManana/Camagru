<?php

    class Validator
    {
        private $data;
        private $errors = [];

        public function __construct($data)
        {
            $this->data = $data;
        }
        public function getField($field)
        {
            if (!isset($this->data[$data]))
            {
                return null;
            }
            return $this->data[$field];
        } 

        public function isAlpha($field, $errorMsg = '')
        {
            if (!preg_match('/^[a-zA-Z0-9_-]+$/', $this->getField($field)))
            {
                $this->errors[$field] = $errorMsg;
            }
        }

        public function isUniq($field, $db, $table, $errorMsg = '')
        {
            $record = $db->query("SELECT id FROM $table WHERE $field = ?",[$this->getField($field-
            )])->fetch();
            if ($record)
            {
                $this->erros[$field] = $errorMsg;
            }
        }


    }
?>