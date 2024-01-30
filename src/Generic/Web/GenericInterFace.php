<?php
namespace App\Generic\Web;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
interface GenericInterFace{
    public function onQuerySet(ServiceEntityRepository $entityManager);
}