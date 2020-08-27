<TABLE border="0" cellspacing="0" cellpadding="0" id="tabelGaji">
  <THEAD>
    <TR>
      <TD align="center" valign="top" width="100%">
        <TABLE align="center" valign="top" width="100%" border="0" cellspacing="0" cellpadding="0">
          <TR>
            <TD align="left" valign="top" width="81" height="47">
              <IMG src="{{ asset('images/logo_pdp.jpg') }}" width="81" border="0">
            </TD>
            <TD align="center" valign="top" width="100%">
              <TABLE align="center" valign="top" width="100%" border="0" cellspacing="0" cellpadding="5">
                <TR>
                  <TH align="center" valign="top">
                    KOPKAR PRIMA DAYA PERDANA
                  </TH>
                </TR>
                <TR>
                  <TH align="center" valign="top">
                    Slip Potongan Koperasi
                  </TH>
                </TR>
                <TR>
                  <TH align="center" valign="top">
                    Bulan : {{ namaBulan((int) $bulan). " ".$tahun }}
                  </TH>
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
                        <TD align="left" valign="top" nowrap>PT</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->pt }}</TD>
                      </TR>
                    </TABLE>
                  </TD>
                  <TD width="50%" valign="top">
                    <!-- divisi, dept, seksi, sub seksi -->
                    <TABLE width="100%" align="right" valign="top" border="0" cellspacing="0" cellpadding="3" class="standart">
                      <TR>
                        <TD align="left" valign="top" nowrap>Divisi</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->desc_div }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Departemen</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->desc_dep }}</TD>
                      </TR>
                      <TR>
                        <TD align="left" valign="top" nowrap>Seksi</TD>
                        <TD align="left" valign="top" nowrap>: {{ $mobile->desc_sie }}</TD>
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
                  <TH align="left" valign="top" colspan="7">RINCIAN POTONGAN PINJAMAN :</TH>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Belanja Kredit</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->jual) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Angsuran Pinjaman
                    Koperasi PDP</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->pinj_tiw) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Angsuran Pinjaman KAI</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->pinj_kai) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Angsuran BTN</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->pot_btn) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Angsuran Jamsostek</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->pot_jams) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Asuransi CMG</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->pot_cmg) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Angsuran Lainnya
                    (Barang)</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->pinj_lain) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Potongan Lain-Lain</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->lainnya) }}</TD>
                </TR>
                <TR>
                  <TH align="left" valign="top" colspan="7">RINCIAN POTONGAN SIMPANAN ANGGOTA :
                  </TH>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Simpanan Pokok</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->simpok) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Simpanan Wajib</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->simwa) }}</TD>
                </TR>
                <TR>
                  <TD align="left" nowrap="nowrap">Simpanan Sukarela</TD>
                  <TD align="left" valign="top">Rp.</TD>
                  <TD align="right" valign="top">{{ numberFormatter(2, 2)->format($mobile->simsuk) }}</TD>
                </TR>
                <TR>
                  <TD align="right" valign="top" nowrap="nowrap">Jumlah
                    Potongan Koperasi</TD>
                  <TD align="left" class="atas">Rp.</TD>
                  <TD align="right" class="atas">{{ numberFormatter(2, 2)->format($mobile->total_pot) }}</TD>
                </TR>
              </TABLE> <!-- Gaji sebelah kiri untuk karyawan sampai di sini -->
            </TD>
          </TR>
        </TABLE> <!-- tabel data karyawan di atas dan data gaji di bawah sampai di sini -->
      </TD>
    </TR>
  </TBODY>
</TABLE>