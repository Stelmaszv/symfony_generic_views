<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Controller\GenericDetailController;
use App\Entity\Cars;
use App\class\GenericSetDataInterFace;

class CarDetailController extends GenericDetailController implements GenericSetDataInterFace
{
    #[Route('/car/detail/{id}', name: 'app_car_detail')]
    public function index(int $id,ManagerRegistry $doctrine): Response
    {
        return $this->detailView($id,$doctrine);
    }

    public function setData(): void
    {
        $this->setEntity(Cars::class);
        $this->setTwig('car_detail/index.html.twig');
    }
}
