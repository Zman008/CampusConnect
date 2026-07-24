<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QuestionBankFile;
use App\Models\CourseMaterial;
use Illuminate\Support\Facades\Storage;

class SavePdfFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:save {type : Type of PDF to save (question-bank or course-material)} {--output= : Output path for the PDF}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Save PDF files from database records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $output = $this->option('output') ?? storage_path('app/pdfs');

        // Create output directory if it doesn't exist
        if (!Storage::disk('local')->exists('pdfs')) {
            Storage::disk('local')->makeDirectory('pdfs');
        }

        if ($type === 'question-bank') {
            $this->saveQuestionBankPdfs($output);
        } elseif ($type === 'course-material') {
            $this->saveCourseMaterialPdfs($output);
        } else {
            $this->error("Invalid type. Use 'question-bank' or 'course-material'");
            return 1;
        }

        return 0;
    }

    /**
     * Save all approved question bank PDFs
     */
    private function saveQuestionBankPdfs($output)
    {
        $files = QuestionBankFile::where('status', 'approved')->get();

        if ($files->isEmpty()) {
            $this->warn('No approved question bank files found.');
            return;
        }

        foreach ($files as $file) {
            $sourcePath = $file->file_path;
            $fileName = $file->original_name;

            if (Storage::disk('public')->exists($sourcePath)) {
                $content = Storage::disk('public')->get($sourcePath);
                Storage::disk('local')->put("pdfs/{$fileName}", $content);
                $this->line("<info>✓</info> Saved: {$fileName}");
            } else {
                $this->error("✗ File not found: {$sourcePath}");
            }
        }

        $this->info("Question bank PDFs saved to: {$output}");
    }

    /**
     * Save all approved course material PDFs
     */
    private function saveCourseMaterialPdfs($output)
    {
        $materials = CourseMaterial::where('status', 'approved')
            ->where('type', 'pdf')
            ->get();

        if ($materials->isEmpty()) {
            $this->warn('No approved PDF materials found.');
            return;
        }

        foreach ($materials as $material) {
            $sourcePath = $material->file_path;
            $fileName = $material->file_name;

            if (Storage::disk('public')->exists($sourcePath)) {
                $content = Storage::disk('public')->get($sourcePath);
                Storage::disk('local')->put("pdfs/{$fileName}", $content);
                $this->line("<info>✓</info> Saved: {$fileName}");
            } else {
                $this->error("✗ File not found: {$sourcePath}");
            }
        }

        $this->info("Course material PDFs saved to: {$output}");
    }
}
