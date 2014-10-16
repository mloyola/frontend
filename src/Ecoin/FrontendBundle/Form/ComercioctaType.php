<?php

namespace Ecoin\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComercioctaType extends AbstractType
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
            ->add( 'banco', 'entity', array('class' => 'Ecoin\BackendBundle\Entity\Banco',
                'query_builder' => function($er) use ( $pais_id ) {
                return $er->createQueryBuilder('w')                                    
                  ->join('w.pais','d')
                  ->orderBy('w.descripcion', 'ASC')
                  ->where('d.id = ?1')                  
                  ->setParameter(1, $pais_id);}))
            ->add('tipocta')            
            ->add( 'moneda', 'entity', array('class' => 'Ecoin\BackendBundle\Entity\Moneda',
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
            'data_class' => 'Ecoin\FrontendBundle\Entity\Comerciocta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Ecoin_frontendbundle_comerciocta';
    }
}
