<?php

namespace CleanPhp\Invoicer\Domain\Entity;

class AbstractEntity
{
    protected $id;

    /**
     * Get Id of this instance
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set Id for this instance
     * @param [type] $id [description]
     * @return  AbstractEntity self
     */
    public function setId($id)
    {
        $this->id = id;
        return $this;
    }
}
