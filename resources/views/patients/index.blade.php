@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header Section with improved styling -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="text-primary fw-bold">
                <i class="fas fa-hospital-user me-2"></i>Data Pasien
            </h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#patientModal">
                <i class="fas fa-plus-circle me-2"></i>Tambah Pasien
            </button>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label for="filterHospital" class="form-label fw-bold">
                        <i class="fas fa-filter me-2"></i>Filter Rumah Sakit
                    </label>
                    <select id="filterHospital" class="form-select">
                        <option value="">-- Semua Rumah Sakit --</option>
                        @foreach ($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="patientsTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Telp</th>
                            <th>Rumah Sakit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Improved Modal -->
<div class="modal fade" id="patientModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="patientForm">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Tambah/Edit Pasien
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="patientId">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No Telp</label>
                        <input type="tel" id="no_telp" name="no_telp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rumah Sakit</label>
                        <select id="hospital_id" name="hospital_id" class="form-select">
                            <option value="">-- Pilih Rumah Sakit --</option>
                            @foreach ($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .btn-sm {
        border-radius: 4px;
    }
    .card {
        border: none;
        border-radius: 8px;
    }
    .modal-content {
        border: none;
        border-radius: 8px;
    }
    .form-control, .form-select {
        border-radius: 6px;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(function() {
        loadPatients();

        function loadPatients(hospitalId = '') {
            let url = '/patients/list';
            if (hospitalId) {
                url += '?hospital_id=' + hospitalId;
            }

            $.get(url, function(data) {
                let rows = '';
                data.forEach(p => {
                    rows += `
                    <tr>
                        <td>${p.id}</td>
                        <td>
                            <i class="fas fa-user me-2 text-primary"></i>${p.nama}
                        </td>
                        <td>${p.alamat}</td>
                        <td>
                            <i class="fas fa-phone me-2 text-success"></i>${p.no_telp}
                        </td>
                        <td>
                            <i class="fas fa-hospital me-2 text-info"></i>${p.hospital.name}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning editBtn me-1" data-id="${p.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="${p.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                });
                $('#patientsTable tbody').html(rows);
            });
        }


        $('#filterHospital').on('change', function() {
            let hospitalId = $(this).val();
            loadPatients(hospitalId);
        });

        $('#patientForm').submit(function(e) {
            e.preventDefault();
            let id = $('#patientId').val();
            let data = {
                nama: $('#nama').val(),
                alamat: $('#alamat').val(),
                no_telp: $('#no_telp').val(),
                hospital_id: $('#hospital_id').val(),
                _token: '{{ csrf_token() }}'
            };

            if (id) {
                $.ajax({
                    url: '/patients/' + id,
                    type: 'PUT',
                    data: data,
                    success: function() {
                        $('#patientModal').modal('hide');
                        loadPatients($('#filterHospital').val());
                    }
                });
            } else {
                $.post('/patients', data, function() {
                    $('#patientModal').modal('hide');
                    loadPatients($('#filterHospital').val());
                });
            }
        });


        $(document).on('click', '.editBtn', function() {
            let id = $(this).data('id');
            $.get('/patients/list', function(data) {
                let patient = data.find(p => p.id == id);
                $('#patientId').val(patient.id);
                $('#nama').val(patient.nama);
                $('#alamat').val(patient.alamat);
                $('#no_telp').val(patient.no_telp);
                $('#hospital_id').val(patient.hospital_id);
                $('#patientModal').modal('show');
            });
        });


        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            if (confirm('Yakin hapus pasien ini?')) {
                $.ajax({
                    url: '/patients/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        loadPatients($('#filterHospital').val());
                    }
                });
            }
        });
    });
</script>
@endsection
