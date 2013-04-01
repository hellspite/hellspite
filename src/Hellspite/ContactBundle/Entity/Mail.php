<?php

namespace Hellspite\ContactBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Mail{
    /**
     *
     * @Assert\NotBlank()
     *
     */
    private $name;

    /**
     *
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * ) 
     */
    private $email;

    /**
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="4",
     *     minMessage="Your name must have at least {{ limit }} characters."
     * )
     */
    private $text;

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getText(){
        return $this->text;
    }

    public function setText($text){
        $this->text = $text;
    }
}
