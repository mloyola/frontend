<?php

namespace Ecoin\FrontendBundle\Form\Model;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;



class Changepassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
     protected $oldPassword;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Password should by at least 6 chars long"
     * )
     */
     protected $newPassword;

    /**
     * Set oldPassword
     *
     * @param string $oldPassword     
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    
        return $this;
    }

    /**
     * Get oldPassword
     *
     * @return string 
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * Set newPassword
     *
     * @param string $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    
        return $this;
    }

    /**
     * Get oldPassword
     *
     * @return string 
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }
}
