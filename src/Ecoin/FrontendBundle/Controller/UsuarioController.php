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

use Ecoin\FrontendBundle\Entity\Usuario;
use Ecoin\FrontendBundle\Form\UsuarioType;

use Ecoin\FrontendBundle\Entity\Codigoactivauser;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{  

    public function notificacionAction($id)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Usuario')->find($id);

        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        if( $id_usuario == $entity->getId() )
        {
            $this->get('session')->getFlashBag()->add('success','Bienvenido a Moneda Móvil');
            $this->get('session')->getFlashBag()->add('info','Bienvenido a Moneda Móvil');
            $this->get('session')->getFlashBag()->add('warning','Bienvenido a Moneda Móvil');
            $this->get('session')->getFlashBag()->add('danger','Bienvenido a Moneda Móvil');

            return $this->render('FrontendBundle:Usuario:notificacion.html.twig', array(
            'entity_usuario'      => $entity,                                    
            'lenguaje' => $locale));            
        }
        else
        {
            return $this->redirect($this->generateUrl('usuario_main'));
        }    
    }

    public function changepassAction($id)
    {
        $request = $this->getRequest();        
        $locale = $request->getLocale();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id_usuario = $usuario->getId();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Usuario')->find($id);

        if (!$entity) {
           throw $this->createNotFoundException('Unable to find Usuario entity.');
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

            return $this->render('FrontendBundle:Usuario:changepass.html.twig', array(
            'entity_usuario'      => $entity,            
            'form'   => $form->createView(),                        
            'lenguaje' => $locale));
        }
        else
        {
            return $this->redirect($this->generateUrl('usuario_main'));
        }    
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
                return $this->redirect($this->generateUrl('usuario_forgot'));                      
            }

            return $this->render('FrontendBundle:Usuario:forgot.html.twig', array('formulario' => $formulario->createView(),'lenguaje' => $locale));
    }

    public function mainAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $usuario = $this->get('security.context')->getToken()->getUser();
        $id=$usuario->getId();
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('FrontendBundle:Usuario')->find($id);

        return $this->render('FrontendBundle:Usuario:main.html.twig', array('lenguaje' => $locale,'entity_usuario'  => $entity));
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

        return $this->render('FrontendBundle:Usuario:login.html.twig', 
            array('lenguaje' => $locale,'last_username' => $session->get(SecurityContext::LAST_USERNAME),'error' => $error));        
    }

    public function activeAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Usuario')->find($id);

        if (!$entity) {            
            return $this->redirect($this->generateUrl('_login'));
        }

        if ( $entity->getEstado() == 'N')
        {
            $entity->setEstado('S');
            $entity->setFchActive(new \DateTime('now'));
            $em->flush();

            return $this->render('FrontendBundle:Usuario:active.html.twig', array('lenguaje' => $locale));        
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

        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);        
        $errors= array();

        return $this->render('FrontendBundle:Usuario:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
            'form'   => $form->createView(),));
    }


    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request)
    {  
        $request = $this->getRequest();
        $locale = $request->getLocale(); 

        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);

        if (count($errors) > 0) 
        {              
             return $this->render('FrontendBundle:Usuario:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
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

                $tipodoc = $em->getRepository('BackendBundle:Tipodoc')->findOneBy(array('id' => 1));

                $entity->setFchCreate(new \DateTime('now'));
                $entity->setFchUpdate(new \DateTime('now'));
                $entity->setFchActive(new \DateTime('now'));
                $entity->setEstado('N');
                $entity->setFoto('');
                $entity->setTipodoc($tipodoc);
                $entity->setNumdoc('');                

                $idioma = $em->getRepository('BackendBundle:Idioma')->findOneBy(array('router' => $locale));
                $entity->setIdioma($idioma);            
                $em->persist($entity);
                $em->flush();
                

                $message = \Swift_Message::newInstance()
                    ->setSubject('Bienvenido a Ecoinmobile.com')
                    ->setFrom('no-reply@ecoinmobile.com')
                    ->setTo($entity->getUsuario())
                    ->setBody($this->renderView('FrontendBundle:Usuario:emailregistro.txt.twig',array(
                    'titulo1' => 'Bienvenid@ a Ecoinmobile.com',
                    'sr'=> 'Sr(a)',
                    'titulo2' => 'Paga tus compras desde tu móvil',   
                    'linea1' => 'Fácil y seguro',   
                    'linea2' => 'No necesitas llevar dinero en efectivo',
                    'linea3' => 'No necesitas llevar tarjetas de crédito o debito',
                    'buscar_establecimiento' => 'Buscar establecimientos afiliados',
                    'datos_acceso' => 'Datos de acceso usuario',
                    'texo_email' => 'Correo electrónico',
                    'texto_password' => 'Contraseña',
                    'texto_login' => 'Ingresar a ecoinmobile.com con mi usuario',
                    'para_informes' => 'Para mayor información enviar un email a',
                    'visitanos_en' => 'Visítanos en',
                    'texto_activacion' => 'Por medida de seguridad se requiere que active su cuenta para poder ingresar y utilizar ecoinmobile.com',
                    'link_activar' => ' Activar mi cuenta',
                    'nombre'  => $entity->getNombreCompleto(),
                    'email'  => $entity->getUsername(),
                    'password' => $password)),'text/html');
                    $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('usuario_show'));            
            }
            else {
                return $this->render('FrontendBundle:Usuario:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
            'form'   => $form->createView(),));            
            }        
       }
       else
       {
             return $this->render('FrontendBundle:Usuario:registro.html.twig', array('lenguaje' => $locale,'entity' => $entity,'errors' => $errors,
            'form'   => $form->createView(),));            
       }         
    }

    /**
    * Creates a form to create a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_create'),
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

        return $this->render('FrontendBundle:Usuario:show.html.twig', array('lenguaje' => $locale));        
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id)
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();

        $em = $this->getDoctrine()->getManager();        
        $entity = $em->getRepository('FrontendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('FrontendBundle:Usuario:edit.html.twig', array(
            'entity_usuario'      => $entity,
            'edit_form'   => $editForm->createView(),
            'lenguaje' => $locale            
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {                
        $request = $this->getRequest();
        $locale = $request->getLocale();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FrontendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('info','Los datos se han guardado satisfactoriamente');
            return $this->redirect($this->generateUrl('usuario_edit', array('id' => $id)));
        }

        return $this->render('FrontendBundle:Usuario:edit.html.twig', array(
            'entity_usuario'      => $entity,
            'edit_form'   => $editForm->createView(),    
            'lenguaje' => $locale                    
        ));     
    }
    
}
