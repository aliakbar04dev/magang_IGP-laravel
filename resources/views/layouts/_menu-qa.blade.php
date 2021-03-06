@if (strlen(Auth::user()->username) == 5)
  @permission(['qc-plant-*','pica-view','pica-approve','pica-reject','qpr-email','qa-alatukur-*','qa-kalibrasi-*','qa-author-*','qa-audit-*','qa-sa-*','qc-usul-prob-approve'])
    <li class="header">QUALITY ASSURANCE NAVIGATION</li>
    @permission(['qc-plant-*','pica-view','pica-approve','pica-reject','qpr-email','qc-usul-prob-approve'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>QPR - PICA</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['qc-plant-*'])
            <li class="{{ route('qcmnpks.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('qcmnpks.index') }}"><i class="fa fa-circle-o"></i>Setting NPK/Plant</a>
            </li>
          @endpermission
          @permission(['pica-view','pica-approve','pica-reject'])
            <li class="{{ route('picas.all') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('picas.all') }}"><i class="fa fa-circle-o"></i>Daftar PICA</a>
            </li>
          @endpermission
          @permission(['pica-view','pica-approve','pica-reject'])
            <li class="{{ route('qprs.monitoring') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('qprs.monitoring') }}"><i class="fa fa-circle-o"></i>Quality Performance</a>
            </li>
          @endpermission
          @permission(['qpr-email'])
            <li class="{{ route('qpremails.index') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('qpremails.index') }}"><i class="fa fa-circle-o"></i>Email Supplier (QPR)</a>
            </li>
            @if (config('app.env', 'local') === 'production')
              <li>
                <a target="_blank" href="{{ route('apis.qprs') }}"><i class="fa fa-circle-o"></i>Send Notifikasi QPR</a>
              </li>
            @else 
              <li>
                <a target="_blank" href="{{ route('apis.qprstrial') }}"><i class="fa fa-circle-o"></i>Send Notifikasi QPR (TRIAL)</a>
              </li>
            @endif
          @endpermission
          @permission(['qc-usul-prob-approve'])
          <li class="{{ route('appusulprob.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('appusulprob.index') }}"><i class="fa fa-circle-o"></i>Approval Usulan Problem</a>
          </li>
          @endpermission
          <li>
            <a target="_blank" href="{{ route('qprs.userguide') }}"><i class="fa fa-book"></i>Download User Guide</a>
          </li>
        </ul>
      </li>
    @endpermission
    @permission(['qa-kalibrasi-*','qa-alatukur-*','qa-author-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>Calibration</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['qa-kalibrasi-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>MASTER</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu"> 
                <li class="{{ route('mstalatukurkal.index') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('mstalatukurkal.index') }}"><i class="fa fa-circle-o"></i>Alat Ukur</a>
                </li>
                <li class="{{ route('kalibrator.index') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('kalibrator.index') }}"><i class="fa fa-circle-o"></i>Kalibrator</a>
                </li>
                <li class="{{ route('klbrtemp.index') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('klbrtemp.index') }}"><i class="fa fa-circle-o"></i>Humidity - Temperature</a>
                </li>
                <li class="{{ route('konstanta.index') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('konstanta.index') }}"><i class="fa fa-circle-o"></i>Konstanta</a>
                </li>
              </ul>
            </li>
          @endpermission
          <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i> <span>TRANSACTION</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @permission(['qa-alatukur-*']) 
              <li class="{{ route('kalibrasi.index') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalibrasi.index') }}"><i class="fa fa-circle-o"></i>Permintaan Kalibrasi</a>
              </li>
              @endpermission
              @permission(['qa-kalibrasi-*'])        
              <li class="{{ route('kalworksheet.index') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalworksheet.index') }}"><i class="fa fa-circle-o"></i>Worksheet</a>
              </li>
              <li class="{{ route('kalserti.index') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalserti.index') }}"><i class="fa fa-circle-o"></i>Sertifikat</a>
              </li>             
              <li class="{{ route('kalibrasidet.indextarik') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalibrasidet.indextarik') }}"><i class="fa fa-circle-o"></i>Batal Permintaan Kalibrasi</a>
              </li>
              {{-- <li class="{{ route('kalibrasidet.index') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalibrasidet.index') }}"><i class="fa fa-circle-o"></i>Status Alat Ukur</a>
              </li> --}}
              @endpermission        
              @permission(['qa-author-*'])
              <li class="{{ route('kalworksheet.indexws') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalworksheet.indexws') }}"><i class="fa fa-circle-o"></i>View Worksheet</a>
              </li>
              <li class="{{ route('kalserti.indexapp') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalserti.indexapp') }}"><i class="fa fa-circle-o"></i>Autorisasi Sertifikat</a>
              </li>
              @endpermission
              @permission(['qa-alatukur-*']) 
              <li class="{{ route('kalserti.indexcust') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalserti.indexcust') }}"><i class="fa fa-circle-o"></i>Cetak Sertifikat</a>
              </li>
              <li class="{{ route('kalibrasidet.indexkembali') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalibrasidet.indexkembali') }}"><i class="fa fa-circle-o"></i>Pengambilan Alat Ukur</a>
              </li>
              @endpermission
            </ul>
          </li>
        </ul>
      </li>
    @endpermission
    @permission(['qa-audit-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>Audit</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i> <span>TRANSACTION</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu"> 
              <li class="{{ route('schedulecpp.index') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('schedulecpp.index') }}"><i class="fa fa-circle-o"></i>Schedule CPP</a>
              </li>        
              
            </ul>
          </li>
        </ul>
      </li>
    @endpermission
    @permission(['qa-sa-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>Special Acceptance</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i> <span>TRANSACTION</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @permission(['qa-sa-*']) 
              <li class="{{ route('qatsas.indexapp') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('qatsas.indexapp') }}"><i class="fa fa-circle-o"></i>Approval SA</a>
              </li>
              @endpermission
            </ul>
          </li>
        </ul>
      </li>
    @endpermission
  @endpermission
  @if (config('app.env', 'local') !== 'production')
      <li class="header">AUDIT NAVIGATION</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>AUDIT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ route('auditors.auditorform') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.auditorform') }}"><i class="fa fa-circle-o"></i>FORM AUDITOR</a>
          </li>
          @php $tahun = \Carbon\Carbon::now()->format("Y"); $bulan = \Carbon\Carbon::now()->format("m") @endphp
          <li class="{{ route('auditors.schedule', ['igpj', $tahun, 'I', 'latest']) == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.schedule', ['igpj', $tahun, 'I', 'latest']) }}"><i class="fa fa-circle-o"></i>FORM SCHEDULE AUDIT</a>
          </li>
          <li class="{{ route('auditors.turtleform') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.turtleform') }}"><i class="fa fa-circle-o"></i>FORM TURTLE DIAGRAM</a>
          </li>
          <li class="{{ route('auditors.temuanauditform') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.temuanauditform') }}"><i class="fa fa-circle-o"></i>FORM TEMUAN AUDIT</a>
          </li>
          <li class="{{ route('auditors.daftartemuan') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.daftartemuan') }}"><i class="fa fa-circle-o"></i>DAFTAR TEMUAN</a>
          </li>    
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>PICA AUDIT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>  
        <ul class="treeview-menu">
          <li class="{{ route('auditors.new_pica') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.new_pica') }}"><i class="fa fa-circle-o"></i>FORM PICA</a>
          </li>
          <li class="{{ route('auditors.daftar_pica') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.daftar_pica') }}"><i class="fa fa-circle-o"></i>DAFTAR PICA</a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i> <span>REPORT AUDIT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ route('auditors.daftar_auditor') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.daftar_auditor') }}"><i class="fa fa-circle-o"></i>DAFTAR AUDITOR</a>
          </li>
          <li class="{{ route('auditors.turtleform') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.turtleform') }}"><i class="fa fa-circle-o"></i>TURTLE DIAGRAM</a>
          </li>
          <li class="{{ route('auditors.grafik_temuan_ia') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('auditors.grafik_temuan_ia') }}"><i class="fa fa-circle-o"></i>GRAFIK TEMUAN IA</a>
          </li>
        </ul>
      </li>
  @endif
@endif
@if (strlen(Auth::user()->username) > 5)
  @permission(['qa-alatukur-*','qc-alatukur-*'])
      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-text-o"></i> <span>Calibration</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission(['qc-alatukur-*'])
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i> <span>MASTER</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu"> 
                <li class="{{ route('mstalatukur.index') == request()->url() ? 'active' : '' }}">
                  <a href="{{ route('mstalatukur.index') }}"><i class="fa fa-circle-o"></i>Alat Ukur</a>
                </li>
              </ul>
            </li>
          @endpermission
          @permission(['qa-alatukur-*']) 
          <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i> <span>TRANSACTION</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">              
              <li class="{{ route('kalibrasi.index') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalibrasi.index') }}"><i class="fa fa-circle-o"></i>Permintaan Kalibrasi</a>
              </li>              
              <li class="{{ route('kalserti.indexcust') == request()->url() ? 'active' : '' }}">
                <a href="{{ route('kalserti.indexcust') }}"><i class="fa fa-circle-o"></i>Cetak Sertifikat</a>
              </li>              
            </ul>
          </li>
          @endpermission
        </ul>
      </li>
  @endpermission
@endif