@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: fadeIn 0.3s ease;
    }

    .modern-form {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-group label i {
        color: #4361ee;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: #f8fafc;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #4361ee;
        background: white;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .form-text {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: #64748b;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        padding: 0.75rem 1.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .info-card {
        max-width: 600px;
        margin: 1.5rem auto 0;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid #bbf7d0;
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
    }

    .info-card h4 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0 0 0.75rem 0;
        color: #166534;
        font-size: 1rem;
        font-weight: 700;
    }

    .info-card ul {
        margin: 0;
        padding-left: 0;
        list-style: none;
    }

    .info-card ul li {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0;
        color: #14532d;
        font-size: 0.875rem;
    }

    .info-card ul li i {
        color: #22c55e;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .modern-form { padding: 1.5rem; }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-secondary { justify-content: center; }
    }
</style>

<div class="page-header">
    <div class="header-content">
        <h2>
            @if(isset($service))
                <i class="fas fa-edit"></i>
                <span class="title-text">Edit Service</span>
            @else
                <i class="fas fa-plus-circle"></i>
                <span class="title-text">Tambah Service</span>
            @endif
        </h2>
        <p>
            <span class="description-text">
                <i class="fas fa-info-circle"></i>
                @if(isset($service))
                    Ubah data service yang sudah ada
                @else
                    Tambahkan service baru untuk dipantau
                @endif
            </span>
        </p>
    </div>
</div>

<div class="form-container">
    <form method="POST" action="{{ isset($service) ? route('services.update', $service->id) : route('services.store') }}" class="modern-form">
        @csrf
        @if(isset($service))
            @method('PUT')
        @endif
        
        <div class="form-group">
            <label for="name">
                <i class="fas fa-tag"></i> Nama Service
            </label>
            <input type="text" id="name" name="name" placeholder="Contoh: Website Diskominfo" 
                   value="{{ old('name', $service->name ?? '') }}" required>
            <small class="form-text">Masukkan nama yang mudah diidentifikasi</small>
            @error('name')
                <span class="error-text" style="color:#dc2626;font-size:12px;display:block;margin-top:5px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="url">
                <i class="fas fa-link"></i> URL / IP Address
            </label>
            <input type="text" id="url" name="url" placeholder="https://example.com / 192.168.1.1" 
                   value="{{ old('url', $service->url ?? '') }}" required>
            <small class="form-text">Contoh: https://google.com atau 8.8.8.8</small>
            @error('url')
                <span class="error-text" style="color:#dc2626;font-size:12px;display:block;margin-top:5px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="service_type">
                <i class="fas fa-code-branch"></i> Tipe Service
            </label>
            <select id="service_type" name="service_type">
                <option value="HTTP" @if(old('service_type', $service->service_type ?? 'HTTP') == 'HTTP') selected @endif>
                    🌐 HTTP/HTTPS
                </option>
                <option value="PING" @if(old('service_type', $service->service_type ?? 'HTTP') == 'PING') selected @endif>
                    📡 PING
                </option>
            </select>
            <small class="form-text">
                <strong>HTTP:</strong> Untuk website/api &nbsp;&nbsp;|&nbsp;&nbsp;
                <strong>PING:</strong> Untuk server/IP address
            </small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                @if(isset($service)) Update Service @else Simpan Service @endif
            </button>
            <a href="{{ route('services.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<div class="info-card">
    <h4><i class="fas fa-lightbulb"></i> Tips Monitoring</h4>
    <ul>
        <li><i class="fas fa-check-circle"></i> Pastikan URL/IP dapat diakses</li>
        <li><i class="fas fa-check-circle"></i> Gunakan tipe HTTP untuk website</li>
        <li><i class="fas fa-check-circle"></i> Gunakan tipe PING untuk server</li>
    </ul>
</div>

<script>
    // ===============================
    // VALIDASI REALTIME
    // ===============================
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const urlInput = document.getElementById('url');
        
        if (nameInput) {
            nameInput.addEventListener('input', function() {
                this.style.borderColor = this.value.trim().length > 0 ? '#10b981' : '#e2e8f0';
            });
        }
        
        if (urlInput) {
            urlInput.addEventListener('input', function() {
                this.style.borderColor = this.value.trim().length > 0 ? '#10b981' : '#e2e8f0';
            });
        }
    });
</script>
@endsection