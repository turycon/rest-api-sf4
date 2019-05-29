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
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          }
 *     },
 *     collectionOperations={
 *          "get"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          },
 *          "post"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          }
 *     },
 *     normalizationContext={
 *          "groups"={"read"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\MainConfigurationRepository")
 */
class MainConfiguration implements RegisterEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días para entrega de Cierre no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días para entrega de Cierre no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="90",
     *     message="Días para entrega de Cierre debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días para entrega de Cierre debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $balanceDays;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días para emisión de factura no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días para emisión de factura no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="90",
     *     message="Días para emisión de factura debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días para emisión de factura debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $billingdays;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días para entrega a Finanzas no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días para entrega a Finanzas no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="90",
     *     message="Días para entrega a Finanzas debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días para entrega a Finanzas debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $financialdays;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días para entrega a Auditoría no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días para entrega a Auditoría no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="90",
     *     message="Días para entrega a Auditoría debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días para entrega a Auditoría debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $auditdays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días KPI Gobierno no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días KPI Gobierno no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="90",
     *     message="Días KPI Gobierno debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días KPI Gobierno debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $gobDays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días KPI Asociaciones no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días KPI Asociaciones no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="90",
     *     message="Días KPI Asociaciones debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días KPI Asociaciones debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $asocDays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Días KPI Corporativo no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Días KPI Corporativo no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="90",
     *     message="Días KPI Corporativo debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Días KPI Corporativo debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $corpDays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     * @Assert\NotBlank(
     *     message="Porcentaje de utilidad mínimo no debe estár vacio"
     * )
     * @Assert\NotNull(
     *      message = "Porcentaje de utilidad mínimo no debe contener valores NULL"
     * )
     * @Assert\LessThanOrEqual(
     *     value="100",
     *     message="Porcentaje de utilidad mínimo debe ser menor o igual que {{ limit }}"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value="1",
     *     message="Porcentaje de utilidad mínimo debe ser mayor o igual que {{ limit }}"
     * )
     */
    private $minPercentRevenue;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="mainConfigurations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalanceDays(): ?int
    {
        return $this->balanceDays;
    }

    public function setBalanceDays(?int $balanceDays): self
    {
        $this->balanceDays = $balanceDays;

        return $this;
    }

    public function getBillingdays(): ?int
    {
        return $this->billingdays;
    }

    public function setBillingdays(?int $billingdays): self
    {
        $this->billingdays = $billingdays;

        return $this;
    }

    public function getFinancialdays(): ?int
    {
        return $this->financialdays;
    }

    public function setFinancialdays(?int $financialdays): self
    {
        $this->financialdays = $financialdays;

        return $this;
    }

    public function getAuditdays(): ?int
    {
        return $this->auditdays;
    }

    public function setAuditdays(?int $auditdays): self
    {
        $this->auditdays = $auditdays;

        return $this;
    }

    public function getGobDays(): ?int
    {
        return $this->gobDays;
    }

    public function setGobDays(?int $gobDays): self
    {
        $this->gobDays = $gobDays;

        return $this;
    }

    public function getAsocDays(): ?int
    {
        return $this->asocDays;
    }

    public function setAsocDays(?int $asocDays): self
    {
        $this->asocDays = $asocDays;

        return $this;
    }

    public function getCorpDays(): ?int
    {
        return $this->corpDays;
    }

    public function setCorpDays(?int $corpDays): self
    {
        $this->corpDays = $corpDays;

        return $this;
    }

    public function getMinPercentRevenue(): ?int
    {
        return $this->minPercentRevenue;
    }

    public function setMinPercentRevenue(?int $minPercentRevenue): self
    {
        $this->minPercentRevenue = $minPercentRevenue;

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
}
