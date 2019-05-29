<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "put"={
 *              "access_control"="is_granted('ROLE_SUPERVISOR') or (is_granted('ROLE_OPERATOR') and object.getUsuario() == user)"
 *          }
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "access_control"="is_granted('ROLE_OPERATOR')"
 *          }
 *     },
 *     normalizationContext={
 *          "groups"={"read"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @UniqueEntity(
 *      fields={"name","startDate","endDate"},
 *      errorPath="name",
 *      message="Existe un evento con las mismas características"
 * )
 */
class Project implements RegisterEntityInterface, RegisterDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Nombre del Proyecto no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Nombre del Proyecto no debe contener valores NULL"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 120,
     *      minMessage = "Nombre del Proyecto debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Nombre del Proyecto no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Fecha de inicio no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Fecha de inicio no debe contener valores NULL"
     * )
     * @Assert\Date(
     *     message="Debe capturar una fecha válida"
     * )
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Fecha de término no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Fecha de término no debe contener valores NULL"
     * )
     * @Assert\Date(
     *     message="Debe capturar una fecha válida"
     * )
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Date(
     *     message="Debe capturar una fecha válida"
     * )
     */
    private $createDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billing", mappedBy="project")
     * @ApiSubresource()
     */
    private $billings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectProfile", mappedBy="project")
     */
    private $projectProfiles;

    public function __construct()
    {
        $this->billings = new ArrayCollection();
        $this->projectProfiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(?\DateTimeInterface $createDate): RegisterDateEntityInterface
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    /**
     * @param UserInterface $usuario
     * @return RegisterEntityInterface
     */
    public function setUsuario(UserInterface $usuario): RegisterEntityInterface
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection|Billing[]
     */
    public function getBillings(): Collection
    {
        return $this->billings;
    }

    public function addBilling(Billing $billing): self
    {
        if (!$this->billings->contains($billing)) {
            $this->billings[] = $billing;
            $billing->setProject($this);
        }

        return $this;
    }

    public function removeBilling(Billing $billing): self
    {
        if ($this->billings->contains($billing)) {
            $this->billings->removeElement($billing);
            // set the owning side to null (unless already changed)
            if ($billing->getProject() === $this) {
                $billing->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectProfile[]
     */
    public function getProjectProfiles(): Collection
    {
        return $this->projectProfiles;
    }

    public function addProjectProfile(ProjectProfile $projectProfile): self
    {
        if (!$this->projectProfiles->contains($projectProfile)) {
            $this->projectProfiles[] = $projectProfile;
            $projectProfile->setProject($this);
        }

        return $this;
    }

    public function removeProjectProfile(ProjectProfile $projectProfile): self
    {
        if ($this->projectProfiles->contains($projectProfile)) {
            $this->projectProfiles->removeElement($projectProfile);
            // set the owning side to null (unless already changed)
            if ($projectProfile->getProject() === $this) {
                $projectProfile->setProject(null);
            }
        }

        return $this;
    }
}
