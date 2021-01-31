<?php

namespace Rekamy\Generator\Core\Generators;

use DB;
use Rekamy\Generator\Console\RuleParser;
use Rekamy\Generator\Console\StubGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableCell;

class CrudBaseVueGenerator
{
    private $context;

    private $tables;

    public function __construct($context)
    {
        $this->context = $context;
        $this->context->info("Creating Vue Base...");
        $this->tables = collect($this->context->db->listTableNames())
            ->filter(function ($item) {
                return !in_array($item, $this->context->excludeTables);
            });
    }

    public function generate()
    {
        try {
            foreach ($this->tables as $table) {
                $this->context->info("Creating Vue Base for Table $table ...");

                // $data['context'] = $this->context;
                $name = strlen($table) > 3 ? Str::of($table)->singular()  :  Str::of($table);
                $data['columns'] = collect($this->context->db->listTableColumns($table))
                    ->except([
                        'id', 'created_at', 'updated_at', 'created_by', 'updated_by',
                        'deleted_at', 'deleted_by', 'remark',
                    ]);
                $data['table'] = $name;
                $data['title'] = $name->replace('_', ' ')->title();
                $data['slug'] =  $name->slug();
                // $data['repoName'] = Str::of($table)->singular()->studly() . "Repository";
                // $data['requestName'] = Str::of($table)->singular()->studly() . "Request";

                $view = view('frontend::crud-flat/CrudBaseVue', $data);

                $stub = new StubGenerator(
                    $this->context,
                    $view->render(),
                    resource_path("frontend/src/views/crud/$name/base.vue")
                );

                $stub->render();
                $this->context->info("Vue Base for Table $table Created.");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}