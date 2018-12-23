<?php

namespace CleanPhp\Invoicer\Domain\Entity;

class Customer extends AbstractEntity
{
    protected $name;
    protected $email;

    /**
     * Get name of current instance
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name of current instance
     * @param string $name name for current customer
     * @return Customer self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get email of current instance
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email for current instance
     * @param string $email email for current instance
     * @return Customer self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
