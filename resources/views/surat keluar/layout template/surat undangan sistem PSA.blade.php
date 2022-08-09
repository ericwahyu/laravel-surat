@extends('surat keluar.layout template.layout template')
@section('generate')
    <div class="card">
        <div class="card-header">
            <h4>Generate Surat</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label style="font-size: 16px">Tempat Surat</label>
                    <input type="text" class="form-control @error('tempat_surat') is-invalid @enderror" name="tempat_surat" placeholder="Surabaya" value="{{ old('tempat_surat') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label style="font-size: 16px">Tanggal Surat</label>
                    <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label style="font-size: 16px">Nomor Surat</label>
                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" name="nomor_surat" placeholder="0123/PSI/ITATS/2021" value="{{ old('nomor_surat') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label style="font-size: 16px">Perihal Surat</label>
                    <input type="text" class="form-control @error('perihal_surat') is-invalid @enderror" name="perihal_surat"  value="Undangan Sosialisasi Sistem Pelayanan Satu Atap Online[beta]" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label style="font-size: 16px">Lampiran Surat</label>
                    <input type="text" class="form-control @error('lampiran_surat') is-invalid @enderror" name="lampiran_surat" placeholder="Satu Lembar" value="{{ old('lampiran_surat') }}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Tujuan Surat</label>
                <input type="text" class="form-control @error('tujuan_surat') is-invalid @enderror" name="tujuan_surat" value="Kabag Unit/Staf Admin Fakultas/Marketing, Humas, dan PSA" required>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Salam Pembuka</label>
                <textarea name="pembuka_surat" class="form-control @error('pembuka_surat') is-invalid @enderror" cols="30" rows="100">Sehubungan dengan rencana digitalisasi pelayanan mahasiswa di lingkungan Institut Teknologi Adhi Tama Surabaya (seperti pengurusan: DHS, Surat Aktif Kuliah, Surat Keterangan Lulus, dan lain-lain) yang sebelumnya digawangi oleh unit Pelayanan Satu Atap (PSA), dengan ini kami mengundang Bapak/Ibu Kabag Unit, Staf Admin Fakultas, serta Staf Marketing, Humas, dan PSA untuk menghadiri acara Sosialisasi Sistem Pelayanan Satu Atap Online[beta] pada:</textarea>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Isi Surat</label>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label style="font-size: 14px">Paragraf 1</label>
                    </div>
                    <div class="form-group col-md-10">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Hari, Tanggal</label>
                            </div>
                            <div class="form-group col-md-2">
                                <select class="form-control @error('hari') is-invalid @enderror" name="hari" required>
                                    <option disabled selected>-- Pilih Hari --</option>
                                    <option value="Senin" {{ (old("hari") == 'Senin' ? "selected":"") }}>Senin</option>
                                    <option value="Selasa" {{ (old("hari") == 'Selasa' ? "selected":"") }}>Selasa</option>
                                    <option value="Rabu" {{ (old("hari") == 'Rabu' ? "selected":"") }}>Rabu</option>
                                    <option value="Kamis" {{ (old("hari") == 'Kamis' ? "selected":"") }}>Kamis</option>
                                    <option value="Jum'at" {{ (old("hari") == "Jum'at" ? "selected":"") }}>Jum'at</option>
                                    <option value="Sabtu" {{ (old("hari") == 'Sabtu' ? "selected":"") }}>Sabtu</option>
                                    <option value="Minggu" {{ (old("hari") == 'Minggu' ? "selected":"") }}>Minggu</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" placeholder="Tuliskan Sesuatu" value="{{ old('tanggal') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Waktu</label>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="time" class="form-control @error('jam') is-invalid @enderror" name="jam" placeholder="Tuliskan Sesuatu" value="{{ old('jam') }}" required>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" class="form-control @error('') is-invalid @enderror" name="" placeholder="" value="WIB s.d. selesai" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-7 offset-md-2">
                                <input type="text" class="form-control @error('waktu_catatan') is-invalid @enderror" name="waktu_catatan" placeholder="" value="(diawali makan siang bersama)" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Tempat</label>
                            </div>
                            <div class="form-group col-md-7">
                                <input type="text" class="form-control @error('tempat') is-invalid @enderror" name="tempat" placeholder="Tuliskan Sesuatu" value="{{ old('tempat') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Salam Penutup</label>
                <textarea name="penutup_surat" class="form-control @error('penutup_surat') is-invalid @enderror" cols="30" rows="10">Demikian undangan ini kami sampaikan. Atas perhatian Bapak/Ibu, kami ucapkan terima kasih.</textarea>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Pengesahan</label>
                <div class="row">
                    <div class="form-group col-md-6 text-center">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <p><b>Tertanda</b></p>
                            </div>
                            <div class="card-body">
                                <label style="font-size: 14px">hormat saya, </label>
                                <select class="form-control @error('tertanda_1') is-invalid @enderror" name="tertanda_1" required>
                                    <option disabled selected>--Tertanda--</option>
                                    @foreach ($dosen as $dosens)
                                        <option value="{{ $dosens->user_id }}" {{ (old("tertanda_1") == $dosens->user_id ? "selected":"") }}>{{ $dosens->nama }}</option>
                                    @endforeach
                                    @foreach ($mahasiswa as $mahasiswas)
                                        <option value="{{ $mahasiswas->user_id }}" {{ (old("tertanda_1") == $mahasiswas->user_id ? "selected":"") }}>{{ $mahasiswas->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Buat Surat dan Simpan Data</button>
        </div>
    </div>
@endsection
