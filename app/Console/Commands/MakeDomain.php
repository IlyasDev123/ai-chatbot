<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDomain extends Command
{
    protected $signature = 'make:domain {name}';
    protected $description = 'Create a new domain structure with Controller, Model, Request, Action, and DTO';

    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));
        $basePath = app_path("Domains/{$name}");

        $folders = ['Controllers', 'DTOs', 'Actions', 'Requests', 'Models'];
        foreach ($folders as $folder) {
            File::ensureDirectoryExists("{$basePath}/{$folder}");
        }

        $this->generateController($name);
        $this->generateModel($name);
        $this->generateDTO($name);
        $this->generateRequest($name);
        $this->generateAction($name);

        $this->info("✅ Domain '{$name}' created with structure.");
    }

    protected function generateController(string $name): void
    {
        $content = <<<PHP
<?php

namespace App\Domains\\{$name}\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class {$name}Controller extends Controller
{
    public function index()
    {
        // TODO: implement index
    }
}
PHP;

        File::put(app_path("Domains/{$name}/Controllers/{$name}Controller.php"), $content);
    }

    protected function generateModel(string $name): void
    {
        $content = <<<PHP
<?php

namespace App\Domains\\{$name}\Models;

use Illuminate\Database\Eloquent\Model;

class {$name} extends Model
{
    protected \$guarded = [];
}
PHP;

        File::put(app_path("Domains/{$name}/Models/{$name}.php"), $content);
    }

    protected function generateDTO(string $name): void
    {
        $content = <<<PHP
<?php

namespace App\Domains\\{$name}\DTOs;

class {$name}Data
{
    public function __construct(
        // public readonly string \$title
    ) {}

    public static function fromArray(array \$data): self
    {
        return new self(
            // \$data['title']
        );
    }
}
PHP;

        File::put(app_path("Domains/{$name}/DTOs/{$name}Data.php"), $content);
    }

    protected function generateRequest(string $name): void
    {
        $content = <<<PHP
<?php

namespace App\Domains\\{$name}\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Create{$name}Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'title' => 'required|string'
        ];
    }
}
PHP;

        File::put(app_path("Domains/{$name}/Requests/Create{$name}Request.php"), $content);
    }

    protected function generateAction(string $name): void
    {
        $content = <<<PHP
<?php

namespace App\Domains\\{$name}\Actions;

use App\Domains\\{$name}\DTOs\\{$name}Data;
use App\Domains\\{$name}\Models\\{$name};

class Create{$name}Action
{
    public function execute({$name}Data \$data): {$name}
    {
        return {$name}::create([
            // 'title' => \$data->title,
        ]);
    }
}
PHP;

        File::put(app_path("Domains/{$name}/Actions/Create{$name}Action.php"), $content);
    }
}
