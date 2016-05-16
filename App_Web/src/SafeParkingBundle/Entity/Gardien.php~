<?php

namespace SafeParkingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gardien
 *
 * @ORM\Table(name="gardien")
 * @ORM\Entity(repositoryClass="SafeParkingBundle\Repository\GardienRepository")
 */
class Gardien
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="SafeParkingBundle\Entity\Garage", inversedBy="gardiens", cascade={"persist",
     *     "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $parking;

    /**
     * @ORM\ManyToOne(targetEntity="SafeParkingBundle\Entity\Proprietaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprietaire;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Gardien
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Gardien
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Gardien
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Gardien
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set parking
     *
     * @param \SafeParkingBundle\Entity\Garage $parking
     * @return Gardien
     */
    public function setParking(\SafeParkingBundle\Entity\Garage $parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return \SafeParkingBundle\Entity\Garage 
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set proprietaire
     *
     * @param \SafeParkingBundle\Entity\Proprietaire $proprietaire
     * @return Gardien
     */
    public function setProprietaire(\SafeParkingBundle\Entity\Proprietaire $proprietaire)
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * Get proprietaire
     *
     * @return \SafeParkingBundle\Entity\Proprietaire 
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }
}
