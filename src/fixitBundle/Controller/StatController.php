<?php

namespace fixitBundle\Controller;
use AppBundle\Entity\Ad;
use AppBundle\Entity\Category;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;
use AppBundle\Entity\Service;

class StatController extends Controller
{
    public function StatAction(){
        $service=$this->getDoctrine()->getRepository( Service::class)->findAll();

        $ob = new Highchart();

        $ob->chart->renderTo('piechart');
        $ob->title->text('Moyen des services demandés');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        for($i = 0; $i < count($service); ++$i){
            $data[]=array($service[$i]->getName(),$service[$i]->getNote());
        }




//      $service
//        for($i=0;$i<count($service);++$i){
//            $cat=$service[$i]->getCategory();
//            $categorie=$this->getDoctrine()->getRepository(Category::class)->find($cat);
//            $somme=count($service);
// }

        $ob->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $data)));
        return $this->render('@fixit/Stat/Stat.html.twig', array(
            'chart' => $ob

        ));


    }
}
