<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateFlowchart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:flowchart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Mermaid Flowchart based on the project workflow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating Flowchart file...');

        $mermaid = "flowchart TD\n";
        $mermaid .= "    subgraph Checkout_Process\n";
        $mermaid .= "        A[Mulai Checkout] --> B{Keranjang Kosong?}\n";
        $mermaid .= "        B -- Ya --> C[Kembali ke Katalog]\n";
        $mermaid .= "        B -- Tidak --> D[Input Data Pengiriman]\n";
        $mermaid .= "        D --> E[Proses Checkout]\n";
        $mermaid .= "        E --> F[Simpan Data User & Alamat]\n";
        $mermaid .= "        F --> G[Buat Data Order: Status 'pending']\n";
        $mermaid .= "        G --> H{Stok Cukup?}\n";
        $mermaid .= "        H -- Tidak --> I[Rollback & Tampilkan Error]\n";
        $mermaid .= "        H -- Ya --> J[Simpan Order Items & Kurangi Stok]\n";
        $mermaid .= "        J --> K[Generate Midtrans Snap Token]\n";
        $mermaid .= "        K --> L[Hapus Sesi Keranjang]\n";
        $mermaid .= "        L --> M[Arahkan ke Halaman Pembayaran]\n";
        $mermaid .= "        M[Arahkan ke Halaman Pembayaran] --> N[Customer Bayar via Midtrans]\n";
        $mermaid .= "        N --> O[Midtrans Kirim HTTP Notification/Callback]\n";
        $mermaid .= "        O --> P{Status Bayar di Callback?}\n";
        $mermaid .= "        P -- capture / settlement --> Q[Status Otomatis: 'paid']\n";
        $mermaid .= "        P -- deny / expire / cancel --> R[Status Otomatis: 'cancelled']\n";
        $mermaid .= "        P -- pending --> S[Status tetap 'pending']\n";
        $mermaid .= "    end\n\n";

        $mermaid .= "    subgraph Admin_Process\n";
        $mermaid .= "        Q --> AD[Order Masuk Admin - Status Paid]\n";
        $mermaid .= "        AD --> AE[Admin Proses Order]\n";
        $mermaid .= "        AE -- Sudah --> AF[Update Status 'processing']\n";
        $mermaid .= "        AF --> AG[Packing & Kirim]\n";
        $mermaid .= "        AG --> AH[Input Nomor Resi]\n";
        $mermaid .= "        AH --> AI[Update Status 'shipped']\n";
        $mermaid .= "        AI --> AJ[Customer Terima Barang]\n";
        $mermaid .= "        AJ --> AK[Status 'delivered' / Selesai]\n";
        $mermaid .= "    end\n";

        $filePath = base_path('project_flowchart.mermaid');
        File::put($filePath, $mermaid);

        $this->info("Success! Flowchart file created at: $filePath");
        $this->info("You can open this file in VS Code and use the 'Mermaid Preview' extension to see the diagram.");
    }
}
