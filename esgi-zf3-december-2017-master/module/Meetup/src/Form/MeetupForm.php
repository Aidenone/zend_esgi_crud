<?php

declare(strict_types=1);

namespace Meetup\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\StringLength;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Meetup\Entity\Meetup;
use Doctrine\ORM\EntityManager;

class MeetupForm extends Form implements InputFilterProviderInterface
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('meetup');

        $hydrator = new DoctrineHydrator($entityManager, Meetup::class);
        $this->setHydrator($hydrator);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'title',
            'options' => [
                'label' => 'Title : ',
            ],
        ]);

        $this->add([
            'type' => Element\TextArea::class,
            'name' => 'description',
            'options' => [
                'label' => 'Description : ',
            ],
        ]);

        $this->add([
            'type' => Element\Date::class,
            'name' => 'dateDebut',
            'options' => [
                'label' => 'Date de début : ',
            ],
        ]);

        $this->add([
            'type' => Element\Date::class,
            'name' => 'dateFin',
            'options' => [
                'label' => 'Date de fin : ',
            ],
        ]);

        $this->add([
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Submit',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'title' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                            'max' => 18,
                        ],
                    ],
                ],
            ],
            'description' => [
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'min' => 2,
                        ],
                    ],
                ],
            ],
        ];
    }
}
