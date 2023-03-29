<?php

namespace App\Controller;

use App\Entity\AutoService;
use App\Entity\Basket;
use App\Entity\Brand;
use App\Entity\Client;
use App\Entity\Consignment;
use App\Entity\PartInstall;
use App\Entity\Service;
use App\Entity\Vehicle;
use App\Form\ConsigmentFormType;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class ManagerController extends AbstractController
{

    #[Route('/manager', name: 'app_manager')]
    public function register(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ConsigmentFormType::class);
        $form->handleRequest($request);
        $basket = $doctrine->getRepository(Basket::class)->findAll();

        if($form->isSubmitted() && $form->isValid()){
            $conModel = $form->getData();
            $consignment = new Consignment();
            $vehicle = new Vehicle();
            $brand = new Brand();
            $client = new Client();
            $autoService = new AutoService();

            //заполнение таблиц без внешних ключей (brand) (client)
            $brand->setName($conModel->brand);
            $client->setName($conModel->name);
            $client->setSurname($conModel->surname);
            $client->setMidName($conModel->midName);
            $client->setPhone($conModel->phone);

            //заполнение таблицы (vehicle)
            $vehicle->setModel($conModel->model);
            $vehicle->setReleaseDate($conModel->releaseDate);
            $vehicle->setVin($conModel->vin);
            $vehicle->setBrand($brand);
            $vehicle->setClient($client);

            //заполнение таблицы (Auto service)
            $autoService->setName($conModel->service);
            $autoService->setAddress($conModel->address);

            // Заполнение таблицы (consignment)
            $consignment->setDate($conModel->date);
            $consignment->setUser($user);
            $consignment->setVehicle($vehicle);
            $consignment->setService($autoService);

            $em = $doctrine->getManager();
            $em->persist($brand);
            $em->persist($client);
            $em->persist($vehicle);
            $em->persist($autoService);
            $em->persist($consignment);
            $em->flush();

            return $this->render('manager/index.html.twig', [
                'controller_name' => 'ManagerController',
                'consignmentForm' => $form->createView(),
                'basket' => $basket,
                'message' => 'Успешно'
            ]);

        }




        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
            'consignmentForm' => $form->createView(),
            'basket' => $basket,
            'message'=> false
        ]);
    }

    #[Route('/manager/{id}/pdf', name: 'app_pdf' )]
    public function convertPdf(Pdf $knpSnappyPdf, ManagerRegistry $doctrine, $id){

        $basket = $doctrine->getRepository(Basket::class)->find($id);
        $details = $doctrine->getRepository(PartInstall::class)->findByIdBasket($id);
        //ищу услуги
        $services =  $doctrine->getRepository(Service::class)->findByIdBasket($id);


        $html = $this->renderView('base.html.twig', array(
            'basket' => $basket,
            'details' => $details,
            'services' => $services
        ));

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html)
        );
    }
}
