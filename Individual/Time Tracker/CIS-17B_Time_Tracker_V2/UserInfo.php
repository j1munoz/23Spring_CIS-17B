<?php
// Create the User Object
class User {
    // Properties
    public $username;
    public $hours;
    public $minutes;
    public $seconds;
    
    // Methods
    // Set Methods
    function setUsername($username) {$this->username = $username;}
    function setHours($hours) {$this->hours = $hours;}
    function setMinutes($minutes) {$this->minutes = $minutes;}
    function setSeconds($seconds) {$this->seconds = $seconds;}
    
    // Get Methods
    function getUsername() {return $this->username;}
    function getHours() {return $this->hours;}
    function getMinutes() {return $this->minutes;}
    function getSeconds() {return $this->seconds;}
    
}
