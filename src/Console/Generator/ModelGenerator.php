<?php

namespace Rekamy\Generator\Console\Generator;

use DB;
use Rekamy\Generator\Console\RuleParser;
use Rekamy\Generator\Console\StubGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableCell;

trait ModelGenerator
{
    public function generateModels($outputDecorator)
    {

        try {
            $this->progress = $this->outputDecorator->createProgressBar(count($this->db['tables']));
            $this->progress->start();

            $this->output['rows'] = [];
            $separator = new TableSeparator;

            array_push($this->output['rows'], [new TableCell('<info>Models</info>')]);
            array_push($this->output['rows'], $separator);

            foreach ($this->db['tables'] as $table) {
                $view = view('generaltemplate::CreateModelTemplate')
                    ->with('db', (object) $this->db)
                    ->with('context', $this)
                    ->with('tablename', $table->TABLE_NAME);

                $stub = new StubGenerator(
                    $view->render(),
                    $this->path['model'] . ucfirst(Str::camel(Str::singular($table->TABLE_NAME))) . '.php'
                );

                $stub->render([
                    $stub
                ]);
                $response = ucfirst(Str::camel(Str::singular($table->TABLE_NAME))) . " Model Successfully Created";

                array_push($this->output['rows'], ['<comment>' . $response . '</comment>']);
                $this->progress->advance();
            }
            $outputDecorator->setRows($this->output['rows']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
