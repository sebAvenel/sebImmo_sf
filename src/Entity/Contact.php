<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * Assert\NotBlank
     * @Assert\Length(min = 2, max = 50)
     * @var string|null
     */
    private $firstname;

    /**
     * Assert\NotBlank
     * @Assert\Length(min = 2, max = 50)
     * @var string|null
     */
    private $lastName;

    /**
     * @Assert\Regex("/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/")
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @Assert\Email(message = "L'email '{{ value }}' n'est pas valide.")
     * @Assert\Length(min = 2, max = 100)
     * @var string|null
     */
    private $email;

    /**
     * Assert\NotBlank
     * Assert\length(min=10)
     * @var string|null
     */
    private $message;

    /**
     * @var Property|null
     */
    private $property;

    /**
     * Get assert\NotBlank
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set assert\NotBlank
     */
    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get assert\NotBlank
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set assert\NotBlank
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get assert\length(min=10)
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set assert\length(min=10)
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of property
     */
    public function getProperty(): ?Property
    {
        return $this->property;
    }

    /**
     * Set the value of property
     */
    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }
}
