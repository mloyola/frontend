<?php

namespace Ecoin\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ecoin\FrontendBundle\Form\EventListener\AddCiudad2FieldSubscriber;
use Ecoin\FrontendBundle\Form\EventListener\AddDistrito2FieldSubscriber;

class LocalType extends AbstractType
{
    public function __construct($pais,$categoria,$comercio)
    {
        $this->pais = $pais;                
        $this->categoria = $categoria;
        $this->comercio = $comercio;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {             
        $pais = $this->pais;        
        $categoria = $this->categoria;
        $comercio = $this->comercio;        

        $factory = $builder->getFormFactory();                
        $ciudadSubscriber = new AddCiudad2FieldSubscriber($factory,$pais);        
        $distritoSubscriber = new AddDistrito2FieldSubscriber($factory);        

        $builder                        
            ->addEventSubscriber($ciudadSubscriber)                        
            ->addEventSubscriber($distritoSubscriber)
            ->add('imagen','file')
            ->add('descripcion')
            ->add('telefono','text',array('max_length' => '20','required' => false))
            ->add('email','email',array('max_length' => '100','required' => false))            
            ->add('nombrevia')
            ->add('numero')
            ->add('numinterior','text',array('max_length' => '6','required' => false))
            ->add('referencia','text',array('max_length' => '100','required' => false))                        
            ->add( 'via', 'entity', array('class' => 'Ecoin\BackendBundle\Entity\Via',
                'query_builder' => function($er) {
                return $er->createQueryBuilder('w')
                  ->orderBy('w.descripcion', 'ASC');}))
            ->add( 'interior', 'entity', array('class' => 'Ecoin\BackendBundle\Entity\Interior',
                'query_builder' => function($er) {
                return $er->createQueryBuilder('w')
                  ->orderBy('w.descripcion', 'ASC');}))            
            ->add( 'horarios', 'entity', array('expanded'=>true, 'multiple'=>true,'class' => 'Ecoin\FrontendBundle\Entity\Comerciohor',
                'query_builder' => function($er) use ( $comercio) {
                return $er->createQueryBuilder('a')                     
                  ->join('a.comercio','b')                  
                  ->orderBy('a.descripcion', 'ASC')
                  ->where('b.id = ?1')                  
                  ->setParameter(1, $comercio);}))              
            ->add( 'subcategorias', 'entity', array('expanded'=>true, 'multiple'=>true,'class' => 'Ecoin\BackendBundle\Entity\Subcategoria',
                'query_builder' => function($er) use ( $categoria) {
                return $er->createQueryBuilder('a')                     
                  ->join('a.categoria','b')                  
                  ->orderBy('b.nombre', 'ASC')
                  ->where('b.id = ?1')                  
                  ->setParameter(1, $categoria);}))  
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ecoin\FrontendBundle\Entity\Local'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        #return 'Ecoin_frontendbundle_local';
        return 'local';

    }
}
