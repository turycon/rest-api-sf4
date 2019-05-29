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
 * @ORM\Entity(repositoryClass="App\Repository\BillingRepository")
 * @UniqueEntity(
 *      fields={"number"},
 *      errorPath="number",
 *      message="Existe una factura con el mismo número"
 * )
 */
class Billing implements RegisterEntityInterface, RegisterDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Número de Factura no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Número de Factura no debe contener valores NULL"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 45,
     *      minMessage = "Número de Factura debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Número de Factura no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $number;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Fecha de Facturación no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Fecha de Facturación no debe contener valores NULL"
     * )
     * @Assert\Date(
     *     message="Formato de Fecha de Facturación incorrecto"
     * )
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Monto de la Factura no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Monto de la Factura no debe contener valores NULL"
     * )
     * @Assert\Length(
     *      min = 4,
     *      max = 14,
     *      minMessage = "Monto de la Factura debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Monto de la Factura no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Categoría de Factura no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Categoría de Factura no debe contener valores NULL"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 45,
     *      minMessage = "Categoría de Factura debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Categoría de Factura no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Status de Factura no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Status de Factura no debe contener valores NULL"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 45,
     *      minMessage = "Status de Factura debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Status de Factura no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read"})
     */
    private $createDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read"})
     * @Assert\Date(
     *     message="Formato de Fehca de Facturación incorrecto"
     * )
     */
    private $paymentDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="billings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="billings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    /**
     * @param \DateTimeInterface|null $createDate
     * @return RegisterDateEntityInterface
     */
    public function setCreateDate(?\DateTimeInterface $createDate): RegisterDateEntityInterface
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}
