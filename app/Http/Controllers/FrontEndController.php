<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \stdClass;
use App\Volunteer;
use App\Causes;
use App\Donations;
use App\Gallery;
use App\Contact;

class FrontEndController extends Controller
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

    //INDEX PAGE

    public function submitVolunteer(Request $request)
    {
        $volunteer = new Volunteer;

        $submit= $request->api_submit;

        if(!empty($submit) && $submit == "Submit Volunteer")
       {
        $volunteer->name= $request->name;
        $volunteer->number= $request->number;
        $volunteer->email= $request->email;
        $volunteer->short_note= $request->note;

        if($volunteer->save()){
            // return response()->json(['status' => 'Success', 'message' => 'Message Sent']);
            return redirect('http://massivecheefulgivingnetwork.com/index.php?status=volunteer_saved');
           }else{
            // return response()->json(['status' => 'failed', 'message' => 'Could not send message']);
            return redirect('http://massivecheefulgivingnetwork.com/index.php?status=not_saved');
           }
        }else{
            // return response()->json(['status' => 'failed', 'message' => 'Not submitted']);
            return redirect('http://massivecheefulgivingnetwork.com/index.php?status=not_submitted');
           }
    }

    //CAUSES PAGE

    public function fetchCauses()
     {
         $cause = Causes::orderBy('created_at', 'desc')->paginate(6);
         return response()->json($cause);
     }

    public function firstThreeDonations()
    {
        $donations = Donations::orderBy('created_at', 'desc')->paginate(3);
        return response()->json($donations);
    }

    //GALLERY PAGE
    public function fetchGallery()
    {
        $gallery = Gallery::get();
        return response()->json($gallery);
    }

    //CONTACT US PAGE

    public function contactUs(Request $request)
    {
        // $uri = $request->path();
        // return response()->json($uri);
        $contact = new Contact;

        $submit= $request->api_submit;

        if(!empty($submit) && $submit == "Send Message")
       {
        $contact->name= $request->name;
        $contact->email= $request->email;
        $contact->subject= $request->subject;
        $contact->message= $request->message;

        if($contact->save()){
            // return response()->json(['status' => 'Success', 'message' => 'Message Sent']);
            return redirect('http://massivecheefulgivingnetwork.com/contact.php?status=message_sent');
           }else{
            return response()->json(['http://massivecheefulgivingnetwork.com/contact.php?status=not saved']);
           }
        }else{
            return response()->json(['http://massivecheefulgivingnetwork.com/contact.php?status=not submitted']);
           }
    }

    public function cashDonated($id)
    {
        $totalDonated = Donations::get()->sum('cash');
        $totalDonatedToCause = Donations::where('cause_id', $id)->sum('cash');
        return response()->json(['status' => 'sucess', 'message' => 'Data Retrieved', 'totalDonated' => $totalDonated, 'totalDonatedToCause' => $totalDonatedToCause]);
    }
}
