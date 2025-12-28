<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateERD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:erd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Mermaid ERD based on the current database schema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating ERD file...');

        $mermaid = "erDiagram\n";
        
        // Relationships
        $mermaid .= "    users ||--o{ orders : \"places\"\n";
        $mermaid .= "    users ||--o{ carts : \"has\"\n";
        $mermaid .= "    products ||--o{ order_items : \"contained in\"\n";
        $mermaid .= "    products ||--o{ carts : \"added to\"\n";
        $mermaid .= "    products }o--o{ categories : \"categorized by\"\n";
        $mermaid .= "    orders ||--o{ order_items : \"consists of\"\n\n";

        // Tables
        $mermaid .= "    users {\n";
        $mermaid .= "        bigint id PK\n";
        $mermaid .= "        string name\n";
        $mermaid .= "        string email UK\n";
        $mermaid .= "        string password\n";
        $mermaid .= "        string phone\n";
        $mermaid .= "        text address\n";
        $mermaid .= "        string city\n";
        $mermaid .= "        string province\n";
        $mermaid .= "        string postal_code\n";
        $mermaid .= "        boolean is_admin\n";
        $mermaid .= "        timestamp created_at\n";
        $mermaid .= "        timestamp updated_at\n";
        $mermaid .= "    }\n\n";

        $mermaid .= "    admins {\n";
        $mermaid .= "        bigint id PK\n";
        $mermaid .= "        string name\n";
        $mermaid .= "        string email UK\n";
        $mermaid .= "        string password\n";
        $mermaid .= "        timestamp created_at\n";
        $mermaid .= "        timestamp updated_at\n";
        $mermaid .= "    }\n\n";

        $mermaid .= "    products {\n";
        $mermaid .= "        bigint id PK\n";
        $mermaid .= "        string name\n";
        $mermaid .= "        string slug UK\n";
        $mermaid .= "        text description\n";
        $mermaid .= "        integer price\n";
        $mermaid .= "        integer discount_price\n";
        $mermaid .= "        integer stock\n";
        $mermaid .= "        string image\n";
        $mermaid .= "        boolean is_active\n";
        $mermaid .= "        timestamp created_at\n";
        $mermaid .= "        timestamp updated_at\n";
        $mermaid .= "    }\n\n";

        $mermaid .= "    categories {\n";
        $mermaid .= "        bigint id PK\n";
        $mermaid .= "        string name\n";
        $mermaid .= "        string slug UK\n";
        $mermaid .= "        text description\n";
        $mermaid .= "        string image\n";
        $mermaid .= "        boolean is_active\n";
        $mermaid .= "        timestamp created_at\n";
        $mermaid .= "        timestamp updated_at\n";
        $mermaid .= "    }\n\n";

        $mermaid .= "    orders {\n";
        $mermaid .= "        bigint id PK\n";
        $mermaid .= "        bigint user_id FK\n";
        $mermaid .= "        string order_number UK\n";
        $mermaid .= "        string name\n";
        $mermaid .= "        string email\n";
        $mermaid .= "        string phone\n";
        $mermaid .= "        text address\n";
        $mermaid .= "        decimal total_amount\n";
        $mermaid .= "        string snap_token\n";
        $mermaid .= "        string transaction_id\n";
        $mermaid .= "        string status\n";
        $mermaid .= "        string payment_type\n";
        $mermaid .= "        string payment_proof\n";
        $mermaid .= "        string bank_name\n";
        $mermaid .= "        string shipping_courier\n";
        $mermaid .= "        string shipping_service\n";
        $mermaid .= "        decimal shipping_cost\n";
        $mermaid .= "        string tracking_number\n";
        $mermaid .= "        timestamp paid_at\n";
        $mermaid .= "        timestamp shipped_at\n";
        $mermaid .= "        date estimated_delivery\n";
        $mermaid .= "        text notes\n";
        $mermaid .= "        timestamp created_at\n";
        $mermaid .= "        timestamp updated_at\n";
        $mermaid .= "    }\n\n";

        $mermaid .= "    order_items {\n";
        $mermaid .= "        bigint id PK\n";
        $mermaid .= "        bigint order_id FK\n";
        $mermaid .= "        bigint product_id FK\n";
        $mermaid .= "        string product_name\n";
        $mermaid .= "        integer quantity\n";
        $mermaid .= "        decimal price\n";
        $mermaid .= "        decimal subtotal\n";
        $mermaid .= "        timestamp created_at\n";
        $mermaid .= "        timestamp updated_at\n";
        $mermaid .= "    }\n\n";

        $mermaid .= "    carts {\n";
        $mermaid .= "        bigint id PK\n";
        $mermaid .= "        bigint user_id FK\n";
        $mermaid .= "        bigint product_id FK\n";
        $mermaid .= "        string session_id\n";
        $mermaid .= "        integer quantity\n";
        $mermaid .= "        timestamp created_at\n";
        $mermaid .= "        timestamp updated_at\n";
        $mermaid .= "    }\n";

        $filePath = base_path('database_erd.mermaid');
        File::put($filePath, $mermaid);

        $this->info("Success! ERD file created at: $filePath");
        $this->info("You can open this file in VS Code and use the 'Mermaid Preview' extension to see the diagram.");
    }
}
