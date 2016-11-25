<?php

    namespace AppBundle\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use AppBundle\AppBundle;
    use AppBundle\Entity\Ordenantza;
    use AppBundle\Entity\Udala;

    class DefaultController extends Controller
    {
        /**
         * @Route("/html/{udala}", name="homepage")
         */
        public function htmlAction(Request $request, $udala)
        {
            $em = $this->getDoctrine()->getManager();
            /** @var $udala \AppBundle\Entity\Udala */
            $udala = $em->getRepository( 'AppBundle:Udala' )->find( $udala );

            /** @var $ordenantzak \AppBundle\Entity\Ordenantza */
            $ordenantzak = $em->getRepository( 'AppBundle:Ordenantza' )->findAll(
                array (
                    'udala_id' => $udala,
                )
            );


            return $this->render('default\index.html.twig', array(
                'ordenantzas' => $ordenantzak,
                'udala'=>$udala,
            ));
        }
    }
