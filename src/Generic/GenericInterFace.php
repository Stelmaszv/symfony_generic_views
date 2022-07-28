<?php
namespace App\Generic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
interface GenericInterFace{
    public function onQuerySet(ServiceEntityRepository $entityManager);
}