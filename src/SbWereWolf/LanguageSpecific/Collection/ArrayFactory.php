<?php
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/29/24, 6:24 AM
 */

declare(strict_types=1);
/*
 * @package  LanguageSpecific
 * @author   SbWereWolf <ulfnew@gmail.com>
 * @link     https://github.com/SbWereWolf/language-specific
 *
 * Copyright © 2024 Volkhin Nikolay
 * 12/26/24, 9:40 PM
 */

namespace SbWereWolf\LanguageSpecific\Collection;

use SbWereWolf\LanguageSpecific\Value\CommonValueFactory;
use SbWereWolf\LanguageSpecific\Value\CommonValueFactoryInterface;

class ArrayFactory implements ArrayFactoryInterface
{
    protected readonly CommonValueFactoryInterface $valueFactory;

    public function __construct(
        CommonValueFactoryInterface|null $factory = null
    ) {
        if (is_null($factory)) {
            $factory = new CommonValueFactory();
        }

        $this->valueFactory = $factory;
    }

    /** @inheritDoc */
    public function makeBaseArray(mixed $data): BaseArrayInterface
    {
        $data = $this->makeItProper($data);

        return new BaseArray($data, $this->valueFactory);
    }

    /**
     * @param mixed $data
     * @return array
     */
    protected function makeItProper(mixed $data): array
    {
        $isProper = is_array($data);
        if (!$isProper) {
            $data = [$data];
        }
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $data = array_replace([], $data);

        return $data;
    }

    /** @inheritDoc */
    public function makeCommonArray(mixed $data): CommonArrayInterface
    {
        $data = $this->makeItProper($data);

        return new CommonArray($data, $this->valueFactory);
    }
}