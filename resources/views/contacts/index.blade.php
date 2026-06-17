<h1>Contacts</h1>@extends('layouts.app')

@section('content')
<style>
    .contact-header {
        background: white;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
    }
    
    .contact-header h2 {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 8px 0;
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .contact-header h2 i {
        color: #1e3a5f;
        font-size: 28px;
    }
    
    .contact-header p {
        color: #64748b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .contact-count {
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 14px;
        margin-left: 10px;
    }
    
    .info-chip {
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .info-chip i {
        color: #3b82f6;
        font-size: 12px;
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
        width: 250px;
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
    
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
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
        text-decoration: none;
    }
    
    .btn-primary:hover {
        background: #0f2b4f;
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-edit {
        background: #f59e0b;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }
    
    .btn-edit:hover {
        background: #d97706;
        transform: translateY(-1px);
        color: white;
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
        color: white;
    }
    
    .btn-icon {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-icon:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    
    .contact-name {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .avatar i {
        font-size: 1.5rem;
        color: #4361ee;
    }
    
    .contact-info {
        display: flex;
        flex-direction: column;
    }
    
    .contact-name-text {
        font-weight: 600;
        color: #1e293b;
    }
    
    .phone-number {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f0fdf4;
        color: #166534;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
    }
    
    .phone-number i {
        color: #25D366;
        font-size: 14px;
    }
    
    .card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .modern-table th {
        text-align: left;
        padding: 14px 12px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
    }
    
    .modern-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    
    .modern-table tr:hover td {
        background: #f8fafc;
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
        gap: 8px;
        margin-top: 20px;
        flex-wrap: wrap;
        padding: 15px;
        background: #f8fafc;
        border-radius: 12px;
    }
    
    .page-btn {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #1e293b;
        font-size: 13px;
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
        margin-left: 12px;
        padding: 6px 12px;
        background: #e2e8f0;
        border-radius: 8px;
        font-size: 12px;
        color: #475569;
    }
    
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
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
    
    .modal-box input {
        width: 100%;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        margin-bottom: 15px;
        font-family: inherit;
    }
    
    .modal-box input:focus {
        outline: none;
        border-color: #1e3a5f;
    }
    
    .modal-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    
    .modal-buttons button {
        flex: 1;
        padding: 12px;
        border-radius: 10px;
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
    
    .btn-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background: #dc2626;
    }
    
    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .contact-header h2 { font-size: 1.2rem; }
        .btn-primary { padding: 8px 16px; font-size: 12px; }
        .search-box input { width: 180px; font-size: 12px; }
        .modern-table th, .modern-table td { padding: 10px 8px; font-size: 12px; }
        .action-buttons { flex-direction: column; gap: 5px; }
        .btn-edit, .btn-delete, .btn-icon { padding: 4px 8px; font-size: 10px; }
        .contact-name { gap: 8px; }
        .avatar { width: 32px; height: 32px; }
        .avatar i { font-size: 1.2rem; }
        .phone-number { padding: 4px 8px; font-size: 11px; }
    }
</style>

<div class="contact-header">
    <h2>
        <i class="fas fa-address-book"></i>
        Daftar Kontak
        <span class="contact-count" id="contactCount">0 Kontak</span>
    </h2>
    <p>
        <i class="fas fa-info-circle"></i>
        Kelola kontak untuk menerima notifikasi WhatsApp
        <span class="info-chip">
            <i class="fas fa-bell"></i> Notifikasi Aktif
        </span>
        <span class="info-chip">
            <i class="fab fa-whatsapp"></i> Format: 628xxxxxxxxxx
        </span>
    </p>
</div>

<div class="table-toolbar">
    <a href="{{ route('contacts.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Kontak
    </a>
    
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari kontak..." onkeyup="searchContacts()">
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Nama</th>
                    <th><i class="fab fa-whatsapp"></i> Nomor WhatsApp</th>
                    <th><i class="fas fa-cog"></i> Aksi</th>
                </tr>
            </thead>
            <tbody id="contactTableBody">
                @if(isset($contacts) && count($contacts) > 0)
                    @foreach($contacts as $contact)
                    <tr>
                        <td data-label="Nama">
                            <div class="contact-name">
                                <div class="avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div class="contact-info">
                                    <span class="contact-name-text">{{ $contact->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td data-label="WhatsApp">
                            <span class="phone-number">
                                <i class="fab fa-whatsapp"></i> {{ $contact->phone_number }}
                            </span>
                        </td>
                        <td data-label="Aksi">
                            <div class="action-buttons">
                                <a href="{{ route('contacts.edit', $contact->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn-delete delete-btn" 
                                        data-id="{{ $contact->id }}" 
                                        data-name="{{ $contact->name }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                                <button class="btn-icon" onclick="copyToClipboard('{{ $contact->phone_number }}')" title="Salin nomor WhatsApp">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="empty-state">
                            <i class="fas fa-address-book"></i>
                            <p>Belum ada data kontak</p>
                            <a href="{{ route('contacts.create') }}" class="btn-primary" style="margin-top: 10px;">
                                <i class="fas fa-plus"></i> Tambah Kontak Sekarang
                            </a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div id="pagination"></div>
</div>

<!-- MODAL DELETE CONFIRMATION -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <h3>
            <i class="fas fa-trash-alt"></i> Konfirmasi Hapus
        </h3>
        <p id="deleteText">Yakin ingin menghapus kontak ini?</p>
        <div class="modal-buttons">
            <button type="button" class="btn-danger" id="btnConfirmDelete">
                <i class="fas fa-check"></i> Ya, Hapus
            </button>
            <button type="button" class="btn-secondary" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Batal
            </button>
        </div>
    </div>
</div>

<script>
    // ===============================
    // COPY TO CLIPBOARD
    // ===============================
    async function copyToClipboard(text) {
        if (!text) {
            alert('Tidak ada nomor untuk disalin');
            return;
        }
        try {
            await navigator.clipboard.writeText(text);
            alert('Nomor WhatsApp berhasil disalin: ' + text);
        } catch (err) {
            // Fallback
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('Nomor WhatsApp berhasil disalin: ' + text);
        }
    }
    
    // ===============================
    // DELETE MODAL
    // ===============================
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const modal = document.getElementById('deleteModal');
            const deleteText = document.getElementById('deleteText');
            
            modal.style.display = 'flex';
            deleteText.innerHTML = `Yakin ingin menghapus kontak <b>${name}</b>?`;
            
            document.getElementById('btnConfirmDelete').onclick = function() {
                // Submit form delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/contacts/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            };
        });
    });
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }
    
    window.onclick = function(e) {
        const modal = document.getElementById('deleteModal');
        if (e.target === modal) closeDeleteModal();
    };
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
    
    // ===============================
    // SEARCH
    // ===============================
    function searchContacts() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.querySelector('.modern-table');
        const tr = table.getElementsByTagName('tr');
        
        for (let i = 1; i < tr.length; i++) {
            const tdName = tr[i].getElementsByTagName('td')[0];
            if (tdName) {
                const textValue = tdName.textContent || tdName.innerText;
                tr[i].style.display = textValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }
</script>
@endsection