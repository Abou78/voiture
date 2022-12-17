<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class RechercheVoiture{
    /**
     * @Assert\LessThanOrEqual(propertyPath="maxAnnee", message="doit être plus petit que l'année max" )
     */
    private $minAnnee;

    /**
     * @Assert\GreaterThanOrEqual(propertyPath="minAnnee", message="doit être plus grand que l'année min" )
     */
    private $maxAnnee;

    /**
     * @return mixed
     */
    public function getMinAnnee()
    {
        return $this->minAnnee;
    }

    /**
     * @param mixed $minAnnee
     * @return RechercheVoiture
     */
    public function setMinAnnee($minAnnee)
    {
        $this->minAnnee = $minAnnee;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxAnnee()
    {
        return $this->maxAnnee;
    }

    /**
     * @param mixed $maxAnnee
     * @return RechercheVoiture
     */
    public function setMaxAnnee($maxAnnee)
    {
        $this->maxAnnee = $maxAnnee;
        return $this;
    }


}
