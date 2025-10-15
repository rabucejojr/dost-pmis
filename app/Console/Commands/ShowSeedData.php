<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ShowSeedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage examples:
     * --------------
     * php artisan show:data Project
     * php artisan show:data Activity --limit=5
     * php artisan show:data ProjectStaff --filter="status=completed"
     *
     * Arguments:
     * - {model}:     Name of the Eloquent model (without namespace)
     * Options:
     * - {--limit=}:  Restrict how many records to show
     * - {--filter=}: Filter records by a "field=value" condition
     */
    protected $signature = 'show:data
                            {model : The Eloquent model name (e.g. Program, Project, ProjectStaff, Activity)}
                            {--limit= : Limit the number of records displayed}
                            {--filter= : Filter results by field=value (e.g. status=completed)}';

    /**
     * Command description displayed in `php artisan list`
     */
    protected $description = 'Display seeded data for any model (Program, Project, ProjectStaff, Activity, etc.)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        /**
         * Step 1: Get the fully qualified model class name.
         * -------------------------------------------------
         * Example: if user runs `php artisan show:data Project`,
         * this resolves to App\Models\Project.
         */
        $modelName = Str::studly($this->argument('model'));
        $modelClass = "App\\Models\\{$modelName}";

        // Check if the given model actually exists
        if (!class_exists($modelClass)) {
            $this->error("Model {$modelName} does not exist in App\\Models.");
            return self::FAILURE;
        }

        /**
         * Step 2: Build the base query.
         * -----------------------------
         * This uses Eloquent to retrieve data from the model.
         */
        $query = $modelClass::query();

        /**
         * Step 3: Optional filter logic.
         * ------------------------------
         * Allows `--filter="status=completed"`
         * or any column=value pair (LIKE search).
         */
        if ($filter = $this->option('filter')) {
            [$field, $value] = explode('=', $filter, 2);
            if (!empty($field) && !empty($value)) {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        /**
         * Step 4: Optional limit.
         * -----------------------
         * Restrict how many rows to display with `--limit=5`.
         */
        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        /**
         * Step 5: Fetch all records after applying filters and limits.
         */
        $records = $query->get();

        // If no records were found, show a warning and exit successfully
        if ($records->isEmpty()) {
            $this->warn("No records found in {$modelName}.");
            return self::SUCCESS;
        }

        /**
         * Step 6: Dynamically detect column names.
         * ----------------------------------------
         * We get attribute keys from the first record so
         * the table header adapts automatically to any model.
         */
        $columns = array_keys($records->first()->getAttributes());

        /**
         * Step 7: Display the results in a formatted Artisan table.
         * ---------------------------------------------------------
         * - Automatically handles Enums (e.g., App\Enums\ProjectStatus)
         * - Converts arrays/objects safely into strings
         */
        $this->info("Showing " . $records->count() . " record(s) from {$modelName}:");
        $this->table(
            $columns,
            $records->map(function ($record) use ($columns) {
                $data = [];

                foreach ($columns as $col) {
                    $value = $record->{$col};

                    // Handle PHP 8.1+ Enum values gracefully
                    if ($value instanceof \BackedEnum) {
                        $value = $value->value; // or use ->name if preferred
                    }

                    // Convert arrays into JSON
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    // Handle non-stringable objects (avoid exceptions)
                    elseif (is_object($value) && !method_exists($value, '__toString')) {
                        $value = get_class($value);
                    }

                    $data[$col] = $value;
                }

                return $data;
            })
        );

        /**
         * Step 8: Return success status.
         */
        return self::SUCCESS;
    }
}
