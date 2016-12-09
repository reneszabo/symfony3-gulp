<?php

namespace AppBundle\Entity;

use AppBundle\Model\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContactMe
 *
 * @ORM\Table(name="contact_me")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactMeRepository")
 */
class ContactMe extends EntityBase
{

  /**
   * @var string
   * @ORM\Column(name="username", type="string", length=64, nullable=false)
   * @Assert\NotBlank()
   * @Assert\Email()
   */
  protected $username;

  /**
   * @var String $comment
   * @ORM\Column(name="comment", type="text", nullable=false)
   * @Assert\NotBlank()
   */
  protected $comment;


    /**
     * Set username
     *
     * @param string $username
     *
     * @return ContactMe
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return ContactMe
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
