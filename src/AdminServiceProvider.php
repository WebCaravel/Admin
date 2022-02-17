<?php

namespace WebCaravel\Admin;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Livewire\Component;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Symfony\Component\Finder\SplFileInfo;
use WebCaravel\Admin\Console\Commands\CreateResourceCommand;

class AdminServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('admin')
            ->hasConfigFile('caravel-admin')
            ->hasViews('caravel-admin')
            ->hasTranslations()
            //->hasMigration('create_admin_table')
            ->hasCommand(CreateResourceCommand::class)
        ;
    }


    public function packageBooted(): void
    {
        $this->registerLivewireComponentDirectory(config("caravel-admin.resources.path"), config("caravel-admin.resources.namespace"), config("caravel-admin.resources.prefix"));

        foreach(config("caravel-admin.component-aliases") as $key => $value) {
            Blade::component($key, $value);
        }
    }


    /**
     * Taken from filamentadmin (/src/FilamentServiceProvider.php)
     *
     * @param string $directory
     * @param string $namespace
     * @param string $aliasPrefix
     * @return void
     */
    protected function registerLivewireComponentDirectory(string $directory, string $namespace, string $aliasPrefix = ''): void
    {
        $filesystem = app(Filesystem::class);

        if (! $filesystem->isDirectory($directory)) {
            return;
        }

        collect($filesystem->allFiles($directory))
            ->map(function (SplFileInfo $file) use ($namespace): string {
                return (string) \Str::of($namespace)
                    ->append('\\', $file->getRelativePathname())
                    ->replace(['/', '.php'], ['\\', '']);
            })
            ->filter(fn (string $class): bool => is_subclass_of($class, Component::class) && (! (new \ReflectionClass($class))->isAbstract()))
            ->each(function (string $class) use ($namespace, $aliasPrefix): void {
                $alias = \Str::of($class)
                    ->after($namespace . '\\')
                    ->replace(['/', '\\'], '.')
                    ->prepend($aliasPrefix)
                    ->explode('.')
                    ->map([\Str::class, 'kebab'])
                    ->implode('.');

                Livewire::component($alias, $class);
            });
    }
}
