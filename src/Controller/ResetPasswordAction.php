<?php
/**
 * Created by PhpStorm.
 * User: gerentent
 * Date: 2019-05-27
 * Time: 18:23
 */

namespace App\Controller;


use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;

class ResetPasswordAction
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
        $data->getRetypedNewPassword(),
        $data->getOldPassword(),
        $data->getPassword(),
        $data->getEmail(),
        $data->getCreateDate(),
        $data->getFullname(),
        $data->getUsername(),
        $data->getPosition(),
        $data->getPhone(),
        $data->getMobil(),
        $data->getRoles(),
        $data->getRetypedPassword()
        );

        die;
         */

        // $context['groups'] = ['put-reset-password'];

        $this->validator->validate($data);


    }

}