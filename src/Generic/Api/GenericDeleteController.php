<?php

namespace App\Generic\Api;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenericDeleteController extends AbstractController
{
    protected ?string $entity = null;

    protected ManagerRegistry $managerRegistry;
    protected int $id = 0;

    public function __invoke(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $this->initialize($doctrine,$id);
        return $this->delete($doctrine,$id);
    }

    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {

        $car = $doctrine->getRepository($this->entity)->find($id);
    
        if (!$car) {
            return new JsonResponse(['message' => 'Car not found'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        $this->beforeDelete();
        $this->deleteAction($car);
        $this->afterDelete();
    
        return new JsonResponse(['message' => 'Car deleted successfully'], JsonResponse::HTTP_OK);
    }

    protected function initialize(ManagerRegistry $doctrine, int $id): void
    {
        $this->managerRegistry = $doctrine;
        $this->id = $id;
    }

    protected function beforeDelete(): void {}

    protected function afterDelete(): void {}

    private function deleteAction(object $car) : void 
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->remove($car);
        $entityManager->flush();
    }
}