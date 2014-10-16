<?php

namespace Ecoin\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Ecoin\FrontendBundle\Entity\Tarjeta;
use Ecoin\FrontendBundle\Form\TarjetaType;

use Ecoin\FrontendBundle\Entity\Usuario;
use Ecoin\FrontendBundle\Form\UsuarioType;


/**
 * Tarjeta controller.
 *
 */
class TarjetaController extends Controller
{

    /**
     * Lists all Tarjeta entities.
     *
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:Usuario')->find($id);

        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Usuario entity.');
        }
       
        $entity_tarjeta = $em->getRepository('FrontendBundle:Tarjeta')->findBy(array('usuario' => $usuario));
        
        return $this->render('FrontendBundle:Tarjeta:index.html.twig', array(      
            'entity_tarjeta' => $entity_tarjeta,
            'entity_usuario' => $entity,                                                
            'lenguaje' => $locale            
        ));
                            
    }

    /**
     * Creates a new Tarjeta entity.
     *
     */
    public function createAction(Request $request)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_usuario = $em->getRepository('FrontendBundle:Usuario')->find($id_usuario);

        $entity = new Tarjeta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUsuario($entity_usuario);
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Haz registrado tu tarjeta satisfactoriamente');                  

            return $this->redirect($this->generateUrl('tarjeta'));            
        }        

        return $this->render('FrontendBundle:Tarjeta:new.html.twig', array(
            'lenguaje' => $locale,
            'entity_usuario'  => $entity_usuario,
            'entity' => $entity,
            'form'   => $form->createView(),
        )); 
    }

    /**
    * Creates a form to create a Tarjeta entity.
    *
    * @param Tarjeta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Tarjeta $entity)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_usuario = $em->getRepository('FrontendBundle:Usuario')->find($id_usuario);
        $pais_id = $entity_usuario->getPais()->getId();

        $form = $this->createForm(new TarjetaType($pais_id), $entity, array(
            'action' => $this->generateUrl('tarjeta_create'),
            'method' => 'POST',
        ));        

        return $form;
    }

    /**
     * Displays a form to create a new Tarjeta entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_usuario = $em->getRepository('FrontendBundle:Usuario')->find($id_usuario);

        $entity = new Tarjeta();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontendBundle:Tarjeta:new.html.twig', array('lenguaje' => $locale,
            'entity_usuario'  => $entity_usuario,
            'entity' => $entity,
            'form'   => $form->createView(),));        
    }

    /**
     * Finds and displays a Tarjeta entity.
     *
     */
    public function showAction($id)
    {        
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_tarjeta = $em->getRepository('FrontendBundle:Tarjeta')->find($id);

        if (!$entity_tarjeta) {
           throw $this->createNotFoundException('Unable to find Tarjeta entity.');
        }    

        $entity_usuario = $em->getRepository('FrontendBundle:Usuario')->find($id_usuario);        
       
        if( $id_usuario == $entity_tarjeta->getUsuario()->getId() )
        {
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('FrontendBundle:Tarjeta:show.html.twig', array(      
            'entity_tarjeta' => $entity_tarjeta,
            'entity_usuario' => $entity_usuario,   
            'delete_form' => $deleteForm->createView(),                                                                                         
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('tarjeta'));
        }                    
    }

    /**
     * Displays a form to edit an existing Tarjeta entity.
     *
     */
    public function editAction($id)
    {        
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_tarjeta = $em->getRepository('FrontendBundle:Tarjeta')->find($id);

        if (!$entity_tarjeta) {
           throw $this->createNotFoundException('Unable to find Tarjeta entity.');
        }
        
        $entity_usuario = $em->getRepository('FrontendBundle:Usuario')->find($id_usuario);        

        if( $id_usuario == $entity_tarjeta->getUsuario()->getId() )
        {
            $editForm = $this->createEditForm($entity_tarjeta);
            $deleteForm = $this->createDeleteForm($id);
            
            return $this->render('FrontendBundle:Tarjeta:edit.html.twig', array(      
            'entity_tarjeta' => $entity_tarjeta,
            'entity_usuario' => $entity_usuario,    
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),                                            
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('tarjeta'));
        } 
        
    }

    /**
    * Creates a form to edit a Tarjeta entity.
    *
    * @param Tarjeta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tarjeta $entity)
    {   
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_usuario = $em->getRepository('FrontendBundle:Usuario')->find($id_usuario);
        $pais_id = $entity_usuario->getPais()->getId();

        $form = $this->createForm(new TarjetaType($pais_id), $entity, array(
            'action' => $this->generateUrl('tarjeta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        
        return $form;
    }
    /**
     * Edits an existing Tarjeta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Tarjeta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarjeta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Los datos se han guardado satisfactoriamente');             
            return $this->redirect($this->generateUrl('tarjeta_edit', array('id' => $id)));
        }

        return $this->render('FrontendBundle:Tarjeta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Tarjeta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Tarjeta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tarjeta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('info','El registro ha sido eliminado satisfactoriamente');        
        return $this->redirect($this->generateUrl('tarjeta'));
    }

    /**
     * Creates a form to delete a Tarjeta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tarjeta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
