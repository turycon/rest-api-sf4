<?php
/**
 * Created by PhpStorm.
 * User: gerentent
 * Date: 2019-05-27
 * Time: 11:32
 */

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;

class ResetPassword
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {

        $this->validator = $validator;
    }


    public function __invoke(User $data)
    {
        // $reset = new ResetPassword();
        // $reset();

        /**
         * var_dump(
                $data->getNewPassword(),
                $data->getNewRetypedPassword(),
                $data->getOldPassword(),
                $data->getRetypedPassword(),
                $data->getPassword(),
                $data->getEmail(),
                $data->getCreateDate(),
                $data->getFullname(),
                $data->getUsername(),
                $data->getPosition(),
                $data->getPhone(),
                $data->getMobil(),
                $data->getRoles()
            );

                die;
         */

        // $context['groups'] = ['put-reset-password'];

        $this->validator->validate($data);


    }
}