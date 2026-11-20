<?php
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\Random;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class phpAES
{
    /**
     * AES instance.
     *
     * @var AES
     */
    protected $aes;

    CONST MODE_CTR    = -1;
    CONST MODE_ECB    = 1;
    CONST MODE_CBC    = 2;
    const MODE_CFB    = 3;
    const MODE_OFB    = 4;
    const MODE_STREAM = 5;

    const ENGINE_INTERNAL = 1;
    const ENGINE_EVAL     = 2;
    const ENGINE_MCRYPT   = 3;
    const ENGINE_OPENSSL  = 4;

    public function init($key, $iv)
    {
        $this->aes = new AES('cbc');
        $this->aes->setKey($key);
        $this->aes->setIV($iv);
    }

    public function encrypt($output)
    {
        return $this->aes->encrypt($output);
    }

    public function decrypt($input)
    {
        return $this->aes->decrypt($input);
    }

    public function getEngine()
    {
        return match($this->aes->getEngine())
        {
            'PHP'     => 'ENGINE_INTERNAL',
            'Eval'    => 'ENGINE_EVAL',
            'mcrypt'  => 'ENGINE_MCRYPT',
            'OpenSSL' => 'ENGINE_OPENSSL',
            default   => 'error',
        };
    }

    public static function randomString($length)
    {
        return Random::string($length);
    }
}
