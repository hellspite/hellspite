<?php

namespace Hellspite\GigBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

/**
 * Hellspite\GigBundle\Entity\Gig
 *
 * @ORM\Table(name="gig")
 * @ORM\Entity(repositoryClass="Hellspite\GigBundle\Entity\GigRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Gig
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string $venue
     *
     * @ORM\Column(name="venue", type="string", length=255)
     */
    private $venue;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var text $text
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var string $icon
     *
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @Gedmo\Slug(fields={"venue"})
     * @ORM\Column(length=128, unique=true, nullable=true)
     */
    private $slug;

    public $file;

    public function getUploadsRoot(){
        return __DIR__.'/../../../../web/uploads/gig/';
    }

    public function removeIcon(){
        if($file = $this->getUploadsRoot().$this->getIcon())
            unlink($file);
        if($file = $this->getUploadsRoot().'thumb/'.$this->getIcon())
            unlink($file);
    }

    /**
     * @ORM\prePersist()
     * @ORM\preUpdate()
     */
    public function preUpload(){
        if(is_null($this->file))
            return;

        $this->setIcon($this->file->getClientOriginalName());
    }

    /**
     * @ORM\postPersist()
     * @ORM\postUpdate()
     */
    public function upload(){
        if(is_null($this->file)){
            return;
        }

        $this->file->move($this->getUploadsRoot(), $this->icon);

        $thumb = new Imagine();

        $size = new Box(110, 110);

        $mode = ImageInterface::THUMBNAIL_OUTBOUND;

        $original = $this->getUploadsRoot().$this->icon; 

        $thumb->open($original)
            ->thumbnail($size, $mode)
            ->save($this->getUploadsRoot().'thumb/'.$this->icon)
        ;

        unset($this->file);
    }

    /**
     * @ORM\postRemove()
     */
    public function removeUpload(){
        if($this->getIcon() != '')
            $this->removeIcon();
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        if(is_string($date))
            $this->date = new \DateTime($date);
        else
            $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set text
     *
     * @param text $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return text 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set icon
     *
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set venue
     *
     * @param string $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * Get venue
     *
     * @return string 
     */
    public function getVenue()
    {
        return $this->venue;
    }
}