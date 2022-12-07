<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Models\Epresence;
use Carbon\Carbon;

class UserController extends Controller
{
    protected $user;
    protected $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user;
        $this->request = $request;
    }

    function checkInOut(){
        $check = Epresence::query()
            ->where('user_id', $this->user->id)
            ->where(DB::Raw('date(waktu)'), Carbon::parse($this->request->waktu)->format('Y-m-d'))
            ->where('type', $this->request->type)
            ->first();
        if($check){
            if($this->request->type == 'OUT'){
                $check->waktu = $this->request->waktu;
                $check->save();
            }
        }else{
            $in = new Epresence;
            $in->user_id    = $this->user->id;
            $in->type       = $this->request->type;
            $in->waktu      = $this->request->waktu;
            if(!$this->user->npp_supervisor) $in->is_approve = 'TRUE';
            $in->save();
        }

        return response()->json([
            'message' => 'Success'
        ]);
    }

    function getUser(){
        if($this->request->start_date){
            if($this->request->start_date > $this->request->end_date) return response()->json(['message' => 'invalid date'], 400);
        }

        $getPresence = Epresence::query()
            ->join('users as u', 'u.id', '=', 'epresence.user_id')
            ->join('epresence as e', function($join){
                $join->on('e.user_id','epresence.user_id');
                $join->on(DB::Raw('date(e.waktu)'), DB::Raw('date(epresence.waktu)'));
                $join->where('e.type','OUT');
            })
            ->where('epresence.user_id', $this->user->id)
            ->where('epresence.type', 'IN')
            ->where('epresence.waktu', '>', $this->request->start_date)
            ->where('epresence.waktu', '<', Carbon::parse($this->request->end_date)->addDays(1))
            ->selectRaw("u.id id_user, u.nama nama_user, date(epresence.waktu) tanggal, epresence.waktu::time waktu_masuk, e.waktu::time waktu_keluar,
                case when
                    epresence.is_approve='TRUE'
                then 'APPROVE'
                else 'REJECT' end status_masuk,
                case when
                    e.is_approve='TRUE'
                then 'APPROVE'
                else 'REJECT' end status_keluar")
            ->orderByRaw('date(epresence.waktu) asc')
            ->take($this->request->per_page)
            ->skip(($this->request->page - 1) * $this->request->per_page)
            ->get();

        return response()->json([
            'message' => 'Success get data',
            'data' => $getPresence
        ]);
    }
}
