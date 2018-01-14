<?php

declare(strict_types=1);

namespace Meetup\Controller;

use Meetup\Entity\Meetup;
use Meetup\Repository\MeetupRepository;
use Meetup\Form\MeetupForm;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

final class IndexController extends AbstractActionController
{
    /**
     * @var MeetupRepository
     */
    private $meetupRepository;

    /**
     * @var MeetupForm
     */
    private $meetupForm;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(MeetupRepository $meetupRepository, MeetupForm $meetupForm, EntityManager $entityManager)
    {
        $this->meetupRepository = $meetupRepository;
        $this->meetupForm = $meetupForm;
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        return new ViewModel([
            'meetups' => $this->meetupRepository->findAll(),
        ]);
    }

    public function addAction()
    {
        $form = $this->meetupForm;
        /* @var $request Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $meetup = $form->getData();
                if(!$this->checkDate($meetup['dateDebut'], $meetup['dateFin'])){
                    return new ViewModel([
                        'form' => $form,
                        'error_date_logic' => 'Not logical date.'
                    ]);
                }
                $meetup = $this->meetupRepository->createMeetupFromNameAndDescription($meetup['title'], $meetup['description'], $meetup['dateDebut'], $meetup['dateFin']);
                $this->meetupRepository->add($meetup);
                return $this->redirect()->toRoute('meetups');
            }
        }

        $form->prepare();

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', -1);
        $meetup = $this->meetupRepository->findOneBy(array('id' => $id));
        $this->meetupRepository->delete($meetup);
        return $this->redirect()->toRoute('meetups');
    }

    public function updateAction()
    {
        $form = $this->meetupForm;
        $id = $this->params()->fromRoute('id', -1);

        $meetup = $this->meetupRepository->findOneBy(array('id' => $id));

        $form->bind($meetup);

        /* @var $request Request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $meetup->setTitle($data->getTitle());
                $meetup->setDescription($data->getDescription());
                $this->meetupRepository->update($data);
                return $this->redirect()->toRoute('meetups');
            }
        }

        $form->prepare();

        return new ViewModel([
            'form' => $form,
        ]);
    }

    public function checkDate($debut, $fin) {
        if ($fin < $debut) {
            return false;
        }
        return true;
    }
}
