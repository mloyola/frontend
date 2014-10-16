<?php

namespace Ecoin\FrontendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddPaisFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }

    private function addPaisForm($form, $pais)
    {
        $form->add('pais', 'entity', array(            
            'class'         => 'BackendBundle:Pais',  
            'data'          => $pais,
            'empty_value'   => 'País',
            'attr'          => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('pais');

                return $qb;
            }
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $distrito = $accessor->getValue($data, 'distrito');

        $ciudad = $accessor->getValue($data, 'ciudad');
        $pais = ($ciudad) ? $ciudad->getPais() : null ;
        $this->addPaisForm($form, $pais);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $pais = array_key_exists('pais', $data) ? $data['pais'] : null;
        $this->addPaisForm($form, $pais);
    }
}
