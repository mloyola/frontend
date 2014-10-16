<?php

namespace Ecoin\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComerciohorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder
            ->add('descripcion')
            ->add('apertura','time')
            ->add('cierre','time')
            //->add('dias') 
            ->add( 'dias', 'entity', array('expanded'=>true, 'multiple'=>true,'class' => 'Ecoin\BackendBundle\Entity\Diasatencion'))           
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecoin\FrontendBundle\Entity\Comerciohor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Ecoin_frontendbundle_comerciohor';
    }
}

