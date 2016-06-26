<?php

namespace Develop\Business\Wishlist;

use Develop\Business\Wishlist\Exceptions\InvalidArgument;

class Status
{
    const PENDING = 'P';

    const SENT = 'S';

    private $status;

    private $availableStatus = [
        Status::PENDING,
        Status::SENT,
    ];

    /**
     * Status constructor.
     * @param string $status
     */
    protected function __construct($status)
    {
        $this->validate($status);
        $this->status = $status;
    }

    /**
     * @param string $status
     * @throws InvalidArgument
     */
    protected function validate($status)
    {
        if (!in_array($status, $this->availableStatus)) {
            throw InvalidArgument::invalidStatus($status, $this->availableStatus);
        }
    }

    /**
     * @param string $status
     * @return Status
     */
    public static function create($status)
    {
        return new static($status);
    }

    /**
     * @return Status
     */
    public static function pending()
    {
        return static::create(static::PENDING);
    }

    /**
     * @return Status
     */
    public static function sent()
    {
        return static::create(static::SENT);
    }

    /**
     * @param string $status
     * @return bool
     */
    public function is($status)
    {
        return $this->status === $status;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->status;
    }
}
