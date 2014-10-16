<?php

namespace Ecoin\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecoin\FrontendBundle\Entity\Comerciohor;
use Ecoin\FrontendBundle\Form\ComerciohorType;

/**
 * comerciohor controller.
 *
 */
class ComerciohorController extends Controller
{

    /**
     * Lists all comerciohor entities.
     *
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Comercio entity.');
        }
       
        $entity_comerciohor = $em->getRepository('FrontendBundle:Comerciohor')->findBy(array('comercio' => $usuario));
        
        return $this->render('FrontendBundle:Comerciohor:index.html.twig', array(      
            'entity_comerciohor' => $entity_comerciohor,
            'entity_comercio' => $entity,                                                
            'lenguaje' => $locale            
        ));
    }
    /**
     * Creates a new comerciohor entity.
     *
     */
    public function createAction(Request $request)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);

        $entity = new comerciohor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setComercio($entity_comercio);
            $entity->setFchCreate(new \DateTime('now'));
            $entity->setFchUpdate(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Haz registrado tu cuenta satisfactoriamente');                  

            return $this->redirect($this->generateUrl('comerciohor'));            
        }        

        return $this->render('FrontendBundle:Comerciohor:new.html.twig', array(
            'lenguaje' => $locale,
            'entity_comercio'  => $entity_comercio,
            'entity' => $entity,
            'form'   => $form->createView(),
        )); 
    }

    /**
    * Creates a form to create a comerciohor entity.
    *
    * @param comerciohor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(comerciohor $entity)
    {           
        $form = $this->createForm(new comerciohorType(), $entity, array(
            'action' => $this->generateUrl('comerciohor_create'),
            'method' => 'POST',
        ));        

        return $form;
    }

    /**
     * Displays a form to create a new comerciohor entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);

        $entity = new comerciohor();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontendBundle:Comerciohor:new.html.twig', array('lenguaje' => $locale,
            'entity_comercio'  => $entity_comercio,
            'entity' => $entity,
            'form'   => $form->createView(),));  
    }

    /**
     * Finds and displays a comerciohor entity.
     *
     */
    public function showAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comerciohor = $em->getRepository('FrontendBundle:Comerciohor')->find($id);

        if (!$entity_comerciohor) {
           throw $this->createNotFoundException('Unable to find Comerciohor entity.');
        }    

        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);        
       
        if( $id_usuario == $entity_comerciohor->getComercio()->getId() )
        {
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('FrontendBundle:Comerciohor:show.html.twig', array(      
            'entity_comerciohor' => $entity_comerciohor,
            'entity_comercio' => $entity_comercio,   
            'delete_form' => $deleteForm->createView(),                                                                                         
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('comerciohor'));
        } 
    }

    /**
     * Displays a form to edit an existing comerciohor entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comerciohor = $em->getRepository('FrontendBundle:Comerciohor')->find($id);

        if (!$entity_comerciohor) {
           throw $this->createNotFoundException('Unable to find Comerciohor entity.');
        }
        
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);        

        if( $id_usuario == $entity_comerciohor->getComercio()->getId() )
        {
            $editForm = $this->createEditForm($entity_comerciohor);
            $deleteForm = $this->createDeleteForm($id);
            
            return $this->render('FrontendBundle:Comerciohor:edit.html.twig', array(      
            'entity_comerciohor' => $entity_comerciohor,
            'entity_comercio' => $entity_comercio,    
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),                                            
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('comerciohor'));
        }
    }

    /**
    * Creates a form to edit a comerciohor entity.
    *
    * @param comerciohor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(comerciohor $entity)
    {                   
        $form = $this->createForm(new comerciohorType(), $entity, array(
            'action' => $this->generateUrl('comerciohor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));        

        return $form;
    }
    /**
     * Edits an existing comerciohor entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Comerciohor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comerciohor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setFchUpdate(new \DateTime('now'));
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Los datos se han guardado satisfactoriamente');             
            return $this->redirect($this->generateUrl('comerciohor_edit', array('id' => $id)));
        }

        return $this->render('FrontendBundle:comerciohor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a comerciohor entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Comerciohor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comerciohor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('info','El registro ha sido eliminado satisfactoriamente');        
        return $this->redirect($this->generateUrl('comerciohor'));
    }

    /**
     * Creates a form to delete a comerciohor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comerciohor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
