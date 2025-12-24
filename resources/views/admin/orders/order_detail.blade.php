<!DOCTYPE html>
<html>
<head>
    <title>Detail Order</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .card { border: 1px solid #ddd; padding: 20px; margin: 20px 0; }
        .form-group { margin-bottom: 15px; }
        input, select { padding: 8px; width: 300px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; }
    </style>
</head>
<body>
    <h1>Detail Order #{{ $order->id }}</h1>
    
    <div class="card">
        <h3>Informasi Customer</h3>
        <p><strong>Nama:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Telepon:</strong> {{ $order->phone }}</p>
        <p><strong>Alamat:</strong> {{ $order->address }}</p>
    </div>
    
    <div class="card">
        <h3>Informasi Order</h3>
        <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        
        @if($order->tracking_number)
            <div style="background: #d4edda; padding: 15px;">
                <h4>Sudah Dikirim</h4>
                <p><strong>Resi:</strong> {{ $order->tracking_number }}</p>
                <p><strong>Kurir:</strong> {{ strtoupper($order->shipping_courier) }}</p>
                
                @if($order->tracking_link)
                    <a href="{{ $order->tracking_link }}" target="_blank">Lacak Paket</a>
                @endif
            </div>
        @endif
    </div>
    
    <!-- FORM INPUT RESI -->
    <div class="card">
        <h3>{{ $order->tracking_number ? 'Update' : 'Input' }} Resi</h3>
        <form method="POST" action="/admin/order/{{ $order->id }}/tracking">
            @csrf
            
            <div class="form-group">
                <label>Nomor Resi:</label>
                <input type="text" name="tracking_number" 
                       value="{{ $order->tracking_number }}" required>
            </div>
            
            <div class="form-group">
                <label>Kurir:</label>
                <select name="shipping_courier" required>
                    <option value="">Pilih Kurir</option>
                    <option value="jne" {{ $order->shipping_courier == 'jne' ? 'selected' : '' }}>JNE</option>
                    <option value="tiki" {{ $order->shipping_courier == 'tiki' ? 'selected' : '' }}>TIKI</option>
                    <option value="pos" {{ $order->shipping_courier == 'pos' ? 'selected' : '' }}>POS</option>
                    <option value="sicepat" {{ $order->shipping_courier == 'sicepat' ? 'selected' : '' }}>SiCepat</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Layanan (opsional):</label>
                <input type="text" name="shipping_service" 
                       value="{{ $order->shipping_service }}" 
                       placeholder="REG, YES, OKE">
            </div>
            
            <button type="submit">💾 Simpan Resi</button>
            <a href="/admin" style="margin-left: 10px;">← Kembali</a>
        </form>
    </div>
</body>
</html>