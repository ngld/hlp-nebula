<?php

/*
* Copyright 2014 HLP-Nebula authors, see NOTICE file
4
*
* Licensed under the EUPL, Version 1.1 or – as soon they
will be approved by the European Commission - subsequent
versions of the EUPL (the "Licence");
* You may not use this work except in compliance with the
Licence.
* You may obtain a copy of the Licence at:
*
*
http://ec.europa.eu/idabc/eupl
5
*
* Unless required by applicable law or agreed to in
writing, software distributed under the Licence is
distributed on an "AS IS" basis,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
express or implied.
* See the Licence for the specific language governing
permissions and limitations under the Licence.
*/ 

namespace HLP\NebulaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ORM\Table(name="hlp_nebula_file")
 * @ORM\Entity(repositoryClass="HLP\NebulaBundle\Entity\FileRepository")
 */
class File
{
    /**
     * @ORM\ManyToOne(targetEntity="HLP\NebulaBundle\Entity\Package", inversedBy="files")
     * @ORM\JoinColumn(nullable=false)
     */
    private $package;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="dest", type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     * @Assert\Regex(
     *     pattern="/^([\\\/]?[^\0\\\/:\*\?\x22<>\|]+)*[\\\/]?$/",
     *     message="The file destination must be a valid relative path."
     * )
     */
    private $dest;

    /**
     * @var array
     *
     * @ORM\Column(name="urls", type="array")
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one server where this file can be retrieved."
     * )
     * @Assert\All({
     *     @Assert\Url,
     *     @Assert\Length(max=255)
     * })
     */
    private $urls;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isArchive", type="boolean")
     */
    private $isArchive;


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
     * Set filename
     *
     * @param string $filename
     * @return File
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
     * Set dest
     *
     * @param string $dest
     * @return File
     */
    public function setDest($dest)
    {
        $this->dest = trim(str_replace('\\', '/', $dest), '/');

        return $this;
    }

    /**
     * Get dest
     *
     * @return string 
     */
    public function getDest()
    {
        return $this->dest;
    }

    /**
     * Set urls
     *
     * @param array $urls
     * @return File
     */
    public function setUrls($urls)
    {
        $this->urls = array_values($urls);

        return $this;
    }

    /**
     * Get urls
     *
     * @return array 
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Set isArchive
     *
     * @param boolean $isArchive
     * @return File
     */
    public function setIsArchive($isArchive)
    {
        $this->isArchive = $isArchive;

        return $this;
    }

    /**
     * Get isArchive
     *
     * @return boolean 
     */
    public function getIsArchive()
    {
        return $this->isArchive;
    }

    /**
     * Set package
     *
     * @param \HLP\NebulaBundle\Entity\Package $package
     * @return File
     */
    public function setPackage(\HLP\NebulaBundle\Entity\Package $package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return \HLP\NebulaBundle\Entity\Package 
     */
    public function getPackage()
    {
        return $this->package;
    }
    
    public function __clone()
    {
         if ($this->id) {
            $this->id = null;
         }
    }
}
