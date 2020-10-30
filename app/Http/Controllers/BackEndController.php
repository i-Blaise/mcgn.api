<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use \stdClass;
use App\Volunteer;
use App\Causes;
use App\Donations;
use App\Gallery;
use App\Contact;

class BackEndController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    //DASHBOARD
    public function countVolunteers()
    {
        $volunteer_num = Volunteer::count();
        return response()->json($volunteer_num);
    }

    public function totalCashDonated()
    {
        $donatedCash = Donations::where('cash_or_item', 'cash')->sum('cash');
        return response()->json($donatedCash);
    }

    public function fetchVolunteers()
    {
        $volunteers = Volunteer::orderBy('created_at', 'desc')->get();
        return response()->json($volunteers);
    }



    //ADD CAUSE
    public function addCause(Request $request)
    {
        $causes = new Causes;
        $data = $request->json()->all();
        // $donor_data = json_decode($data);
        $heading = $data['heading'];
        $amount_needed = $data['amount_needed'];
        $date = $data['date'];
        $message = $data['message'];
        $cause_image = $data['cause_image'];

         $causes->heading= $heading;
         $causes->message= $message;
         $causes->date_due= $date;
         $causes->amount_needed= $amount_needed;
         $causes->image= $cause_image;
 
         if($causes->save()){
             return response()->json(['status' => 'success', 'message' => 'Message Sent']);
             // return redirect('http://localhost/sonzie/contact_logic.php?status=comment_saved');
            }else{
             return response()->json(['status' => 'failed', 'message' => 'Could not send message']);
            }
        
    }

    public function recentCause()
    {
        $recentCause = Causes::orderBy('created_at', 'desc')
        ->first();
        return response()->json($recentCause);
    }

    public function cashDonatedToCause($id)
    {
        $donatedCash = Donations::where('cause_id', $id)->sum('cash');
        return response()->json($donatedCash);
    }

    //ADD DONOR
    public function addDonor(Request $request)
    {
        $donor = new Donations;
        $data = $request->json()->all();
        // $donor_data = json_decode($data);
        $time = time();
        $name = $data['name'];
        $donation = $data['donations'];
        $causeId = $data['causeId'];
        $donor_pic = $data['donor_pic'];



            $cash = "cash";
            $item = "item";

            $cause_result = Causes::where('id', $causeId)->first('heading');
            $cause = $cause_result->heading;


            if(isset($donation) && is_numeric($donation))
            {
                // if ($request->hasFile('image')) {
                //     $image = $request->file('image');
                //     $donor_pic = $target_dir.$image.'.'.$image->getClientOriginalExtension();
                //     $destinationPath = storage_path('/app/donors');
                //     $image->move($destinationPath, $donor_pic);
                // }

                $donor->name= $name;
                $donor->cash= $donation;
                $donor->cause= $cause;
                $donor->image= $donor_pic; 
                $donor->cash_or_item = $cash; 
                $donor->cause_id = $causeId;  
                $donor->time = $time;  
            }elseif(isset($donation) && !is_numeric($donation))
            {
                $donor->name= $name;
                $donor->item= $donation;
                $donor->cause= $cause;
                $donor->image= $donor_pic;
                $donor->cash_or_item = $item; 
                $donor->cause_id = $causeId;  
                $donor->time = $time;  
            }else {
                return response()->json(['status' => 'failed', 'message' => 'Donation field not set / has an error']);
            }
                 
    
            if($donor->save()){
                return response()->json(['status' => 'success', 'message' => 'Message Sent']);
                // return redirect('http://localhost/sonzie/contact_logic.php?status=comment_saved');
            }else{
                return response()->json(['status' => 'failed', 'message' => 'Error with saving to database']);
            }

    }




    public function recentDonor()
    {
        $recentDonor = Donations::orderBy('created_at', 'desc')
        ->first();
        return response()->json($recentDonor);
    }

    public function deleteRecentDonor()
    {
        Donations::orderBy('created_at', 'desc')
        ->first()->delete();
        return redirect('http://massivecheerfulgivingnetwork.com/mcgn-dashboard/dashboard/add_donor.php?status=delete');
    }
    
    public function getCauseName()
    {
        $recentDonor = Causes::select('id', 'heading')
        ->orderBy('created_at', 'desc')
        ->get();
        return response()->json($recentDonor);
    }


    public function testt(Request $request)
    {
        $donor_data = $request->json()->all();
        // $data = json_decode($donor_data);
        // $d = $donor_data['picname'];
        // print_r($donor_data);
        // return response()->json($d);
        return response()->json(['status' => 'failed', 'message' => $donor_data]);
    }
}
