<?php
/**
 * Created by PhpStorm.
 * User: gerentent
 * Date: 2019-05-17
 * Time: 14:14
 */

namespace App\Entity;


interface RegisterDateEntityInterface
{
    /**
     * @param \DateTimeInterface $createDate
     * @return RegisterDateEntityInterface
     */
    public function setCreateDate(\DateTimeInterface $createDate): RegisterDateEntityInterface;

}