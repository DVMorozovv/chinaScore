<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function refer(Request $req){

        $referralsFirst = Auth::user()->referrals;
        $referralsFirstResult = [];
        foreach ($referralsFirst as $referral){
            $referralResult = $referral->toArray();
            $referralsFirstResult[] = $referralResult;
        }
        return view('/pages/referral', ['referralsFirst'=>$referralsFirstResult]);
    }

}
