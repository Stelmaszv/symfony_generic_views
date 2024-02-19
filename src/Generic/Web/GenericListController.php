<?php
namespace App\Generic\Web;
use App\Generic\Web\GenericInterFace;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class GenericListController extends AbstractController implements GenericInterFace
{ 
    use Generic;
    protected bool $paginate = false;
    protected int $per_page = 5;
    private Request $request;
    private PaginatorInterface $paginator;

    public function listView(ManagerRegistry $doctrine,Request $request, PaginatorInterface $paginator): Response
    {
        $this->paginator = $paginator;
        return $this->baseView($doctrine,$request);
    }

    public function onQuerySet(ServiceEntityRepository $entityManager)
    {
        return $entityManager->findAll();
    }

    private function preaperQuerySet($entityManager)
    {
       $data= $entityManager->getRepository($this->entity);
       $query = $this->onQuerySet($data);
       if ($this->paginate){
        return $this->paginator->paginate(
            $query,
            $this->request->query->getInt('page', 1),
            $this->per_page
        );
      }else{
        return $query;
      }
    }

    public function setData(): void {}
}
