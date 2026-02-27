<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Member;
use Illuminate\View\View;

class AttendanceLogController extends Controller
{
    public function checkInByQr(Member $member): View
    {
        $recentCheckin = AttendanceLog::query()
            ->where('member_id', $member->id)
            ->where('checkin_method', 'qr')
            ->where('check_in_at', '>=', now()->subMinutes(2))
            ->latest('check_in_at')
            ->first();

        $attendanceLog = $recentCheckin ?? AttendanceLog::create([
            'member_id' => $member->id,
            'check_in_at' => now(),
            'checkin_method' => 'qr',
            'checked_in_by' => auth()->id(),
        ]);

        $wasRecent = $recentCheckin !== null;

        return view('attendance.checkin-success', compact('member', 'attendanceLog', 'wasRecent'));
    }
}
