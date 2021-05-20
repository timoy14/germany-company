<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invite;
use App\Http\Controllers\Auth\RegisterController;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request)
    {
        $token = md5($request->email.date("Y-m-d H:i:s"));
        if(Invite::insert(["token"=>$token]))
        {
            $invitation_link = \URL::to("/")."/api/invitation/".$token; 
            return $invitation_link;           
            mail($request->email, "Invitation", $invitation_link);
            return response()->json(["message"=>"invitation sent"],200);
        }
        return response()->json(["message"=>"fail"],500);
    }

    public function register_invitee(Request $request, $token)
    {
        if ($invite_data = Invite::where("token",$token)->get()->first()) 
        {
            if (!isset($request->code)) {
                $code = random_int(100000, 999999);
                if (Invite::where("token",$token)->update(["code"=>$code])) {
                    mail($request->email, "Confirmation Code", "CODE: ".$code);
                    return response()->json(["message"=>"Please check your email for confirmation"],401);
                }
            }

            if (isset($request->code) && $request->code == $invite_data->code) {
               $RegisterController = new RegisterController();
               return $RegisterController->store($request);
            }
            return response()->json(["message"=>"something is wrong"],500);
        }else{
            return response()->json(["message"=>"not authorized"],401);
        }
    }

}
