@extends('layouts.app')

@section('content')
<style>
    /* ================= RESPONSIVE STYLES ================= */
    * {
        box-sizing: border-box;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 15px;
    }
    
    .search-box i {
        color: #94a3b8;
    }
    
    .search-box input {
        border: none;
        outline: none;
        width: 100%;
        max-width: 250px;
        font-size: 14px;
    }
    
    .table-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .per-page-selector {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 5px 12px;
    }
    
    .per-page-selector label {
        font-size: 13px;
        color: #475569;
        font-weight: 500;
    }
    
    .per-page-selector select {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 5px 8px;
        font-size: 13px;
        background: #f8fafc;
        cursor: pointer;
        outline: none;
    }
    
    .per-page-selector select:hover {
        background: #f1f5f9;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    /* ========== 3 STATUS BADGE ========== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-up {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-warning {
        background: #fed7aa;
        color: #92400e;
    }
    
    .status-down {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-unknown {
        background: #e2e8f0;
        color: #475569;
    }
    
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .type-http {
        background: #e0e7ff;
        color: #3730a3;
    }
    
    .type-ping {
        background: #fef3c7;
        color: #92400e;
    }
    
    .uptime-container {
        min-width: 100px;
    }
    
    .percent-text-small {
        font-size: 1rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 5px;
        color: #1e3a5f;
    }
    
    .progress-bar-small {
        background: #e5e7eb;
        height: 18px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .progress-fill-small {
        height: 100%;
        width: 0%;
        color: #fff;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 6px;
        font-size: 9px;
        transition: all 0.8s ease;
    }
    
    .detail-info {
        font-size: 10px;
        color: #64748b;
        margin-top: 6px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .detail-info .status-code {
        font-family: monospace;
        font-weight: 600;
    }
    
    .detail-info .down-reason {
        color: #991b1b;
    }
    
    .detail-info .warning-reason {
        color: #92400e;
    }
    
    .status-desc {
        font-size: 10px;
        display: block;
        margin-top: 3px;
    }
    
    .internet-warning {
        background: #fef3c7;
        color: #92400e;
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 9px;
        margin-bottom: 4px;
    }
    
    .auto-refresh-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        color: #475569;
    }
    
    .auto-refresh-indicator i {
        color: #10b981;
    }
    
    .internet-banner {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-left: 4px solid #ef4444;
    }
    
    .internet-banner i {
        font-size: 18px;
    }
    
    .internet-banner button {
        margin-left: auto;
        background: #991b1b;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .btn-check {
        background: #3b82f6;
        color: white;
        padding: 4px 8px;
        border: none;
        border-radius: 6px;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-check:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }
    
    .btn-check:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }
    
    .btn-edit {
        background: #f59e0b;
        color: white;
        padding: 4px 8px;
        border: none;
        border-radius: 6px;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-edit:hover {
        background: #d97706;
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
        padding: 4px 8px;
        border: none;
        border-radius: 6px;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    .empty-state {
        text-align: center;
        padding: 50px !important;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 50px;
        margin-bottom: 15px;
        display: block;
    }
    
    .loading-state {
        text-align: center;
        padding: 50px !important;
        color: #64748b;
    }
    
    .loading-state i {
        font-size: 30px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        margin-top: 20px;
        flex-wrap: wrap;
        padding: 12px;
        background: #f8fafc;
        border-radius: 12px;
    }
    
    .page-btn {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #1e293b;
        font-size: 12px;
    }
    
    .page-btn:hover:not(:disabled) {
        background: #1e3a5f;
        color: white;
        border-color: #1e3a5f;
    }
    
    .page-btn.active {
        background: #1e3a5f;
        color: white;
        border-color: #1e3a5f;
    }
    
    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .page-dots {
        padding: 0 4px;
        color: #64748b;
    }
    
    .page-info {
        margin-left: 10px;
        padding: 4px 10px;
        background: #e2e8f0;
        border-radius: 6px;
        font-size: 11px;
        color: #475569;
    }
    
    .modal-box form {
        text-align: left;
    }
    
    .modal-box input, 
    .modal-box select {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 15px;
        font-family: inherit;
    }
    
    .modal-box input:focus,
    .modal-box select:focus {
        outline: none;
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }
    
    .modal-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    
    .modal-buttons button {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
    }
    
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    
    .btn-secondary:hover {
        background: #e2e8f0;
    }
    
    .btn-primary {
        background: #1e3a5f;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary:hover {
        background: #0f2b4f;
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background: #dc2626;
    }
    
    .header-content {
        background: white;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }
    
    .header-content h2 {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 8px 0;
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        flex-wrap: wrap;
    }
    
    .header-content h2 i {
        color: #1e3a5f;
        font-size: 28px;
    }
    
    .service-count {
        background: #1e3a5f;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 14px;
        margin-left: 10px;
    }
    
    .header-content p {
        color: #64748b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .status-legend {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
        font-size: 11px;
    }
    
    .status-legend span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .status-legend .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .dot-up { background: #10b981; }
    .dot-warning { background: #f59e0b; }
    .dot-down { background: #ef4444; }
    .dot-unknown { background: #64748b; }
    
    .card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: visible;
        }
        
        .modern-table thead {
            display: none;
        }
        
        .modern-table,
        .modern-table tbody,
        .modern-table tr,
        .modern-table td {
            display: block;
            width: 100%;
        }
        
        .modern-table tr {
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            background: white;
            position: relative;
        }
        
        .modern-table td {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 0;
            border: none;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .modern-table td:last-child {
            border-bottom: none;
        }
        
        .modern-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #1e293b;
            min-width: 100px;
            font-size: 12px;
        }
        
        .modern-table td[data-label="Aksi"] {
            flex-direction: column;
        }
        
        .modern-table td[data-label="Aksi"]::before {
            margin-bottom: 5px;
        }
        
        .action-buttons {
            width: 100%;
            justify-content: flex-start;
        }
        
        .uptime-container {
            width: 100%;
        }
        
        .header-content h2 {
            font-size: 1.2rem;
        }
        
        .btn-primary {
            padding: 8px 16px;
            font-size: 12px;
        }
        
        .search-box {
            width: 100%;
        }
        
        .search-box input {
            max-width: 100%;
        }
        
        .table-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .per-page-selector {
            justify-content: space-between;
        }
        
        .pagination-wrapper {
            gap: 4px;
        }
        
        .page-btn {
            padding: 4px 8px;
            font-size: 11px;
        }
        
        .page-info {
            font-size: 10px;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .modern-table th,
        .modern-table td {
            padding: 8px;
            font-size: 11px;
        }
        
        .btn-check, .btn-edit, .btn-delete {
            padding: 3px 6px;
            font-size: 9px;
        }
        
        .percent-text-small {
            font-size: 0.8rem;
        }
        
        .progress-bar-small {
            height: 14px;
        }
    }
    
    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .modern-table th {
        text-align: left;
        padding: 12px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #475569;
        font-size: 13px;
    }
    
    .modern-table td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: top;
    }
    
    .table-responsive {
        overflow-x: visible;
    }
    
    .url-code {
        font-family: monospace;
        font-size: 0.75rem;
        word-break: break-all;
        white-space: normal;
        display: inline-block;
    }
    
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }
    
    .modal-box {
        background: white;
        border-radius: 20px;
        padding: 25px;
        width: 90%;
        max-width: 450px;
        animation: slideUp 0.3s ease;
    }
    
    .modal-box h3 {
        margin-bottom: 20px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<div class="page-header">
    <div class="header-content">
        <h2>
            <i class="fas fa-server"></i>
            Daftar Service
            <span class="service-count" id="serviceCount">0 Service</span>
        </h2>
        <p>
            <i class="fas fa-info-circle"></i>
            Kelola semua service monitoring - Setiap service memiliki uptime rate masing-masing
        </p>
        <div class="status-legend">
            <span><span class="dot dot-up"></span> UP - Normal (Berfungsi)</span>
            <span><span class="dot dot-warning"></span> WARNING - Perlu Perhatian</span>
            <span><span class="dot dot-down"></span> DOWN - Tidak Berfungsi</span>
            <span><span class="dot dot-unknown"></span> UNKNOWN (Belum Dicek)</span>
        </div>
    </div>
</div>

<div class="table-toolbar">
    <button class="btn-primary" onclick="openServiceModal()">
        <i class="fas fa-plus"></i> Tambah Service
    </button>
    
    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
        <div class="auto-refresh-indicator">
            <i class="fas fa-clock"></i>
            <span>Update: setiap 5 menit</span>
        </div>
        
        <div class="per-page-selector">
            <label><i class="fas fa-eye"></i> Tampilkan:</label>
            <select id="perPageSelect">
                <option value="10" selected>10 data</option>
                <option value="20" >20 data</option>
                <option value="30">30 data</option>
                <option value="50">50 data</option>
            </select>
        </div>
        
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari service..." onkeyup="searchServices()">
        </div>
    </div>
</div>

<div class="card">
    <div id="internetBannerContainer"></div>
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Nama & Detail</th>
                    <th>URL</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Uptime Rate</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="serviceTableBody">
                @if(isset($services) && count($services) > 0)
                    @foreach($services as $service)
                    <tr>
                        <td data-label="Nama">
                            <strong>{{ $service->name }}</strong>
                            <div class="detail-info">
                                <span>🕐 {{ $service->last_checked ? $service->last_checked->format('d/m/Y H:i:s') : 'Belum dicek' }}</span>
                            </div>
                        </td>
                        <td data-label="URL">
                            <code class="url-code">{{ $service->url }}</code>
                        </td>
                        <td data-label="Tipe">
                            <span class="type-badge {{ $service->service_type == 'HTTP' ? 'type-http' : 'type-ping' }}">
                                {{ $service->service_type == 'HTTP' ? '🌐' : '📡' }} {{ $service->service_type }}
                            </span>
                        </td>
                        <td data-label="Status">
                            @php
                                $statusClass = 'status-unknown';
                                $statusText = 'UNKNOWN';
                                if($service->last_status == 'UP') { $statusClass = 'status-up'; $statusText = 'UP - Normal'; }
                                elseif($service->last_status == 'WARNING') { $statusClass = 'status-warning'; $statusText = 'WARNING - Perlu Perhatian'; }
                                elseif($service->last_status == 'DOWN') { $statusClass = 'status-down'; $statusText = 'DOWN - Tidak Berfungsi'; }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="fas fa-circle"></i> {{ $statusText }}
                            </span>
                            @if($service->last_status == 'DOWN')
                                <div class="detail-info">
                                    <span class="down-reason">📋 {{ $service->last_down_detail ?? 'Tidak ada detail' }}</span>
                                    <span>🔢 Code: {{ $service->last_status_code ?? '-' }} | ⏱️ {{ $service->last_response_time ? number_format($service->last_response_time, 2) . 's' : '-' }}</span>
                                </div>
                            @endif
                        </td>
                        <td data-label="Uptime">
                            @php
                                $uptime = $service->uptime_percentage ?? 100;
                                $progressColor = $uptime >= 90 ? 'linear-gradient(90deg, #06d6a0, #059669)' : ($uptime >= 70 ? 'linear-gradient(90deg, #facc15, #eab308)' : 'linear-gradient(90deg, #ef4444, #dc2626)');
                            @endphp
                            <div class="uptime-container">
                                <div class="percent-text-small">{{ $uptime }}%</div>
                                <div class="progress-bar-small">
                                    <div class="progress-fill-small" style="width: {{ $uptime }}%; background: {{ $progressColor }};">
                                        {{ $uptime >= 30 ? $uptime . '%' : '' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Aksi">
                            <div class="action-buttons">
                                <button class="btn-check" onclick="manualCheck({{ $service->id }})" title="Cek Status">
                                    <i class="fas fa-sync-alt"></i> Cek
                                </button>
                                <a href="{{ route('services.edit', $service->id) }}" class="btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn-delete delete-btn" data-id="{{ $service->id }}" data-name="{{ $service->name }}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data service</p>
                            <button class="btn-primary" onclick="openServiceModal()" style="margin-top: 10px;">
                                <i class="fas fa-plus"></i> Tambah Service Sekarang
                            </button>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div id="pagination"></div>