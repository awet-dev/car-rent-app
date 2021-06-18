<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 * @Vich\Uploadable
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="car_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="text")
     */
    private $information;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\OneToOne(targetEntity=CarRate::class, mappedBy="car", cascade={"persist", "remove"})
     */
    private $carRate;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="car")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

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

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCarRate(): ?CarRate
    {
        return $this->carRate;
    }

    public function setCarRate(?CarRate $carRate): self
    {
        // unset the owning side of the relation if necessary
        if ($carRate === null && $this->carRate !== null) {
            $this->carRate->setCar(null);
        }

        // set the owning side of the relation if necessary
        if ($carRate !== null && $carRate->getCar() !== $this) {
            $carRate->setCar($this);
        }

        $this->carRate = $carRate;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCar($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCar() === $this) {
                $transaction->setCar(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function __toString() 
    {
        return $this->name;
    }
}
