<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass= "App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface, PasswordHasherAwareInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=25, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=250, nullable=false)
     */
    private $mdp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_inscription", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateInscription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip_inscription", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $ipInscription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tracker", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $tracker;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role_utilisateur", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $roleUtilisateur;

    /**
     * @ORM\Column(name="verification", type="boolean", nullable=false)
     */
    private $isVerified = false;


    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return (string) $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(?\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getIpInscription(): ?string
    {
        return $this->ipInscription;
    }

    public function setIpInscription(?string $ipInscription): self
    {
        $this->ipInscription = $ipInscription;

        return $this;
    }

    public function getTracker(): ?string
    {
        return $this->tracker;
    }

    public function setTracker(?string $tracker): self
    {
        $this->tracker = $tracker;

        return $this;
    }

    public function getRoleUser(): ?string
    {
        return $this->roleUtilisateur;
    }

    public function setRoleUser(?string $roleUtilisateur): self
    {
        $this->roleUtilisateur = $roleUtilisateur;

        return $this;
    }

    public function getRoles(): array
    {
        // guarantee every user at least has ROLE_USER
        $roles=[$this->roleUtilisateur];

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
        // TODO: Implement getUserIdentifier() method.
    }
    public function getSalt(): ?string
{
    return null;
}

public function getPasswordHasherName(): ?string

{

    return null; // use the default hasher

}
public function getPassword(): string
    {
        return $this->mdp;
    }

    public function setPassword(string $password): self
    {
        $this->mdp = $password;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}


