<!DOCTYPE html>
<html>
<head>
    <title>Detail Order #{{ $order->order_number }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f8f9fa; }
        .card { margin-bottom: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .btn-back { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Detail Order: {{ $order->order_number }}</h1>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">👤 Informasi Customer</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="120">Nama:</th>
                                <td>{{ $order->user->name ?? $order->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $order->user->email ?? $order->email }}</td>
                            </tr>
                            <tr>
                                <th>Telepon:</th>
                                <td>{{ $order->phone }}</td>
                            </tr>
                            <tr>
                                <th>Alamat:</th>
                                <td>{{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">📋 Informasi Order</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="120">Status:</th>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : 'success') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal:</th>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($order->payment_proof)
                            <tr>
                                <th>Bukti Bayar:</th>
                                <td>
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}" style="max-width: 150px; border-radius: 8px;" class="border">
                                    </a>
                                    <br>
                                    <small class="text-muted">Bank: {{ $order->bank_name }}</small>
                                </td>
                            </tr>
                            @endif
                            @if($order->tracking_number)
                            <tr>
                                <th>Resi:</th>
                                <td>
                                    <span class="badge bg-info">{{ $order->tracking_number }}</span>
                                    <small class="text-muted">({{ strtoupper($order->shipping_courier) }})</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Dikirim:</th>
                                <td>{{ $order->shipped_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- FORM UPDATE STATUS --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Update Status Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            <div class="d-flex gap-2">
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses (Sudah Bayar)</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                <button type="submit" class="btn btn-dark">Simpan Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FORM UPDATE RESI -->
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Update Resi Pengiriman</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-tracking', $order->id) }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nomor Resi *</label>
                                <input type="text" class="form-control" name="tracking_number" 
                                       value="{{ old('tracking_number', $order->tracking_number) }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kurir *</label>
                                <select class="form-control" name="shipping_courier" required>
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne" {{ $order->shipping_courier == 'jne' ? 'selected' : '' }}>JNE</option>
                                    <option value="tiki" {{ $order->shipping_courier == 'tiki' ? 'selected' : '' }}>TIKI</option>
                                    <option value="pos" {{ $order->shipping_courier == 'pos' ? 'selected' : '' }}>POS Indonesia</option>
                                    <option value="sicepat" {{ $order->shipping_courier == 'sicepat' ? 'selected' : '' }}>SiCepat</option>
                                    <option value="jnt" {{ $order->shipping_courier == 'jnt' ? 'selected' : '' }}>J&T</option>
                                    <option value="anteraja" {{ $order->shipping_courier == 'anteraja' ? 'selected' : '' }}>AnterAja</option>
                                    <option value="ninja" {{ $order->shipping_courier == 'ninja' ? 'selected' : '' }}>Ninja Xpress</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Layanan</label>
                                <input type="text" class="form-control" name="shipping_service" 
                                       value="{{ old('shipping_service', $order->shipping_service) }}"
                                       placeholder="REG, YES, OKE, dll">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        @if($order->tracking_number)
                            <i class="bi bi-pencil"></i> Update Resi
                        @else
                            <i class="bi bi-check"></i> Simpan Resi
                        @endif
                    </button>
                </form>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4 mb-5">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                ← Kembali ke Daftar Order
            </a>
            
            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-dark">
                <i class="bi bi-printer"></i> Cetak Invoice
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>