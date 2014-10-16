<?php

namespace Ecoin\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Ecoin\FrontendBundle\Entity\Usuario;
use Ecoin\FrontendBundle\Form\UsuarioType;


/**
 * Lugar controller.
 *
 */
class PlaceController extends Controller
{
    
    public function searchAction(Request $request)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_usuario = $em->getRepository('FrontendBundle:Usuario')->find($id_usuario);                        

        $pais = $entity_usuario->getPais();
        $pais_id = $pais->getId();
        
        $entity_locales = $em->getRepository('FrontendBundle:Local')->find(0);        
        
        $form = $this->createFormBuilder()            
            ->add('categoria', 'entity', array('class'=> 'Ecoin\\BackendBundle\\Entity\\Categoria',
                'query_builder' => function ($repositorio) {return 
                    $repositorio->createQueryBuilder('a')
                    ->orderBy('a.nombre', 'ASC');},'required' => true))            
           ->getForm();

        $form->handleRequest($request);

        if( $id_usuario == $entity_usuario->getId() )        
        {            
            if ($request->getMethod() == 'POST')
            {                
                if ($form->isValid())
                {
                    $datos = $form->getData();
                    $categoria = $datos['categoria'];
                    
                    $entity_locales = $em->getRepository('FrontendBundle:Local')->findByCategoria($pais_id,$categoria);
                    //->findBy(array('comercio.categoria' => $categoria,'comercio.pais' => $pais),array('comercio.nombre' => 'ASC'));        

                   
                }                               
           }
                        
           return $this->render('FrontendBundle:Place:search.html.twig', array(                  
            'entity_locales' => $entity_locales,      
            'entity_usuario' => $entity_usuario,                                                
            'lenguaje' => $locale,
            'form' => $form->createView()            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('usuario_main'));
        }    

    }

}
