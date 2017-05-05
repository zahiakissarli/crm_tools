<?php

namespace CRM\ToolsBundle\Controller;

use CRM\ToolsBundle\Entity\GraphName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
//        return $this->render('CRMToolsBundle:Default:index.html.twig');
        return $this->render('CRMToolsBundle:Monitoring:homePage.html.twig');
    }

    public function creatAction()
    {
        $graph = new GraphName();
        $graph->setName('UCR_TABLES_DE_REF');
        $graph->setEnableDisplay('1');
        $graph->setAverageDurationJob(120);

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($graph);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id '.$graph->getId());
    }

    public function displayAction()
    {
        $em= $this->getDoctrine()->getEntityManager();
        $graphs = $em->getRepository("CRMToolsBundle:GraphName")->recupeWithWhere();

//        var_dump($graphs);
        foreach ($graphs as $graph){
            var_dump('le graph '.$graph['id']);
//            return new Response('le premier graph ');
        }die;


    }



}
