<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductInvoice::class)]
    private Collection $productInvoices;

    public function __construct()
    {
        $this->productInvoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(){
        return $this->name;
    }

    /**
     * @return Collection<int, ProductInvoice>
     */
    public function getProductInvoices(): Collection
    {
        return $this->productInvoices;
    }

    public function addProductInvoice(ProductInvoice $productInvoice): static
    {
        if (!$this->productInvoices->contains($productInvoice)) {
            $this->productInvoices->add($productInvoice);
            $productInvoice->setProduct($this);
        }

        return $this;
    }

    public function removeProductInvoice(ProductInvoice $productInvoice): static
    {
        if ($this->productInvoices->removeElement($productInvoice)) {
            // set the owning side to null (unless already changed)
            if ($productInvoice->getProduct() === $this) {
                $productInvoice->setProduct(null);
            }
        }

        return $this;
    }
}
