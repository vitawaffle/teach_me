<?php

namespace App\Unit\Validator\Password\Configurator;

use App\Validator\Password\Configurator\HardCodeRuleConfigurator;
use PHPUnit\Framework\TestCase;

class HardCodeRuleConfiguratorTest extends TestCase
{
    private HardCodeRuleConfigurator $configurator;

    protected function setUp(): void
    {
        $this->configurator = new HardCodeRuleConfigurator();
    }

    public function testGetValueWithHasBigLetterKeyShouldReturnTrue(): void
    {
        $this->assertTrue($this->configurator->getValue('hasBigLetter'));
    }

    public function testGetValueWithHasSmallLetterKeyShouldReturnTrue(): void
    {
        $this->assertTrue($this->configurator->getValue('hasSmallLetter'));
    }

    public function testGetValueWithNotExistingKeyShouldReturnNull(): void
    {
        $this->assertNull($this->configurator->getValue('notExisting'));
    }
}
