<?php

namespace App\Entity;



use App\Entity\Company;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarsRepository;
use App\Generic\Api\Trait\EntityApiGeneric;
use App\Generic\Api\Interfaces\ApiInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
class Cars implements ApiInterface
{
    use EntityApiGeneric;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * @Groups("api")
     */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Groups("api")
     */
    private ?string $name = null;

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
       return $this->setApiGroup(new Company);
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
