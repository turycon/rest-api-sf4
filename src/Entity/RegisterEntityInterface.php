<?php
/**
 * Created by PhpStorm.
 * User: gerentent
 * Date: 2019-05-17
 * Time: 13:33
 */

namespace App\Entity;


use Symfony\Component\Security\Core\User\UserInterface;

interface RegisterEntityInterface
{
    public function setUsuario(UserInterface $user): RegisterEntityInterface;

}