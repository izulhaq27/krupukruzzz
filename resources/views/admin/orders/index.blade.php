@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Daftar Pesanan</h3>
        <span class="badge bg-secondary">{{ $orders->count() }} pesanan</span>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="table-layout: fixed; width: 100%;">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th style="width: 80px; min-width: 80px; padding: 12px;">ID</th>
                            <th style="width: 180px; min-width: 180px; padding: 12px;">Pelanggan</th>
                            <th style="width: 200px; min-width: 200px; padding: 12px;">Email</th>
                            <th style="width: 140px; min-width: 140px; padding: 12px;">Telepon</th>
                            <th style="width: 120px; min-width: 120px; padding: 12px;">Total</th>
                            <th style="width: 100px; min-width: 100px; padding: 12px;">Status</th>
                            <th style="width: 180px; min-width: 180px; padding: 12px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="border-bottom">
                            <!-- Kolom 1 - ID -->
                            <td style="padding: 12px;">
                                <span class="fw-bold text-dark">#{{ $order->id }}</span>
                            </td>
                            
                            <!-- Kolom 2 - Pelanggan -->
                            <td style="padding: 12px;">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 36px; height: 36px; background: #f0f0f0;">
                                            <i class="bi bi-person text-muted"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="fw-medium text-truncate" style="max-width: 150px;">
                                            {{ $order->name }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.8rem;">
                                            ID: {{ $order->id }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Kolom 3 - Email -->
                            <td style="padding: 12px;">
                                <div class="text-truncate" title="{{ $order->email }}" style="max-width: 180px;">
                                    @if($order->email && $order->email != 'belum-diisi@example.com')
                                        {{ $order->email }}
                                    @else
                                        <span class="text-muted fst-italic">-</span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Kolom 4 - Telepon -->
                            <td style="padding: 12px;">
                                <div class="text-truncate" style="max-width: 130px;">
                                    @if($order->phone)
                                        {{ $order->phone }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Kolom 5 - Total & Produk -->
                            <td style="padding: 12px;">
                                <div class="fw-bold text-success mb-1">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>
                                <div class="small text-muted text-truncate" style="max-width: 150px;">
                                    @foreach($order->items as $item)
                                        {{ $item->product_name }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </div>
                            </td>
                            
                            <!-- Kolom 6 - Status -->
                            <td style="padding: 12px;">
                                @php
                                    $badgeClass = match($order->status) {
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-info text-white',
                                        'completed' => 'bg-success text-white',
                                        'cancelled' => 'bg-danger text-white',
                                        'Quadro' => 'bg-primary text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                    
                                    $statusText = $order->status == 'Quadro' ? 'Quadro' : ucfirst($order->status);
                                @endphp
                                <span class="badge {{ $badgeClass }} px-2 py-1 rounded-pill d-inline-block" style="font-size: 0.75rem;">
                                    {{ $statusText }}
                                </span>
                            </td>
                            
                            <!-- Kolom 7 - Aksi -->
                            <td style="padding: 12px; text-align: right;">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="/admin/orders/{{ $order->id }}" 
                                       class="btn btn-sm px-3" 
                                       style="background: #6c757d; color: white; border-radius: 6px; font-size: 0.85rem;">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>

                                    @if(in_array($order->status, ['cancelled', 'failed']))
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger px-3" style="border-radius: 6px; font-size: 0.85rem;">
                                                <i class="bi bi-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(!$order->tracking_number && !in_array($order->status, ['cancelled', 'failed']))
                                    <a href="/admin/orders/{{ $order->id }}#resi-form" 
                                       class="btn btn-sm px-3" 
                                       style="background: #28a745; color: white; border-radius: 6px; font-size: 0.85rem;">
                                        <i class="bi bi-truck me-1"></i> Resi
                                    </a>
                                    @else
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <i class="bi bi-check-circle text-success me-1"></i>
                                        {{ Str::limit($order->tracking_number, 8) }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($orders->isEmpty())
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="bi bi-cart-x display-4 text-muted"></i>
        </div>
        <h5 class="text-muted">Belum ada pesanan</h5>
        <p class="text-muted small">Pesanan akan muncul di sini</p>
    </div>
    @endif
</div>

<style>
    /* PERBAIKAN UTAMA: table-layout fixed untuk kolom tetap */
    .table {
        table-layout: fixed;
        width: 100%;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        color: #495057;
        border-top: none;
        border-bottom: 2px solid #e9ecef;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .table td {
        vertical-align: middle;
        padding: 12px;
        border-bottom: 1px solid #f0f0f0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .table tbody tr:last-child {
        border-bottom: none;
    }
    
    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        
        h3 {
            font-size: 1.25rem;
        }
        
        /* Sembunyikan kolom Email dan Telepon di mobile */
        .table th:nth-child(3), 
        .table th:nth-child(4),
        .table td:nth-child(3),
        .table td:nth-child(4) {
            display: none;
        }
        
        /* Perlebar kolom Pelanggan di mobile */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 250px !important;
            min-width: 250px !important;
        }
    }
</style>
@endsection