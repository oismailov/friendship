<?php

namespace Acme\FriendshipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="RelationshipRepository")
 * @ORM\Table(name="relationship")
 * @ORM\HasLifecycleCallbacks
 */
class Relationship
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="relationship")
     * @ORM\JoinColumn(name="user_one_id", referencedColumnName="id")
     */

    protected $user_one_id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="relationship")
     * @ORM\JoinColumn(name="user_two_id", referencedColumnName="id")
     */

    protected $user_two_id;

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
     * Set userOneId
     *
     * @param integer $userOneId
     *
     * @return Relationship
     */
    public function setUserOneId($userOneId)
    {
        $this->user_one_id = $userOneId;

        return $this;
    }

    /**
     * Get userOneId
     *
     * @return integer
     */
    public function getUserOneId()
    {
        return $this->user_one_id;
    }

    /**
     * Set userTwoId
     *
     * @param integer $userTwoId
     *
     * @return Relationship
     */
    public function setUserTwoId($userTwoId)
    {
        $this->user_two_id = $userTwoId;

        return $this;
    }

    /**
     * Get userTwoId
     *
     * @return integer
     */
    public function getUserTwoId()
    {
        return $this->user_two_id;
    }
}
