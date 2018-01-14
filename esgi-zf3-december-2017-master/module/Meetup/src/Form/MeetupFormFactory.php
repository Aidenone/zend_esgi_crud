<?php

declare(strict_types=1);

namespace Meetup\Form;

use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

final class MeetupFormFactory
{
    public function __invoke(ContainerInterface $container) : MeetupForm
    {
        $entityManager = $container->get(EntityManager::class);

        return new MeetupForm($entityManager);
    }
}
