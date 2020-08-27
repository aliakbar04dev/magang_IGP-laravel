<html>
<head>
   
    <title>PRINT TEMUAN AUDIT</title>
     <style> 
    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }
 
    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;
    }
 
    .table th {
        border:1px solid #000000;
        text-align: center;
        /* font-size: 50%; */
        word-wrap: break-word;
        font-size:100%;
        
    }
 
    .table td {
        padding: 3px 3px;
        border:1px solid #000000;
        width: 300px; 
        /* font-size: 50%; */
        /* word-break:break-all;  */
        word-wrap: break-word;
    }
 
    .text-center {
        text-align: center;
    }

    body { 
        font-family: 'Times New Roman', Times, serif;
        /* font-size: 8px; */
    }
</style>

</head>
    <body>            
        <!-- <table class="table table-bordered">
            <tr>
                <td style="width:120px;border-bottom: double;text-align: center;"><img style="width: 100px;" src="{{ asset('images/logo.png') }}"></td>
                <td colspan="9" style="text-align: center;font-size: 20px;border-bottom: double;">AUDIT WORKSHEET</td>
            </tr>
            <tr>
                <td colspan="2" style="width:150px;">Finding Number</td>    
                <td colspan="4" style="text-align: center;">Test</td>
            </tr>
        </table> -->
        <table>
            <tr>
                <td style="width: 10%;" rowspan="2"><img style="width: 80%;" src="{{ asset('images/logo.png') }}"></td>
                <td><h2 style="text-align: center;">DAFTAR INTERNAL AUDITOR</h2></td>
            </tr>
            <tr>
                <td><p style="text-align: center;">Tahun {{ $get_latest->tahun }} Rev {{ $get_latest->rev }} Date {{ substr($get_latest->date, 0, 4) }}</p></td>
            </tr>
        </table>
        <table id="example" class="table">
                                    <thead>
                                        <tr>
                                            <th class="no-sort" rowspan="2" width="3%">NO.</th>
                                            <th class="datanya" rowspan="2" width="5%" class="loc_npk">NPK</th>
                                            <th class="datanya" rowspan="2" width="10%" class="loc_nama">NAMA</th>
                                            <th class="datanya" rowspan="2" width="10%" class="loc_dept">DEPT</th>
                                            <th class="datanya" rowspan="2" width="10%" class="loc_sect">SECT</th>
                                            <th style="border-top: 1px solid #000;" class="loc_training" colspan="{{ $list_training->count() }}">TRAINING</th> 
                                            <th style="border-top: 1px solid #000;" rowspan="2" class="loc_remark">RM</th>
                                        </tr>
                                        <tr>
                                            @foreach ($list_training as $trn)
                                            <th style="font-size: 10px;" class="no-sort">{{ $trn->desc_trn }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data_nama as $nama)
                                    <tr id="data{{ $loop->iteration }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $nama->npk }}</td>
                                        <td>{{ $nama->nama }}</td>
                                        <td>{{ $nama->desc_dep }}</td>
                                        <td>{{ $nama->desc_sie }}</td>
                                        @for ($a = 0; $a < $data_training2->count(); $a++)
                                        @if ($data_training2[$a]->npk == $nama->npk)
                                        @if ($data_training2[$a]->nilai == 1)
                                        <td style="color: #68b303;font-weight: bold;text-align: center;">○</td>
                                        @elseif ($data_training2[$a]->nilai == 0)
                                        <td style="color: #e82d2d;font-weight: bold;text-align: center;">-</td>
                                        @endif
                                        @endif
                                        @endfor
                                        <td>
                                        @if ($nama->remark == 'LEAD AUDITOR')
                                                Lead Auditor
                                            @elseif ($nama->remark == 'AUDITOR')
                                                Auditor
                                            @elseif ($nama->remark == 'OBSERVER')
                                                Observer
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
    </body>
</html>