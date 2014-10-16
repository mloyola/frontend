<?php

namespace Ecoin\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecoin\FrontendBundle\Entity\Comerciocta;
use Ecoin\FrontendBundle\Form\ComercioctaType;

/**
 * Comerciocta controller.
 *
 */
class ComercioctaController extends Controller
{

    /**
     * Lists all Comerciocta entities.
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
       
        $entity_comerciocta = $em->getRepository('FrontendBundle:Comerciocta')->findBy(array('comercio' => $usuario));
        
        return $this->render('FrontendBundle:Comerciocta:index.html.twig', array(      
            'entity_comerciocta' => $entity_comerciocta,
            'entity_comercio' => $entity,                                                
            'lenguaje' => $locale            
        ));
    }
    /**
     * Creates a new Comerciocta entity.
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

        $entity = new Comerciocta();
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

            return $this->redirect($this->generateUrl('comerciocta'));            
        }        

        return $this->render('FrontendBundle:Comerciocta:new.html.twig', array(
            'lenguaje' => $locale,
            'entity_comercio'  => $entity_comercio,
            'entity' => $entity,
            'form'   => $form->createView(),
        )); 
    }

    /**
    * Creates a form to create a Comerciocta entity.
    *
    * @param Comerciocta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Comerciocta $entity)
    {   
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);
        $pais_id = $entity_comercio->getPais()->getId();

        $form = $this->createForm(new ComercioctaType($pais_id ), $entity, array(
            'action' => $this->generateUrl('comerciocta_create'),
            'method' => 'POST',
        ));        

        return $form;
    }

    /**
     * Displays a form to create a new Comerciocta entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:comercio')->find($id_usuario);

        $entity = new Comerciocta();
        $form   = $this->createCreateForm($entity);

        return $this->render('FrontendBundle:Comerciocta:new.html.twig', array('lenguaje' => $locale,
            'entity_comercio'  => $entity_comercio,
            'entity' => $entity,
            'form'   => $form->createView(),));  
    }

    /**
     * Finds and displays a Comerciocta entity.
     *
     */
    public function showAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comerciocta = $em->getRepository('FrontendBundle:Comerciocta')->find($id);

        if (!$entity_comerciocta) {
           throw $this->createNotFoundException('Unable to find Comerciocta entity.');
        }    

        $entity_comercio = $em->getRepository('FrontendBundle:comercio')->find($id_usuario);        
       
        if( $id_usuario == $entity_comerciocta->getComercio()->getId() )
        {
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('FrontendBundle:comerciocta:show.html.twig', array(      
            'entity_comerciocta' => $entity_comerciocta,
            'entity_comercio' => $entity_comercio,   
            'delete_form' => $deleteForm->createView(),                                                                                         
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('comerciocta'));
        } 
    }

    /**
     * Displays a form to edit an existing Comerciocta entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comerciocta = $em->getRepository('FrontendBundle:Comerciocta')->find($id);

        if (!$entity_comerciocta) {
           throw $this->createNotFoundException('Unable to find Comerciocta entity.');
        }
        
        $entity_comercio = $em->getRepository('FrontendBundle:comercio')->find($id_usuario);        

        if( $id_usuario == $entity_comerciocta->getComercio()->getId() )
        {
            $editForm = $this->createEditForm($entity_comerciocta);
            $deleteForm = $this->createDeleteForm($id);
            
            return $this->render('FrontendBundle:comerciocta:edit.html.twig', array(      
            'entity_comerciocta' => $entity_comerciocta,
            'entity_comercio' => $entity_comercio,    
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),                                            
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('comerciocta'));
        }
    }

    /**
    * Creates a form to edit a Comerciocta entity.
    *
    * @param Comerciocta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comerciocta $entity)
    {   
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);
        $pais_id = $entity_comercio->getPais()->getId();
        
        $form = $this->createForm(new ComercioctaType($pais_id), $entity, array(
            'action' => $this->generateUrl('comerciocta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));        

        return $form;
    }
    /**
     * Edits an existing Comerciocta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Comerciocta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comerciocta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setFchUpdate(new \DateTime('now'));
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Los datos se han guardado satisfactoriamente');             
            return $this->redirect($this->generateUrl('comerciocta_edit', array('id' => $id)));
        }

        return $this->render('FrontendBundle:Comerciocta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Comerciocta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Comerciocta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comerciocta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('info','El registro ha sido eliminado satisfactoriamente');        
        return $this->redirect($this->generateUrl('comerciocta'));
    }

    /**
     * Creates a form to delete a Comerciocta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comerciocta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
