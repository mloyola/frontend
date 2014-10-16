<?php

namespace Ecoin\FrontendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddCiudad2FieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory,$pais)
    {
        $this->factory = $factory;
        $this->pais = $pais;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }

    private function addCiudadForm($form, $ciudad)
    {
        $pais = $this->pais;
        $form->add('ciudad', 'entity', array(            
            'class'         => 'BackendBundle:Ciudad',  
            'data'          => $ciudad,
            'empty_value'   => 'Ciudad',
            'attr'          => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) use ($pais) {
                $qb = $repository->createQueryBuilder('ciudad')
                ->innerJoin('ciudad.pais', 'pais')
                ->where('ciudad.pais = :pais')
                ->setParameter('pais', $pais);

                return $qb;
            /*    
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
            */    
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
        $this->addCiudadForm($form, $ciudad);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $ciudad = array_key_exists('ciudad', $data) ? $data['ciudad'] : null;
        $this->addCiudadForm($form, $ciudad);
    }
}
