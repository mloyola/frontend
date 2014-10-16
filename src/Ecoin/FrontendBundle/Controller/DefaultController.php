<?php

namespace Ecoin\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {       
    	$request = $this->getRequest();
        //SESSION DE VISITANTE
 		$session = $request->getSession();                

        if( $session->has('idioma') !== FALSE)
        {
            $idioma = $session->get('idioma');     

            return $this->render('FrontendBundle:Default:index.html.twig', array('lenguaje' => $idioma));              
        }    
        else
        {
            //DETECTAMOS EL PAIS DE LOCALIZACION
        //$client  = @$_SERVER['HTTP_CLIENT_IP'];
        $client  = '201.210.255.255';
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        $result  = "Unknown";
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

        if($ip_data && $ip_data->geoplugin_countryName != null)
        {    
            /*
            $pais_codigo = $ip_data->geoplugin_countryCode;  
            $ciudad_nombre= $ip_data->geoplugin_city;
            $pais_moneda_codigo = $ip_data->geoplugin_currencyCode;            
            */           
        }
        //Borrar cuando se conecte a internet
            $pais_codigo = 'PE';  
            $ciudad_nombre= 'Lima';
            $pais_moneda_codigo = '01'; 

        //AGREGAMOS LOS DATOS DE LOCALIZACION
        //Guardamos el codigo del pais
        $session->set('pais_codigo', $pais_codigo);
        $locale_pais_codigo = $session->get('pais_codigo');
        //Guardamos el nombre de la ciudad
        $session->set('ciudad_nombre', $ciudad_nombre);
        $ciudad_nombre = $session->get('ciudad_nombre');
        //Guardamos el codigo de la moneda del pais
        $session->set('pais_moneda_codigo', $pais_moneda_codigo);
        $pais_moneda_codigo = $session->get('pais_moneda_codigo');
        
        //DETECTAMOS EL IDIOMA DEL USUARIO
        $idiomas = explode(";", $_SERVER['HTTP_ACCEPT_LANGUAGE']); 
        if(strpos($idiomas[0], "es") !== FALSE)
        { $idioma = "es"; } 
        elseif(strpos($idiomas[0], "en") !== FALSE)
        { $idioma = "en"; } 
        elseif($idioma <> "es" && $idioma <> "en")
        { $idioma = "es"; }
        //Guardamos el codigo del idioma del visitante
        $session->set('idioma', $idioma);
        $idioma = $session->get('idioma');
        // set the user locale
        //$session->setLocale($idioma);
        

        return $this->redirect($this->generateUrl('frontend_homepage', array('_locale' => $idioma)));              

        }    

    
        //$locale = $request->getLocale();    
        //$request->setLocale($idioma);    
        

        //return $this->render('FrontendBundle:Default:index.html.twig', array('lenguaje' => $idioma,'_locale' => $idioma));
    }



    public function indexcomercioAction()
    {
        //$session = new Session();
        //$session->start();

        $request = $this->getRequest();
        $locale = $request->getLocale();    
        $session = $request->getSession();

        //$culture = $this->getUser()->getCulture();
        $languages = $request->getLanguages();
        //$languages = $request->getPreferredCulture(array('es','en', 'fr'));

        $idioma = $session->get('idioma');


        return $this->render('FrontendBundle:Default:indexcomercio.html.twig', array('lenguaje' => $idioma,'languages' => $languages));
    }

    public function faqsAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();    

        //$culture = $this->getUser()->getCulture();
        $languages = $request->getLanguages();
        //$languages = $request->getPreferredCulture(array('es','en', 'fr'));

        return $this->render('FrontendBundle:Default:faqs.html.twig', array('lenguaje' => $locale,'languages' => $languages));
    }

    public function contactoAction()
    {
        $request = $this->getRequest();
        $locale = $request->getLocale();    

        //$culture = $this->getUser()->getCulture();
        $languages = $request->getLanguages();
        //$languages = $request->getPreferredCulture(array('es','en', 'fr'));

        return $this->render('FrontendBundle:Default:contacto.html.twig', array('lenguaje' => $locale,'languages' => $languages));
    }

    public function estaticaAction($name)
    {
    	$request = $this->getRequest();
 		$locale = $request->getLocale();
        return $this->render('FrontendBundle:Default:'.$name.'.html.twig', array('lenguaje' => $locale));
    }

    /**     
     * @Route("/ciudades", name="select_ciudades")
     * @Template()
     */ 
    public function ciudadesAction()
    {
        $pais_id = $this->getRequest()->request->get('pais_id');
        $em = $this->getDoctrine()->getManager();
        $ciudades = $em->getRepository('BackendBundle:Ciudad')->findByPaisId($pais_id);        
        return $this->render('FrontendBundle:Default:ciudades.html.twig', array('ciudades' => $ciudades));
    }
    
    /**     
     * @Route("/distritos", name="select_distritos")
     * @Template()
     */ 
    public function distritosAction()
    {
        $ciudad_id = $this->getRequest()->request->get('ciudad_id');
        $em = $this->getDoctrine()->getManager();
        $distritos = $em->getRepository('BackendBundle:Distrito')->findByCiudadId($ciudad_id);        
        return $this->render('FrontendBundle:Default:distritos.html.twig', array('distritos' => $distritos));
    }
}
