<?php

namespace Ecoin\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TarjetaType extends AbstractType
{
    public function __construct($pais_id)
    {
        $this->pais_id = $pais_id;        
    }

        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $pais_id = $this->pais_id;  
        
        $builder
            ->add('numero')            
            ->add('expdate', 'date', array( 'format' => 'dd-MM-yyyy'))            
            ->add('securitycode')
            ->add('holdername')            
            //->add('producto')
            ->add( 'producto', 'entity', array('class' => 'Ecoin\BackendBundle\Entity\Producto',
                'query_builder' => function($er) use ( $pais_id ) {
                return $er->createQueryBuilder('w')                                    
                  ->join('w.paises','d')
                  ->orderBy('w.descripcion', 'ASC')
                  ->where('d.id = ?1')                  
                  ->setParameter(1, $pais_id);}))              
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecoin\FrontendBundle\Entity\Tarjeta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Ecoin_frontendbundle_tarjeta';
    }
}
