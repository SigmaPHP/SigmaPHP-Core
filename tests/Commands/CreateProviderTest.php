<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateProvider;

/**
 * Create Provider Command Test
 */
class CreateProviderTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'providers/UserServiceProvider.php';

        $command = $this->commandFactory(CreateProvider::class);

        $command->getArguments()['name']->setValue('User');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}
