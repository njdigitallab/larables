<?php

namespace NjDigitalLab\Larables\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use NjDigitalLab\Larables\Larables;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

#[Signature('larables:table {name : The table name}')]
#[Description('Create a table.')]
class MakeTableCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        new Filesystem()->ensureDirectoryExists($this->tableDirectory());

        $this->createTableStub();
        $this->createActiveTableStub();
        $this->createTrashTableStub();

        $this->info('Table created successfully!');
    }

    /**
     * Create the table stub.
     */
    protected function createTableStub(): void
    {
        $search = [
            '{namespace}', '{classname}', 
        ];

        $replace = [
            $this->tableNamespace(),
            $this->tableClassname(),
        ];

        $filepath = Larables::stubsPath().'/Table.php';
        $content = str_replace($search, $replace, File::get($filepath));

        File::put($this->tableDirectory().'/'.$this->tableClassname().'.php', $content);
    }

    /**
     * Create the active table stub.
     */
    protected function createActiveTableStub(): void
    {
        $search = [
            '{namespace}', '{classname}', '{extendclassname}',
        ];

        $replace = [
            $this->tableNamespace(),
            $this->activeTableClassname(),
            $this->tableClassname(),
        ];

        $filepath = Larables::stubsPath().'/ActiveTable.php';
        $content = str_replace($search, $replace, File::get($filepath));

        File::put($this->tableDirectory().'/'.$this->activeTableClassname().'.php', $content);
    }

    /**
     * Create the trash table stub.
     */
    protected function createTrashTableStub(): void
    {
        $search = [
            '{namespace}', '{classname}', '{extendclassname}', 
        ];

        $replace = [
            $this->tableNamespace(),
            $this->trashTableClassname(),
            $this->tableClassname(),
        ];

        $filepath = Larables::stubsPath().'/TrashTable.php';
        $content = str_replace($search, $replace, File::get($filepath));

        File::put($this->tableDirectory().'/'.$this->trashTableClassname().'.php', $content);
    }

    /**
     * Get the relative path for the file being created.
     */
    protected function relativePath(): string
    {
        return rtrim($this->argument('name'), $this->tableClassname());
    }

    /**
     * Get the table name.
     */
    protected function tableClassname(): string
    {
        $name = ucfirst($this->argument('name'));

        preg_match('/(?<=\/){0,1}[A-Z]{1}\w*$/', $name, $matches);

        return $matches[0].'Table';
    }

    /**
     * Get the active table name.
     */
    protected function activeTableClassname(): string
    {
        $name = ucfirst($this->argument('name'));

        preg_match('/(?<=\/){0,1}[A-Z]{1}\w*$/', $name, $matches);

        return $matches[0].'ActiveTable';
    }

    /**
     * Get the trash table name.
     */
    protected function trashTableClassname(): string
    {
        $name = ucfirst($this->argument('name'));

        preg_match('/(?<=\/){0,1}[A-Z]{1}\w*$/', $name, $matches);

        return $matches[0].'TrashTable';
    }

    /**
     * Get the name of the policy directory.
     */
    protected function tableDirectory(): string
    {
        $name = ucfirst($this->argument('name'));

        preg_match('/(?<=\/){0,1}[A-Z]{1}\w*$/', $name, $matches);

        return app_path('Tables/'.rtrim($this->relativePath(), '/').'/'.$matches[0]);
    }

    /**
     * Get the file namespace.
     */
    protected function tableNamespace(): string
    {
        return rtrim('App\Tables\\'.str_replace('/', '\\', $this->relativePath()), '\\').'\\'.$this->basename();
    }

    /**
     * Get the basename.
     */
    protected function basename(): string
    {
        $name = ucfirst($this->argument('name'));

        preg_match('/(?<=\/){0,1}[A-Z]{1}\w*$/', $name, $matches);

        return $matches[0];
    }
}
