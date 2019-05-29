<?php
/**
 * Created by PhpStorm.
 * User: gerentent
 * Date: 2019-05-21
 * Time: 16:55
 */

namespace App\Serializer;


use App\Entity\User;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;


class UserAttributeNormalizer implements ContextAwareNormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    const USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED = 'USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function supportsNormalization(
        $data,
        $format = null,
        array $context = []
    ){
        if (isset($context[self::USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED])){
            return false;
        }

        return $data instanceof User;
    }


    public function normalize($object, $format = null, array $context = [])
    {
        if ($this->isUserHimself($object)){
            $context['groups'][] = 'get-owner';
        }

        // Ahora serializamos
        return $this->passOn($object, $format, $context);
    }

    private function isUserHimself($object)
    {
        return $object->getUsername() === $this->tokenStorage->getToken()->getUsername();
    }

    private function passOn($object, $format, array $context)
    {
        if ($this->serializer instanceof NormalizableInterface){
            throw new \LogicException(
                sprintf(
                    'No es posible normalizar el objeto "%s" por que el serializador inyectado no es un normalizador',
                    $object
                )
            );
        }

        $context[self::USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED] = true;

        return $this->serializer->normalize($object, $format, $context);

    }

}