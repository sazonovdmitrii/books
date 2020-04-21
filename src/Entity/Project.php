<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{

    const CROWDFUNDING_TYPE_YES = 1;
    const CROWDFUNDING_TYPE_NO = 0;

    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $main_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middle_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookHash", mappedBy="project")
     */
    private $bookHashes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $crowdfunding;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="project")
     */
    private $orders;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $short_book_en;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $short_book_ru;

    public function __construct()
    {
        $this->bookHashes = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainImage(): ?string
    {
        return $this->main_image;
    }

    public function setMainImage(?string $main_image): self
    {
        $this->main_image = $main_image;

        return $this;
    }

    public function getMiddleImage(): ?string
    {
        return $this->middle_image;
    }

    public function setMiddleImage(?string $middle_image): self
    {
        $this->middle_image = $middle_image;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function __call($method, $arguments)
    {
        $method = ('get' === substr($method, 0, 3) || 'set' === substr($method, 0, 3)) ? $method : 'get'. ucfirst($method);

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __get($name)
    {
        $method = 'get'. ucfirst($name);
        $arguments = [];
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|BookHash[]
     */
    public function getBookHashes(): Collection
    {
        return $this->bookHashes;
    }

    public function addBookHash(BookHash $bookHash): self
    {
        if (!$this->bookHashes->contains($bookHash)) {
            $this->bookHashes[] = $bookHash;
            $bookHash->setProject($this);
        }

        return $this;
    }

    public function removeBookHash(BookHash $bookHash): self
    {
        if ($this->bookHashes->contains($bookHash)) {
            $this->bookHashes->removeElement($bookHash);
            // set the owning side to null (unless already changed)
            if ($bookHash->getProject() === $this) {
                $bookHash->setProject(null);
            }
        }

        return $this;
    }

    public function getCrowdfunding(): ?bool
    {
        return $this->crowdfunding;
    }

    public function setCrowdfunding(?bool $crowdfunding): self
    {
        $this->crowdfunding = $crowdfunding;

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setProject($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getProject() === $this) {
                $order->setProject(null);
            }
        }

        return $this;
    }

    public function getShortBookEn(): ?string
    {
        return $this->short_book_en;
    }

    public function setShortBookEn(?string $short_book_en): self
    {
        $this->short_book_en = $short_book_en;

        return $this;
    }

    public function getShortBookRu(): ?string
    {
        return $this->short_book_ru;
    }

    public function setShortBookRu(string $short_book_ru): self
    {
        $this->short_book_ru = $short_book_ru;

        return $this;
    }
}
