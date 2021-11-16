<?php

namespace Glfromd;

require_once('./vendor/autoload.php');

use Glfromd\Storage\SQLiteStorage;
use Glfromd\Validator\Validator;
use Glfromd\UID\UID;
use Glfromd\Label\Label;

class Generator
{

    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Bootstrap and display the label
     *
     * @return void
     */
    public function run(): void
    {
        $db = new SQLiteStorage($this->path);
        $address = $db->readRandomOne();
        $validator = new Validator($address);
        if (!empty($errors = $validator->validate())){
            echo $this->show_errors($errors);
        } else {
            $uid = new UID($address);
            $hash = $uid->generate();
            $label = new Label($address,$hash);
            $label->generate();
        };
    }

    /**
     * Display validation errors
     *
     * @param array
     * @return string
     */
    private function show_errors($errors){
        $str = "<h1> There were validation errors </h1>
        <ul>";
            foreach($errors as $error){
                $str .= "<li>{$error}</li>";
            };
        $str .= "</ul>";

        return $str;
    }
}
