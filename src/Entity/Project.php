<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;
use DateTimeInterface;

/**
 * @ApiResource(
 *     normalizationContext = {"groups"={"project:read"}},
 *     denormalizationContext = {"groups" = {"project:write"}}
 * )
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("project:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"project:read", "project:write"})
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"project:read", "project:write"})
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("project:read")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("project:read")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("project:read")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->isPublished = false;
        $this->createdAt = new \DateTime();
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

    /**
     * Get the value of isPublished
     */
    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    /**
     * Set the value of isPublished
     *
     * @return  self
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get the value of publishedAt
     */
    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * Set the value of publishedAt
     *
     * @return  self
     */
    public function setPublishedAt(DateTimeInterface $publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of picture
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }
}
