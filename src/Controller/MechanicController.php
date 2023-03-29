<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Brand;
use App\Entity\Consignment;
use App\Entity\Detail;
use App\Entity\Job;
use App\Entity\PartInstall;
use App\Entity\Service;
use App\Entity\Vehicle;
use App\Form\AddDetailFormType;
use App\Form\AddServiceFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MechanicController extends AbstractController
{


    #[Route('/mechanic', name: 'app_mechanic')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $vehicle = $doctrine->getRepository(Vehicle::class)->findAll();
        $brand = $doctrine->getRepository(Brand::class)->findAll();

        return $this->render('mechanic/index.html.twig', [
            'controller_name' => 'MechanicController',
            'vehicle' => $vehicle,
            'brand' => $brand
        ]);
    }

    #[Route('/mechanic/{id}/add', name: 'app_add')]
    public function addService(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($id);
        $con = $doctrine->getRepository(Consignment::class)->findOneBy(['vehicle' => $id]);

        if($basket = $doctrine->getRepository(Basket::class)->findOneBy(['id'=>$con->getId()]) == null){
            $basket = new Basket();
            $basket->setConsignment($con);
        } else
        {
           $basket = $doctrine->getRepository(Basket::class)->findOneby(['id'=>$con->getId()]);
        }

        //необходимо для рендера деталей и услуг
        //ищу запчасти
        $basketOne = $doctrine->getRepository(Basket::class)->findOneBy(['consignment' => $con->getId()]);
        $details = $doctrine->getRepository(PartInstall::class)->findByIdBasket($id);
        //ищу услуги
        $services =  $doctrine->getRepository(Service::class)->findByIdBasket($id);

        $formDet = $this->createForm(AddDetailFormType::class);
        $formDet->handleRequest($request);

        if($formDet->isSubmitted() && $formDet->isValid()){
            $detModel = $formDet->getData();
            $detail = new Detail();
            $partIn = new PartInstall();

            $detail->setName($detModel->detail);
            $detail->setCost($detModel->cost);

            $partIn->setDetail($detail);
            $costB = $basket->getCost();
            $basket->setCost($costB + $detModel->cost);
            $partIn->setBasket($basket);

            $em = $doctrine->getManager();
            $em->persist($detail);
            $em->persist($partIn);
            $em->persist($basket);
            $em->flush();
            return $this->redirectToRoute('app_add',['id'=>$id]);

        }

        $formService = $this->createForm(AddServiceFormType::class);
        $formService->handleRequest($request);

        if($formService->isSubmitted() && $formService->isValid()) {
            $serviceModel = $formService->getData();
            $job = new Job();
            $service = new Service();

            $job->setName($serviceModel->service);
            $job->setCost($serviceModel->cost);

            $service->setJob($job);

            $costB = $basket->getCost();
            $basket->setCost($costB + $serviceModel->cost);
            $service->setBasket($basket);

            $em = $doctrine->getManager();
            $em->persist($job);
            $em->persist($service);
            $em->persist($basket);
            $em->flush();
            return $this->redirectToRoute('app_add',['id'=>$id]);
        }



        return $this->render('mechanic/addTemplate.html.twig', [
            'vehicle' => $vehicle,
            'addDetailForm' => $formDet->createView(),
            'addServiceForm' => $formService->createView(),
            'details' => $details,
            'services' => $services
        ]);
    }
}
