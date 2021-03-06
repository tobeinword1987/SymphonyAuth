<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users_hobbies
 *
 * @ORM\Table(name="users_hobbies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Users_hobbiesRepository")
 */
class Users_hobbies
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="hobbies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Interest", inversedBy="hobbies")
     * @ORM\JoinColumn(name="hobby_id", referencedColumnName="id")
     */
    private $interest;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="hobby_id", type="integer")
     */
    private $hobbyId;


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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Users_hobbies
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set hobbyId
     *
     * @param integer $hobbyId
     *
     * @return Users_hobbies
     */
    public function setHobbyId($hobbyId)
    {
        $this->hobbyId = $hobbyId;

        return $this;
    }

    /**
     * Get hobbyId
     *
     * @return int
     */
    public function getHobbyId($user)
    {
        return $this->hobbyId;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Users_hobbies
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set interest
     *
     * @param \AppBundle\Entity\Interest $interest
     *
     * @return Users_hobbies
     */
    public function setInterest(\AppBundle\Entity\Interest $interest = null)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return \AppBundle\Entity\Interest
     */
    public function getInterest()
    {
        return $this->interest;
    }
}
