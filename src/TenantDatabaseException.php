<?php 

namespace gamerwalt\LaraMultiDbTenant;

use Exception;

class TenantDatabaseException extends Exception
{
    /**
     * @type string
     */
    protected $message;

    public function __construct($message, $previous, $code = 0)
    {
        $this->message = $message;

        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ': Error Code: ' . $this->code . ', Error Message: ' . $this->message;
    }

    public function getError()
    {
        return $this->message;
    }
} 