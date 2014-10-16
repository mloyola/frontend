<?php

namespace Ecoin\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComercioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                        
            ->add('nombre','text', array('max_length' => '100'))
            ->add('razonsocial','text',array('max_length' => '100'))            
            ->add('categoria')
            ->add('pais')            
            ->add('marketing', 'checkbox', array('required' => false))            
        ;

        if (null == $options['data']->getId()) 
        {
             $builder
             ->add('usuario', 'repeated', array('first_name' => 'email','second_name' => 'confirm', 'type' => 'email',
                'invalid_message' => 'Las cuentas de correo electrónico deben de coincidir',
                'options' => array('label' => 'Email','required' => true,'max_length' => '100')))
            ->add('password', 'password',array('required' => true, 'max_length' => '10')) 
            ;            
        }
        else if($options['data']->getId() > 0)
        {   
            $builder
            //->add('ruc','text', array('required' => true,'max_length' => '20'))
            ->add('contacto','text', array('required' => true,'max_length' => '50'))
            ->add('telefono','text', array('required' => false,'max_length' => '20'))
            ->add('movil','text', array('required' => false,'max_length' => '20'))
            ;      
        }    
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecoin\FrontendBundle\Entity\Comercio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Ecoin_frontendbundle_comercio';
    }
}
