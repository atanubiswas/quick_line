<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DatabaseDownloadController extends Controller
{
    public function downloadAllTables()
    {
        $database = env('DB_DATABASE');
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . $database;
        $timestamp = now()->format('Ymd_His');
        $folder = storage_path("app/db_exports/{$timestamp}");
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }
        foreach ($tables as $table) {
            $tableName = $table->$key;
            $sql = '';
            // Get CREATE TABLE statement
            $create = DB::select("SHOW CREATE TABLE `$tableName`");
            $sql .= $create[0]->{'Create Table'} . ";\n\n";
            $filePath = "$folder/{$tableName}.sql";
            File::put($filePath, $sql); // Write structure first
            // Get INSERT statements in chunks
            DB::table($tableName)->orderByRaw('1=1')->chunk(500, function ($rows) use ($tableName, $filePath) {
                $inserts = '';
                foreach ($rows as $row) {
                    $columns = array_map(function($v) { return "`$v`"; }, array_keys((array)$row));
                    $values = array_map(function($v) { return is_null($v) ? 'NULL' : DB::getPdo()->quote($v); }, array_values((array)$row));
                    $inserts .= "INSERT INTO `$tableName` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ");\n";
                }
                File::append($filePath, $inserts);
            });
        }
        return response()->json(['message' => 'Database tables exported successfully', 'folder' => $folder]);
    }
}
