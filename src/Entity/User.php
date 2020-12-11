<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Un compte existe déjà avec cette adresse email.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="Le prénom doit faire plus de 3 caractères.")
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=2, minMessage="Le prénom doit faire plus de 2 caractères.")
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(message="La valeur entrée n'est pas une adresse email valide.")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length (min=8, minMessage="Le mot de passe doit faire plus de 8 caractères.")
     * @Assert\Regex(
     *      pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/",
     *      message="Le mot de passe doit contenir des chiffres, des lettres miniscules et majuscules.")
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**

     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="idUser")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function __toString() {
        return strval($this->id);
    }
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $mariadb_user = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $mariadb_password = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pgsql_user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pgsql_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sqlite_path;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;

    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function getName() {
        return $this->getFirstname() . " " . $this->getLastname();
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setIdUser($this);
        }
    }

    public function getMariadbUser(): ?string
    {
        return $this->mariadb_user;
    }

    public function setMariadbUser(?string $mariadb_user): self
    {
        $this->mariadb_user = $mariadb_user;
        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdUser() === $this) {
                $comment->setIdUser(null);
            }
        }
    }

    public function getMariadbPassword(): ?string
    {
        return $this->mariadb_password;
    }

    public function setMariadbPassword(?string $mariadb_password): self
    {
        $this->mariadb_password = $mariadb_password;
        return $this;
    }

    public function getPgsqlUser(): ?string
    {
        return $this->pgsql_user;
    }

    public function setPgsqlUser(string $pgsql_user): self
    {
        $this->pgsql_user = $pgsql_user;

        return $this;
    }

    public function getPgsqlPassword(): ?string
    {
        return $this->pgsql_password;
    }

    public function setPgsqlPassword(string $pgsql_password): self
    {
        $this->pgsql_password = $pgsql_password;

        return $this;
    }

    public function getSqlitePath(): ?string
    {
        return $this->sqlite_path;
    }

    public function setSqlitePath(string $sqlite_path): self
    {
        $this->sqlite_path = $sqlite_path;
        return $this;
    }
}
