<TABLE border="0" cellspacing="0" cellpadding="0" style="" id="tabelGaji">
  <THEAD>
    <TR>
      <TD align="center" valign="top" width="100%">
        <TABLE align="center" valign="top" width="100%" border="0" cellspacing="0" cellpadding="0">
          <TR>
            <TD align="left" valign="top" width="81" height="47"><IMG src="{{ asset('images/logo_igp_group.bmp') }}" width="81" border="0"></TD>
            <TD align="center" valign="top" width="100%">
              <TABLE align="center" valign="top" width="100%" border="0" cellspacing="0" cellpadding="5">
                <TR>
                  <TH align="center" valign="top">Slip Gaji</TH>
                </TR>
                <TR>
                  <TH align="center" valign="top">Slip Gaji Bulanan Karyawan</TH>
                </TR>
                <TR>
                  <TH align="center" valign="top">Bulan : {{ namaBulan((int) $mobile->bulan). " ".$mobile->tahun }}</TH>
                </TR>
              </TABLE>
            </TD>
          </TR>
        </TABLE>
      </TD>
    </TR>
  </THEAD>
  {{--  --}}
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
                        <TD align="left" valign="top" nowrap>: {{ $mobile->npk_asli }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Nama</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->nama }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Jabatan</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->desc_jab }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>PTKP / Status</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->kd_ptkp }} / {{ $mobile->status_pegawai }}</TD>
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
                      <TR>
                        <TD align="left" valign="top" nowrap>Sub Seksi</TD>
                        <TD align="left" valign="top" nowrap>: -</TD>
                      </TR>
                    </TABLE>
                  </TD>
                </TR>
              </TABLE>
              <!-- data karyawan sampai disini -->
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
                  <TH align="left" valign="top">PENGHASILAN</TH>
                  <TH align="center" valign="top" colspan="2">Reguler</TH>
                  <TH align="center" valign="top" colspan="2">Koreksi</TH>
                  <TH align="center" valign="top" colspan="2">Total</TH>
                </TR>
                <TR>
                  <TD align="left" valign="top" nowrap>Upah Pokok Gol {{ $mobile->kd_gol }} / 0</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_gp) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kgp) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tgp) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Tunj. Pajak</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tp) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_ktp) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_ttp) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>BPJS Pensiun</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_bpjs_pens) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kbpjs_pens) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tbpjs_pens) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>BPJS Kesehatan</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_bpjs_kes) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kbpjs_kes) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tbpjs_kes) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Premi Jamsostek</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_jams) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kjams) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tjams) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Premi DPA</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_dpa) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kdpa) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tdpa) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Insentif Hadir</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_ins) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kins) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tins) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Lain-lain (Gol. 3)</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_lain) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_klain) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tlain) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>THR</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_thr) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kthr) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tthr) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>HAT</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_hat) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_khat) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_that) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Reward</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_reward) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kreward) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_treward) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Bantuan Khusus</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_bkk) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_kbkk) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->t_tbkk) }}</TD>
                </TR>
                <TR>
                  <TD align="right" valign="top" nowrap>Penghasilan Bruto</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->jum_bruto) }}</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->jum_kbruto) }}</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->jum_tbruto) }}</TD>
                </TR>
                <TR>
                  <TH align="left" colspan="7">POTONGAN</TH>
                </TR>
                <TR>
                  <TD align="left" nowrap>Pajak Penghasilan (actual)</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_pph21) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kpph21) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tpph21) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>BPJS Pensiun</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_bpjs_pens) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kbpjs_pens) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tbpjs_pens) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>BPJS Kesehatan</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_bpjs_kes) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kbpjs_kes) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tbpjs_kes) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Premi Jamsostek</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_jams) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kjams) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tjams) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Premi DPA</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_dpa) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kdpa) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tdpa) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Loan (Khusus Gol 3)</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_loan) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kloan) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tloan) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>THR</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_thr) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kthr) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tthr) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>HAT</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_hat) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_khat) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_that) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Obat</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_obat) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kobat) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tobat) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Reward</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_reward) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kreward) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_treward) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap>Bantuan Khusus</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_bkk) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kbkk) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_tbkk) }}</TD>
                </TR>
                <TR>
                  <TD align="right" valign="top" nowrap>Jumlah Potongan</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->jum_pot) }}</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->jum_kpot) }}</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->jum_tpot) }}</TD>
                </TR>
                <TR>
                  <TD align="right" valign="top" nowrap>Penghasilan Netto</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->jum_netto) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->jum_knetto) }}</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->jum_tnetto) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="7" nowrap>Potongan lain :</TD>
                </TR>
                <TR>
                  <TD align="right" valign="top" colspan="3" nowrap>SPSI Iuran</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->spsi_iuran) }}</TD>
                </TR>
                <TR>
                  <TD align="right" valign="top" colspan="3" nowrap>SPSI Kedukaan</TD>
                  <TD align="left" valign="top" class="grsbawahtipis">Rp.</TD>
                  <TD align="right" valign="top" class="grsbawahtipis">{{ numberFormatter(2, 2)->format($mobile->spsi_duka) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="5" nowrap>Potongan SPSI</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_spsi) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="5" nowrap>Potongan Koperasi</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->p_kop) }}</TD>
                </TR>
                <TR>
                  <TD align="left" valign="top" colspan="5" nowrap>THP (Gaji) yang diterima karyawan</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->jum_thp) }}</TD>
                </TR>
              </TABLE>
              <!-- Gaji sebelah kiri untuk karyawan sampai di sini -->
            </TD>
          </TR>
        </TABLE>
        <!-- tabel data karyawan di atas dan data gaji di bawah sampai di sini -->
      </TD>
    </TR>
  </TBODY>
  {{--  --}}
</TABLE>