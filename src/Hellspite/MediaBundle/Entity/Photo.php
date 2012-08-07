<?php

namespace Hellspite\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hellspite\MediaBundle\Entity\Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="Hellspite\MediaBundle\Entity\PhotoRepository")
 */
class Photo
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string $caption
     *
     * @ORM\Column(name="caption", type="string", length=255)
     */
    private $caption;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="photos")
     * @ORM\JoinColumn(name="album", referencedColumnName="id")
     */
    protected $album;


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
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set caption
     *
     * @param string $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set album
     *
     * @param Hellspite\MediaBundle\Entity\Album $album
     */
    public function setAlbum(\Hellspite\MediaBundle\Entity\Album $album)
    {
        $this->album = $album;
    }

    /**
     * Get album
     *
     * @return Hellspite\MediaBundle\Entity\Album 
     */
    public function getAlbum()
    {
        return $this->album;
    }
}
