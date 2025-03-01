<?php

namespace ShuffleLunch;

use HttpNotFoundException;

class ShuffleController extends Controller
{
  const NUMBER_OF_THREE_DIVISION = 3;
  const NUMBER_OF_TWO_DIVISION = 2;

  public function index()
  {
    return $this->render([
      'shuffleEmployees' => [],
    ]);
  }

  public function create()
  {
    if (!$this->request->isPost()) {
      throw new HttpNotFoundException();
    }

    $shuffleEmployees = [];
    $employees = $this->databaseManager->get('Employee')->fetchAllNames();
    $shuffleEmployees = $this->shuffleEmployees($employees);
    return $this->render([
      'shuffleEmployees' => $shuffleEmployees,
    ], 'index');
  }

  private function shuffleEmployees(array $employeesRegisters): array
  {
    shuffle($employeesRegisters);
    $results = $this->splitOfArray($employeesRegisters);
    return $results;
  }

  private function splitOfArray(array $employeesRegisters): array
  {
    $cnt = count($employeesRegisters);
    if ($cnt % 3 === 0) {
      $splitArray = array_chunk($employeesRegisters, self::NUMBER_OF_THREE_DIVISION);
    } elseif ($cnt % 2 === 0) {
      $splitArray = array_chunk($employeesRegisters, self::NUMBER_OF_TWO_DIVISION);
    } else {
      $extra = array_pop($employeesRegisters);
      $splitArray = array_chunk($employeesRegisters, self::NUMBER_OF_TWO_DIVISION);
      array_push($splitArray[0], $extra);
    }
    return $splitArray;
  }
}
