<?php

namespace Ecoin\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Ecoin\FrontendBundle\Form\ChangepasswordType;
use Ecoin\FrontendBundle\Form\Model\Changepassword;

use Ecoin\FrontendBundle\Entity\Comercio;
use Ecoin\FrontendBundle\Form\ComercioType;

/**
 * Comercio controller.
 *
 */
class ComercioController extends Controller
{

    public function changepassAction($id)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();

        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Comercio entity.');
        }

        if( $id_usuario == $entity->getId() )
        {
            $PasswordOriginal = $entity->getPassword();

            $form = $this->createFormBuilder()
            ->add('oldPassword','password', array('max_length' => '10','required' => true, 'invalid_message' => 'Ingrese su contraseña'))
            ->add('newPassword', 'repeated', array('type' => 'password','invalid_message' => 'Las contraseñas deben coincidir',
            'required' => true,'first_options'  => array('label' => 'Password','max_length' => '10'),
            'second_options' => array('label' => 'Repeat Password','max_length' => '10')))                       
            ->getForm(); 

            if ($request->getMethod() == 'POST')
            {                
                $form->handleRequest($request);
                if ($form->isValid())
                {
                    $datos = $form->getData();                     
                    if (null == $datos['oldPassword'] )
                    {                    
                        $this->get('session')->getFlashBag()->add('error','Error: Ingrese su contraseña vigente');
                    }
                    else
                    {
                        $passwordold = $datos['oldPassword'];                        
                        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
                        $passwordCodificado = $encoder->encodePassword($passwordold,$entity->getSalt());                        

                        if( $passwordCodificado == $PasswordOriginal)
                        {                                                    
                            $newPassword = $datos['newPassword'];                                                    
                            $passwordnew = $encoder->encodePassword($newPassword,$entity->getSalt());     

                            $entity->setPassword($passwordnew);
                            $entity->setFchUpdate(new \DateTime('now'));
                            $em->persist($entity);
                            $em->flush(); 

                            $this->get('session')->getFlashBag()->add('info','Haz cambiado tu contraseña satisfactoriamente');                  
                        }    
                        else
                        {
                            $this->get('session')->getFlashBag()->add('error','Error: La contraseña ingresada no es igual a la vigente');
                        }                                                                     
                    }                        
                }                    
                
            }            

            return $this->render('FrontendBundle:Comercio:changepass.html.twig', array(
            'entity_comercio'      => $entity,            
            'form'   => $form->createView(),                        
            'lenguaje' => $locale));
        }
        else
        {
            return $this->redirect($this->generateUrl('comercio_main'));
        }    
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FrontendBundle:Comercio')->findAll();

        return $this->render('FrontendBundle:Comercio:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function forgotAction()
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();
        
        $formulario = $this->createFormBuilder()
            ->add('email', 'email')                
            ->getForm();
        
        if ($request->getMethod() == 'POST')
            {                
                $formulario->handleRequest($request);
                if ($formulario->isValid())
                {
                    $datos = $formulario->getData();   
                    $email = $datos['email'];                  
                    $this->get('session')->getFlashBag()->add('info','La contraseña ha sido enviada satisfactoriamente');                                                                                      
                }                    
                return $this->redirect($this->generateUrl('comercio_forgot'));                      
            }

            return $this->render('FrontendBundle:Comercio:forgot.html.twig', array('formulario' => $formulario->createView(),'lenguaje' => $locale));
    }

    public function mainAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $negocio = $this->get('security.context')->getToken()->getUser();
        $id=$negocio->getId();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        return $this->render('FrontendBundle:Comercio:main.html.twig', array('lenguaje' => $locale,'entity_comercio'  => $entity));
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();    
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);            
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);            
        }

        if ( count($error) > 0)
        {            
            $this->get('session')->getFlashBag()->add('error','Error: Los datos ingresados no son validos');
        }

        return $this->render('FrontendBundle:Comercio:login.html.twig', 
            array('lenguaje' => $locale,'last_username' => $session->get(SecurityContext::LAST_USERNAME),'error' => $error));        
    }

    public function activeAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        if (!$entity) {            
            return $this->redirect($this->generateUrl('_login'));
        }

        if ( $entity->getEstado() == 'N')
        {
            $entity->setEstado('S');
            $entity->setFchActive(new \DateTime('now'));
            $em->flush();

            return $this->render('FrontendBundle:Comercio:active.html.twig', array('lenguaje' => $locale));        
        }    
        else
        {            
            return $this->redirect($this->generateUrl('_login'));   
        }    
    }

    public function registroAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();    

        $entity = new Comercio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);        
        $errors= array();

        return $this->render('FrontendBundle:Comercio:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
            'form'   => $form->createView(),));
    }

    /**
     * Creates a new Comercio entity.
     *
     */
    public function createAction(Request $request)
    {  
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $entity = new Comercio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);

        if (count($errors) > 0) 
        {              
             return $this->render('FrontendBundle:Comercio:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
            'form'   => $form->createView(),));     
        } 

        if ($request->getMethod() == 'POST')
        {            
            if ($form->isValid()) 
            {   
                $em = $this->getDoctrine()->getManager();
            
                $entity->setSalt(md5(time()));            
                $password = $entity->getPassword();
                $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
                $passwordCodificado = $encoder->encodePassword($entity->getPassword(),$entity->getSalt());
                $entity->setPassword($passwordCodificado);

                $entity->setFchCreate(new \DateTime('now'));
                $entity->setFchUpdate(new \DateTime('now'));
                $entity->setFchActive(new \DateTime('now'));
                $entity->setEstado('N');
                $entity->setEstadocategorias('N');
                $entity->setEstadolocales('N');
                $entity->setEstadocuentas('N');
                $entity->setLogo('');    
                $entity->setContacto('');            
                $entity->setTelefono('');
                $entity->setMovil('');

                $idioma = $em->getRepository('BackendBundle:Idioma')->findOneBy(array('router' => $locale));
                $entity->setIdioma($idioma);            

                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('comercio_show'));            
            }
            else {
                return $this->render('FrontendBundle:Comercio:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
            'form'   => $form->createView(),));            
            }        
       }
       else
       {
             return $this->render('FrontendBundle:Comercio:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
            'form'   => $form->createView(),));            
       }         
    }

    /**
    * Creates a form to create a Comercio entity.
    *
    * @param Comercio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Comercio $entity)
    {
        $form = $this->createForm(new ComercioType(), $entity, array(
            'action' => $this->generateUrl('comercio_create'),
            'method' => 'POST',
        ));

        return $form;
    }

     /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();    

        return $this->render('FrontendBundle:Comercio:show.html.twig', array('lenguaje' => $locale));        
    }

    /**
     * Displays a form to edit an existing Comercio entity.
     *
     */
    public function editAction($id)
    {        
        $request = $this->getRequest();
        $locale = $request->getLocale();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comercio entity.');
        }

        $editForm = $this->createEditForm($entity);        

        return $this->render('FrontendBundle:Comercio:edit.html.twig', array(
            'entity_comercio'      => $entity,
            'edit_form'   => $editForm->createView(),
            'lenguaje' => $locale            
        ));
    }

    /**
    * Creates a form to edit a Comercio entity.
    *
    * @param Comercio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Comercio $entity)
    {
        $form = $this->createForm(new ComercioType(), $entity, array(
            'action' => $this->generateUrl('comercio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Comercio entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comercio entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Los datos se han guardado satisfactoriamente');
            return $this->redirect($this->generateUrl('comercio_edit', array('id' => $id)));
        }

        return $this->render('FrontendBundle:Comercio:edit.html.twig', array(
            'entity_comercio'      => $entity,
            'edit_form'   => $editForm->createView(),    
            'lenguaje' => $locale                    
        ));
    }
    
    /**
     * Deletes a Comercio entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Comercio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('comercio'));
    }

    /**
     * Creates a form to delete a Comercio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comercio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function notificacionAction($id)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Comercio')->find($id);

        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        if( $id_usuario == $entity->getId() )
        {
            $this->get('session')->getFlashBag()->add('success','Bienvenido a Moneda Móvil');
            $this->get('session')->getFlashBag()->add('info','Bienvenido a Moneda Móvil');
            $this->get('session')->getFlashBag()->add('warning','Bienvenido a Moneda Móvil');
            $this->get('session')->getFlashBag()->add('danger','Bienvenido a Moneda Móvil');

            return $this->render('FrontendBundle:Comercio:notificacion.html.twig', array(
            'entity_comercio'      => $entity,                                    
            'lenguaje' => $locale));            
        }
        else
        {
            return $this->redirect($this->generateUrl('comercio_main'));
        }    
    }
}
