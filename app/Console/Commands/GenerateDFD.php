<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateDFD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dfd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Mermaid DFD based on the system data flow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating DFD file...');

        $mermaid = "graph TD\n";
        
        $mermaid .= "    subgraph DFD_Level_0_Context_Diagram\n";
        $mermaid .= "        Customer((Customer)) -- \"Registrasi, Login, Order, Bayar\" --> System[[\"KrupuKruzzz System\"]]\n";
        $mermaid .= "        System -- \"Info Produk, Status Order, Invoice\" --> Customer\n";
        $mermaid .= "        Admin((Admin)) -- \"Kelola Produk, Kategori, Update Status Order\" --> System\n";
        $mermaid .= "        System -- \"Laporan Penjualan, Info Order\" --> Admin\n";
        $mermaid .= "        System -- \"Request Payment Token\" --> Midtrans((Midtrans Gateway))\n";
        $mermaid .= "        Midtrans -- \"Notifikasi Status Bayar\" --> System\n";
        $mermaid .= "    end\n\n";

        $mermaid .= "    subgraph DFD_Level_1_Process_Overview\n";
        $mermaid .= "        C1((Customer)) -- \"Pilih Produk\" --> P1[\"1.0 Katalog & Keranjang\"]\n";
        $mermaid .= "        P1 -- \"Data Keranjang\" --> DS4[(\"DS4: Carts\")]\n";
        
        $mermaid .= "        C1 -- \"Checkout\" --> P2[\"2.0 Transaksi & Pembayaran\"]\n";
        $mermaid .= "        P2 -- \"Update Stok\" --> DS2[(\"DS2: Products\")]\n";
        $mermaid .= "        P2 -- \"Simpan Transaksi\" --> DS3[(\"DS3: Orders/Items\")]\n";
        $mermaid .= "        P2 -- \"Request Token\" --> MID((Midtrans))\n";
        $mermaid .= "        MID -- \"Callback Status\" --> P2\n";

        $mermaid .= "        A1((Admin)) -- \"Kelola Data\" --> P3[\"3.0 Manajemen Produk/Kategori\"]\n";
        $mermaid .= "        P3 -- \"Read/Write\" --> DS1[(\"DS1: Users/Admins\")]\n";
        $mermaid .= "        P3 -- \"Read/Write\" --> DS2\n";

        $mermaid .= "        A1 -- \"Input Resi/Status\" --> P4[\"4.0 Pemrosesan Order\"]\n";
        $mermaid .= "        P4 -- \"Update Status\" --> DS3\n";
        $mermaid .= "        P4 -- \"Kirim Notifikasi\" --> C1\n";
        $mermaid .= "    end\n";

        $filePath = base_path('project_dfd.mermaid');
        File::put($filePath, $mermaid);

        $this->info("Success! DFD file created at: $filePath");
        $this->info("You can open this file in VS Code and use the 'Mermaid Preview' extension to see the diagram.");
    }
}
