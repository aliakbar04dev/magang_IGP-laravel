@permission(['mtc-*','dashboar-andon'])
  <li class="header">MAINTENANCE NAVIGATION</li>
  @permission(['mtc-plant-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>MASTER</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['mtc-plant-*'])
          <li class="{{ route('mtcmnpks.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtcmnpks.index') }}"><i class="fa fa-circle-o"></i>NPK/Plant</a>
          </li>
        @endpermission
        @permission(['mtc-setting-oli-*'])
          <li class="{{ route('mtctmoilings.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctmoilings.index') }}"><i class="fa fa-circle-o"></i>Setting Jenis Oli/Mesin</a>
          </li>
        @endpermission
        @permission(['mtc-master-*'])
          <li class="{{ route('mtcmesin.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtcmesin.index') }}"><i class="fa fa-circle-o"></i>Mesin</a>
          </li>
        @endpermission
        @permission(['mtc-master-*'])
          <li class="{{ route('mtcmasicheck.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtcmasicheck.index') }}"><i class="fa fa-circle-o"></i>Item Pengecekan</a>
          </li>
        @endpermission
        @permission(['mtc-master-*'])
          <li class="{{ route('mtcdpm.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtcdpm.index') }}"><i class="fa fa-circle-o"></i>Daftar Perawatan Mesin</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
  @permission(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp','mtc-oli-*', 'mtc-apr-logpkb','mtc-absen-*','mtc-lchforklift-*','mtc-dmplant-*'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>TRANSAKSI</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @permission(['mtc-dmplant-*'])
          <li class="{{ route('mtctdftmslhplants.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctdftmslhplants.index') }}"><i class="fa fa-circle-o"></i>Daftar Masalah [Plant]</a>
          </li>
        @endpermission
        @permission(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])
          <li class="{{ route('mtctdftmslhs.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctdftmslhs.index') }}"><i class="fa fa-circle-o"></i>Daftar Masalah</a>
          </li>
          <li class="{{ route('mtctdftmslhs.indexcms') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctdftmslhs.indexcms') }}"><i class="fa fa-circle-o"></i>Daftar CMS</a>
          </li>
        @endpermission
        @permission(['mtc-dm-*','mtc-lp-*'])
          <li class="{{ route('mtctpmss.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctpmss.index') }}"><i class="fa fa-circle-o"></i>Daily Activity Zone</a>
          </li>
        @endpermission
        @permission(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])
          <li class="{{ route('tmtcwo1s.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('tmtcwo1s.index') }}"><i class="fa fa-circle-o"></i>Laporan Pekerjaan</a>
          </li>
        @endpermission
        @permission(['mtc-oli-*'])
          <li class="{{ route('mtctolis.pengisianoli') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctolis.pengisianoli') }}"><i class="fa fa-circle-o"></i>Pengisian Oli</a>
          </li>
        @endpermission
        @permission(['mtc-tempac-*'])
          <li class="{{ route('mtcttempacs.tempac') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtcttempacs.tempac') }}"><i class="fa fa-circle-o"></i>Temperature AC</a>
          </li>
        @endpermission
        @permission(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp', 'mtc-apr-logpkb'])
          <li class="{{ route('mtctlogpkbs.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctlogpkbs.index') }}"><i class="fa fa-circle-o"></i>Kebutuhan Spare Parts Plant</a>
          </li>
        @endpermission
        @permission(['mtc-apr-sh-lp'])
          <li class="{{ route('mtctasakais.asakai') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctasakais.asakai') }}"><i class="fa fa-circle-o"></i>Asakai</a>
          </li>
        @endpermission
        @permission(['mtc-absen-*'])
          <li class="{{ route('mtctabsensis.absensi') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctabsensis.absensi') }}"><i class="fa fa-circle-o"></i>Absensi</a>
          </li>
        @endpermission
        @permission(['mtc-dmaa-create'])
        <li class="{{ route('mtctmslhangkut.index') == request()->url() ? 'active' : '' }}">
          <a href="{{ route('mtctmslhangkut.index') }}"><i class="fa fa-circle-o"></i>Daftar Masalah Alat Angkut</a>
        </li>
        @endpermission
        @permission(['mtc-lchforklift-*'])
          <li class="{{ route('mtctlchforklif1s.lch') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctlchforklif1s.lch') }}"><i class="fa fa-circle-o"></i>LCH Alat Angkut</a>
          </li>
        @endpermission
        @permission(['mtc-param-harden-*'])
          <li class="{{ route('mtcparamhardenfollow.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtcparamhardenfollow.index') }}"><i class="fa fa-circle-o"></i>Follow Up Param Hardening</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
  @permission(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp','mtc-oli-*','mtc-stockwhs-view','mtc-dpm-*','mtc-absen-*','mtc-lchforklift-*','dashboar-andon','mtc-historycard'])
    <li class="treeview">
      <a href="#">
        <i class="fa fa-files-o"></i> <span>LAPORAN</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">        
        @permission(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm'])
          <li class="{{ route('mtctdftmslhs.all') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctdftmslhs.all') }}"><i class="fa fa-circle-o"></i>Daftar Masalah</a>
          </li>
        @endpermission
        @permission(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp','mtc-historycard'])
          @permission(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])
            <li class="{{ route('tmtcwo1s.all') == request()->url() ? 'active' : '' }}">
              <a href="{{ route('tmtcwo1s.all') }}"><i class="fa fa-circle-o"></i>Laporan Pekerjaan</a>
            </li>
            <li>
              <a href="{{ url('/monitoringlp') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring LP</a>
            </li>
          @endpermission
          <li class="{{ route('tmtcwo1s.historycard') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('tmtcwo1s.historycard') }}"><i class="fa fa-circle-o"></i>History Card</a>
          </li>
        @endpermission
        @permission(['mtc-dm-*','mtc-lp-*','mtc-apr-pic-dm','mtc-apr-fm-dm','mtc-apr-pic-lp','mtc-apr-sh-lp'])
          <li class="{{ route('mtctpmss.progress') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctpmss.progress') }}"><i class="fa fa-circle-o"></i>Progress PMS</a>
          </li>
          <li class="{{ route('mtctpmss.reportpms') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctpmss.reportpms') }}"><i class="fa fa-circle-o"></i>Print PMS</a>
          </li>
          <li class="{{ route('mtctpmss.pmsachievement') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctpmss.pmsachievement') }}"><i class="fa fa-circle-o"></i>PMS Achievement</a>
          </li>
          <li class="{{ route('tmtcwo1s.paretobreakdown') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('tmtcwo1s.paretobreakdown') }}"><i class="fa fa-circle-o"></i>Pareto Breakdown</a>
          </li>
          <li class="{{ route('tmtcwo1s.ratiobreakdownpreventive') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('tmtcwo1s.ratiobreakdownpreventive') }}"><i class="fa fa-circle-o"></i>Ratio Breakdown vs Preventive</a>
          </li>
        @endpermission
        @permission(['mtc-stockwhs-view'])
          <li class="{{ route('stockohigps.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('stockohigps.index') }}"><i class="fa fa-circle-o"></i>Stock Warehouse</a>
          </li>
        @endpermission
        @permission(['mtc-oli-*'])
          <li class="{{ route('mtctolis.resumepengisianoli') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctolis.resumepengisianoli') }}"><i class="fa fa-circle-o"></i>Resume Pengisian Oli</a>
          </li>
          <li class="{{ route('mtctolis.laporanpengisianoli') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctolis.laporanpengisianoli') }}"><i class="fa fa-circle-o"></i>Pengisian Oli</a>
          </li>
          <li class="{{ route('mtctolis.laporanharian') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctolis.laporanharian') }}"><i class="fa fa-circle-o"></i>Pengisian Oli Harian</a>
          </li>
        @endpermission
        @permission(['mtc-tempac-*'])
          <li class="{{ route('mtcttempacs.laporantempac') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtcttempacs.laporantempac') }}"><i class="fa fa-circle-o"></i>Temperature AC</a>
          </li>
        @endpermission
        @permission(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp'])
          <li class="{{ route('mtctasakais.laporanasakai') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctasakais.laporanasakai') }}"><i class="fa fa-circle-o"></i>Data Performance</a>
          </li>
        @endpermission
        @permission(['mtc-dpm-*'])
          <li class="{{ route('sqlservers.dpm') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('sqlservers.dpm') }}"><i class="fa fa-circle-o"></i>Digital Power Meter</a>
          </li>
        @endpermission
        @permission(['mtc-absen-*'])        
          <li class="{{ route('mtctabsensis.indexrep') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctabsensis.indexrep') }}"><i class="fa fa-circle-o"></i>Absensi</a>
          </li>
        @endpermission 
        @permission(['mtc-lchforklift-*'])
          <li class="{{ route('mtctlchforklif1s.index') == request()->url() ? 'active' : '' }}">
            <a href="{{ route('mtctlchforklif1s.index') }}"><i class="fa fa-circle-o"></i>LCH Alat Angkut</a>
          </li>
        @endpermission
        @permission('dashboar-andon')
          <li>
            <a href="{{ url('/monitoringandon') }}" target="_blank"><i class="fa fa-circle-o"></i>Monitoring ANDON</a>
          </li>
        @endpermission
      </ul>
    </li>
  @endpermission
@endpermission