<?php

namespace App\Entity;

use ReflectionClass;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarsRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
class Cars
{
    //private array $companyApiFields = ['Id','Name'];
    /**
     * @Groups("api")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Groups("api")
     */
    private ?string $name = null;

    /**
     * @Groups("api")
     */
    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Company $company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @Groups("api")
     */
    public function getCompany(): ?array
    {
        if ($this->company === null) {
            return null;
        }

        $companyApiFields = new ReflectionClass(new Company);
        $properties = $companyApiFields->getProperties();


        foreach ($properties as $property) {
            $atrybute = $property->getName();
            $method = 'get'.$atrybute;
            $values[$atrybute] = $this->company->$method(); 
        }

        return $values;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
