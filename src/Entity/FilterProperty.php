<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

class FilterProperty
{

    private $id;

    /**
     * @var int|null
     * @Assert\Range(
     *  min = 1,
     *  max = 30)
     */
    private $roomsMin;

    /**
     * @var int|null
     * @Assert\Range(
     *  min = 75000,
     *  max = 10000000)
     */
    private $priceMax;

    /**
     * @var int|null
     *@Assert\Range(
     *  min = 10,
     *  max = 400)
     */
    private $surfaceMin;

    /**
     * @var ArrayCollection
     */
    private $options;

    /**
     * @var int|null
     */
    private $arrayresultsize;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->arrayresultsize = 0;
    }
    
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoomsMin(): ?int
    {
        return $this->roomsMin;
    }

    public function setRoomsMin(int $roomsMin): self
    {
        $this->roomsMin = $roomsMin;

        return $this;
    }

    public function getPriceMax(): ?int
    {
        return $this->priceMax;
    }

    public function setPriceMax(int $priceMax): self
    {
        // if($priceMax <= 74999 || $priceMax >=10000001)
        // {
        //     $this->priceMax = null;
        // }else{
        //     $this->priceMax = $priceMax;
        // }
        $this->priceMax = $priceMax;
        return $this;
    }

    public function getSurfaceMin(): ?int
    {
        return $this->surfaceMin;
    }

    public function setSurfaceMin(int $surfaceMin): self
    {
        $this->surfaceMin = $surfaceMin;

        return $this;
    }

    public function getArrayResultSize(): ?int
    {
        return $this->arrayresultsize;
    }

    public function setArrayResultSize(?Array $arrayresult): self
    {
        if($arrayresult != null){
            foreach($arrayresult as $e) $this->arrayresultsize++;
        }

        return $this;
    }


}
