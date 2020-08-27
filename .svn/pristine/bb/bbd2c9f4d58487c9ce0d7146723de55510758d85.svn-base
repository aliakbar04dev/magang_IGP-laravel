<TABLE border="0" cellspacing="0" cellpadding="0" id="tabelHAT">
  <THEAD>
    <TR>
      <TD align="center" valign="top" width="100%">
        <TABLE align="center" valign="top" width="100%" border="0" cellspacing="0" cellpadding="0">
          <TR>
            <TD align="left" valign="top" width="81" height="47"><IMG src="{{ asset('images/logo_igp_group.bmp') }}" width="81" border="0"></TD>
            <TD align="center" valign="top" width="100%">
              <TABLE align="center" valign="top" width="100%" border="0" cellspacing="0" cellpadding="5">
                <TR>
                  <TH align="center" valign="top">{{ strtoupper(config('app.nm_pt', 'Laravel')) }}</TH>
                </TR>
                <TR>
                  <TH align="center" valign="top">Slip HAT {{ $tahun }}</TH>
                </TR>
              </TABLE>
            </TD>
          </TR>
        </TABLE>
      </TD>
    </TR>
  </THEAD>
  <TBODY>
    <TR>
      <TD align="left" valign="top" width="100%"><HR color="#000000" width="100%"></TD>
    </TR>
    <TR>
      <TD align="left" valign="top" width="100%">
        <!-- tabel data karyawan di atas dan data gaji di bawah -->
        <TABLE align="left" valign="top" width="100%" border="0" cellspacing="10" cellpadding="0">
          <TR>
            <TD>
              <!-- tabel data karyawan -->
              <TABLE align="left" valign="top" width="100%" border="0" cellspacing="0" cellpadding="0">
                <TR>
                  <TD align="left" valign="top">
                    <!-- npk, nama, jabatan, ptkp -->
                    <TABLE align="left" valign="top" width="100%" border="0" cellspacing="0" cellpadding="3" class="standart">
                      <TR>
                        <TD align="left" valign="top" nowrap>NPK</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->npk }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Nama</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->nama }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Jabatan</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->jabatan }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>PTKP / Status</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->ptkp }} / {{ $mobile->status }}</TD>
                      </TR>
                    </TABLE>
                  </TD>
                  <TD width="50%" valign="top">
                    <!-- divisi, dept, seksi, sub seksi -->
                    <TABLE width="100%" align="right" valign="top" border="0" cellspacing="0" cellpadding="3" class="standart">
                      <TR>
                        <TD align="left" valign="top" nowrap>Divisi</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->divisi }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Departemen</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->departemen }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Seksi</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->desc_sie }}</TD>
                      </TR>
                    </TABLE>
                  </TD>
                </TR>
              </TABLE> <!-- data karyawan sampai disini -->
            </TD>
          </TR>
        </TABLE>
      </TD>
    </TR>
    <TR>
      <TD align="left" valign="top" width="100%"><HR color="#000000" width="100%"></TD>
    </TR>
    <TR>
      <TD align="left" valign="top" width="100%">
        <!-- tabel data karyawan di atas dan data gaji di bawah -->
        <TABLE align="left" valign="top" width="100%" border="0" cellspacing="10" cellpadding="0">
          <TR>
            <TD align="left" valign="top" width="50%">
              <!-- Gaji sebelah kiri untuk karyawan -->
              <TABLE width="100%" align="right" border="0" cellspacing="0" cellpadding="3" class="standart">
                <TR>
                  <TH align="left" valign="top" colspan="4">Komponen Upah</TH>
                </TR>
                <TR>
                  <TD align="left" valign="top" nowrap>Gaji Pokok ({{ $mobile->gol }})</TD>
                  <TD colspan="2" align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->gaji) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" nowrap>Makan</TD>
                  <TD colspan="2" align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->makan) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" nowrap>Transport</TD>
                  <TD colspan="2" align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->transport) }}</TD>
                </TR>
                <TR>
                  <TD colspan="4"></TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" rowspan="4" nowrap>Tgl Masuk {{ \Carbon\Carbon::parse($mobile->tgl_masuk_gkd)->format('d/m/Y') }}</TD>
                  <TD colspan="2" align="left" valign="top">Nilai Proporsional</TD>
                  <TD align="right" valign="top">{{ $mobile->c_prop }}</TD>
                </TR>
                <TR>
                  <TD colspan="2" align="left" valign="top">Garansi ( 1 x Upah)</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 0)->format($mobile->garansi) }}</TD>
                </TR>
                <TR>
                  <TD colspan="2" align="left" valign="top">N x Gaji Pokok</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->betha_kali) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top">Plus Rupiah</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->plus_rp) }}</TD>
                </TR>
                <TR>
                  <TD colspan="4"></TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" rowspan="3" nowrap>Nilai HAT</TD>
                  <TD align="left" valign="top">Gaji Pokok</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->hat_grs) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" nowrap>Nilai Makan</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->hat_ntmk) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" nowrap>Nilai Transport</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->hat_nttr) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="2" nowrap>Tunjangan Pajak</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->tpajak) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="2" nowrap>Bruto</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->bruto) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="2" nowrap>PPh 21</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->pajak) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="2" nowrap>Total Diterima Karyawan (THP)</TD>
                  <TD align="right" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->thp) }}</TD>
                </TR>
                <TR>
                  <TD colspan="4"></TD>
                </TR>
                <TR>
                  <TD colspan="4"></TD>
                </TR>
                <TR>
                  <TD align="right" valign="top" colspan="4" nowrap>
                    <TABLE align="right" valign="top" border="0" cellspacing="0" cellpadding="3" class="standart">
                      <TR>
                        <TD align="left" valign="top">Penerima,</TD>
                      </TR>
                      <TR>
                        <TD height="50"></TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top">({{ Auth::user()->name }})</TD>
                      </TR>
                    </TABLE>
                  </TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="4" nowrap></TD>
                </TR>
              </TABLE> <!-- Gaji sebelah kiri untuk karyawan sampai di sini -->
            </TD>
          </TR>
        </TABLE> <!-- tabel data karyawan di atas dan data gaji di bawah sampai di sini -->
      </TD>
    </TR>
  </TBODY>
</TABLE>