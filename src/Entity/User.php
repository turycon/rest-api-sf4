<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

use App\Controller\ResetPasswordAction;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *          },
 *          "put"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *              "denormalization_context"={
 *                  "groups"={"put"}
 *              },
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *          },
 *          "put-reset-password"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *              "method"="PUT",
 *              "path"="/users/{id}/reset-password",
 *              "controller"=ResetPasswordAction::class,
 *              "denormalization_context"={
 *                  "groups"={"reset-password"}
 *              }
 *          }
 *     },
 *     collectionOperations={
 *          "post"={
 *              "denormalization_context"={
 *                  "groups"={"post"}
 *              },
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     errorPath="username",
 *     message="Existe un registro con el mismo Nombre de Usuario"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="Existe un registro con el mismo Correo Electrónico"
 * )
 */
class User implements UserInterface, RegisterDateEntityInterface
{

    const ROLE_OPERATOR = 'ROLE_OPERATOR';
    const ROLE_SUPERVISOR = 'ROLE_SUPERVISOR';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_GUEST = 'ROLE_GUEST';

    const DEFAULT_ROLES = [self::ROLE_OPERATOR];


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get", "post"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     * @Assert\NotBlank(
     *      message = "Nombre de Usuario no debe estar vacio"
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 15,
     *      minMessage = "Nombre de Usuario debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Nombre de Usuario no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post"})
     * @Assert\NotBlank(
     *     message="Password no debe estar vacío",
     *     groups={"post"}
     * )
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="El Password debe tener 7 caractéres de longitud y contener por lo menos un número, una letra mayúscula y una letra minúscula",
     *     groups={"post"}
     * )
     */
    private $password;

    /**
     * @Groups({"post"})
     * @Assert\NotBlank(
     *     message="Repetir Password no debe estar vacío",
     *     groups={"post"}
     * )
     * @Assert\Expression(
     *     "this.getPassword() === this.getRetypedPassword()",
     *     message="Sus Passwords no coinciden",
     *     groups={"post"}
     * )
     */
    private $retypedPassword;

    /**
     * @Groups({"reset-password"})
     * @Assert\NotBlank(groups={"reset-password"})
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="El Password debe tener 7 caractéres de longitud y contener por lo menos un número, una letra mayúscula y una letra minúscula",
     *     groups={"reset-password"}
     * )
     */
    private $newPassword;


    /**
     * @Groups({"reset-password"})
     * @Assert\NotBlank(groups={"reset-password"})
     * @Assert\Expression(
     *     "this.getNewPassword() === this.getRetypedNewPassword()",
     *     message="Sus Passwords no coinciden",
     *     groups={"reset-password"}
     * )
     */
    private $retypedNewPassword;


    /**
     * @Groups({"reset-password"})
     * @Assert\NotBlank(groups={"reset-password"})
     * @UserPassword(groups={"reset-password"})
     * */
    private $oldPassword;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get-owner","get-admin", "post"})
     * @Assert\NotBlank(
     *      message = "Correo Electrónico no debe estar vacio"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 120,
     *      minMessage = "Correo Electrónico debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Correo Electrónico no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get", "post"})
     * @Assert\NotBlank(
     *      message = "Nombre Completo no debe estar vacio"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 120,
     *      minMessage = "Nombre Completo debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Nombre Completo no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get", "post"})
     * * @Assert\NotBlank(
     *      message = "Puesto no debe estar vacio"
     * )
     * @Assert\Length(
     *      min = 1,
     *      max = 120,
     *      minMessage = "Puesto debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Puesto no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"get", "post"})
     * @Assert\NotBlank(
     *      message = "Teléfono no debe estar vacio"
     * )
     * @Assert\Length(
     *      min = 8,
     *      max = 10,
     *      minMessage = "Teléfono debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Teléfono no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"get", "post"})
     * @Assert\NotBlank(
     *      message = "Celular no debe estar vacio"
     * )
     * @Assert\Length(
     *      min = 8,
     *      max = 10,
     *      minMessage = "Celular debe contener al menos {{ limit }} caractéres de longitud",
     *      maxMessage = "Celular no debe contener mas de  {{ limit }} caractéres"
     * )
     */
    private $mobil;

    /**
     * @ORM\Column(type="simple_array", length=200)
     * @Groups({"get-admin","get-owner"})
     * */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\State", mappedBy="usuario")
     */
    private $states;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Country", mappedBy="usuario")
     */
    private $countries;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Venue", mappedBy="usuario")
     */
    private $venues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="usuario")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Market", mappedBy="usuario")
     */
    private $markets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MainConfiguration", mappedBy="usuario")
     */
    private $mainConfigurations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="usuario")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billing", mappedBy="usuario")
     */
    private $billings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectProfile", mappedBy="usuario")
     */
    private $projectProfiles;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    public function __construct()
    {
        $this->states = new ArrayCollection();
        $this->countries = new ArrayCollection();
        $this->venues = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->markets = new ArrayCollection();
        $this->mainConfigurations = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->billings = new ArrayCollection();
        $this->projectProfiles = new ArrayCollection();

        // Valores por default en caso de que no tenga roles aún en la base de datos
        $this->roles = self::DEFAULT_ROLES;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMobil(): ?string
    {
        return $this->mobil;
    }

    public function setMobil(?string $mobil): self
    {
        $this->mobil = $mobil;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles){

        $this->roles = $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }


    public function getRetypedPassword()
    {
        return $this->retypedPassword;
    }


    public function setRetypedPassword($retypedPassword): void
    {
        $this->retypedPassword = $retypedPassword;
    }

    /**
     * @return Collection|State[]
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    public function addState(State $state): self
    {
        if (!$this->states->contains($state)) {
            $this->states[] = $state;
            $state->setUsuario($this);
        }

        return $this;
    }

    public function removeState(State $state): self
    {
        if ($this->states->contains($state)) {
            $this->states->removeElement($state);
            // set the owning side to null (unless already changed)
            if ($state->getUsuario() === $this) {
                $state->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Country[]
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->countries->contains($country)) {
            $this->countries[] = $country;
            $country->setUsuario($this);
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->countries->contains($country)) {
            $this->countries->removeElement($country);
            // set the owning side to null (unless already changed)
            if ($country->getUsuario() === $this) {
                $country->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Venue[]
     */
    public function getVenues(): Collection
    {
        return $this->venues;
    }

    public function addVenue(Venue $venue): self
    {
        if (!$this->venues->contains($venue)) {
            $this->venues[] = $venue;
            $venue->setUsuario($this);
        }

        return $this;
    }

    public function removeVenue(Venue $venue): self
    {
        if ($this->venues->contains($venue)) {
            $this->venues->removeElement($venue);
            // set the owning side to null (unless already changed)
            if ($venue->getUsuario() === $this) {
                $venue->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setUsuario($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getUsuario() === $this) {
                $client->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Market[]
     */
    public function getMarkets(): Collection
    {
        return $this->markets;
    }

    public function addMarket(Market $market): self
    {
        if (!$this->markets->contains($market)) {
            $this->markets[] = $market;
            $market->setUsuario($this);
        }

        return $this;
    }

    public function removeMarket(Market $market): self
    {
        if ($this->markets->contains($market)) {
            $this->markets->removeElement($market);
            // set the owning side to null (unless already changed)
            if ($market->getUsuario() === $this) {
                $market->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MainConfiguration[]
     */
    public function getMainConfigurations(): Collection
    {
        return $this->mainConfigurations;
    }

    public function addMainConfiguration(MainConfiguration $mainConfiguration): self
    {
        if (!$this->mainConfigurations->contains($mainConfiguration)) {
            $this->mainConfigurations[] = $mainConfiguration;
            $mainConfiguration->setUsuario($this);
        }

        return $this;
    }

    public function removeMainConfiguration(MainConfiguration $mainConfiguration): self
    {
        if ($this->mainConfigurations->contains($mainConfiguration)) {
            $this->mainConfigurations->removeElement($mainConfiguration);
            // set the owning side to null (unless already changed)
            if ($mainConfiguration->getUsuario() === $this) {
                $mainConfiguration->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setUsuario($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getUsuario() === $this) {
                $project->setUsuario(null);
            }
        }

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
            $billing->setUsuario($this);
        }

        return $this;
    }

    public function removeBilling(Billing $billing): self
    {
        if ($this->billings->contains($billing)) {
            $this->billings->removeElement($billing);
            // set the owning side to null (unless already changed)
            if ($billing->getUsuario() === $this) {
                $billing->setUsuario(null);
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
            $projectProfile->setUsuario($this);
        }

        return $this;
    }

    public function removeProjectProfile(ProjectProfile $projectProfile): self
    {
        if ($this->projectProfiles->contains($projectProfile)) {
            $this->projectProfiles->removeElement($projectProfile);
            // set the owning side to null (unless already changed)
            if ($projectProfile->getUsuario() === $this) {
                $projectProfile->setUsuario(null);
            }
        }

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

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    public function getRetypedNewPassword(): ?string
    {
        return $this->retypedNewPassword;
    }

    public function setRetypedNewPassword($retypedNewPassword): void
    {
        $this->retypedNewPassword = $retypedNewPassword;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

}
