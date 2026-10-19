<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateView;

/**
 * Create View Command Test
 */
class CreateViewTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'templates/users_table.template.html';

        $command = $this->commandFactory(CreateView::class);

        $command->getArguments()['name']->setValue('users_table');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }

    /**
     * Test view won't be created if already exists.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testViewWillNotBeCreatedIfAlreadyExists()
    {
        $targetPath = 'templates/users_table.template.html';

        if (!file_exists($targetPath)) {
            touch($targetPath);
        }

        $this->ioHandler->setOutputStream(fopen('php://output', 'r+'));

        $command = $this->commandFactory(CreateView::class);

        $command->getArguments()['name']->setValue('users_table');

        $command->execute();

        $this->expectOutputRegex(
            "/The view 'users_table' already exists/"
        );

        if (file_exists($targetPath)) {
            unlink($targetPath);
        }
    }
}
