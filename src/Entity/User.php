<?php

// src/Entity/User.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=160, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=160, unique=true)
     * @Assert\NotBlank()
     */
    public $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="user_id")
     */
    private $yes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="users")
     */
    private $projects;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Module", inversedBy="yes")
     */
    private $module;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="author")
     */
    private $owned_projects;

    public function __construct() {
        $this->roles = array('ROLE_USER');
        $this->yes = new ArrayCollection();
        $this->project_id = new ArrayCollection();
        $this->module = new ArrayCollection();
        $this->owned_projects = new ArrayCollection();
    }

    // other properties and methods

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }


    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Project[]
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(Project $ye): self
    {
        if (!$this->yes->contains($ye)) {
            $this->yes[] = $ye;
            $ye->addUserId($this);
        }

        return $this;
    }

    public function removeYe(Project $ye): self
    {
        if ($this->yes->contains($ye)) {
            $this->yes->removeElement($ye);
            $ye->removeUserId($this);
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

    public function addProjects(Project $projects): self
    {
        if (!$this->projects->contains($projects)) {
            $this->projects[] = $projects;
            $projects->addUserId($this);
        }

        return $this;
    }

    public function removeProjects(Project $projects): self
    {
        if ($this->projects->contains($projects)) {
            $this->projects->removeElement($projects);
            $projects->removeUserId($this);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param mixed $roles
     *
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param mixed $yes
     *
     * @return self
     */
    public function setYes($yes)
    {
        $this->yes = $yes;

        return $this;
    }

    /**
     * @param mixed $project_id
     *
     * @return self
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModule(): Collection
    {
        return $this->module;
    }

    public function addModule(Module $module): self
    {
        if (!$this->module->contains($module)) {
            $this->module[] = $module;
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->module->contains($module)) {
            $this->module->removeElement($module);
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getOwnedProjects(): Collection
    {
        return $this->owned_projects;
    }

    public function addOwnedProject(Project $ownedProject): self
    {
        if (!$this->owned_projects->contains($ownedProject)) {
            $this->owned_projects[] = $ownedProject;
            $ownedProject->setAuthor($this);
        }

        return $this;
    }

    public function removeOwnedProject(Project $ownedProject): self
    {
        if ($this->owned_projects->contains($ownedProject)) {
            $this->owned_projects->removeElement($ownedProject);
            // set the owning side to null (unless already changed)
            if ($ownedProject->getAuthor() === $this) {
                $ownedProject->setAuthor(null);
            }
        }

        return $this;
    }

}