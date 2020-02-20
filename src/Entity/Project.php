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

    public function __construct()
    {
        $this->bookHashes = new ArrayCollection();
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
}
