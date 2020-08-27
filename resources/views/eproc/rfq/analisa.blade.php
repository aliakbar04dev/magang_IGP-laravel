<!-- Slideshow container -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Q. Anianda -->
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.env', 'local') === 'production' ? config('app.name', 'Laravel') : config('app.name', 'Laravel').' TRIAL' }}</title>
  <link rel="shortcut icon" href="{{ asset('images/splash.png') }}"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <style>
    .pricingdiv{
      display: flex;
      /*flex-wrap: wrap; */
      font-size: 12px;
      justify-content: center;
      font-family: 'Source Sans Pro', Arial, sans-serif;
      float:left;
      overflow-x: auto;
    }

    .pricingdiv ul.theplan{
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      color: black;
      /*width: 260px;  width of each table */
      width: 300px; /* width of each table */
      /*margin-right: 20px;  spacing between tables */
      margin-right: 10px; /* spacing between tables */
      margin-bottom: 1em;
      border: 1px solid gray;
      transition: all .5s;
    }

    .pricingdiv ul.theplan:hover{ /* when mouse hover over pricing table */
      transform: scale(1.05);
      transition: all .5s;
      z-index: 100;
      box-shadow: 0 0 10px gray;
    }

    .pricingdiv ul.theplan .center{
      margin: 0 auto;
      text-align: center;
    }

    .pricingdiv ul.theplan img{
      max-width: 80%;
      height: auto;
    }

    .pricingdiv ul.theplan li{
      padding: 10px 10px;
      position: relative;
      border-bottom: 1px solid #eee;
    }

    .pricingdiv ul.theplan li.title{
      font-weight: bold;
      text-align: center;
      padding: 10px 10px;
      background: rgb(40, 193, 203);
      color: white;
      box-shadow: 0 -10px 5px rgba(0,0,0,.1) inset;
      text-transform: uppercase;
      font-size: 12px;
    }

    .pricingdiv ul.theplan li.total{
      font-size: 16px;
    }

    .pricingdiv ul.theplan:nth-of-type(1) li.title{
      background: red;
      color: white;
    }

    .pricingdiv ul.theplan:nth-of-type(2) li.title{
      /*background: rgb(249, 111, 118);*/
      background: blue;
      color: white;
    }
        
    .pricingdiv ul.theplan:nth-of-type(3) li.title{
      /*background: rgb(210, 117, 251);*/
      background: green;
      color: white;
    }

    .pricingdiv ul.theplan li b{
      text-transform: uppercase;
    }
    .pricingdiv ul.theplan li.title b{
      font-size: 250%;
    }

    .pricingdiv ul.theplan:last-of-type{ /* remove right margin in very last table */
      margin-right: 0;
    }

    /*very last LI within each pricing UL */
    .pricingdiv ul.theplan li:last-of-type{
      text-align: center;
      margin-top: auto; /*align last LI (price botton li) to the very bottom of UL */
    }  

    .pricingdiv a.pricebutton{
      background: orange;
      text-decoration: none;
      padding: 10px;
      display: inline-block;
      margin: 10px auto;
      border-radius: 5px;
      color: black;
      font-weight: bold;
      border-radius: 5px;
      text-transform: uppercase;
    }

    .pricingdiv button.approvebutton {
      border: none;
      outline: 0;
      padding: 12px;
      color: white;
      background-color: green;
      text-align: center;
      cursor: pointer;
      width: 45%;
      font-size: 18px;
      text-decoration: none;
      padding: 10px;
      display: inline-block;
      margin: 10px auto;
      border-radius: 5px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .pricingdiv button.detailbutton {
      border: none;
      outline: 0;
      padding: 12px;
      color: white;
      background-color: #000;
      text-align: center;
      cursor: pointer;
      width: 45%;
      font-size: 18px;
      text-decoration: none;
      padding: 10px;
      display: inline-block;
      margin: 10px auto;
      border-radius: 5px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .pricingdiv button.selectedbutton {
      border: none;
      outline: 0;
      padding: 12px;
      color: white;
      background-color: green;
      text-align: center;
      cursor: pointer;
      width: 100%;
      font-size: 18px;
      text-decoration: none;
      padding: 10px;
      display: inline-block;
      margin: 10px auto;
      border-radius: 5px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .pricingdiv button.approvebutton:hover {
      opacity: 0.7;
    }

    .pricingdiv button.detailbutton:hover {
      opacity: 0.7;
    }

    @media only screen and (max-width: 600px) {

      .pricingdiv{
        display: flex;
        flex-wrap: wrap; 
        font-size: 12px;
        justify-content: center;
        font-family: 'Source Sans Pro', Arial, sans-serif;
        /*float:left;
        overflow-x: auto;*/
      }
      
      .pricingdiv ul.theplan{
        border-radius: 0;
        width: 100%;
        margin-right: 0;
      }
      
      .pricingdiv ul.theplan:hover{
        transform: none;
        box-shadow: none;
      }
      
      .pricingdiv a.pricebutton{
        display: block;
      }

      .pricingdiv button.approvebutton{
        display: block;
      }

      .pricingdiv button.detailbutton{
        display: block;
      }

      .pricingdiv button.selectedbutton{
        display: block;
      }
    }
  </style>
  <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
  <!-- Scripts -->
  <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
  </script>
</head>
<body>
  <center>
    <h3>Analisa NO. SSR: {{ $no_ssr }}, Part No: {{ $part_no }} - {{ $nm_part }}, Proses: {{ $nm_proses }}</h3>
  </center>
  {{ csrf_field() }}
  <div class="pricingdiv">
    @foreach($prctrfqs->get() as $prctrfq) 
      <ul class="theplan">
        <li class="title">
          @if($loop->iteration == 1) 
            <b>{{ $loop->iteration }}st</b>
          @elseif($loop->iteration == 2) 
            <b>{{ $loop->iteration }}nd</b>
          @elseif($loop->iteration == 3) 
            <b>{{ $loop->iteration }}rd</b>
          @else
            <b>{{ $loop->iteration }}th</b>
          @endif
          <br />{{ $prctrfq->nm_supp }}
          <br />{{ $prctrfq->no_rfq }} - {{ $prctrfq->no_rev }}
        </li>
        <li @if($rfq_rm === $prctrfq->no_rfq) style="background: yellow;" @endif><b>1. Raw Material:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_rm) }}</li>
        <li @if($rfq_proses === $prctrfq->no_rfq) style="background: yellow;" @endif><b>2. Process:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_proses) }}</li>
        <li @if($rfq_ht === $prctrfq->no_rfq) style="background: yellow;" @endif><b>3. Heat Treatment:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_ht) }}</li>
        <li @if($rfq_pur_part === $prctrfq->no_rfq) style="background: yellow;" @endif><b>4. Purchase Part:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_pur_part) }}</li>
        <li @if($rfq_tool=== $prctrfq->no_rfq) style="background: yellow;" @endif><b>5. Tooling:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_tool) }}</li>
        <li @if($rfq_transpor === $prctrfq->no_rfq) style="background: yellow;" @endif><b>6. Transport Cost:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_transpor) }}</li>
        <li @if($rfq_pack === $prctrfq->no_rfq) style="background: yellow;" @endif><b>7. Packaging Cost:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_pack) }}</li>
        <li @if($rfq_admin === $prctrfq->no_rfq) style="background: yellow;" @endif><b>8. Administration Cost ({{ numberFormatter(0, 2)->format($prctrfq->prs_admin) }}%):</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_admin) }}</li>
        <li @if($rfq_profit === $prctrfq->no_rfq) style="background: yellow;" @endif><b>9. Profit ({{ numberFormatter(0, 2)->format($prctrfq->prs_profit) }}%):</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_profit) }}</li>
        <li @if($rfq_fob === $prctrfq->no_rfq) style="background: yellow;" @endif><b>10. In-line Cost (FOB) ({{ numberFormatter(0, 5)->format($prctrfq->nil_fob_usd) }} USD):</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_fob) }}</li>
        <li @if($rfq_cif === $prctrfq->no_rfq) style="background: yellow;" @endif><b>11. Freight Cost (CIF) ({{ numberFormatter(0, 5)->format($prctrfq->nil_cif_usd) }} USD):</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_cif) }}</li>
        <li @if($rfq_diskon === $prctrfq->no_rfq) style="background: yellow;" @endif><b>Diskon:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_diskon) }}</li>
        <li class="total" id="li_total_{{ $loop->iteration }}"><b>GRAND TOTAL:</b> Rp. {{ numberFormatter(0, 5)->format($prctrfq->nil_total) }}</li>
        <li>
          @if($prctrfq->tgl_close == null)
            @if(Auth::user()->can('prc-rfq-create'))
              <button id='btnapprove' type='button' class="approvebutton" data-toggle='tooltip' data-placement='top' title='Approve RFQ {{ $prctrfq->no_rfq }}' onclick='approveRfq("{{ $prctrfq->no_rfq }}", "ANALISA")'>
                <span class="icon-tag"></span> Approve
              </button>
            @endif
            {{-- &nbsp;&nbsp; --}}
            <button id='btndetail' type='button' class="detailbutton" data-toggle='tooltip' data-placement='top' title='Show Detail RFQ {{ $prctrfq->no_rfq }}' onclick='detailRfq("{{ $prctrfq->no_rfq }}")'>
              <span class="icon-tag"></span> Detail
            </button>
            {{-- &nbsp;&nbsp;
            <a class="pricebutton" href="" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Detail RFQ" rel="nofollow"><span class="icon-tag"></span> Show Detail</a> --}}
          @elseif($prctrfq->tgl_pilih != null)
            <button id='btnselect' type='button' class="selectedbutton">
              <span class="icon-tag"></span> SELECTED
            </button>
          @endif
        </li>
      </ul>
    @endforeach
  </div>
  <div style="text-align:center;clear: both;">
    <p>
      <a href="#" onclick="window.open('', '_self', ''); window.close();"><button><H1>Close Page</H1></button></a>
    </p>
  </div>
</body>
</html> 

<!-- jQuery 2.2.3 -->
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script type="text/javascript">
  function approveRfq(no_rfq, mode)
  {
    var msg = 'Anda yakin APPROVE No. RFQ: ' + no_rfq + '?';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('prctrfqs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_rfq         : window.btoa(no_rfq),
          mode           : window.btoa(mode)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal({
              title: "Approved",
              text: data.message,
              type: "success",
              allowOutsideClick: true,
              allowEscapeKey: false,
              allowEnterKey: true,
              reverseButtons: false,
              focusCancel: true,
            }).then(
            function () {
              location.reload();
            }, function (dismiss) {
              location.reload();
            }).catch(swal.noop)
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          $("#loading").hide();
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        // swal(
        //   'Cancelled',
        //   'Your imaginary file is safe :)',
        //   'error'
        // )
      }
    })
  }

  function detailRfq(no_rfq)
  {
    var urlRedirect = "{{ route('prctrfqs.showdetail', 'param') }}";
    urlRedirect = urlRedirect.replace('param', window.btoa(no_rfq));
    // window.location.href = urlRedirect;
    window.open(urlRedirect, '_blank');
  }
</script>
<!-- Sweet Alert 2-->
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>