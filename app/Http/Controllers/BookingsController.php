<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Calendar;
use DB;

class BookingsController extends Controller
{
    public function index($id_ruangan = null)
    {
        // https://fullcalendar.io/docs
        
        if($id_ruangan == null) {
            $id_ruangan = "004";
        }

        $ruangan = DB::connection("oracle-usrintra")
            ->table(DB::raw("meeting_mstr_ruangan"))
            ->select(DB::raw("*"))
            ->where("id_ruangan", "=", $id_ruangan)
            ->first();

        if($ruangan != null) {
            $events = [];

            $data = DB::connection("oracle-usrintra")
            ->table(DB::raw("meeting_trn_booking"))
            ->select(DB::raw("no_doc, materi, npk_pemakai, nvl(ext,'-') ext, waktu_mulai, waktu_selesai, nvl(nvl(usrhrcorp.f_inisial(npk_pemakai), usrhrcorp.finit_nama(npk_pemakai)),fnm_username(npk_pemakai)) nama, usrhrcorp.finit_dep (usrhrcorp.fdept_npk(npk_pemakai)) pemakai"))
            ->where("id_ruangan", "=", $ruangan->id_ruangan)
            ->get();

            if($data->count()) {
                foreach ($data as $key => $value) {
                    $display = "Materi: ".$value->materi;
                    $display .= "\n"."Pemakai: ".$value->nama." - ".$value->pemakai;
                    $display .= "\n"."EXT: ".$value->ext;
                    $events[] = Calendar::event(
                        $display,
                        false,
                        new \DateTime($value->waktu_mulai),
                        new \DateTime($value->waktu_selesai),
                        null,
                        // Add color and link on event
                        [
                            'color' => 'black',
                            // 'backgroundColor' => 'black',
                            'textColor' => 'white',
                            'url' => base64_encode($value->no_doc),
                        ]
                    );
                }
            }
            $calendar = Calendar::addEvents($events)
            ->setOptions([
                'timeFormat' => 'H:mm', 
                'allDaySlot' => false, 
                'firstDay' => 1, 
                'defaultView' => 'agendaWeek', 
                'aspectRatio' => 2.8, 
                'minTime' => '07:00:00', 
                'maxTime' => '17:00:00',
                'slotDuration' => '00:30:00',
                'titleFormat' => 'MMMM DD, YYYY',
                // 'weekends' => false,
                // hiddenDays: [ 2, 4 ], // hide Tuesdays and Thursdays
                // 'nowIndicator' => true,
            ]);
            return view('booking.index', compact('ruangan', 'calendar'));
        } else {
            return view('errors.404');
        }
    }
}
