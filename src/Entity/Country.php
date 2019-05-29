<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
 *              "access_control"="is_granted('ROLE_SUPERVISOR')"
 *          }
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "access_control"="is_granted('ROLE_SUPERVISOR')"
 *          }
 *     },
 *     normalizationContext={
 *          "groups"={"read"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @UniqueEntity(
 *      fields={"name"},
 *      errorPath="name",
 *      message="Existe un país con el mismo nombre"
 * )
 * @UniqueEntity(
 *      fields={"ctkey"},
 *      errorPath="ctkey",
 *      message="Existe un país con la misma clave"
 * )
 */
class Country implements RegisterEntityInterface, RegisterDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Nombre del País no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Nombre del País no debe contener valores NULL"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 125,
     *      minMessage = "Nombre del País debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Nombre del País no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Código de País no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Código de País no debe contener valores NULL"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 4,
     *      minMessage = "Código de País debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Código de País no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $ctkey;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="countries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

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

    public function getCtkey(): ?string
    {
        return $this->ctkey;
    }

    public function setCtkey(?string $ctkey): self
    {
        $this->ctkey = $ctkey;

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

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    /**
     * @param \DateTimeInterface $createDate
     * @return RegisterDateEntityInterface
     */
    public function setCreateDate(\DateTimeInterface $createDate): RegisterDateEntityInterface
    {
        $this->createDate = $createDate;

        return $this;
    }
}
