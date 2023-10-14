<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Supplier $supplier = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Address $billingAddress = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Address $deliveryAddress = null;

    #[ORM\Column]
    private ?float $priceHT = null;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: ProductInvoice::class)]
    private Collection $productInvoices;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function __construct()
    {
        $this->productInvoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getBillingAddress(): ?Address
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?Address $billingAddress): static
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getDeliveryAddress(): ?Address
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Address $deliveryAddress): static
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getPriceHT(): ?float
    {
        return $this->priceHT;
    }

    public function setPriceHT(float $priceHT): static
    {
        $this->priceHT = $priceHT;

        return $this;
    }

    public function __toString(){
        return $this->number;
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
            $productInvoice->setInvoice($this);
        }

        return $this;
    }

    public function removeProductInvoice(ProductInvoice $productInvoice): static
    {
        if ($this->productInvoices->removeElement($productInvoice)) {
            // set the owning side to null (unless already changed)
            if ($productInvoice->getInvoice() === $this) {
                $productInvoice->setInvoice(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
