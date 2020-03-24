<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $payment_method_code;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="entity")
     */
    private $transactions;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $payment_link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="orders")
     */
    private $user;

    public function __construct()
    {
        $this->created = new \DateTime('now');
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPaymentMethodCode(): ?string
    {
        return $this->payment_method_code;
    }

    public function setPaymentMethodCode(?string $payment_method_code): self
    {
        $this->payment_method_code = $payment_method_code;

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
            $transaction->setEntity($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getEntity() === $this) {
                $transaction->setEntity(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentLink()
    {
        return $this->payment_link;
    }

    /**
     * @param mixed $payment_link
     */
    public function setPaymentLink($payment_link)
    {
        $this->payment_link = $payment_link;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
