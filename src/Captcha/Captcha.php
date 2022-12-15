<?php

namespace Karim007\LaravelCaptcha\Captcha;

use Karim007\LaravelCaptcha\Captcha\Storage\StorageInterface;
use Karim007\LaravelCaptcha\Captcha\Generator\GeneratorInterface;
use Karim007\LaravelCaptcha\Captcha\Code\CodeInterface;

class Captcha
{
    /**
     * @var CodeInterface
     */
    private $code;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * Captcha parameters.
     *
     * @var array.
     */
    private $params = [];

    /**
     * Captcha constructor.
     *
     * @param CodeInterface $code
     * @param StorageInterface $storage
     * @param GeneratorInterface $generator
     * @param array $params
     */
    public function __construct(
        CodeInterface $code,
        StorageInterface $storage,
        GeneratorInterface $generator,
        array $params
    ) {
        $this->code      = $code;
        $this->storage   = $storage;
        $this->generator = $generator;
        $this->params    = $params;

        $this->params['background'] = is_array($this->params['background']) ? $this->params['background'] : [$this->params['background']];
        $this->params['colors']     = is_array($this->params['colors']) ? $this->params['colors'] : [$this->params['colors']];

        if (! file_exists($this->params['font'])) {
            $this->params['font'] = __DIR__ . '/../resources/fonts/IndiraK.ttf';
        }
    }

    /**
     * Output a PNG image.
     *
     * @return mixed
     */
    public function getImage()
    {
        $code = $this->code->generate(
            $this->params['chars'],
            $this->params['length'][0],
            $this->params['length'][1]
        );

        $this->storage->push($code);

        return $this->generator->render($code, $this->params);
    }

    /**
     * Captcha validation.
     *
     * @param string $code Code.
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function validate($code)
    {
        $correctCode = $this->storage->pull();

        if (! empty($correctCode)) {
            return mb_strtolower($correctCode) === mb_strtolower($code);
        }

        return false;
    }

    /**
     * Get html image tag.
     *
     * @return \Illuminate\Contracts\View\Factory | \Illuminate\View\View
     */
    public function getView(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('captcha::image', [
            'route'    => route('captcha.image') . '?' . mt_rand(),
            'title'    => trans('captcha::captcha.update_code'),
            'width'    => config('captcha.width'),
            'height'   => config('captcha.height'),
            'input_id' => config('captcha.inputId'),
        ]);
    }
}
