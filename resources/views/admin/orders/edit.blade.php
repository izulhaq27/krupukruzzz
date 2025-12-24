<div class="card mb-4">
    <div class="card-header">
        <h5>Informasi Pengiriman</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kurir Pengiriman</label>
                    <select name="shipping_courier" class="form-control">
                        <option value="">Pilih Kurir</option>
                        <option value="jne" {{ $order->shipping_courier == 'jne' ? 'selected' : '' }}>JNE</option>
                        <option value="tiki" {{ $order->shipping_courier == 'tiki' ? 'selected' : '' }}>TIKI</option>
                        <option value="pos" {{ $order->shipping_courier == 'pos' ? 'selected' : '' }}>POS Indonesia</option>
                        <option value="sicepat" {{ $order->shipping_courier == 'sicepat' ? 'selected' : '' }}>SiCepat</option>
                        <option value="jnt" {{ $order->shipping_courier == 'jnt' ? 'selected' : '' }}>J&T</option>
                        <option value="anteraja" {{ $order->shipping_courier == 'anteraja' ? 'selected' : '' }}>AnterAja</option>
                        <option value="ninja" {{ $order->shipping_courier == 'ninja' ? 'selected' : '' }}>Ninja Express</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label>Layanan</label>
                    <select name="shipping_service" class="form-control">
                        <option value="">Pilih Layanan</option>
                        <option value="reg" {{ $order->shipping_service == 'reg' ? 'selected' : '' }}>Reguler</option>
                        <option value="eco" {{ $order->shipping_service == 'eco' ? 'selected' : '' }}>Economy</option>
                        <option value="yes" {{ $order->shipping_service == 'yes' ? 'selected' : '' }}>YES</option>
                        <option value="ons" {{ $order->shipping_service == 'ons' ? 'selected' : '' }}>Ongkos Kirim Sendiri</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nomor Resi</label>
                    <input type="text" name="tracking_number" class="form-control" 
                           value="{{ old('tracking_number', $order->tracking_number) }}"
                           placeholder="Contoh: 1234567890123">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Dikirim</label>
                    <input type="date" name="shipped_at" class="form-control" 
                           value="{{ old('shipped_at', $order->shipped_at ? $order->shipped_at->format('Y-m-d') : '') }}">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label>Estimasi Tiba</label>
                    <input type="date" name="estimated_delivery" class="form-control" 
                           value="{{ old('estimated_delivery', $order->estimated_delivery ? $order->estimated_delivery->format('Y-m-d') : '') }}">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ongkos Kirim</label>
                    <input type="number" name="shipping_cost" class="form-control" 
                           value="{{ old('shipping_cost', $order->shipping_cost) }}">
                </div>
            </div>
        </div>
        
        @if($order->tracking_number)
        <div class="alert alert-info mt-3">
            <strong>Link Tracking:</strong> 
            <a href="{{ $order->tracking_link }}" target="_blank" class="ml-2">
                Klik untuk lacak paket
            </a>
        </div>
        @endif
    </div>
</div>