<?php

namespace App\Generic\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Generic\Web\GenericGetTrait;
use Doctrine\ORM\EntityManagerInterface;

class GenericDetailController extends AbstractController
{
    use GenericGetTrait;

    protected int $id;
    protected EntityManagerInterface $entityManager;
    protected ServiceEntityRepository $repository;

    public function __invoke(EntityManagerInterface $entityManager,int $id): Response
    {
        $this->initialize($entityManager, $id);
        return $this->showAction();
    }

    protected function initialize(EntityManagerInterface $entityManager,int $id): void
    {
        $this->checkData();
        $this->entityManager = $entityManager;
        $this->id = $id;
        $this->repository = $this->entityManager->getRepository($this->entity);
    }

    private function getQuery(): ?object
    {
        $this->beforeQuery();

        $queryBuilder = $this->repository->find($this->id);

        if (!$queryBuilder) {
            throw $this->createNotFoundException('Not Found');
        }

        $this->afterQuery();

        return $queryBuilder;
    }

    private function getAttributes(): array
    {
        $attributes['object'] = $this->getQuery();

        return array_merge($attributes, $this->onSetAttribute());
    }

    private function showAction(): Response
    {
        return $this->render($this->twig, $this->getAttributes());
    }
}
