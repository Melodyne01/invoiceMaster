<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Votre prénom doit faire au moins {{ limit }} cacractères",
     *      maxMessage = "Votre prénom ne peut pas faire plus de {{ limit }} cacractères"
     * )
     */
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Votre nom doit faire au moins {{ limit }} cacractères",
     *      maxMessage = "Votre nom ne peut pas faire plus de {{ limit }} cacractères"
     * )
     */
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    /**
     * @Assert\Length(min="6", minMessage="Votre mot de passe doit faire minimum 6 caracteres")
     */
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passes ne correspondent pas !")
     */
    public $confirmPassword;

    #[ORM\Column(length: 255)]
    private ?string $accountType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(string $accountType): static
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsername() {
        return $this->getEmail();
    }
    /**
	 * Returns the roles granted to the user.
	 *
	 * public function getRoles()
	 * {
	 * return ['ROLE_USER'];
	 * }
	 *
	 * Alternatively, the roles might be stored in a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return array
	 */
	function getRoles(): array {
        return [$this->getAccountType()];
    }
	
	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 *
	 * @return mixed
	 */
	function eraseCredentials() {
    }
	
	/**
	 * Returns the identifier for this user (e.g. its username or email address).
	 *
	 * @return string
	 */
	function getUserIdentifier(): string {
        return $this->getId();
    }
}
