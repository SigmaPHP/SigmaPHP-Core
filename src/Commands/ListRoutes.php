<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

/**
 * List Routes Command.
 */
class ListRoutes extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('list:routes');
        $this->setDescription('List all defined routes in the app');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $data = [];
        $header = ['Method', 'Path', 'Controller', 'Action', 'Name'];

        foreach (container('router')->listRoutes() as $route) {
            $row = [' ', ' ', ' ', ' ', ' '];

            if (isset($route['method'])) {
                $row[0] = implode(',', $route['method']);
            }

            if (isset($route['path'])) {
                $row[1] = '/' . $route['path'];
            }

            if (isset($route['controller'])) {
                $row[2] = $route['controller'] ?: ' ';
            }

            if (isset($route['action'])) {
                $row[3] = $route['action'];
            }

            if (isset($route['name'])) {
                if (!is_numeric($route['name'])) {
                    $row[4] = $route['name'];
                }
            }

            $data[] = $row;
        }

        $this->table->create($header, $data);
    }
}
