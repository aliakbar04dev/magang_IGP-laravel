@if (strlen(Auth::user()->username) == 5)
  <li class="header">EMPLOYEE INFO NAVIGATION</li>
  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-info-sign"></i> <span>INFO HRD</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      @if (config('app.env', 'local') === 'production')
        <li class="{{ route('mobiles.personaldata') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.personaldata') }}"><i class="fa fa-circle-o"></i>Personal Data</a>
        </li>
      @endif     
      <li class="{{ route('mobiles.absen') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.absen') }}"><i class="fa fa-circle-o"></i>Absensi</a>
      </li>
      @if (config('app.env', 'local') === 'production')
        <li class="{{ route('mobiles.slip') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.slip') }}"><i class="fa fa-circle-o"></i>Slip Gaji</a>
        </li>
      @endif
      <li class="{{ route('mobiles.saldocuti') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.saldocuti') }}"><i class="fa fa-circle-o"></i>Saldo Cuti</a>
      </li>
      <li class="{{ route('mobiles.nilaipk') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.nilaipk') }}"><i class="fa fa-circle-o"></i>Point Karya</a>
      </li>
      <li class="{{ route('mobiles.training') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.training') }}"><i class="fa fa-circle-o"></i>Training Record</a>
      </li>
      <li class="{{ route('mobiles.trainingmember') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.trainingmember') }}"><i class="fa fa-circle-o"></i>Training Record Member</a>
      </li>
      <li class="{{ route('mobiles.daftaremail') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.daftaremail') }}"><i class="fa fa-circle-o"></i>Daftar Email</a>
      </li>
      <li class="{{ route('mobiles.daftarinitial') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.daftarinitial') }}"><i class="fa fa-circle-o"></i>Daftar Inisial</a>
      </li>
      <li class="{{ route('mobiles.daftarext') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.daftarext') }}"><i class="fa fa-circle-o"></i>Daftar EXT</a>
      </li>
      <li class="{{ route('mobiles.daftartelp') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.daftartelp') }}"><i class="fa fa-circle-o"></i>Daftar Telp</a>
      </li>
      <li class="{{ route('mobiles.dob') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.dob') }}"><i class="fa fa-circle-o"></i>Daftar Ulang Tahun</a>
      </li>
      @if (config('app.env', 'local') === 'production')
        <li class="{{ route('mobiles.monitoringpkl') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.monitoringpkl') }}"><i class="fa fa-circle-o"></i>Monitoring PKL</a>
        </li>
        <li class="{{ route('mobiles.koperasi') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.koperasi') }}"><i class="fa fa-circle-o"></i>Potongan Koperasi</a>
        </li>
      @endif
    </ul>
  </li>
  @if(Auth::user()->masKaryawan()->kd_pt === config('app.kd_pt', 'XXX'))
    <li class="treeview">
      <a href="#">
        <i class="glyphicon glyphicon-info-sign"></i> <span>FORM HRD</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @if (config('app.env', 'local') !== 'production')
          <li class="{{ route('pengajuancuti.daftarpengajuancuti') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('pengajuancuti.daftarpengajuancuti') }}"><i class="fa fa-circle-o"></i>Pengajuan Cuti</a>
          </li>
          <li class="{{ route('mobiles.izinterlambat') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.izinterlambat') }}"><i class="fa fa-circle-o"></i>Ijin Telat</a>
          </li>
          <li class="{{ route('mobiles.indexlupaprik') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indexlupaprik') }}"><i class="fa fa-circle-o"></i>Tidak Prik</a>
          </li>
          <li class="{{ route('mobiles.indeximp') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indeximp') }}"><i class="fa fa-circle-o"></i>IMP</a>
          </li>
          <li class="{{ route('mobiles.suketkaryawan') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.suketkaryawan') }}"><i class="fa fa-circle-o"></i>Buat Surat Keterangan</a>
          </li>
          <li class="{{ route('mobiles.RegistrasiUlangKaryawan') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.RegistrasiUlangKaryawan') }}"><i class="fa fa-circle-o"></i>Registrasi Ulang Karyawan</a>
          </li>
        @else 
          @if (Auth::user()->masKaryawan()->kode_div === "H" || Auth::user()->masKaryawan()->kode_div === "N")
            <li class="{{ route('pengajuancuti.daftarpengajuancuti') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('pengajuancuti.daftarpengajuancuti') }}"><i class="fa fa-circle-o"></i>Pengajuan Cuti</a>
            </li>
            <li class="{{ route('mobiles.izinterlambat') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mobiles.izinterlambat') }}"><i class="fa fa-circle-o"></i>Ijin Telat</a>
            </li>
            <li class="{{ route('mobiles.indexlupaprik') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mobiles.indexlupaprik') }}"><i class="fa fa-circle-o"></i>Tidak Prik</a>
            </li>
          @endif
        @endif
      </ul>
    </li>
  @endif
  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-info-sign"></i> <span>INFO GA</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="{{ route('mobiles.saldoobat') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.saldoobat') }}"><i class="fa fa-circle-o"></i>Saldo Pengobatan</a>
      </li>
      <li class="{{ route('mobiles.daftarrs') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.daftarrs') }}"><i class="fa fa-circle-o"></i>Daftar Rayon</a>
      </li>
      <li class="{{ route('mobiles.jadwaldokter') == request()->url() ? 'active' : '' }}">
        <a href="{{ route('mobiles.jadwaldokter') }}"><i class="fa fa-circle-o"></i>Jadwal Dokter</a>
      </li>
    </ul>
  </li>
  @if (config('app.env', 'local') !== 'production')
    <li class="treeview">
      <a href="#">
        <i class="glyphicon glyphicon-info-sign"></i> <span>FORM GA</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="{{ route('mobiles.permintaanuniform') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.permintaanuniform') }}"><i class="fa fa-circle-o"></i>Permintaan UniForm</a>
        </li>
        <li class="{{ route('mobiles.uniform_ga_master') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.uniform_ga_master') }}"><i class="fa fa-circle-o"></i>Master Uniform</a>
        </li>
        <li class="{{ route('mobiles.indexlpbuni') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.indexlpbuni') }}"><i class="fa fa-circle-o"></i>Laporan Penerimaan Uniform</a>
        </li>
        <li class="{{ route('mobiles.indexmutasiuni') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mobiles.indexmutasiuni') }}"><i class="fa fa-circle-o"></i>Laporan Mutasi Uniform</a>
        </li>
      </ul>
    </li>
  @endif
  @if (config('app.env', 'local') !== 'production')
    @if (substr(Auth::user()->masKaryawan()->kode_gol,0,1) === "4" || substr(Auth::user()->masKaryawan()->kode_gol,0,1) === "5" || substr(Auth::user()->masKaryawan()->kode_gol,0,1) === "6")
      <li class="treeview">
        <a href="#">
          <i class="glyphicon glyphicon-info-sign"></i> <span>APPROVAL</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ route('persetujuancuti.daftarpersetujuancuti') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('persetujuancuti.daftarpersetujuancuti') }}"><i class="fa fa-circle-o"></i>Pengajuan Cuti</a>
          </li>
          <li class="{{ route('mobiles.approvaltelat') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.approvaltelat') }}"><i class="fa fa-circle-o"></i>Ijin Telat</a>
          </li>
          <li class="{{ route('mobiles.indexapprovallupaprik') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indexapprovallupaprik') }}"><i class="fa fa-circle-o"></i>Tidak Prik</a>
          </li>
          {{-- <li class="{{ route('mobiles.indexapprovallupaprik_sechead') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indexapprovallupaprik_sechead') }}"><i class="fa fa-circle-o"></i>Tidak Prik By Sec Head</a>
          </li>
          <li class="{{ route('mobiles.indexapprovallupaprik_dephead') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indexapprovallupaprik_dephead') }}"><i class="fa fa-circle-o"></i>Tidak Prik Dep Head</a>
          </li>
          <li class="{{ route('mobiles.indexapprovallupaprik_divhead') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indexapprovallupaprik_divhead') }}"><i class="fa fa-circle-o"></i>Tidak Prik Div Head</a>
          </li> --}}
          <li class="{{ route('mobiles.indexapprovalimp') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.indexapprovalimp') }}"><i class="fa fa-circle-o"></i>IMP</a>
          </li>
          <li class="{{ route('mobiles.suketpengajuan') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.suketpengajuan') }}"><i class="fa fa-circle-o"></i>Surat Keterangan Pengajuan</a>
          </li>
          <li class="{{ route('mobiles.uniformappr') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.uniformappr') }}"><i class="fa fa-circle-o"></i>Permintaan UniForm</a>
          </li>
          <li class="{{ route('mobiles.uniformappr_ga') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mobiles.uniformappr_ga') }}"><i class="fa fa-circle-o"></i>Permintaan UniForm [GA]</a>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-circle-o"></i>Perintah Kerja Lembur
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{{ route('sect.viewhome') }}"><i class="fa fa-circle-o"></i>Section Head</a>
              </li>
              <li>
                <a href="{{ route('dept.viewhome') }}"><i class="fa fa-circle-o"></i>Departement Head</a>
              </li>
              <li>
                <a href="{{ route('div.viewhome') }}"><i class="fa fa-circle-o"></i>Division Head</a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
    @endif
  @else
    @if (Auth::user()->masKaryawan()->kode_div === "H" || Auth::user()->masKaryawan()->kode_div === "N")
      @if (substr(Auth::user()->masKaryawan()->kode_gol,0,1) === "4" || substr(Auth::user()->masKaryawan()->kode_gol,0,1) === "5" || substr(Auth::user()->masKaryawan()->kode_gol,0,1) === "6")
        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-info-sign"></i> <span>APPROVAL</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ route('persetujuancuti.daftarpersetujuancuti') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('persetujuancuti.daftarpersetujuancuti') }}"><i class="fa fa-circle-o"></i>Pengajuan Cuti</a>
            </li>
            <li class="{{ route('mobiles.approvaltelat') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mobiles.approvaltelat') }}"><i class="fa fa-circle-o"></i>Ijin Telat</a>
            </li>
            <li class="{{ route('mobiles.indexapprovallupaprik') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mobiles.indexapprovallupaprik') }}"><i class="fa fa-circle-o"></i>Tidak Prik</a>
            </li>
            {{-- <li class="{{ route('mobiles.indexapprovallupaprik_sechead') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mobiles.indexapprovallupaprik_sechead') }}"><i class="fa fa-circle-o"></i>Tidak Prik By Sec Head</a>
            </li>
            <li class="{{ route('mobiles.indexapprovallupaprik_dephead') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mobiles.indexapprovallupaprik_dephead') }}"><i class="fa fa-circle-o"></i>Tidak Prik Dep Head</a>
            </li>
            <li class="{{ route('mobiles.indexapprovallupaprik_divhead') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('mobiles.indexapprovallupaprik_divhead') }}"><i class="fa fa-circle-o"></i>Tidak Prik Div Head</a>
            </li> --}}
          </ul>
        </li>
      @endif
    @endif
  @endif
  {{-- @if (config('app.env', 'local') === 'production') --}}
    <li class="treeview">
      <a href="#">
        <i class="glyphicon glyphicon-info-sign"></i> <span>Ruang Rapat</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="{{ url('/rr/001') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT 1</a>
          <a href="{{ url('/rr/002') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT 2</a>
          <a href="{{ url('/rr/003') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT HRD</a>
          <a href="{{ url('/rr/004') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT IT</a>
          <a href="{{ url('/rr/005') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT PROJECT</a>
          <a href="{{ url('/rr/006') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT ADMIN 2</a>
          <a href="{{ url('/rr/007') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT PRC 1</a>
          <a href="{{ url('/rr/008') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT PRC 2</a>
          <a href="{{ url('/rr/009') }}" target="_blank"><i class="fa fa-circle-o"></i>R. RAPAT 4</a>
          <a href="{{ url('/rr/010') }}" target="_blank"><i class="fa fa-circle-o"></i>RR QA - IGP1</a>
          <a href="{{ url('/rr/011') }}" target="_blank"><i class="fa fa-circle-o"></i>RR QCC IGP1</a>
          <a href="{{ url('/rr/012') }}" target="_blank"><i class="fa fa-circle-o"></i>RR PRODUKSI IGP1</a>
          <a href="{{ url('/rr/013') }}" target="_blank"><i class="fa fa-circle-o"></i>RR TRANSMISI - IGP1</a>
          <a href="{{ url('/rr/014') }}" target="_blank"><i class="fa fa-circle-o"></i>RR HOUSING IGP2</a>
        </li>
      </ul>
    </li>
  {{-- @endif --}}
@endif