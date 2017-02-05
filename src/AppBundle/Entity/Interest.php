<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interest
 *
 * @ORM\Table(name="interest")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InterestRepository")
 */
class Interest
{
    /**
     * @ORM\OneToMany(targetEntity="Users_hobbies", mappedBy="interest")
     */
    private $hobbies;

    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
    }
    
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
     * @ORM\Column(name="hobby", type="string", length=200, unique=true)
     */
    private $hobby;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hobby
     *
     * @param string $hobby
     *
     * @return Interest
     */
    public function setHobby($hobby)
    {
        $this->hobby = $hobby;

        return $this;
    }

    /**
     * Get hobby
     *
     * @return string
     */
    public function getHobby()
    {
        return $this->hobby;
    }

    /**
     * Add hobby
     *
     * @param \AppBundle\Entity\Users_hobbies $hobby
     *
     * @return Interest
     */
    public function addHobby(\AppBundle\Entity\Users_hobbies $hobby)
    {
        $this->hobbies[] = $hobby;

        return $this;
    }

    /**
     * Remove hobby
     *
     * @param \AppBundle\Entity\Users_hobbies $hobby
     */
    public function removeHobby(\AppBundle\Entity\Users_hobbies $hobby)
    {
        $this->hobbies->removeElement($hobby);
    }

    /**
     * Get hobbies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }
}
