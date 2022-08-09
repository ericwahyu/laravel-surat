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
                    <input type="text" class="form-control @error('perihal_surat') is-invalid @enderror" name="perihal_surat" placeholder="Surat Permohonan Beasiswa" value="{{ old('perihal_surat') }}" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label style="font-size: 16px">Lampiran Surat</label>
                    <input type="text" class="form-control @error('lampiran_surat') is-invalid @enderror" name="lampiran_surat" placeholder="1 lembar" value="{{ old('lampiran_surat') }}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Tujuan Surat</label>
                <input type="text" class="form-control @error('tujuan_surat') is-invalid @enderror" name="tujuan_surat" placeholder="Rektor Institut Adhi Tama Surabaya" value="{{ old('tujuan_surat') }}" required>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Salam Pembuka</label>
                <textarea name="pembuka_surat" class="form-control @error('pembuka_surat') is-invalid @enderror" cols="30" rows="10">Dengan hormat, </textarea>
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
                        <textarea name="paragraf_1" class="form-control @error('paragraf_1') is-invalid @enderror" cols="30" rows="10">Sehubungan dengan adanya informasi pemberian bantuan dana pendidikan (Beasiswa) dari . . . . . . . . . kepada mahasiswa kurang mampu, maka saya : </textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label style="font-size: 14px">Paragraf 2</label>
                    </div>
                    <div class="form-group col-md-10">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Nama</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('paragraf_21') is-invalid @enderror" name="paragraf_21" placeholder="Tuliskan Sesuatu" value="{{ old('paragraf_21') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">NPM</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('paragraf_22') is-invalid @enderror" name="paragraf_22" placeholder="Tuliskan Sesuatu" value="{{ old('paragraf_22') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Semester</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('paragraf_23') is-invalid @enderror" name="paragraf_23" placeholder="Tuliskan Sesuatu" value="{{ old('paragraf_23') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Fakultas</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('paragraf_24') is-invalid @enderror" name="paragraf_24" placeholder="Tuliskan Sesuatu" value="{{ old('paragraf_24') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Jurusan</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('paragraf_25') is-invalid @enderror" name="paragraf_25" placeholder="Tuliskan Sesuatu" value="{{ old('paragraf_25') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Tempat, Tgl. Lahir</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('paragraf_26') is-invalid @enderror" name="paragraf_26" placeholder="Tuliskan Sesuatu" value="{{ old('paragraf_26') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label style="font-size: 14px">Alamat</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('paragraf_27') is-invalid @enderror" name="paragraf_27" placeholder="Tuliskan Sesuatu" value="{{ old('paragraf_27') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label style="font-size: 14px">Paragraf 3</label>
                    </div>
                    <div class="form-group col-md-10">
                        <textarea name="paragraf_3" class="form-control @error('paragraf_3') is-invalid @enderror" cols="30" rows="10">Dengan ini mengajukan permohonan beasiswa kepada Bapak/Ibu. Sebagai bahan pertimbangan saya melampirkan beberapa berkas persyaratan sebagai berikut :</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label style="font-size: 14px">Paragraf 4</label>
                    </div>
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control @error('paragraf_41') is-invalid @enderror" name="paragraf_41" value="Foto copy KTP" required>
                    </div>
                    <div class="form-group col-md-10 offset-md-2">
                        <input type="text" class="form-control @error('paragraf_42') is-invalid @enderror" name="paragraf_42" value="Foto copy KTM" required>
                    </div>
                    <div class="form-group col-md-10 offset-md-2">
                        <input type="text" class="form-control @error('paragraf_43') is-invalid @enderror" name="paragraf_43" value="Surat Keterangan Mahasiswa Aktif" required>
                    </div>
                    <div class="form-group col-md-10 offset-md-2">
                        <input type="text" class="form-control @error('paragraf_44') is-invalid @enderror" name="paragraf_44" value="Surat Keterangan Tidak Menerima Beasiswa Lain" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label style="font-size: 16px">Salam Penutup</label>
                <textarea name="penutup_surat" class="form-control @error('penutup_surat') is-invalid @enderror" cols="30" rows="10">Demikian surat permohonan beasiswa ini saya buat, atas segala perhatian dan partisipasi Bapak/Ibu kami ucapkan terima kasih.</textarea>
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
                            <div class="card-header ">
                                <p><b>Tertanda</b></p>
                            </div>
                            <div class="card-body">
                                <label style="font-size: 14px">hormat saya, </label>
                                <select class="form-control @error('tertanda_1') is-invalid @enderror" name="tertanda_1" required>
                                    <option disabled selected>--Tertanda--</option>
                                    @foreach ($dosen as $dosens)
                                        <option value="{{ $dosens->user_id }}">{{ $dosens->nama }}</option>
                                    @endforeach
                                    @foreach ($mahasiswa as $mahasiswas)
                                        <option value="{{ $mahasiswas->user_id }}">{{ $mahasiswas->nama }}</option>
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
