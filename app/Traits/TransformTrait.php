<?php


namespace App\Traits;

/**
 * 
 */
trait TransformTrait
{

  public function transformResponse($status_code, $status, $message, $data) {
    return [
      'status_code' => $status_code,
      'status' => $status,
      'message' => $message,
      'data' => $data
    ];
  }
  
}
