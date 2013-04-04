<?php

namespace Hellspite\AnnounceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Hellspite\AnnounceBundle\Entity\Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Hellspite\AnnounceBundle\Entity\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Post
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
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string $title
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $icon
     *
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @var text $text
     * @Gedmo\Translatable
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @Gedmo\Locale
     */
    private $locale;

    private $title_en;

    private $title_it;

    private $text_en;

    private $text_it;

    /**
     * @ORM\OneToMany(
     *   targetEntity="PostTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(PostTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true, nullable=true)
     */
    private $slug;

    public $file;

    public function getUploadsRoot(){
        return __DIR__.'/../../../../web/uploads/announce/';
    }

    public function removeIcon(){
        if($file = $this->getUploadsRoot().$this->getIcon())
            unlink($file);
        if($file = $this->getUploadsRoot().'thumb/'.$this->getIcon())
            unlink($file);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
        if(is_null($this->file))
            return;

        $this->setIcon($this->file->getClientOriginalName());
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if(is_null($this->file)){
            return;
        }

        $this->file->move($this->getUploadsRoot(), $this->icon);

        $thumb = new Imagine();

        $size = new Box(210, 210);

        $mode = ImageInterface::THUMBNAIL_OUTBOUND;

        $original = $this->getUploadsRoot().$this->icon; 

        $thumb->open($original)
            ->thumbnail($size, $mode)
            ->save($this->getUploadsRoot().'thumb/'.$this->icon)
        ;

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
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

    public function setTitleEn($t){
        $this->title_en = $t;

    }

    public function getTitleEn(){
        return $this->title_en;
    }

    public function setTitleIt($t){
        $this->title_it = $t;

    }

    public function getTitleIt(){
        return $this->title_it;
    }

    public function setTextEn($t){
        $this->text_en = $t;

    }

    public function getTextEn(){
        return $this->text_en;
    }

    public function setTextIt($t){
        $this->text_it = $t;

    }

    public function getTextIt(){
        return $this->text_it;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

}
