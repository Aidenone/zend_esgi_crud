<?php

declare(strict_types=1);

namespace Meetup\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Meetup
 *
 * Attention : Doctrine génère des classes proxy qui étendent les entités, celles-ci ne peuvent donc pas être finales !
 *
 * @package Application\Entity
 * @ORM\Entity(repositoryClass="\Meetup\Repository\MeetupRepository")
 * @ORM\Table(name="meetups")
 */
class Meetup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=36)
     * @ORM\GeneratedValue(strategy="AUTO")
     **/
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2000, nullable=false)
     */
    private $description = '';

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateDebut = '';

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateFin = '';

    public function __construct(string $title, string $description = '', string $dateDebut, string $dateFin)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->title = $title;
        $this->description = $description;
        $this->dateDebut = new \DateTime($dateDebut);
        $this->dateFin = new \DateTime($dateFin);
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title) : void
    {
       $this->title = $title;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut() : \DateTime
    {
        return $this->dateDebut;
    }
    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut(\DateTime $dateDebut) : void
    {
        $this->dateDebut = $dateDebut;
    }
    /**
     * @return \DateTime
     */
    public function getDateFin() : \DateTime
    {
        return $this->dateFin;
    }
    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin(\DateTime $dateFin) : void
    {
        $this->dateFin = $dateFin;
    }
}
