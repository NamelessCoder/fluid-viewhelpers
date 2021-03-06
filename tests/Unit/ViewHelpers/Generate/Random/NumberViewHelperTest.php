<?php
namespace TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\Generate\Random;

/*
 * This file is part of the TYPO3/FluidViewHelpers project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\FluidViewHelpers\Tests\Unit\ViewHelpers\AbstractViewHelperTestCase;

/**
 * Class NumberViewHelperTest
 */
class NumberViewHelperTest extends AbstractViewHelperTestCase
{

    /**
     * @test
     */
    public function generatesRandomNumberWithoutDecimalsAsDefault()
    {
        $arguments = ['minimum' => 0, 'maximum' => 999999];
        $result1 = $this->executeViewHelper($arguments);
        $result2 = $this->executeViewHelper($arguments);
        $this->assertThat($result1, new \PHPUnit_Framework_Constraint_IsType(\PHPUnit_Framework_Constraint_IsType::TYPE_INT));
        $this->assertThat($result2, new \PHPUnit_Framework_Constraint_IsType(\PHPUnit_Framework_Constraint_IsType::TYPE_INT));
        $this->assertNotEquals($result1, $result2);
    }

    /**
     * @test
     */
    public function generatesRandomNumberWithoutDecimalsGivenArguments()
    {
        $arguments = ['minimum' => 0, 'maximum' => 999999, 'minimumDecimals' => 0, 'maximumDecimals' => 0];
        $result1 = $this->executeViewHelper($arguments);
        $result2 = $this->executeViewHelper($arguments);
        $this->assertThat($result1, new \PHPUnit_Framework_Constraint_IsType(\PHPUnit_Framework_Constraint_IsType::TYPE_INT));
        $this->assertThat($result2, new \PHPUnit_Framework_Constraint_IsType(\PHPUnit_Framework_Constraint_IsType::TYPE_INT));
        $this->assertNotEquals($result1, $result2);
    }

    /**
     * @test
     */
    public function generatesRandomNumberWithDecimalsGivenArguments()
    {
        $arguments = ['minimum' => 0, 'maximum' => 999999, 'minimumDecimals' => 2, 'maximumDecimals' => 8];
        $result1 = $this->executeViewHelper($arguments);
        $result2 = $this->executeViewHelper($arguments);
        $this->assertThat($result1, new \PHPUnit_Framework_Constraint_IsType(\PHPUnit_Framework_Constraint_IsType::TYPE_FLOAT));
        $this->assertThat($result2, new \PHPUnit_Framework_Constraint_IsType(\PHPUnit_Framework_Constraint_IsType::TYPE_FLOAT));
        $this->assertNotEquals($result1, $result2);
    }
}
