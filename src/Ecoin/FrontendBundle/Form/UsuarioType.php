<?php

namespace Ecoin\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ecoin\FrontendBundle\Form\EventListener\AddCiudadFieldSubscriber;
use Ecoin\FrontendBundle\Form\EventListener\AddPaisFieldSubscriber;

use Ecoin\FrontendBundle\Form\EventListener\AddDistritoFieldSubscriber;

class UsuarioType extends AbstractType
{
     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $factory = $builder->getFormFactory();
        $paisSubscriber = new AddPaisFieldSubscriber($factory);        
        $ciudadSubscriber = new AddCiudadFieldSubscriber($factory);        

        $builder
            ->addEventSubscriber($paisSubscriber)
            ->addEventSubscriber($ciudadSubscriber)
            ->add('nombre','text', array('max_length' => '20'))
            ->add('apellido','text',array('max_length' => '20'))                        
            ->add('fchNac', 'birthday', array( 'label' => 'Date of Birth', 'years' => range(date('Y')-90, date('Y')), 'format' => 'yyyy-MM-dd'))            
            ->add('marketing', 'checkbox', array('required' => false))            
            ->add('sexo')    
            //->add('distrito')         
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
            $distritoSubscriber = new AddDistritoFieldSubscriber($factory);        

            $builder            
            ->addEventSubscriber($distritoSubscriber)
            ->add('tipodoc')  
            ->add('numdoc','text',array('max_length' => '10'))      
            ;      
        }    
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecoin\FrontendBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        //return 'Ecoin_frontendbundle_usuario';
        return 'usuario';
    }
}
