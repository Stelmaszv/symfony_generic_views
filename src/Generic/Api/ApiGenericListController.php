<?php

namespace App\Generic\Api;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiGenericListController extends AbstractController
{
    protected ?string $entity = null;
    protected int $perPage = 0;
    protected ManagerRegistry $managerRegistry;
    private SerializerInterface $serializer;
    private PaginatorInterface $paginator;
    private Request $request;
    private ?array $paginatorData = null;
    
    public function listView(ManagerRegistry $doctrine, SerializerInterface $serializer, PaginatorInterface $paginator, Request $request): JsonResponse
    {
        if(!$this->entity) {
            throw new \Exception("Entity is not define in controller ".get_class($this)."!");
        }

        $this->managerRegistry = $doctrine;
        $this->serializer = $serializer;
        $this->paginator = $paginator;
        $this->request = $request;

        return new JsonResponse($this->getResponse(), JsonResponse::HTTP_OK);
    }

    protected function onQuerySet(ObjectRepository $repository): array
    {
        return $repository->findAll();
    }

    private function getResponse(): array
    {
        $query = $this->getQuery();

        return [
            'results' => $this->normalize($query),
            'count' => count($query),
            'paginatorData' => $this->paginatorData
        ];
    }

    private function normalize(array $query): array
    {
        return $this->serializer->normalize($this->prepareQuerySet($query), null, [
            'groups' => 'api',
            'circular_reference_handler' => function () {
                return null;
            },
        ]);
    }

    private function getQuery(): array
    {
        return $this->onQuerySet($this->managerRegistry->getRepository($this->entity));
    }

    private function prepareQuerySet(array $query): mixed
    {
        if($this->perPage){
            $paginator = $this->paginator->paginate(
                $query,
                $this->request->query->getInt('page', 1),
                $this->perPage
            );

            $paginationData = $paginator->getPaginationData();

            $this->paginatorData = [
                'endPage' => $paginationData['endPage'],
                'startPage' => $paginationData['startPage'],
                'current' => $paginationData['current'],
                'pageCount' => $paginationData['pageCount'],
                'previous' => $paginationData['previous'] ?? null,
                'next' => $paginationData['next'] ?? null
            ];

            return $paginator;
        }

        return $query;
    }
}