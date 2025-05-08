<?php

namespace App\Http\Middleware;

use App\Models\Mahasiswa;
use Closure;
use Illuminate\Http\Request;

class VerifyApiSecret
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $nim = $request->query('nim');
        $secretKey = $request->header('X-API-KEY');
        $semester = $request->header('X-API-SEMESTER', null);

        if (!$nim || !$secretKey) {
            return response()->json(['message' => 'Missing NIM or API key'], 400);
        }

        $mahasiswa = Mahasiswa::where('nim', $nim)->where('secret_key', $secretKey)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->merge(['nim' => $mahasiswa->nim, 'semester' => $semester]);

        return $next($request);
    }
}
