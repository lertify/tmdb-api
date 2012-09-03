<?php

namespace Lertify\TMDb\Api\Data\Authentication;

use Lertify\TMDb\Api\Data\AbstractData;

class Token extends AbstractData
{

    public $header;
    public $expires_at;
    public $request_token;
    public $success;

    public function getAuthenticationCallback() {
        return (isset($this->header['Authentication-Callback']) ? $this->header['Authentication-Callback'] : null);
    }

}
