<?php

namespace Hellspite\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

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

    public $file;

    public function getUploadsRoot(){
        return __DIR__.'/../../../../web/uploads/photo/';
    }

    public function removeImage(){
        if($file = $this->getUploadsRoot().$this->getImage())
            unlink($file);
        if($file = $this->getUploadsRoot().'thumb/'.$this->getImage())
            unlink($file);
    }

    /**
     * @ORM\prePersist()
     * @ORM\preUpdate()
     */
    public function preUpload(){
        if(is_null($this->file))
            return;

        $this->setImage($this->file->getClientOriginalName());
    }

    /**
     * @ORM\postPersist()
     * @ORM\postUpdate()
     */
    public function upload(){
        if(is_null($this->file)){
            return;
        }

        $this->file->move($this->getUploadsRoot(), $this->image);

        $thumb = new Imagine();

        $size = new Box(144, 144);

        $mode = ImageInterface::THUMBNAIL_OUTBOUND;

        $original = $this->getUploadsRoot().$this->image; 

        $thumb->open($original)
            ->thumbnail($size, $mode)
            ->save($this->getUploadsRoot().'thumb/'.$this->image)
        ;

        unset($this->file);
    }

    /**
     * @ORM\postRemove()
     */
    public function removeUpload(){
        if($this->getImage() != '')
            $this->removeImage();
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
