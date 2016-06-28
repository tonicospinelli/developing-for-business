<?php

namespace Develop\Business\Wishlist\Exceptions;

class InvalidArgument extends \Exception implements Exception
{
    /**
     * @param string $email
     * @return InvalidArgument
     */
    public static function invalidEmail($email)
    {
        return new static("The email {$email} is not valid.");
    }

    /**
     * @param string $unknownStatus
     * @param array $knowStatusList
     * @return InvalidArgument
     */
    public static function invalidStatus($unknownStatus, array $knowStatusList)
    {
        return new static(
            sprintf(
                "The status %s is not valid. Only supports only the following status: %s",
                $unknownStatus,
                implode(', ', $knowStatusList)
            )
        );
    }
}
