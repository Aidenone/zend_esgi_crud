<?php

declare(strict_types=1);

namespace Meetup\Repository;

use Meetup\Entity\Meetup;
use Doctrine\ORM\EntityRepository;

final class MeetupRepository extends EntityRepository
{

    public function add($meetup) : void
    {
        $this->getEntityManager()->persist($meetup);
        $this->getEntityManager()->flush($meetup);
    }

    public function update($meetup) : void
    {
        $this->getEntityManager()->persist($meetup);
        $this->getEntityManager()->flush($meetup);
    }

    public function delete($meetup) : void
    {
        $this->getEntityManager()->remove($meetup);
        $this->getEntityManager()->flush($meetup);
    }

    public function createMeetupFromNameAndDescription(string $name, string $description, string $dateDebut, string $dateFin)
    {
        return new Meetup($name, $description, $dateDebut, $dateFin);
    }

    public function updateMeetup(string $name, string $description)
    {
        return new Meetup($name, $description);
    }
}
