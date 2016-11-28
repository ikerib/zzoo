<?php

namespace AppBundle\Controller;

use AppBundle\Form\AtalaType;
use AppBundle\Entity\Atala;


use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * API.
 *
 * @Route("/api")
 */
class ApiController extends FOSRestController
{

    /**
     * @Route("/")
     */
    public function indexAction ( Request $request )
    {
        return $this->redirectToRoute('nelmio_api_doc_index', array(), 301);
    }


//    ORDENANTZAK

    /**
     * Udal baten Ordenantza zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Ordenantza guztien zerrenda eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return array|View
     *
     * @Annotations\View()
     * @Get("/ordenantzak/{udalaid}")
     */
    public function getOrdenantzakAction($udalaid)
    {
        $em = $this->getDoctrine()->getManager();
        $ordenantzak = $em->getRepository( 'AppBundle:Ordenantza' )->findBy(
            array (
                'udala' => $udalaid,
            )
        );

        $view = View::create();
        $view->setData( $ordenantzak );
        header( 'content-type: application/json; charset=utf-8' );
        header( "access-control-allow-origin: *" );

        return $view;
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Ordenantza baten informazioa eskuratu"
     * )
     *
     * @Annotations\View()
     * @Get("/ordenantza/{id}")
     */
    public function getOrdenantzaAction($id){
        $em         = $this->getDoctrine()->getManager();
        $ordenantza = $em->getRepository('AppBundle:Ordenantza')->findById($id);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $ordenantza;
    }


//    ATALAK

    /**
     * Ordenantza batem tributu guztien zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Ordenantza baten tributu guztien zerrenda eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return array data
     *
     * @Annotations\View()
     * @Get("/tributuak/{ordenantzaid}")
     */
    public function getAtalakAction($ordenantzaid)
    {
        $em         = $this->getDoctrine()->getManager();
        $atalak = $em->getRepository('AppBundle:Atala')->findBy(array('ordenantza'=>$ordenantzaid));
        $view = View::create();
        $view->setData($atalak);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Tributu baten informazioa eskuratu"
     * )
     *
     * @Annotations\View()
     * @Get("/tributua/{id}")
     */
    public function getAtalaAction($id){
        $em         = $this->getDoctrine()->getManager();
        $atala = $em->getRepository('AppBundle:Atala')->findById($id);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $atala;
    }


//    AZPIATALAK

    /**
     * Udal baten zergen zerrenda.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Udal baten zerga guztien zerrenda eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return array data
     *
     * @Annotations\View()
     * @Get("/zergak/{udalaid}")
     */
    public function getAzpiatalakAction($udalaid)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var  $query \Doctrine\DBAL\Query\QueryBuilder */
        $query = $em->createQuery('SELECT p.id, p.kodea, p.izenburuaeu FROM AppBundle:Azpiatala p WHERE p.udala=:udalaid');
        $query->setParameter( 'udalaid', $udalaid );
        $azpiatalak = $query->getResult();

        $view = View::create();
        $view->setData($azpiatalak);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }

    /**
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Zerga baten informazioa eskuratu",
     *   statusCodes = {
     *     200 = "Zuzena denean"
     *   }
     * )
     *
     *
     * @return View
     *
     * @Annotations\View()
     * @Get("/zerga/{id}")
     */
    public function getAzpiatalaAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $azpiatalak = $em->getRepository( 'AppBundle:Azpiatala' )->findOneById( $id );

        $view = View::create();
        $view->setData($azpiatalak);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        return $view;

    }

}
