<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banaan;
use AppBundle\Form\BanaanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $banaan = new Banaan();
        $newForm = $this->createForm(BanaanType::class,$banaan);
        $newForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if($newForm->isValid()) {
            $em->persist($banaan);
            $em->flush();
        }
        $banaanList = $em->getRepository('AppBundle:Banaan')->findAll();
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'form' => $newForm->createView(),
            'bananen' => $banaanList,
        ));
    }
}
