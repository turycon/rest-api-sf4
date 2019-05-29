<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
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
 * @ORM\Entity(repositoryClass="App\Repository\ProjectProfileRepository")
 */
class ProjectProfile implements RegisterEntityInterface, RegisterDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *      message="Número de pasajeros no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Número de pasajeros no debe contener valores NULL"
     * )
     * @Assert\Type(
     *      type="integer",
     *      message="El número de pasajeros debe ser un número"
     * )
     * @Assert\Range(
     *      min="1",
     *      max="10000",
     *      minMessage="El número de pasajeros debe ser al menos {{ limit }}",
     *      maxMessage="El número de pasajeros debe igual o menor que {{ limit }}"
     * )
     */
    private $pax;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *      message="Monto de presupuesto no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Monto de presupuesto no debe contener valores NULL"
     * )
     * @Assert\Regex(
     *     pattern="/^\d+(\.\d+)?/",
     *     message="Monto de cierre debe ser un número con punto decimal"
     * )
     */
    private $budget;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Monto de cierre no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Monto de cierre no debe contener valores NULL"
     * )
     * @Assert\Regex(
     *     pattern="/^\d+(\.\d+)?/",
     *     message="Monto de cierre debe ser un número con punto decimal"
     * )
     */
    private $balance;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Entrega de cierre no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Entrega de cierre no debe contener valores NULL"
     * )
     * @Assert\Date(
     *     message="Entrega de cierre debe ser una fecha válida"
     * )
     */
    private $balanceDate;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Monto de facturación no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Monto de facturación no debe contener valores NULL"
     * )
     * @Assert\Regex(
     *     pattern="/^\d+(\.\d+)?/",
     *     message="Monto de facturación debe ser un número con punto decimal"
     * )
     */
    private $billing;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Fecha de facturación no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Fecha de facturación no debe contener valores NULL"
     * )
     * @Assert\Date(
     *     message="Fecha de facturación debe ser una fecha válida"
     * )
     */
    private $billingDate;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Prospección de utilidad no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Prospección de utilidad no debe contener valores NULL"
     * )
     * @Assert\Regex(
     *     pattern="/^\d+(\.\d+)?/",
     *     message="Monto de prospección debe ser un número con punto decimal"
     * )
     */
    private $revenueProspection;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Porcentaje de utilidad no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Porcentaje de utilidad no debe contener valores NULL"
     * )
     * @Assert\Type(
     *      type="integer",
     *      message="Porcentaje de utilidad debe ser un número entero"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="0",
     *     message="Porcentaje de utilidad debe ser mayor o igual que 0"
     * )
     */
    private $revenuePercent;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Utilidad no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Utilidad no debe contener valores NULL"
     * )
     * @Assert\Regex(
     *     pattern="/^\d+(\.\d+)?/",
     *     message="Monto de utilidad debe ser un número con punto decimal"
     * )
     */
    private $revenue;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Fecha de pago no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Fecha de pago no debe contener valores NULL"
     * )
     * @Assert\Date(
     *     message="Fecha de pago debe ser una fecha válida"
     * )
     */
    private $paymentDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días de crédito no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días de crédito no debe contener valores NULL"
     * )
     * @Assert\Type(
     *      type="integer",
     *      message="Días de crédito debe ser un número entero"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días de crédito debe ser mayor o igual a 1"
     * )
     * @Assert\LessThanOrEqual(
     *     value="45",
     *     message="Días de crédito debe ser menor o igual a 45"
     * )
     */
    private $paymentDays;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read"})
     * @Assert\Type(
     *      type="bool",
     *      message="Status de entrega en finanzas debe ser verdadero o falso"
     * )
     */
    private $financialStatus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read"})
     * @Assert\Type(
     *      type="bool",
     *      message="Status de facturación debe ser verdadero o falso"
     * )
     */
    private $billingStatus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read"})
     * @Assert\Type(
     *      type="bool",
     *      message="Status de operación debe ser verdadero o falso"
     * )
     */
    private $operationStatus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read"})
     * @Assert\Type(
     *      type="bool",
     *      message="Status de entraga real con auditoría debe ser verdadero o falso"
     * )
     */
    private $auditStatus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"read"})
     * @Assert\Type(
     *      type="bool",
     *      message="Status de entrega parcial con auditoría debe ser verdadero o falso"
     * )
     */
    private $auditStatusIncomplete;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projectProfiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="projectProfiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPax(): ?int
    {
        return $this->pax;
    }

    public function setPax(?int $pax): self
    {
        $this->pax = $pax;

        return $this;
    }

    public function getBudget()
    {
        return $this->budget;
    }

    public function setBudget($budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setBalance($balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getBalanceDate(): ?\DateTimeInterface
    {
        return $this->balanceDate;
    }

    public function setBalanceDate(?\DateTimeInterface $balanceDate): self
    {
        $this->balanceDate = $balanceDate;

        return $this;
    }

    public function getBilling()
    {
        return $this->billing;
    }

    public function setBilling($billing): self
    {
        $this->billing = $billing;

        return $this;
    }

    public function getBillingDate(): ?\DateTimeInterface
    {
        return $this->billingDate;
    }

    public function setBillingDate(?\DateTimeInterface $billingDate): self
    {
        $this->billingDate = $billingDate;

        return $this;
    }

    public function getRevenueProspection()
    {
        return $this->revenueProspection;
    }

    public function setRevenueProspection($revenueProspection): self
    {
        $this->revenueProspection = $revenueProspection;

        return $this;
    }

    public function getRevenuePercent(): ?int
    {
        return $this->revenuePercent;
    }

    public function setRevenuePercent(?int $revenuePercent): self
    {
        $this->revenuePercent = $revenuePercent;

        return $this;
    }

    public function getRevenue()
    {
        return $this->revenue;
    }

    public function setRevenue($revenue): self
    {
        $this->revenue = $revenue;

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

    public function getPaymentDays(): ?int
    {
        return $this->paymentDays;
    }

    public function setPaymentDays(?int $paymentDays): self
    {
        $this->paymentDays = $paymentDays;

        return $this;
    }

    public function getFinancialStatus(): ?bool
    {
        return $this->financialStatus;
    }

    public function setFinancialStatus(?bool $financialStatus): self
    {
        $this->financialStatus = $financialStatus;

        return $this;
    }

    public function getBillingStatus(): ?bool
    {
        return $this->billingStatus;
    }

    public function setBillingStatus(?bool $billingStatus): self
    {
        $this->billingStatus = $billingStatus;

        return $this;
    }

    public function getOperationStatus(): ?bool
    {
        return $this->operationStatus;
    }

    public function setOperationStatus(?bool $operationStatus): self
    {
        $this->operationStatus = $operationStatus;

        return $this;
    }

    public function getAuditStatus(): ?bool
    {
        return $this->auditStatus;
    }

    public function setAuditStatus(?bool $auditStatus): self
    {
        $this->auditStatus = $auditStatus;

        return $this;
    }

    public function getAuditStatusIncomplete(): ?bool
    {
        return $this->auditStatusIncomplete;
    }

    public function setAuditStatusIncomplete(?bool $auditStatusIncomplete): self
    {
        $this->auditStatusIncomplete = $auditStatusIncomplete;

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

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

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
