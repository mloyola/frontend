<?php

namespace Ecoin\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecoin\FrontendBundle\Entity\Local;
use Ecoin\FrontendBundle\Form\LocalType;

/**
 * Local controller.
 *
 */
class LocalController extends Controller
{

    /**
     * Lists all Local entities.
     *
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $locale = $request->getlocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Comercio entity.');
        }
        
        $entity_local = $em->getRepository('FrontendBundle:Local')->findBy(array('comercio' => $usuario));
        
        return $this->render('FrontendBundle:Local:index.html.twig', array(      
            'entity_local' => $entity_local,
            'entity_comercio' => $entity,                                                            
            'lenguaje' => $locale            
        ));
    }
    /**
     * Creates a new Local entity.
     *
     */
    public function createAction(Request $request)
    {
        $request = $this->getRequest();        
        $locale = $request->getlocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);

        $entity = new Local();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setComercio($entity_comercio);
            $entity->setFchCreate(new \DateTime('now'));
            $entity->setFchUpdate(new \DateTime('now'));
            $entity->UploadImage();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Haz registrado tu cuenta satisfactoriamente');                  

            return $this->redirect($this->generateUrl('local'));            
        }        

        return $this->render('FrontendBundle:Local:new.html.twig', array(
            'lenguaje' => $locale,
            'entity_comercio'  => $entity_comercio,
            'entity' => $entity,
            'form'   => $form->createView(),
        )); 
    }

    /**
    * Creates a form to create a Local entity.
    *
    * @param Local $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Local $entity)
    {        
        $request = $this->getRequest();        
        $locale = $request->getlocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);        
        $pais = $entity_comercio->getPais();
        $categoria = $entity_comercio->getCategoria();
        $comercio = $entity_comercio;

        $form = $this->createForm(new LocalType($pais,$categoria,$comercio), $entity, array(
            'action' => $this->generateUrl('local_create'),
            'method' => 'POST',                       
        ));        

        return $form;
    }

    /**
     * Displays a form to create a new Local entity.
     *
     */
    public function newAction()
    {
        $request = $this->getRequest();        
        $locale = $request->getlocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:comercio')->find($id_usuario);

        $entity_ciudad = $em->getRepository('BackendBundle:Ciudad')->findOneBy(array('pais' => $entity_comercio->getPais()));
        $entity_distrito = $em->getRepository('BackendBundle:Distrito')->findOneBy(array('ciudad' => $entity_ciudad));

        $entity = new Local();         
        $entity->setCiudad($entity_ciudad);
        $entity->setDistrito($entity_distrito);

        $form   = $this->createCreateForm($entity);

        return $this->render('FrontendBundle:Local:new.html.twig', array('lenguaje' => $locale,
            'entity_comercio'  => $entity_comercio,
            'entity' => $entity,
            'form'   => $form->createView(),));  
    }

    /**
     * Finds and displays a Local entity.
     *
     */
    public function showAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getlocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_local = $em->getRepository('FrontendBundle:Local')->find($id);

        if (!$entity_local) {
           throw $this->createNotFoundException('Unable to find Local entity.');
        }    

        $entity_comercio = $em->getRepository('FrontendBundle:comercio')->find($id_usuario);        
       
        if( $id_usuario == $entity_local->getComercio()->getId() )
        {
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('FrontendBundle:Local:show.html.twig', array(      
            'entity_local' => $entity_local,
            'entity_comercio' => $entity_comercio,   
            'delete_form' => $deleteForm->createView(),                                                                                         
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('local'));
        } 
    }

    /**
     * Displays a form to edit an existing Local entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getlocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_local = $em->getRepository('FrontendBundle:Local')->find($id);

        if (!$entity_local) {
           throw $this->createNotFoundException('Unable to find Local entity.');
        }
        
        $entity_comercio = $em->getRepository('FrontendBundle:comercio')->find($id_usuario);        

        if( $id_usuario == $entity_local->getComercio()->getId() )
        {
            $editForm = $this->createEditForm($entity_local);
            $deleteForm = $this->createDeleteForm($id);
            
            return $this->render('FrontendBundle:Local:edit.html.twig', array(      
            'entity_local' => $entity_local,
            'entity_comercio' => $entity_comercio,    
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),                                            
            'lenguaje' => $locale            
            ));
        }
        else
        {
            return $this->redirect($this->generateUrl('Local'));
        }
    }

    /**
    * Creates a form to edit a Local entity.
    *
    * @param Local $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Local $entity)
    {
        $request = $this->getRequest();        
        $locale = $request->getlocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario=$usuario->getId();

        $em = $this->getDoctrine()->getManager();
        $entity_comercio = $em->getRepository('FrontendBundle:Comercio')->find($id_usuario);        
        $pais = $entity_comercio->getPais();
        $categoria = $entity_comercio->getCategoria();
        $comercio = $entity_comercio;

        $form = $this->createForm(new LocalType($pais,$categoria,$comercio), $entity, array(
            'action' => $this->generateUrl('Local_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));        

        return $form;
    }
    /**
     * Edits an existing Local entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Local')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Local entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setFchUpdate(new \DateTime('now'));
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Los datos se han guardado satisfactoriamente');             
            return $this->redirect($this->generateUrl('Local_edit', array('id' => $id)));
        }

        return $this->render('FrontendBundle:Local:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Local entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Local')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Local entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('info','El registro ha sido eliminado satisfactoriamente');        
        return $this->redirect($this->generateUrl('Local'));
    }

    /**
     * Creates a form to delete a Local entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Local_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }

}
