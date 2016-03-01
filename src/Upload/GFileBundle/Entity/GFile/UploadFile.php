<?php

namespace Upload\GFileBundle\Entity\GFile;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * upload
 *
 * @ORM\Table(name="UploadFile")
 * @ORM\Entity(repositoryClass="Upload\GfileBundle\Repository\UploadFileRepository")
 */
class UploadFile
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;
    
        /**
     * @var datetime
     *
     * @ORM\Column(name="upload_at", type="datetime")
     */
    private $upload_at;
    
    /**
    *@Assert\File(maxSize="100000000")
    *
    */
    private $file;
    
    public function __construct() {
        $this->upload_at=new \DateTime();
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
     * Set name
     *
     * @param string $name
     * @return upload
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return upload
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
     * Set filename
     *
     * @param string $upload_at
     * @return upload
     */
    public function setUpload_at($upload_at)
    {
        $this->upload_at = $upload_at;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getUpload_at()
    {
        return $this->upload_at;
    }
    
       /**
     * Set filename
     *
     * @param string $filename
     * @return upload
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    
      /**
    * Get path upload
    *@return string
    *Relative path
    */
    public function getUploadPath(){
        return 'IT\UploadFile';
    }

    /**
    * Get absolute path upload
    *@return string
    *Absolute path
    */
    public function getUploadAbsolutePath(){
       // return __DIR__.'/../../../../web/'.$this->getUploadPath();
        return '\\\seneca.local\\FS\\Groups\\'.$this->getUploadPath();
    }

    /**
    *@return string
    *Relative Path
    *
    */
    public function getFileWeb(){
        return NULL ===$this->getFilename()
        ? NULL
        : $this->getUploadPath().'/'.$this->getFilename();
    }


    /**
    *@return string
    *Absolute Path
    *
    */
    public function getFileAbsolute(){
        return NULL ===$this->getFilename()
        ? NULL
        : $this->getUploadAbsolutePath().'/'.$this->getFilename();
    }
    
    /**
    *Sets File
    *@param UploadedFile
    */
    public function setFile(UploadedFile $file=NULL){
        $this->file=$file;
    }

    /**
    *Get File
    *@return UploadedFile
    */
    public function getFile(){
        return $this->file;
    }

    /**
    *Upload Cover photo
    */
    public function upload(){
        if(NULL===$this->getFile()){
            return ;
        }
        $filename=$this->getFile()->getClientOriginalName();
        $this->getFile()->move($this->getUploadAbsolutePath(),$filename);
        $this->setFilename($filename);
        $this->setFile();
    }
}