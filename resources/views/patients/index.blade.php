@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Data Pasien</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#patientModal">Tambah Pasien</button>

        <div class="mb-3">
            <label for="filterHospital">Filter Rumah Sakit</label>
            <select id="filterHospital" class="form-select">
                <option value="">-- Semua Rumah Sakit --</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
            </select>
        </div>

        <table class="table table-bordered" id="patientsTable">
            <thead>
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

    <!-- Modal -->
    <div class="modal fade" id="patientModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="patientForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah/Edit Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="patientId">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>No Telp</label>
                            <input type="text" id="no_telp" name="no_telp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Rumah Sakit</label>
                            <select id="hospital_id" name="hospital_id" class="form-control">
                                <option value="">-- Pilih Rumah Sakit --</option>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                            <td>${p.nama}</td>
                            <td>${p.alamat}</td>
                            <td>${p.no_telp}</td>
                            <td>${p.hospital.name}</td>
                            <td>
                                <button class="btn btn-sm btn-warning editBtn" data-id="${p.id}">Edit</button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${p.id}">Hapus</button>
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
