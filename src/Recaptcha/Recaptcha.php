<?php

namespace App\Recaptcha;

class RecaptchaV3Service
{
    /** @var String*/
    protected $scorethreshold;

    /** @var ReCaptcha*/
    protected  $recaptchaClient;

    /**
     * RecaptchaV3Service constructor.
     * @param String $secret
     * @param String $scorethreshold
     */
    public function __construct(String $secret,String $scorethreshold)
    {
        $this->scorethreshold = $scorethreshold;
        $this->recaptchaClient = new ReCaptcha($secret);
    }

    /**
     * @param $token
     * @return mixed
     * @throws InvalidRecaptchaException
     */
    public function verify($token)
    {
        $response = $this->recaptchaClient->setScoreThreshold($this->scorethreshold)
            ->verify($token);
        return $response->isSuccess();
    }
}