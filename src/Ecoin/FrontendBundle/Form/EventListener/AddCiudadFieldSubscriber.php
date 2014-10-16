<?php

namespace Ecoin\FrontendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use Ecoin\BackendBundle\Entity\Pais;

class AddCiudadFieldSubscriber implements EventSubscriberInterface
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

    private function addCiudadForm($form, $ciudad, $pais)
    {
        $form->add('ciudad','entity', array(            
            'class'         => 'BackendBundle:Ciudad',
            'empty_value'   => 'Ciudad',
            'data'          => $ciudad,
            'attr'          => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) use ($pais) {
                $qb = $repository->createQueryBuilder('ciudad')
                    ->innerJoin('ciudad.pais', 'pais');
                if ($pais instanceof pais) {
                    $qb->where('ciudad.pais = :pais')
                    ->setParameter('pais', $pais->getId());
                } elseif (is_numeric($pais)) {
                    $qb->where('pais.id = :pais')
                    ->setParameter('pais', $pais);
                } else {
                    $qb->where('pais.nombre = :pais')->setParameter('pais', null);
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

        $ciudad = $accessor->getValue($data, 'ciudad');
        $pais = ($ciudad) ? $ciudad->getpais() : null ;
        $this->addCiudadForm($form, $ciudad, $pais);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $pais = array_key_exists('pais', $data) ? $data['pais'] : null;
        $ciudad = array_key_exists('ciudad', $data) ? $data['ciudad'] : null;

        $distrito = array_key_exists('distrito', $data) ? $data['distrito'] : null;

        $this->addCiudadForm($form, $ciudad, $pais);
    }

}
