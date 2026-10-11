<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateController;

/**
 * Create Controller Command Test
 */
class CreateControllerTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'controllers/UserController.php';

        $command = $this->commandFactory(CreateController::class);

        $command->getArguments()['name']->setValue('User');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}
