<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FormGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'form:generator {name} {--table=}';
    //TODO: php artisan form:generator back/generate/test --table=portfolio

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация формы на основе таблицы базы данных';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $options = $this->options();
        $schema = Schema::getColumnListing($this->option('table'));
        //print_r($schema);

        $content = "@extends('back.layouts.app')\n@section('content')\n";
        $content .= "{!! Form::open(['method' => 'post', 'route' => 'home']) !!}\n";

        foreach ($schema as $key => $name) {
            $type = DB::getSchemaBuilder()->getColumnType($this->option('table'), $name);
            $this->info($type);

            if ($name === 'id') {
                continue;
            }

            $group = null;
            $field = null;
            $label = "\t\t{!! Form::label('$name', '$name', ['class' => 'label-control']) !!}\n";

            if ($type === 'string') {
                $field = "\t\t{!! Form::text('$name', null, ['class' => 'form-control']) !!}\n";
            } else if ($type === 'text') {
                $field = "\t\t{!! Form::textarea('$name', null, ['class' => 'form-control']) !!}\n";
            } else if ($type === 'boolean') {
                $field = "\t\t{!! Form::checkbox('$name', 1, null, ['class' => 'checkbox']) !!}\n";
            } else if ($type === 'datetime') {
                $field = "\t\t{!! Form::date('$name', 'Y-m-d H:i:s', ['class' => 'form-control']) !!}\n";
            }

            if ($field) {
                $group = "\t<div class='form-group'>\n" . $label . $field . "\t</div>\n";
                $content .= $group;
            }
        }

        $btn = "\t\t{!! Form::submit('Отправить', ['class' => 'btn btn-success']) !!}\n";
        $btnGroup = "\t<div class='form-group'>\n" . $btn . "\t</div>\n";
        $content .= $btnGroup;
        $content .= "{!! Form::close() !!}\n@endsection";

        Storage::disk('views')->put($this->argument('name') . '.blade.php', $content);
        $view = Storage::disk('views')->path($this->argument('name') . '.blade.php');
        $this->info('Ресурс создан: ' . $view);
    }
}
