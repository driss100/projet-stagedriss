<?php

namespace SafeParkingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Garage
 *
 * @ORM\Table(name="garage")
 * @ORM\Entity(repositoryClass="SafeParkingBundle\Repository\GarageRepository")
 */
class Garage
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
     * @ORM\Column(name="latitude", type="float", length=255, unique=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="float", length=255)
     */
    private $longitude;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_place_total", type="integer")
     */
    private $nbPlaceTotal;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_place_libre", type="integer")
     */
    private $nbPlaceLibre;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_place_prise", type="integer")
     */
    private $nbPlacePrise;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_place_reserve", type="integer")
     */
    private $nbPlaceReserve;

    /**
     * @ORM\ManyToOne(targetEntity="SafeParkingBundle\Entity\Proprietaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprietaire;

    /**
     * @ORM\OneToMany(targetEntity="SafeParkingBundle\Entity\Gardien", mappedBy="parking", cascade={"persist",
     *     "remove"})
     */
    private $gardiens;

    public function __construct()
    {
        $this->nbPlacePrise = 0;
        $this->nbPlaceReserve = 0;
    }


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
     * @return Garage
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
     * Set latitude
     *
     * @param string $latitude
     * @return Garage
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Garage
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set nbPlaceTotal
     *
     * @param integer $nbPlaceTotal
     * @return Garage
     */
    public function setNbPlaceTotal($nbPlaceTotal)
    {
        $this->nbPlaceTotal = $nbPlaceTotal;

        return $this;
    }

    /**
     * Get nbPlaceTotal
     *
     * @return integer 
     */
    public function getNbPlaceTotal()
    {
        return $this->nbPlaceTotal;
    }

    /**
     * Set nbPlaceLibre
     *
     * @param integer $nbPlaceLibre
     * @return Garage
     */
    public function setNbPlaceLibre($nbPlaceLibre)
    {
        $this->nbPlaceLibre = $nbPlaceLibre;

        return $this;
    }

    /**
     * Get nbPlaceLibre
     *
     * @return integer 
     */
    public function getNbPlaceLibre()
    {
        return $this->nbPlaceLibre;
    }

    /**
     * Set nbPlacePrise
     *
     * @param integer $nbPlacePrise
     * @return Garage
     */
    public function setNbPlacePrise($nbPlacePrise)
    {
        $this->nbPlacePrise = $nbPlacePrise;

        return $this;
    }

    /**
     * Get nbPlacePrise
     *
     * @return integer 
     */
    public function getNbPlacePrise()
    {
        return $this->nbPlacePrise;
    }

    /**
     * Set nbPlaceReserve
     *
     * @param integer $nbPlaceReserve
     * @return Garage
     */
    public function setNbPlaceReserve($nbPlaceReserve)
    {
        $this->nbPlaceReserve = $nbPlaceReserve;

        return $this;
    }

    /**
     * Get nbPlaceReserve
     *
     * @return integer 
     */
    public function getNbPlaceReserve()
    {
        return $this->nbPlaceReserve;
    }

    /**
     * Set proprietaire
     *
     * @param \SafeParkingBundle\Entity\Proprietaire $proprietaire
     * @return Garage
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

    /**
     * Add gardiens
     *
     * @param \SafeParkingBundle\Entity\Gardien $gardiens
     * @return Garage
     */
    public function addGardien(\SafeParkingBundle\Entity\Gardien $gardiens)
    {
        $this->gardiens[] = $gardiens;

        return $this;
    }

    /**
     * Remove gardiens
     *
     * @param \SafeParkingBundle\Entity\Gardien $gardiens
     */
    public function removeGardien(\SafeParkingBundle\Entity\Gardien $gardiens)
    {
        $this->gardiens->removeElement($gardiens);
    }

    /**
     * Get gardiens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGardiens()
    {
        return $this->gardiens;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
