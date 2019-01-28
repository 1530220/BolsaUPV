<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Career;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Alert;
use App\Helpers\DeleteHelper;

class LogController extends Controller
{
  public function indexSessions()
  {
    //Consulta el historial de sesiones en el SIITA
    $sessions = DB::table('log')
        ->join('users', 'log.user_id', '=', 'users.id')
        ->select('users.*', 'log.*')
        ->where('action', '!=', '3')
        ->where('action', '!=', '4')
        ->where('action', '!=', '5')
        ->where('action', '!=', '6')->get();

    return view('log.sessionlist')
      ->with('sessions',$sessions)
      ->with('title', 'Historial de Sesiones');
  }

  public function indexMovements()
  {
    //Consulta el historial de movimientos en el SIITA
    $sessions = DB::table('log')
        ->join('users', 'log.user_id', '=', 'users.id')
        ->select('users.*', 'log.*')
        ->where('action', '!=', '1')
        ->where('action', '!=', '2')->get();

    return view('log.movementslist')
      ->with('sessions',$sessions)
      ->with('title', 'Historial de Movimientos');
  }

  /**
   * Muestra un registro dependiendo de su id
   *
   * @param  integer  $id
   * @return \Illuminate\Http\Response
   */
  public function showSession($id)
  {
      //Se buscan los detalles en todos los registros de log con el id mandado
      $log = DB::select("SELECT * FROM log WHERE id = $id");

      $user = User::find($log[0]->user_id);

      return view('log.showSession', compact('user','log'));
  }

  /**
   * Muestra un registro dependiendo de su id
   *
   * @param  integer  $id
   * @return \Illuminate\Http\Response
   */
  public function showMovement($id)
  {
      //Se buscan los detalles en todos los registros de log con el id mandado
      $log = DB::select("SELECT * FROM log WHERE id = $id");

      $user = User::find($log[0]->user_id);

      return view('log.showMovement', compact('user','log'));
  }
}
