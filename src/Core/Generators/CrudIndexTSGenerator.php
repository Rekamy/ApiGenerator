<?php

namespace Rekamy\Generator\Core\Generators;

use DB;
use Rekamy\Generator\Console\RuleParser;
use Rekamy\Generator\Console\StubGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableCell;

class CrudIndexTSGenerator
{
    private $context;

    private $tables;

    public function __construct($context)
    {
        $this->context = $context;
        $this->context->info("Creating TS Index...");
        $this->tables = collect($this->context->db->listTableNames())
            ->filter(function ($item) {
                return !in_array($item, $this->context->excludeTables);
            });
    }

    public function generate()
    {
        try {
            foreach ($this->tables as $table) {
                $this->context->info("Creating TS Index for Table $table ...");

                $data['context'] = $this->context;
                $data['table'] = Str::of($table);
                $data['title'] =  Str::of($table)->singular()->title();
                $data['camelId'] = Str::of($table)->singular()->camel();
                $data['slugId'] =  Str::of($table)->singular()->slug();
                $data['studly'] =  Str::of($table)->singular()->studly();
                $data['columns'] = collect($this->context->db->listTableColumns($table))
                    ->except([
                        'id', 'created_at', 'updated_at', 'created_by', 'updated_by',
                        'deleted_at', 'deleted_by', 'remark',
                    ]);
                $data['className'] = Str::of($table)->singular()->studly() . "Bloc";
                $data['repoName'] = Str::of($table)->singular()->studly() . "Repository";
                $data['requestName'] = Str::of($table)->singular()->studly() . "Request";

                $view = view('frontend::crud-flat/CrudIndexTS', $data);

                $stub = new StubGenerator(
                    $this->context,
                    $view->render(),
                    resource_path("frontend/src/views/crud/{$table->singular()}/index.ts")
                );

                $stub->render();
                $this->context->info("TS Index for Table $table Created.");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
