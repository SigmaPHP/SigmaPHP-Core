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

    /**
     * Test controller won't be created if already exists.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testControllerWillNotBeCreatedIfAlreadyExists()
    {
        $targetPath = 'controllers/UserController.php';

        if (!file_exists($targetPath)) {
            touch($targetPath);
        }

        $this->ioHandler->setOutputStream(fopen('php://output', 'r+'));

        $command = $this->commandFactory(CreateController::class);

        $command->getArguments()['name']->setValue('User');

        $command->execute();

        $this->expectOutputRegex(
            "/The controller 'UserController' already exists/"
        );

        if (file_exists($targetPath)) {
            unlink($targetPath);
        }
    }
}
