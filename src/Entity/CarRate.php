<?php

namespace App\Entity;

use App\Repository\CarRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRateRepository::class)
 */
class CarRate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Car::class, inversedBy="carRate", cascade={"persist", "remove"})
     */
    private $car;

    /**
     * @ORM\Column(type="integer")
     */
    private $rateByHour;

    /**
     * @ORM\Column(type="integer")
     */
    private $rateByDay;

    /**
     * @ORM\Column(type="integer")
     */
    private $rateByKm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getRateByHour(): ?int
    {
        return $this->rateByHour;
    }

    public function setRateByHour(int $rateByHour): self
    {
        $this->rateByHour = $rateByHour;

        return $this;
    }

    public function getRateByDay(): ?int
    {
        return $this->rateByDay;
    }

    public function setRateByDay(int $rateByDay): self
    {
        $this->rateByDay = $rateByDay;

        return $this;
    }

    public function getRateByKm(): ?int
    {
        return $this->rateByKm;
    }

    public function setRateByKm(int $rateByKm): self
    {
        $this->rateByKm = $rateByKm;

        return $this;
    }
}
