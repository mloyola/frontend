<?php

namespace Ecoin\FrontendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use Ecoin\BackendBundle\Entity\Ciudad;

class AddDistrito2FieldSubscriber implements EventSubscriberInterface
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

    private function addDistritoForm($form, $distrito, $ciudad)
    {
        $form->add('distrito','entity', array(            
            'class'         => 'BackendBundle:Distrito',
            'empty_value'   => 'Distrito',
            'data'          => $distrito,
            'attr'          => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) use ($ciudad) {
                $qb = $repository->createQueryBuilder('distrito')
                    ->innerJoin('distrito.ciudad', 'ciudad');
                if ($ciudad instanceof ciudad) {
                    $qb->where('distrito.ciudad = :ciudad')
                    ->setParameter('ciudad', $ciudad->getId());
                } elseif (is_numeric($ciudad)) {
                    $qb->where('ciudad.id = :ciudad')
                    ->setParameter('ciudad', $ciudad);
                } else {
                    $qb->where('ciudad.nombre = :ciudad')->setParameter('ciudad', null);
                }

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
        $ciudad = ($distrito) ? $distrito->getCiudad() : null ;
        $this->addDistritoForm($form, $distrito, $ciudad);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $ciudad = array_key_exists('ciudad', $data) ? $data['ciudad'] : null;
        $distrito = array_key_exists('distrito', $data) ? $data['distrito'] : null;        

        $this->addDistritoForm($form, $distrito, $ciudad);
    }

}
