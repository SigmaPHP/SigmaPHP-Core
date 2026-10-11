<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateMiddleware;

/**
 * Create Middleware Command Test
 */
class CreateMiddlewareTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'middlewares/AuthMiddleware.php';

        $command = $this->commandFactory(CreateMiddleware::class);

        $command->getArguments()['name']->setValue('Auth');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}
